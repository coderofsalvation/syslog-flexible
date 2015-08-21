SysLog-Flexible 
===============

<p align="center">
  <img alt="" width="250" src="http://www.gifbin.com/bin/082014/1408987888_printer_catches_paper.gif"/>
</p>
Minimal class to easily log messages to local syslog and/or papertrail and/or a remote syslog server.

## Usage 

    $ composer require coderofsalvation/syslog

And then 

    <? 
      	use coderofsalvation\Syslog;
		SysLog::send( "this is a local test " );

		SysLog::$hostname = "logs.papertrailapp.com";
		SysLog::$port     = 26987;
		SysLog::send( "this is a local + papertrail test " );

		SysLog::$local = false;
		SysLog::send( "this is a papertrail test only" );
    ?> 


## License

BSD
