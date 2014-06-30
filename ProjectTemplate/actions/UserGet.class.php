<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * ユーザー情報取得
 *
 * @package
 * @author    $Author$
 * @date      $Date$
 * @version   $Id$
 * @copyright peka-lab
 */

class UserGet{

    // {{{ public function execute()
    /**
     * 実行部
     *
     * @return array
     */
    public function execute()
    {
        $data = Request::getInstance()->getRequestParams();

/**
        $data['aaaa']['bbb'] = 100;
        $data['aaaa']['ccc'] = 1000;
        $data['dd'] = 10000;
**/

        return $data;

    }
    // }}}




}

