<?php
#############################################################################
#                    SUPERMAILER TRACKING SCRIPT                            #
#      Copyright © 2003-2016 Mirko Boeer Softwareentwicklungen Leipzig      #
#                 http://www.supermailer.de/                                #
#                                                                           #
# Dieses Script ist URHEBERRECHTLICH GESCHÜTZT und KEIN Open Source Script! #
#                                                                           #
# Es ist NICHT gestattet dieses Script ohne Einverstaendnis des Autors      #
# weiterzugeben oder in anderen Anwendungen einzusetzen.                    #
#                                                                           #
# Systemvoraussetzungen: PHP 4+ und Windows/Unix                            #
#############################################################################
 error_reporting(0); ini_set("display_errors", 0); $V07274a4c="99999 ERR"; $ServerAccessFailure="1 ERR";
$DatabaseSelectFailure="2 ERR"; $Vb4902255="3 ERR"; $V32a19a28="4 ERR"; $V5fea6ef8="5 ERR"; $Vbfbd569f="6 ERR";
$V3b8753ae="7 ERR"; $V58a46475="8 ERR"; $V1795b35d="9 ERR"; $Vfc3b2f76="10 ERR"; $V8aa5e251="11 ERR";
$V78002216="12 ERR"; function getOwnIP() { if (defined('AF_INET6') && isset($_SERVER['REMOTE_ADDR']) && function_exists("filter_var")) {
     if(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
       return $_SERVER['REMOTE_ADDR'];
    } if (!(isset($_SERVER['HTTP_VIA']) || isset($_SERVER['HTTP_CLIENT_IP']))) {
 $V957b527b = long2ip(ip2long($_SERVER['REMOTE_ADDR'])); } else { $Va94aa71c = long2ip(ip2long($_SERVER['REMOTE_ADDR']));
$V42b6379e = "0.0.0.0"; if (isset($_SERVER['HTTP_CLIENT_IP'])) { $V42b6379e = substr($_SERVER['HTTP_CLIENT_IP'], 0, strpos($_SERVER['HTTP_CLIENT_IP'],".")) * 1;
} else { if (isset($_SERVER['HTTP_VIA'])) { $V42b6379e = substr($_SERVER['HTTP_VIA'], 0, strpos($_SERVER['HTTP_VIA'], ".")) * 1;
} } if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $V78b1e6d7 = substr($_SERVER['HTTP_X_FORWARDED_FOR'], 0, strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ".")) * 1;
else $V78b1e6d7 = ""; if ($V78b1e6d7 != "" && !($V78b1e6d7 == 10 || $V78b1e6d7 == 192 || $V78b1e6d7 == 127 || $V78b1e6d7 == 224)) { 
 $V957b527b = long2ip(ip2long($_SERVER['HTTP_X_FORWARDED_FOR'])); } elseif(isset($_SERVER['HTTP_CLIENT_IP']) && !($V42b6379e == 10 || $V42b6379e == 192 || $V42b6379e == 127 || $V42b6379e == 224)) {
 $V957b527b = long2ip(ip2long($_SERVER['HTTP_CLIENT_IP'])); } else { $V957b527b = $Va94aa71c; } } $V4a8a08f0 = strpos($V957b527b, ",");
if ($V4a8a08f0 !== false) $V957b527b = substr($V957b527b, 0, $V4a8a08f0); if(strpos($V957b527b, "'") !== false)
 $V957b527b = str_replace("'", "", $V957b527b); return $V957b527b; } ?>