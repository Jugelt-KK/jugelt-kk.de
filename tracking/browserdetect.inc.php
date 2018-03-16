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

 require 'uasparser.php'; if (!function_exists ('stripos') ) { function stripos ( $Va1cae1a6, $V4bf84bab, $V7a86c157=NULL ) {
 if (isset($V7a86c157) && $V7a86c157 != NULL) return strpos( strtolower($Va1cae1a6), strtolower($V4bf84bab), $V7a86c157);
else return strpos(strtolower($Va1cae1a6), strtolower($V4bf84bab), $V4bf84bab); } } function F6e8aaee0(&$V8e3f1bbb, &$Vdd302f94){
 $V8e3f1bbb = ""; $Vdd302f94 = ""; $Vc66c00ae = ""; $Vc0635a52 = ""; if(!empty($_SERVER['HTTP_REFERER']))
 $Vc66c00ae = $_SERVER['HTTP_REFERER']; if(!empty($_SERVER['HTTP_USER_AGENT'])) $Vc0635a52 = $_SERVER['HTTP_USER_AGENT'];
 
 if($Vc66c00ae != "") { if(stripos($Vc66c00ae, "mail.live.com") !== false) $V8e3f1bbb = "name="."Windows Live Mail".";icon=ua/hotmail.gif";
if(stripos($Vc66c00ae, "mail.yahoo.com") !== false) $V8e3f1bbb = "name="."Yahoo! Mail".";icon=ua/yahoo.gif";
if(stripos($Vc66c00ae, "mail.aol.com") !== false) $V8e3f1bbb = "name="."AOL Mail".";icon=ua/aol.gif";
if(stripos($Vc66c00ae, "mail.google.com") !== false || stripos($Vc66c00ae, ".gmail.com") !== false)
 $V8e3f1bbb = "name="."Google Mail".";icon=ua/google.gif"; if(stripos($Vc66c00ae, ".gmx.net") !== false || stripos($Vc66c00ae, ".gmx.com") !== false)
 $V8e3f1bbb = "name="."GMX".";icon=ua/gmx.gif"; if(stripos($Vc66c00ae, ".web.de") !== false) $V8e3f1bbb = "name="."Web.de".";icon=ua/webde.gif";
if(stripos($Vc66c00ae, ".arcor.net") !== false || stripos($Vc66c00ae, ".arcor.de") !== false) $V8e3f1bbb = "name="."Arcor".";icon=ua/arcor.gif";
} if($Vc0635a52 != "") { $V3643b863 = new UASparser(); $Vd6fe1d0b = getcwd(); if($Vd6fe1d0b === false)
 $Vd6fe1d0b = "."; $V3643b863->SetCacheDir($Vd6fe1d0b); $V2cb9df98 = $V3643b863->Parse($Vc0635a52);
if($V8e3f1bbb == "") { if(isset($V2cb9df98["ua_name"])) $V8e3f1bbb = "name=".$V2cb9df98["ua_name"].";icon=";
else if(isset($V2cb9df98["ua_family"])) $V8e3f1bbb = "name=".$V2cb9df98["ua_family"].";icon="; if(isset($V2cb9df98["ua_icon"]) && $V8e3f1bbb != "")
 $V8e3f1bbb .= $V2cb9df98["ua_icon"]; else if($V8e3f1bbb != "") $V8e3f1bbb .= "ua/unknown.gif"; }
if(isset($V2cb9df98["os_name"])) { $Vdd302f94 = "name=".$V2cb9df98["os_name"].";icon="; if(isset($V2cb9df98["os_icon"])) {
 $Vdd302f94 .= $V2cb9df98["os_icon"]; } else $Vdd302f94 .= "ua/unknown.gif"; } } } ?>