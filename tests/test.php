<?php 

require_once __DIR__ . '/../src/SysLog.php'; // Autoload files using Composer autoload

use coderofsalvation\SysLog;

SysLog::send( "this is a local test " );

SysLog::$hostname = "logs.papertrailapp.com";
SysLog::$port     = 26987;
SysLog::send( "this is a local + papertrail test " );

SysLog::$local = false;
SysLog::send( "this is a papertrail test only" );
