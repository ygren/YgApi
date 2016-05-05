<?php
/*
 * 数据库操作类
 */

/*
 * 提供sql语句的简洁封装
 *
 */

class DB
{
    private static $dbConfig = null;

    public static function table($tables, $dbConfig = null)
    {
        if (!is_string($tables)) {
            throw new Exception('table not string');
        }

        $tables = explode(',', $tables);
        $connection = self::connection($dbConfig);
        return new Query($connection, $tables);
    }

    private static function connection($dbConfig = null)
    {
        $dbConfig = empty($dbConfig) ? self::$dbConfig : $dbConfig;
        if (empty($dbConfig)) {
            throw new Exception('db config not set');
        }
        $dsn = sprintf('mysql:host=%s;dbname=%s;',
            $dbConfig['host'], $dbConfig['database']);
        $conn = new \PDO($dsn, $dbConfig['user'], $dbConfig['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("SET NAMES 'utf8'");
        return $conn;
    }

    public static function config($config)
    {
        self::$dbConfig = $config;
    }

    public static function query($sql, $dbConfig = null)
    {
        $connection = self::connection($dbConfig);
        return $connection->query($sql);
    }
}

class JoinLink
{
    private $connect;
    private $mainTable;
    private $joinTable;
    private $join;

    public function __construct(&$connect, $mainTable, $joinTable, array $join = null)
    {
        $this->connect = &$connect;
        $this->mainTable = $mainTable;
        $this->joinTable = $joinTable;
        $this->join = $join;
    }

    public function on($join)
    {
        $this->join[] = array(
            'table' => $this->joinTable,
            'on' => $join
        );
        return new Query($this->connect, $this->mainTable, $this->join);
    }
}

/*
 * 提供对外接口
*/

class Query
{
    private $table = null;
    private $connect = null;
    private $isLock = false;

    public function __construct(&$connect, array $tables)
    {
        if (empty($tables)) {
            throw new \Exception('table empty');
        }

        $this->connect = $connect;
        $this->table = $tables;
    }

    public function getRow(array $condition = array())
    {
        $condition['limit'] = '0,1';
        $data = $this->getAll($condition);
        return !isset($data[0]) ? null : $data[0];
    }

    public function getAll(array $condition = array())
    {
        $condition = Condition::parse($condition);
        $table = implode(',', $this->table);
        $sql = sprintf('select %s from %s %s', $condition['field'],
            $table, $condition['condition']);
        return $this->query($sql, $condition['params'])->fetchAll();
    }

    private function query($sql, $params = array())
    {
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getVal($field, array $condition = array())
    {
        $condition['field'] = $field;
        $condition['limit'] = '0,1';
        $data = $this->getAll($condition);
        return !isset($data[0][$field]) ? null : $data[0][$field];
    }

    public function count($field, array $condition = array())
    {
        return $this->getVal('count(' . $field . ')', $condition);
    }

    public function max($field, array $condition = array())
    {
        return $this->getVal('max(' . $field . ')', $condition);
    }

    public function min($field, array $condition = array())
    {
        return $this->getVal('min(' . $field . ')', $condition);
    }

    public function avg($field, array $condition = array())
    {
        return $this->getVal('avg(' . $field . ')', $condition);
    }

    public function sum($field, array $condition = array())
    {
        return $this->getVal('sum(' . $field . ')', $condition);
    }

    public function insert($data)
    {
        $table = $this->singleTable();
        $fields = implode(',', array_keys($data));
        $values = array_fill(0, count($data), '?');
        $values = implode(',', $values);
        $sql = sprintf('insert into %s (%s) values (%s)', $table, $fields, $values);

        $this->query($sql, array_values($data));
        return $this->connect->lastInsertId();
    }

    private function singleTable()
    {
        if (count($this->table) > 1) {
            throw new Exception('not can two table insert');
        }
        return $this->table[0];
    }

    public function update($data, array $condition)
    {
        $table = $this->singleTable();
        $condition = Condition::parse($condition);
        $update = implode('=?,', array_keys($data)) . '=? ';
        $sql = 'update ' . $table . ' set ' . $update
            . $condition['condition'];

        $params = array_values($data);
        $params = array_merge($params, $condition['params']);
        return $this->query($sql, $params)->rowCount();
    }

    public function delete(array $condition)
    {
        $table = $this->singleTable();
        $condition = Condition::parse($condition);
        $sql = sprintf('delete from %s %s;', $table, $condition['condition']);
        return $this->query($sql, $condition['params'])->rowCount();
    }

    public function lock()
    {
        $this->isLock = true;
        $sql = 'LOCK TABLES ' . $this->table[0] . ' WRITE';
        $this->query($sql);
    }

    public function unlock()
    {
        $this->isLock = false;
        $sql = 'UNLOCK TABLES ' . $this->table[0] . ' WRITE';
        $this->query($sql);
    }

    public function __destruct()
    {
        //清除锁定
        if ($this->isLock) {
            $this->unlock();
        }
    }

    public function leftJoin($table)
    {
        return new JoinLink($this->connect, $this->table, $table, $this->join, 'left');
    }

    public function rightJoin($table)
    {
        return new JoinLink($this->connect, $this->table, $table, $this->join, 'right');
    }

    public function innerJoin($table)
    {
        return new JoinLink($this->connect, $this->table, $table, $this->join, 'inner');
    }

    public function fullJoin($table)
    {
        return new JoinLink($this->connect, $this->table, $table, $this->join, 'full');
    }
}

/*
 * condition 解析
 * 用于把条件数组转化为sql语句
 */

class Condition
{
    private static $select = array(
        'field' => '*',
        'limit' => '',
        'order' => '',
        'group' => '',
    );

    private static $sqlFormat = array(
        'gt' => '> ?', 'lt' => '< ?', 'not between' => '', 'index' => 1,
        'between' => 'between ? and ?', 'egt' => '>= ?', 'elt' => '<= ?', 'is null' => 1, ' is not null',
        'LIKE' => 1, 'eq' => '=?', 'neq' => '!= ?',
    );

    // 解析sql条件
    public static function parse(array $condition)
    {
        $where = array();
        $params = array();
        $select = self::$select;
        foreach ($condition as $key => $value) {
            if (isset($select[$key])) {// 非where条件
                $select[$key] = $value;
                continue;
            }
            list($item, $args) = self::parseWhere($key, $value);// where条件
            $where[] = $item;
            $params = array_merge($params, $args);
        }

        $where = implode(' and ', $where);
        $sql = self::generateSql($where, $select);
        self::checkParamsNum($sql, $params);
        return array(
            'field' => $select['field'],
            'condition' => $sql,
            'params' => $params
        );
    }

    private static function parseWhere($key, $value)
    {
        if (strpos($key, 'and')) {
            throw new Exception('sql must one');
        }

        if (is_int($key)) { // 无参数
            return array($value, array());
        }
        $key = trim($key);
        if (strpos($key, '?')) { // 源码方式
            $value = !is_array($value) ? array($value) : $value;
            return array($key, $value);
        }
        if (!is_array($value)) { // 单一参数
            return array(($key . '= ?'), array($value));
        }
        $tip = strtolower($value[0]);
        if (isset(self::$sqlFormat[$tip])) { // 标记参数
            $key .= ' ' . self::$sqlFormat[$tip];
            array_shift($value);
            return array($key, $value);
        } else {
            return self::formatIn($key, $value);
        }
    }

    private static function checkParamsNum($sql, $args)
    {
        if (substr_count($sql, '?') != count($args)) {
            throw new \Exception(sprintf(
                    'param num error:sql-%s,args:%s',
                    $sql, json_encode($args))
            );
        }
    }

    private static function formatIn($sql, $args)
    {
        if (!is_array($args) || empty($args)) {
            throw new Exception('in params error');
        }
        $in = rtrim(str_repeat('?,', count($args)), ',');
        $sql .= ' in (' . $in . ')';
        return array($sql, $args);
    }

    private static function generateSql($where, $select)
    {
        $sql = '';
        if (!empty($where)) {
            $sql .= ' where ' . $where;
        }
        if (!empty($select['group'])) {
            $sql .= ' group by ' . $select['group'];
        }
        if (!empty($select['order'])) {
            $sql .= ' order by ' . $select['order'];
        }
        if (!empty($select['limit'])) {
            $sql .= ' limit ' . $select['limit'];
        }
        return $sql;
    }
}