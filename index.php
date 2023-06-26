<?php
include "./vendor/autoload.php";

use Smartedutech\Securelayer\Watchdog\WatchDog;

$watchdog = new WatchDog();
$watchdog->run('high_secaurity_strategy');

