<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * 汎用ログ出力関連ライブラリ
 *
 * staticアクセス専用。
 *
 */

/**
 * 使用例
 *

$array = array("Woooooooooooow!!!!!!!!");

Logger::debug("test log debug", $array);
*/


final class Logger {
    //ログレベル
    const _LOG_LEVEL_DEBUG = 1; //DEBUG
    const _LOG_LEVEL_INFO  = 2; //INFO
    const _LOG_LEVEL_WARN  = 3; //WARN
    const _LOG_LEVEL_ERROR = 4; //ERROR
    const _LOG_LEVEL_NONE  = 9; //ログ出力無し


    // {{{ private function _checkGlobalVal()
    /**
     * グローバル変数の値が[1-9]の範囲かチェックする
     * 範囲外のときは _LOG_LEVEL_INFO を設定する
     *
     * @return void
     * @access static private
     */
     private function _checkGlobalVal(){
        
        if(is_numeric(Ragnarok_Config::$LOG_LEVEL) &&
           0 < Ragnarok_Config::$LOG_LEVEL && Ragnarok_Config::$LOG_LEVEL < 10 ){

        }
        else{
            Ragnarok_Config::$LOG_LEVEL = self::_LOG_LEVEL_INFO;
            Logger::warn(__METHOD__." LOG_LEVEL is not covered number.");
        }
        return;
     }
     // }}}
     
    // {{{ static public function debug($msg ="", $data = null)
    /**
     * DEBUGレベル以上のログを出力する。
     *
     * @param string $msg メッセージ
     * @param object $data dumpしたい変数
     * @return なし
     * @access static public
     */
    static public function debug($msg ="", $data = null){
        self::_checkGlobalVal();
        if(Ragnarok_Config::$LOG_LEVEL <= self::_LOG_LEVEL_DEBUG){
            self::_log("DEBUG", $msg, $data);
        }
        return;
    }
    // }}}

    // {{{ static public function info($msg = "", $data = null)
    /**
     * INFOレベル以上のログを出力する。
     *
     * @param string $msg メッセージ
     * @param object $data dumpしたい変数
     * @return なし
     * @access static public
     */
    static public function info($msg = "", $data = null){
        self::_checkGlobalVal();
        if(Ragnarok_Config::$LOG_LEVEL <= self::_LOG_LEVEL_INFO){
            self::_log("INFO", $msg, $data);
        }
        return;
    }
    // }}}

    // {{{ static public function warn($msg = "", $data = null)
    /**
     * WARNレベル以上のログを出力する。
     *
     * @param string $msg メッセージ
     * @param object $data dumpしたい変数
     * @return なし
     * @access static public
     */
    static public function warn($msg = "", $data = null){
        self::_checkGlobalVal();
        if(Ragnarok_Config::$LOG_LEVEL <= self::_LOG_LEVEL_WARN){
            self::_log("WARN", $msg, $data);
        }
        return;
    }
    // }}}

    // {{{ static public function error($msg = "", $data = null)
    /**
     * ERRORレベル以上のログを出力する。
     *
     * @param string $msg メッセージ
     * @param object $data dumpしたい変数
     * @return なし
     * @access static public
     */
    static public function error($msg = "", $data = null){
        self::_checkGlobalVal();
        if(Ragnarok_Config::$LOG_LEVEL <= self::_LOG_LEVEL_ERROR){
            self::_log("ERROR", $msg, $data);
        }
        return;
    }
    // }}}

    // {{{ static private function _log($level, $msg, $data = null)
    /**
     * ログを出力する。
     *
     * @param int $level int ログレベル
     * @param string $msg メッセージ
     * @param object $data dumpしたい変数
     * @return なし
     * @access static private
     */
     static private function _log($level, $msg, $data = null){

         $trace = debug_backtrace();
         if(count($trace) > 1){
             $file_path = $trace[1]["file"];
             $file_name = substr($file_path,strrpos($file_path,"/")+1);
             $line = $trace[1]['line'];
             $msg = "[" . $file_name . ":".$line."] ".$msg;
         }

        //出力先が指定ファイルの場合
        $log_file = Ragnarok_Config::$LOG_DIR . "php_" . date('Ymd'). ".log";
        error_log("[" . date('Y-m-d H:i:s') ."][".$level."]".$msg.PHP_EOL, 3, $log_file);
        if(isset($data)){
            error_log(print_r($data, true) . PHP_EOL , 3, $log_file);
        }
            return;
    }
    // }}}

}

