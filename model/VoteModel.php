<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/21
 * Time: 下午4:46
 */
class VoteModel
{
    public static function sendBattle($request)
    {

        // 判断所投票对战是否结束（当前对战投票数是否满5，没结束，投票书加一，结束，生成新的对战，返回投票失败结果。
        $vote_pic = \DB::table('jt_battle')->getRow(array('isbattle' => 0, 'id' => $request['battle_id']));
        if ($vote_pic['left_count'] == 5) {
            $pushToBattleWin = new GeTui();
            $WinCID = \DB::table('jt_cid')->getVal('cid',
                array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $vote_pic['left_pic_id']))));
            $contentWin = json_encode(array(
                'Code' => 0,
                'Message' => "当前对战胜利",
                'Data' => \DB::table('jt_battle')->getAll(array('id' => $request['battle_id']))
            ));
            $pushToBattleWin->setCID($WinCID);
            $pushToBattleWin->setTransmissionContent($contentWin);
            $pushToBattleWin->pushMessageToSingle();
            $pushTOBattleFail = new GeTui();
            $FailCID = \DB::table('jt_cid')->getVal('cid',
                array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $vote_pic['right_pic_id']))));

            $contentFail = json_encode(array(
                'Code' => 0,
                'Message' => "当前对战胜利",
                'Data' => \DB::table('jt_battle')->getAll(array('id' => $request['battle_id']))
            ));
            $pushTOBattleFail->setCID($FailCID);
            $pushTOBattleFail->setTransmissionContent($contentFail);
            $pushTOBattleFail->pushMessageToSingle();
            \BattleModel::finishBattle($request['battle_id'], $vote_pic['left_pic_id']);
            \BattleModel::finishBattle($request['battle_id'], $vote_pic['right_pic_id']);
            \BattleModel::resurrectionBattle($vote_pic['right_pic_id'], $vote_pic['jt_theme_id']);

            \BattleModel::interGenerateBattle($vote_pic['left_pic_id'], $vote_pic['jt_theme_id']);


            throw new Exception("投票失败，该对战已结束！", 1044);
        } elseif ($vote_pic['right_count'] == 5) {

            $pushToBattleWin = new GeTui();
            $WinCID = \DB::table('jt_cid')->getVal('cid',
                array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $vote_pic['right_pic_id']))));
            $contentWin = json_encode(array(
                'Code' => 0,
                'Message' => "当前对战胜利",
                'Data' => \DB::table('jt_battle')->getAll(array('id' => $request['battle_id']))
            ));
            $pushToBattleWin->setCID($WinCID);
            $pushToBattleWin->setTransmissionContent($contentWin);
            $pushToBattleWin->pushMessageToSingle();
            $pushTOBattleFail = new GeTui();
            $FailCID = \DB::table('jt_cid')->getVal('cid',
                array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $vote_pic['left_pic_id']))));

            $contentFail = json_encode(array(
                'Code' => 0,
                'Message' => "当前对战胜利",
                'Data' => \DB::table('jt_battle')->getAll(array('id' => $request['battle_id']))
            ));
            $pushTOBattleFail->setCID($FailCID);
            $pushTOBattleFail->setTransmissionContent($contentFail);
            $pushTOBattleFail->pushMessageToSingle();
            \BattleModel::finishBattle($request['battle_id'], $vote_pic['left_pic_id']);
            \BattleModel::finishBattle($request['battle_id'], $vote_pic['right_pic_id']);
            \BattleModel::resurrectionBattle($vote_pic['left_pic_id'], $vote_pic['jt_theme_id']);
            \BattleModel::interGenerateBattle($vote_pic['right_pic_id'], $vote_pic['jt_theme_id']);

            throw new Exception("投票失败，该对战已结束！", 1044);
        } else {
            //判断用户是否属于其中一个，如果属于对战其中一个，则不允许投票
            if (
                \DB::table('jt_post_pic')->getVal('uid', array(
                    'id' => \DB::table('jt_battle')->getVal('left_pic_id', array('id' => $request['battle_id']))
                )) == \DB::table('jt_user')->getVal('id', array('username' => $request['username'])) ||
                \DB::table('jt_post_pic')->getVal('uid', array(
                    'id' => \DB::table('jt_battle')->getVal('right_pic_id', array('id' => $request['battle_id']))
                )) == \DB::table('jt_user')->getVal('id', array('username' => $request['username']))

            ) {
                throw new Exception("投票失败，用户不能给自己投票", 1046);
            } else {

                if (\DB::table('jt_vote')->getAll(array('jt_battle_id' => $request['battle_id'], 'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))) != null) {
                    throw new Exception("投票失败，该用户在该对战中已投票！", 1045);
                } else {


                    if ($vote_pic['left_pic_id'] == $request['pic_id']) {
                        \DB::table('jt_vote')->insert(array('pic_id' => $request['pic_id'],
                            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                            'createtime' => date("Y-m-d H:i:s"),
                            'jt_battle_id' => $request['battle_id'],
                            'chick_id' => \DB::table('jt_userinfo')->getVal('chick_id',
                                array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))))

                        ));
                        $pushTOBattleVoteLeft = new GeTui();
                        $VoteLeftCID = \DB::table('jt_cid')->getVal('cid',
                            array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id']))));
                        $contentVoteLeft = json_encode(array(
                            'Code' => 0,
                            'Message' => "对战被投票提示",
                            'Data' => array(
                                'from_uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                                'nickname' => \DB::table('userinfo')->getVal('nickname',
                                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                                'head_pic_path' => \DB::table('userinfo')->getVal('head_pic_path',
                                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                                'battle_id' => $request['battle_id'],
                                'createtime' => date("Y-m-d H:i:s")
                            )
                        ));
                        $pushTOBattleVoteLeft->setCID($VoteLeftCID);
                        $pushTOBattleVoteLeft->setTransmissionContent($contentVoteLeft);
                        $pushTOBattleVoteLeft->pushMessageToSingle();
                        $count = \DB::table('jt_battle')->getVal('left_count', array('id' => $request['battle_id']));
                        $count++;
                        \DB::table('jt_battle')->update(array('left_count' => $count), array('id' => $request['battle_id']));

                        return array(
                            'Code' => 0,
                            'Msg' => "投票成功！",
                            'Data' => \DB::table('jt_battle')->getRow(array('id' => $request['battle_id']))

                        );

                    } elseif ($vote_pic['right_pic_id'] == $request['pic_id']) {

                        \DB::table('jt_vote')->insert(array('pic_id' => $request['pic_id'],
                            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                            'createtime' => date("Y-m-d H:i:s"),
                            'jt_battle_id' => $request['battle_id'],
                            'chick_id' => \DB::table('jt_userinfo')->getVal('chick_id',
                                array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))))

                        ));

                        $pushTOBattleVoteRight = new GeTui();
                        $VoteRightCID = \DB::table('jt_cid')->getVal('cid',
                            array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id']))));
                        $contentVoteRight = json_encode(array(
                            'Code' => 0,
                            'Message' => "对战被投票提示",
                            'Data' => array(
                                'from_uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                                'nickname' => \DB::table('userinfo')->getVal('nickname',
                                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                                'head_pic_path' => \DB::table('userinfo')->getVal('head_pic_path',
                                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                                'battle_id' => $request['battle_id'],
                                'createtime' => date("Y-m-d H:i:s")
                            )
                        ));
                        $pushTOBattleVoteRight->setCID($VoteRightCID);
                        $pushTOBattleVoteRight->setTransmissionContent($contentVoteRight);
                        $pushTOBattleVoteRight->pushMessageToSingle();
                        $count = \DB::table('jt_battle')->getVal('right_count', array('id' => $request['battle_id']));
                        $count++;
                        \DB::table('jt_battle')->update(array('right_count' => $count), array('id' => $request['battle_id']));
                        return array(
                            'Code' => 0,
                            'Msg' => "投票成功！",
                            'Data' => \DB::table('jt_battle')->getRow(array('id' => $request['battle_id']))

                        );

                    }
                }
            }

        }


    }

    public static function deleteBattle($request)
    {
        //删除已经投票结果
        $vote_pic = \DB::table('jt_battle')->getRow(array('id' => $request['battle_id'], 'isbattle' => 0));

        if ($vote_pic['left_pic_id'] == $request['pic_id']) {
            $count = \DB::table('jt_battle')->getVal('left_count', array('id' => $request['battle_id']));

            $count = $count - 1;

            \DB::table('jt_battle')->update(array('left_count' => $count,
                'updatetime' => date("Y-m-d H-i-s")
            ), array('id' => $request['battle_id']));
        } else {
            $count = \DB::table('jt_battle')->getVal('right_count', array('id' => $request['battle_id']));

            $count = $count - 1;

            \DB::table('jt_battle')->update(array('right_count' => $count,
                'updatetime' => date("Y-m-d H-i-s")
            ), array('id' => $request['battle_id']));
        }
        \DB::table('jt_vote')->delete(array('pic_id' => $request['pic_id'],
            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ));
        return array(
            'Code' => 0,
            'Msg' => "删除投票成功！",
            'Data' => \DB::table('jt_battle')->getAll(array('id' => $request['battle_id']))
        );
    }

