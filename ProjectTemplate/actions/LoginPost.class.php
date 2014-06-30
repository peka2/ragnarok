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


require_once "ragnarok/ProjectTemplate/lib/Login_Info.class.php";

class LoginPost {

    // {{{ public function execute()
    /**
     * 実行部
     *
     * @return array
     */
    public function execute()
    {
        $li = new Login_Info();
        $loginData['mail'] = "aaaa@aaaa"; 
        $loginData['password'] = "passs"; 
        $loginData['user_id'] = null; 
        $li->registerUser($loginData);

        $data['aaa']['aaaaa'] = "aaaaaaaaaa";

        return $data;

    }
    // }}}




}

