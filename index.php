<?php
include "./vendor/autoload.php";

use Smartedutech\Securelayer\Watchdog\WatchDog;
use Smartedutech\Securelayer\Analyser\StrategyAnalyser;
//$main = new StrategyAnalyser();
//$watchdog = new WatchDog();
//$watchdog->run('high_secaurity_strategy');




if(count($_POST)>0){
echo "test";
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


