<?php


/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * 拡張Exception
 */


class SystemException extends Exception {


    private $_errorCode = "";
    private $_errorMessage = "";
    private $_previousException = "";

    /**
     * コンストラクタ
     *
     * @param string エラーメッセージ
     * @param string エラーコード
     * @param object 直前のProjectException
     *
     */
    public function __construct($message = null, $code = 0, $previous = null)
    {
        $this->_errorMessage = $message;
        $this->_errorCode = $code;
        $this->_previousException = $previous;

        parent::__construct($message, 0);
    }
    
    /**
     * エラーメッセージ取得
     *
     * @return string エラーメッセージ
     */
    public function getErrorMessage(){
        return $this->_errorMessage;
    }

    /**
     * エラーコード取得
     *
     * @return string エラーコード
     */
    public function getErrorCode(){
        return $this->_errorCode;
    }

    /**
     * 直前のProjectExceptionオブジェクト取得
     *
     * @return object ProjectExceptionオブジェクト
     */
    public function getPreviousException(){
        return $this->_previousException;
    }

}





