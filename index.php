<?php
include "./vendor/autoload.php";

use Smartedutech\Securelayer\Log\MessageLog;
use Smartedutech\Securelayer\Log\AgentLog;
use Smartedutech\Securelayer\Log\DBAgentLog;
use Smartedutech\Securelayer\Filters\FilterDatas;
use Smartedutech\Securelayer\Analyser\StrategyAnalyser;
use Smartedutech\Securelayer\Watchdog\WatchDog;
use Smartedutech\Securelayer\Watchdog\ClientScan;
use Smartedutech\Securelayer\Watchdog\ActivityScan;


$watchdog = new WatchDog();
$watchdog->run('high_security_strategy');


$app=new StrategyAnalyser();
$app->run();
