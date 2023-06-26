<?php
include "./vendor/autoload.php";

use Smartedutech\Securelayer\Watchdog\WatchDog;
use Smartedutech\Securelayer\Analyser\StrategyAnalyser;
//$main = new StrategyAnalyser();
//$watchdog = new WatchDog();
//$watchdog->run('high_secaurity_strategy');




if(count($_POST)>0){
echo "<h1>Page de test</h1>";
}else{
    ?>
<form method="post">
    EMAIL : <input type="text" name="email">
    <br>
    CIN : <input type="text" name="cin">
    <br><input type="submit" value="send">
</form>
    <?php
}



$app=new StrategyAnalyser();
$app->run();


