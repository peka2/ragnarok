<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * レスポンス用クラス
 *
 * @package
 * @author    $Author$
 * @date      $Date$
 * @version   $Id$
 * @copyright peka-lab
 */


class Response {

    // singleton
    private static $_res = null;
    
    // レスポンスに必要なデータ
    private $_responseCode = null;
    private $_responseData = array();
    private $_responseTemplateFile = null;

    private $_statusCode = array(
            '200' => 'OK',
            '201' => 'Created',
            '202' => 'Accepted',
            '204' => 'No Content',
            '301' => 'Moved Permanently',
            '302' => 'Moved Temporarily',
            '304' => 'Not Modified',
            '400' => 'Bad Request',
            '401' => 'Unauthorized',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '500' => 'Internal Server Error',
            '501' => 'Not Implemented',
            '502' => 'Bad Gateway',
            '503' => 'Service Unavailable'
            );

    // {{{ public static function getInstance()
    /**
     * レスポンスオブジェクト取得(singleton)
     *
     * @return RequestObject
     */
    public static function getInstance()
    {
        if(is_null(self::$_res)){
            self::$_res = new self();
        }
        return self::$_res;

    }
    // }}}

    // {{{ private function __construct()
    /**
     * コンストラクタ
     *
     * @return void
     */
    private function __construct()
    {
    }
    // }}}

    // {{{ public function setResponseCode($code)
    /**
     * HTTPステータスコードを設定
     * @param int http_code
     * @return void
     */
    public function setResponseCode($code)
    {
        $this->_responseCode = $code;
    }
    // }}}

    // {{{ public function getResponseCode()
    /**
     * 設定されたHTTPステータスコードを取得
     * @return int 設定されたHTTPステータスコード
     */
    public function getResponseCode()
    {
        return $this->_responseCode;
    }
    // }}}

    // {{{ public function setResponseData($data)
    /**
     * レスポンス用データを設定
     * @param array $data レスポンスデータ
     * @return void
     */
    public function setResponseData($data)
    {
        $this->_responseData = $data;
    }
    // }}}

    // {{{ public function setTemplateFile($loadTemplateFile)
    /**
     * テンプレートファイルを設定
     * @param string $loadTemplateFile テンプレートファイルのパス
     * @return void
     */
    public function setTemplateFile($loadTemplateFile)
    {
        $this->_responseTemplateFile = $loadTemplateFile;
    }
    // }}}

    // {{{ public function disp()
    /**
     * レスポンス出力
     *
     * @return void
     */
    public function disp()
    {
        $data = $this->_responseData;
        
        //header('HTTP', true, $this->_responseCode);
        header("HTTP/1.1 $this->_responseCode {$this->_statusCode[$this->_responseCode]}");

        // テンプレート呼び出し
        require_once $this->_responseTemplateFile;

    }
    // }}}

}


