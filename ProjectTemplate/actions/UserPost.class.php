<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * ユーザー登録
 *
 * @package
 * @author    $Author$
 * @date      $Date$
 * @version   $Id$
 * @copyright peka-lab
 */

require_once "ragnarok/ProjectTemplate/lib/User_Info.class.php";

class UserPost{

    // {{{ public function execute()
    /**
     * 実行部
     *
     * @return array
     */
    public function execute()
    {

        $userId = Login_Info::getInstance()->getUserId();
        if(empty($userId)){
            throw new ProjectException("no login.", "NO_LOGIN");
        }

        $ui = new User_Info();
        $userData['user_id'] = $userId;
        $userData['user_name'] = "日本語てすと♪★＠";
        $ui->registerUser($userData);

    }
    // }}}




}