//复活投票
    public static function sendResurrection($request)
    {
        // 判断所投票对战是否结束（当前对战投票数是否满5，没结束，投票书加一，结束，生成新的对战，返回投票失败结果。
        $vote_pic = \DB::table('jt_resurrection_pic')->getRow(array('islock' => '0', 'id' => $request['resurrection_id']));
        if ($vote_pic['resurrection_count'] == 5) {
            \BattleModel::finishResurrectionBattle($vote_pic['id'], $vote_pic['jt_theme_id']);
            \BattleModel::interGenerateBattle($vote_pic['pic_id'], $vote_pic['jt_theme_id']);
            throw new Exception("投票失败，该图片复活回合已结束", 1047);

        } else {

            if (
                \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id'])) == \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
            ) {
                throw new Exception("投票失败，用户不能给自己投票", 1046);
            } else {
                if (\DB::table('jt_resurrection_vote')->getAll(array('jt_resurrection_pic_id' => $request['resurrection_id'], 'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))) != null) {
                    throw new Exception("投票失败，该图片复活中此用户已投票", 1048);
                } elseif ($vote_pic['pic_id'] == $request['pic_id']) {

                    \DB::table('jt_resurrection_vote')->insert(array(
                        'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                        'createtime' => date("Y-m-d H:i:s"),
                        'jt_resurrection_pic_id' => $request['resurrection_id']
                    ,
                        'chick_id' => \DB::table('jt_userinfo')->getVal('chick_id',
                            array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))))

                    ));

                    $pushTOResurrection = new GeTui();
                    $ResurrectionCID = \DB::table('jt_cid')->getVal('cid',
                        array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id']))));
                    $contentResurrection = json_encode(array(
                        'Code' => 0,
                        'Message' => "复活被投票提示",
                        'Data' => array(
                            'from_uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                            'nickname' => \DB::table('userinfo')->getVal('nickname',
                                array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                            'head_pic_path' => \DB::table('userinfo')->getVal('head_pic_path',
                                array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                            'battle_id' => $request['resurrection_id'],
                            'createtime' => date("Y-m-d H:i:s")
                        )
                    ));
                    $pushTOResurrection->setCID($ResurrectionCID);
                    $pushTOResurrection->setTransmissionContent($contentResurrection);
                    $pushTOResurrection->pushMessageToSingle();


                    $count = \DB::table('jt_resurrection_pic')->getVal('resurrection_count', array('id' => $request['resurrection_id']));
                    $count++;
                    \DB::table('jt_resurrection_pic')->update(array('resurrection_count' => $count), array('id' => $request['resurrection_id']));
                    return array(
                        'Code' => 0,
                        'Msg' => "投票成功！",
                        'Data' => \DB::table('jt_resurrection_pic')->getRow(array('id' => $request['resurrection_id']))

                    );

                }
            }


        }

    }

    //死亡投票

    public static function sendDeath($request)
    {
        // 判断所投票对战是否结束（当前对战投票数是否满5，没结束，投票书加一，结束，生成新的对战，返回投票失败结果。
        $vote_pic = \DB::table('jt_resurrection_pic')->getRow(array('islock' => '0', 'id' => $request['resurrection_id']));
        if ($vote_pic['death_count'] == 5) {
            \BattleModel::finishResurrectionBattle($vote_pic['id'], $vote_pic['jt_theme_id']);
            \DB::table('jt_post_pic')->update(array('islock' => 1), array('id' => $vote_pic['pic_id']));
            throw new Exception("投票失败，该图片复活回合已结束", 1047);

        } else {

            if (
                \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id'])) == \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
            ) {
                throw new Exception("投票失败，用户不能给自己投票", 1046);
            } else {
                if (\DB::table('jt_death_vote')->getAll(array('jt_resurrection_pic_id' => $request['resurrection_id'], 'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))) != null) {
                    throw new Exception("投票失败，该图片复活中此用户已投票", 1048);
                } elseif ($vote_pic['pic_id'] == $request['pic_id']) {
                    \DB::table('jt_death_vote')->insert(array(
                        'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                        'createtime' => date("Y-m-d H:i:s"),
                        'jt_resurrection_pic_id' => $request['resurrection_id']

                    ));

                    $pushTODeath = new GeTui();
                    $DeathCID = \DB::table('jt_cid')->getVal('cid',
                        array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id']))));
                    $contentDeath = json_encode(array(
                        'Code' => 0,
                        'Message' => "复活 被投票提示",
                        'Data' => array(
                            'from_uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                            'nickname' => \DB::table('userinfo')->getVal('nickname',
                                array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                            'head_pic_path' => \DB::table('userinfo')->getVal('head_pic_path',
                                array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                            'battle_id' => $request['resurrection_id'],
                            'createtime' => date("Y-m-d H:i:s")
                        )
                    ));
                    $pushTODeath->setCID($DeathCID);
                    $pushTODeath->setTransmissionContent($contentDeath);
                    $pushTODeath->pushMessageToSingle();


                    $count = \DB::table('jt_resurrection_pic')->getVal('death_count', array('id' => $request['resurrection_id']));
                    $count++;
                    \DB::table('jt_resurrection_pic')->update(array('death_count' => $count), array('id' => $request['resurrection_id']));
                    return array(
                        'Code' => 0,
                        'Msg' => "投票成功！",
                        'Data' => \DB::table('jt_resurrection_pic')->getRow(array('id' => $request['resurrection_id']))

                    );

                }
            }

        }
    }


    public static function deleteResurrection($request)
    {
        //删除已经投票结果
        if (\DB::table('jt_resurrection_vote')->getVal('id', array('jt_resurrection_pic_id' => $request['resurrection_id'],
            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ))
        ) {


            $count = \DB::table('jt_resurrection_pic')->getVal('resurrection_count', array('id' => $request['resurrection_id']));

            $count = $count - 1;

            \DB::table('jt_resurrection_pic')->update(array('resurrection_count' => $count), array('id' => $request['resurrection_id']));
//删除出现问题，会出现负数，且投票唯一性没有保证
            \DB::table('jt_resurrection_vote')->delete(array('jt_resurrection_pic_id' => $request['resurrection_id'],
                'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
            ));
            return array(
                'Code' => 0,
                'Message' => "复活投票删除成功！",
                'Data' => \DB::table('jt_resurrection_pic')->getRow(array('id' => $request['resurrection_id']))

            );
        } else {

            throw new Exception("该用户未在该复活中投票，不可删除", 1049);
        }
    }


    public static function deleteDeath($request)
    {
//删除已经投票结果
        if (\DB::table('jt_death_vote')->getVal('id', array('jt_resurrection_pic_id' => $request['resurrection_id'],
            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ))
        ) {


            $count = \DB::table('jt_resurrection_pic')->getVal('death_count', array('id' => $request['resurrection_id']));

            $count = $count - 1;

            \DB::table('jt_resurrection_pic')->update(array('death_count' => $count), array('id' => $request['resurrection_id']));
//删除出现问题，会出现负数，且投票唯一性没有保证
            \DB::table('jt_death_vote')->delete(array('jt_resurrection_pic_id' => $request['resurrection_id'],
                'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
            ));
            return array(
                'Code' => 0,
                'Message' => "复活投票删除成功！"
            );
        } else {

            throw new Exception("该用户未在该复活中投票，不可删除", 1049);
        }
    }

    public static function getAppointBattle($request)
    {
        // jt_battle中left_pic_id或者right_pic_id等于指定得pic_id，返回所有对战，按时间排序
        return array(
            'Code' => 0,
            'Message' => "获取指定对战投票详情成功！",
            'Date' => \DB::table('jt_vote')->getAll(
                array(
                    'jt_battle_id' => $request['battle_id'],

                    'order' => 'updatetime desc'
                )
            ),


        );
    }


    public static function getAppointResurrection($request)
    {
        return array(
            'Code' => 0,
            'Message' => "获取指定对战投票详情成功！",
            'Date' => array(
                'ResurrectionMessage' => \DB::table('jt_resurrection_vote')->getAll(
                    array(
                        'jt_resurrection_pic_id' => $request['resurrection_id'],

                        'order' => 'updatetime desc'
                    )
                ),
                'DeathMessage' => \DB::table('jt_death_vote')->getAll(
                    array(
                        'jt_resurrection_pic_id' => $request['resurrection_id'],

                        'order' => 'updatetime desc'
                    )
                ),

            )


        );
    }
}