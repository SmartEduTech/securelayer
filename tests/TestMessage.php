<?php 

use PHPUnit\Framework\TestCase;
use Smartedutech\Securelayer\Log\MessageLog;

final class TestMessage extends TestCase{
    
    public function testIfReadMessage(){
        $message=MessageLog::getMessage("FilterDatas","filterInt","Erreur_Interval","FR");
 
        $this->assertEquals("Erreur d'entier n'est pas dans l'interval",$message);
    }
}