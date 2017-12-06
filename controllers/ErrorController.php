<?php

namespace app\controllers;
use yii\log\FileTarget;
use yii\web\Controller;

class ErrorController extends Controller
{
        public function actionError(){
            //记录错误信息到文件和数据库

            $error = \Yii::$app->errorHandler->exception;
            $err_msg = '';
            if($error){
              $file = $error->getFile();
              $line = $error->getLine();
              $message = $error->getMessage();
              $code = $error->getCode();
              $log = new FileTarget();
              $log->logFile = \Yii::$app->getRuntimePath()."/logs/err.log";
              $err_msg = $message."[file:{$file}][line:{$line}][code:{$code}][url:{$_SERVER['REQUEST_URL']}][POST_DATA:".http_build_query($_POST)."]";

              $log->messages[]=[
                $err_msg,
                1,
                'application',
                microtime(true)
              ];
              //写入到错误文件runtime
              $log->export();
              //写入数据库
            }
            return '错误页面<br/>错误信息：'.$err_msg;
        }
}
