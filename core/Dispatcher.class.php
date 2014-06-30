<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 fdm=marker: */

/**
 * 必要なオブジェクトを生成するクラス
 *
 * @package
 * @author    $Author$
 * @date      $Date$
 * @version   $Id$
 * @copyright peka-lab
 */


require_once "ragnarok/config/Ragnarok_Config.class.php";
require_once "ragnarok/lib/Request.class.php";
require_once "ragnarok/lib/Response.class.php";
require_once "ragnarok/lib/Utils.class.php";
require_once "ragnarok/lib/SystemException.class.php";

class Dispatcher {

    //HTDOCSのルートDIR
    //CONST _WWW_ROOT_DIR = "/home/peka/www/api/";
    //FWのルートDIR
    CONST _ROOT_DIR = "ragnarok";
    //アクション
    CONST _ACTION_DIR = "actions";


    // {{{ public function __construct()
    /**
     * コンストラクタ
     * リクエストから必要なファイルを読みこんでオブジェクト生成
     *
     * @return void
     */
    public function __construct()
    {
        // フォーマットの設定
        $params = Request::getInstance()->getRequestParams();
        if(!isset($params['output'])){
            $params['output'] = "xml";
        }

        // 呼び出すファイルを決定する
        $pathList = Request::getInstance()->getRequestPath();

        $appName = $pathList[0];
        unset($pathList[0]);

        // コントローラーファイル
        $loadControllerFile = self::_ROOT_DIR . "/{$appName}/Controller.php" ;
        require_once $loadControllerFile;
        $controller = new Controller();

        // アクションファイル
        $actionName = "";
        foreach($pathList as $key => $value){
            $actionName .= ucfirst($value); // 一つ目を大文字に
        }
        
        $actionName .= ucfirst(strtolower(Request::getInstance()->getRequestMethod()));
        $loadActionFile = self::_ROOT_DIR . "/{$appName}/actions/{$actionName}.php" ;
        if(!is_readable(dirname(dirname(__DIR__)) . "/" . $loadActionFile)){
            //アクションが読めないときは４０４で終了
           //header("Status: 404 Not Found");
            header("HTTP/1.1 404 Not Found");
            error_log("404 api error. appName = {$appName} , actionName = {$actionName}");
           // echo "aa";
            exit;
        }
        require_once $loadActionFile;

        // actionの実行
        $actionObject = new $actionName;
        try{
            $responseData = $actionObject->execute();
        }
        catch(Exception $e){
            // 共通エラー処理
            $responseData = array();
            $responseData['Error']['Code'] = $e->getCode();
            $responseData['Error']['Message'] = $e->getMessage();
        }

        if($params['output'] === 'xml'){
            $templateName = "CommonXml";
        }
        else if($params['output'] === 'json'){
            $templateName = "CommonJson";
        }
        else if($params['output'] === 'php'){
            $templateName = "CommonPhp";
        }
        else{
            $templateName = "CommonXml";
        }
        $loadTemplateFile = self::_ROOT_DIR . "/{$appName}/templates/{$templateName}.php";
        
        // レスポンス
        if(is_null(Response::getInstance()->getResponseCode())){
            // コードが設定されていなかったらここで設定
            if(Request::getInstance()->getRequestMethod() === 'POST'){
                // POSTのときは201
                $responseCode = 201;
            }
            else{
                $responseCode = 200;
            }

            if(isset($responseData['Error']['Code']) && $responseData['Error']['Code']){
                //エラーコードがあればそれを設定
                $responseCode = $responseData['Error']['Code'];
            }
            
            Response::getInstance()->setResponseCode($responseCode);
        }
        // レスポンスデータセット
        Response::getInstance()->setResponseData($responseData);
        // テンプレセット
        Response::getInstance()->setTemplateFile($loadTemplateFile);
        // 表示
        Response::getInstance()->disp();
    }
    // }}}

}


