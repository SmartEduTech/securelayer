<?php 

use PHPUnit\Framework\TestCase;
 
use Smartedutech\Securelayer\Log\AgentLog;
final class TestAgentLog extends TestCase{
    
    public function testIfLogedFileGenerate(){
        $message=AgentLog::Loger("FilterDatas","filterInt","Erreur_INT","FR");
        $filename=__LOG_LAYERSECURE__."/".__LOG_LAYERSECURE__FILENAME__;
        $this->assertFileExists( 
            $filename, 
            "given filename doesn't exists"
        ); 
    }

    public function testEmailLog(){
        $message=AgentLog::Loger("FilterDatas","filterEmail","ERREUR_EMail","FR");
        $this->assertEquals("Erreur d'e-mail",$message);
    }
}