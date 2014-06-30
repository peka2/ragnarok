<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * リクエスト解析クラス
 * URLの解析など
 *
 * @package
 * @author    $Author$
 * @date      $Date$
 * @version   $Id$
 * @copyright peka-lab
 */


class Request {

    // singleton
    private static $_req = null;
    
    // リクエストデータ格納
    private static $_requestData = array('method' => '', 'param' => '', 'body' => '' , 'session' => array());


    // {{{ public static function getInstance()
    /**
     * リクエストオブジェクト取得(singleton)
     *
     * @return RequestObject
     */
    public static function getInstance()
    {
        if(is_null(self::$_req)){
            self::$_req = new self();
        }
        return self::$_req;

    }
    // }}}

    // {{{ private function __construct()
    /**
     * コンストラクタ
     * リクエストを解析し突っ込む
     *
     * @return void
     */
    private function __construct()
    {
        session_start();
        if(!empty($_SESSION)){
            self::$_requestData['session'] = $_SESSION;
        }
        else{
            self::$_requestData = array();
        }

        $requestMethod = getenv('REQUEST_METHOD');
        self::$_requestData['method'] = $requestMethod;

        // Paramを格納
        self::$_requestData['param'] = array();
        foreach($_GET as $key => $value){
            self::$_requestData['param'][$key] = $value;
        }

        // リクエストボディ取得
        self::$_requestData['body'] = file_get_contents("php://input");

        // URLを解析
        $uri = getenv('PATH_INFO');
        //$uri = preg_replace("@\?.*$@u", "", $uri); // QSを処理
        // 先頭は必ず/なのでそれを削除
        $uri = substr($uri, 1);
        self::$_requestData['path'] = explode("/", $uri);

    }
    // }}}

    // {{{ public function getRequestPath()
    /**
     * リクエストされたリソースのパスを取得
     * 
     * @return array 階層ごとに切ったパスリスト
     */
    public function getRequestPath()
    {
        $path = self::$_requestData['path'];
        return $path;
    }
    // }}}
    // {{{ public function getRequestBody()
    /**
     * リクエストボディ取得
     * 
     * @return array 階層ごとに切ったパスリスト
     */
    public function getRequestBody()
    {
        $body = self::$_requestData['body'];
        return $body;
    }
    // }}}
    // {{{ public function getRequestParams()
    /**
     * リクエストパラメータ取得
     * 
     * @return array パラメータのリスト
     */
    public function getRequestParams()
    {
        $param = self::$_requestData['param'];
        return $param;
    }
    // }}}
    // {{{ public function getRequestMethod()
    /**
     * リクエストメソッド取得
     * 
     * @return string http-method
     */
    public function getRequestMethod()
    {
        $method = self::$_requestData['method'];
        return $method;
    }
    // }}}
    // {{{ public function getRequestSession()
    /**
     * セッション情報取得
     * 
     * @return array sessionデータ
     */
    public function getRequestSession()
    {
        $method = self::$_requestData['session'];
        return $method;
    }
    // }}}
}


