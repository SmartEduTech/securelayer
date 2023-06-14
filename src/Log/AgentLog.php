<?php 
namespace Smartedutech\Securelayer\Log;

abstract class AgentLog{

  public static $_LogStrategy;

  public static function InitLogStategy(array $Strategy):void{

  }

  private static function LogSaveMessageInFile($Message){
    FileAgentLog::FileSaveLogMessage($Message);
  } 
  private static function addTime($Message){
    return date("\n[d-m-D h:i:s]").";". $Message ;
  }
    private static function LogMessageInsertInDB($Message){

    } 
  /**
   * Type : File| DB
   * Langue: FR | AN | AR
   */
    public static function Loger($Class,$Func,$Msg,$Langue="FR",$additional="",$type="File"){
      $Message = MessageLog::getMessage($Class,$Func,$Msg,$Langue);
      $finalMessage=self::addTime("$Class;$Func;$Msg;$Message;$additional");
      if($type=="file"){
        $finalMessage.="\n";
      }
      
      if($type=="File"){ 
          self::LogSaveMessageInFile($finalMessage);
      }else{
          self::LogMessageInsertInDB($finalMessage);
      }
      return $Message;
    }


    public static function LogerMessage(string $message){
      $LigneMessage=date("d-m-D h:i:s").";". $message."\n" ;
      self::LogSaveMessageInFile($LigneMessage);
    }
}