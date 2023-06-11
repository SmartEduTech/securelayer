<?php 
namespace Smartedutech\Securelayer\Log;

abstract class AgentLog{

  private static function LogSaveMessageInFile($Message){
   FileAgentLog::FileSaveLogMessage($Message);
  } 
private function addTime($Message){
  return date("\n[d-m-D h:i:s]")." => ". $Message ;
}
  private static function LogMessageInsertInDB($Message){

  } 
/**
 * Type : File| DB
 * Langue: FR | AN | AR
 */
  public static function Loger($Class,$Func,$Msg,$Langue="FR",$type="File"){
    $Message = MessageLog::getMessage($Class,$Func,$Msg,$Langue);
    $finalMessage=self::addTime("$Class:$Func:$Msg => $Message");
    if($type=="File"){ 
        self::LogSaveMessageInFile($finalMessage);
    }else{
        self::LogMessageInsertInDB($finalMessage);
    }
    return $Message;
  }
}