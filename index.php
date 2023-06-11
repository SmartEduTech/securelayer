<?php

include "./vendor/autoload.php";
use Smartedutech\Securelayer\Log\MessageLog;
use Smartedutech\Securelayer\Log\AgentLog;
use Smartedutech\Securelayer\Filters\FilterDatas;

//FilterDatas::filterEMail("oussama.limam@gmail.com");
$Message=file_get_contents("template.html");
$Message=str_ireplace("{#nom}","Limam",$Message);
$code="testcode_token";
$Message=str_ireplace("{#URL}","www.uvt.rnu.tn/tokin/$code",$Message);

echo $Message;
//$message=MessageLog::getMessage("FilterDatas","filterInt","Erreur_Interval","FR");
//AgentLog::Loger("FilterDatas","filterInt","Erreur_INT","FR");



//echo $message;