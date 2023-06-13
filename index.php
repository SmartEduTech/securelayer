<?php
    include "./vendor/autoload.php";
use Smartedutech\Securelayer\Log\MessageLog;
use Smartedutech\Securelayer\Log\AgentLog;
use Smartedutech\Securelayer\Filters\FilterDatas;
use Smartedutech\Securelayer\Analyser\StrategyAnalyser;
/*
CONST EXPReg="/(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT(\s*+INTO){0,1}|MERGE|SELECT|SELECT\s* *|UPDATE|UNION(\s*+ALL){0,1}|\d\s*=\s*\d)/";
$string="Select * from 1  =1";
preg_match_all(EXPReg,strtoupper($string),$allmatched);
print_r($allmatched);*/
if(count($_POST)>0){

}else{
    ?>
<form method="post">
    <input type="text" name="email">
    <input type="submit" value="send">
</form>
    <?php
}



$app=new StrategyAnalyser();
$app->run();
/*


//FilterDatas::filterEMail("oussama.limam@gmail.com");
$Message=file_get_contents("template.html");
$Message=str_ireplace("{#nom}","Limam",$Message);
$code="testcode_token";
$Message=str_ireplace("{#URL}","www.uvt.rnu.tn/tokin/$code",$Message);

echo $Message;
//$message=MessageLog::getMessage("FilterDatas","filterInt","Erreur_Interval","FR");
//AgentLog::Loger("FilterDatas","filterInt","Erreur_INT","FR");

*/

//echo $message;