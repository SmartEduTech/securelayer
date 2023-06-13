<?php 

namespace Smartedutech\Securelayer\Filters;

use Smartedutech\Securelayer\Log\AgentLog;

abstract class ScanSqlInjection
{	
	 
    CONST EXPReg="/(ALTER|CREATE|DELETE|DROP|EXEC(UTE){0,1}|INSERT(\s*+INTO){0,1}|MERGE|SELECT|SELECT\s* *|UPDATE|UNION(\s*+ALL){0,1}|\d\s*=\s*\d)/";
	public static function scanSqlInjection($data){
       $SQlInjectionProbable= preg_match_all(EXPReg,$data,$matched);
       if( $SQlInjectionProbable){
        AgentLog::Loger("FilterDatas","filterString","FR",json_encode($matched));
       }
        return array("result"=>$SQlInjectionProbable,"matched"=>$matched);
    }
}
  