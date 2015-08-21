<? 
/*
 * Copyright 2015 Leon van Kammen / Coder of Salvation. All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 * 
 *    1. Redistributions of source code must retain the above copyright notice, this list of
 *       conditions and the following disclaimer.
 * 
 *    2. Redistributions in binary form must reproduce the above copyright notice, this list
 *       of conditions and the following disclaimer in the documentation and/or other materials
 *       provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY Leon van Kammen / Coder of Salvation AS IS'' AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
 * FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL Leon van Kammen / Coder of Salvation OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * The views and conclusions contained in the software and documentation are those of the
 * authors and should not be interpreted as representing official policies, either expressed
 * or implied, of Leon van Kammen / Coder of Salvation 
 */

namespace coderofsalvation;

class Syslog{

  public static $hostname   = false;
  public static $port       = 514;
  public static $program    = "[]";
  public static $embedLevel = true;
  public static $local      = true;

  public static function level2String($level){
    // taken from syslog + http:// nl3.php.net/syslog for log levels
    switch( $level ){
      case LOG_EMERG:   return "EMERGENCY"; break; // system is unusable
      case LOG_ALERT:   return "ALERT";     break; // action must be taken immediately
      case LOG_CRIT:    return "CRITICAL";  break; // critical conditions
      case LOG_ERR:     return "ERROR";     break; // error conditions
      case LOG_WARNING: return "WARNING";   break; // warning conditions
      case LOG_NOTICE:  return "NOTICE";    break; // normal, but significant, condition
      case LOG_INFO:    return "INFO";      break; // informational message
      case LOG_DEBUG:   return "DEBUG";     break; // debug-level message
    }
  }

  public static function send( $message, $level = LOG_NOTICE, $component = "web" ){
    if( self::$embedLevel ) $message = "[".self::level2String($level)."] ".$message;
   	if( self::$local      ) syslog( $level, $message );
	if( self::$hostname == false ) return;
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    $facility = 1; // user level
    $pri = ($facility*8)+$level; // multiplying the Facility number by 8 + adding the nume
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    foreach(explode("\n", $message) as $line) {
      $syslog_message = "<{$pri}>" . date('M d H:i:s ') . self::$program . ' ' . $component . ': ' . $message;
      socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, self::$hostname, self::$port );
    }
    socket_close($sock);    
  }
}

