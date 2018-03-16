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

 include("config.inc.php"); include("dbfcts.inc.php"); include_once("browserdetect.inc.php");
 $V0d8d8a24=$_GET['click']; $V0cc175b9=explode("-", $V0d8d8a24); $Campaign_id=intval($V0cc175b9[0]);
$V8812c2d4=intval($V0cc175b9[1]); $V9bf300f7=intval($V0cc175b9[2]); $V4afe66d9=""; if (count($V0cc175b9) > 3)
 $V4afe66d9=$V0cc175b9[3]; $REMOTE_ADDR = getOwnIP(); if(!isset($_SERVER)) if(isset($HTTP_SERVER_VARS))
 $_SERVER = $HTTP_SERVER_VARS; else $_SERVER = array(); if(empty($_SERVER['REQUEST_METHOD'])) $_SERVER['REQUEST_METHOD'] = "GET";
if ($DBLink != FALSE) { if ($_SERVER['REQUEST_METHOD'] != "HEAD") { F6e8aaee0($V7a1c9344, $V17bc1009);
$V7a1c9344 = utf8_encode($V7a1c9344); $V17bc1009 = utf8_encode($V17bc1009);
 $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."UserAgents WHERE Campaign_id=$Campaign_id AND IP=".quote($REMOTE_ADDR)." AND UserAgent=".quote($V7a1c9344);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if(db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."UserAgents (Campaign_id, Clicks, UserAgent, IP) VALUES( $Campaign_id, 1, ".quote($V7a1c9344).", ".quote($REMOTE_ADDR)." )";
db_query($Vac5c74b6); } else{
 } db_free_result($Vb4a88417); $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."OSs WHERE Campaign_id=$Campaign_id AND IP=".quote($REMOTE_ADDR)." AND OS=".quote($V17bc1009);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if(db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."OSs (Campaign_id, Clicks, OS, IP) VALUES( $Campaign_id, 1, ".quote($V17bc1009).", ".quote($REMOTE_ADDR)." )";
db_query($Vac5c74b6); } else{
 } db_free_result($Vb4a88417); if ($V8812c2d4 == 1) { $Vac5c74b6 = "UPDATE ".$tablePrefix."Link_Stat1 SET Clicks=Clicks+1 WHERE CampaignLinks_id=$V9bf300f7";
db_query($Vac5c74b6); } if ($V8812c2d4 == 2) { $Va12a3079 = $REMOTE_ADDR; if($IPBlocking == true) {
 $Vac5c74b6 = "SELECT CampaignLinks_id FROM ".$tablePrefix."Link_Stat2 WHERE CampaignLinks_id=$V9bf300f7 AND IP=".quote($Va12a3079);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if (db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Link_Stat2 (CampaignLinks_id, Clicks, ADateTime, IP) VALUES ( $V9bf300f7, 1, ".db_GetNow().", ".quote($Va12a3079)." )";
db_query($Vac5c74b6); } db_free_result($Vb4a88417); $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."Opening_Stat2 WHERE Campaign_id=$Campaign_id AND IP=".quote($Va12a3079);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if (db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Opening_Stat2 (Campaign_id, Clicks, ADateTime, IP) VALUES ( $Campaign_id, 1, ".db_GetNow().", ".quote($Va12a3079)." )";
db_query($Vac5c74b6); } db_free_result($Vb4a88417);
 } else { $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Link_Stat2 (CampaignLinks_id, Clicks, ADateTime) VALUES ( $V9bf300f7, 1, ".db_GetNow()." )";
db_query($Vac5c74b6); } } if ($V4afe66d9 != "") { $Vac5c74b6 = "UPDATE ".$tablePrefix."Link_Stat3 SET Clicks=Clicks + 1, ADateTime=".db_GetNow()." WHERE (CampaignLinks_id=$V9bf300f7) AND (IdentField=".quote($V4afe66d9).")";
db_query($Vac5c74b6); if (db_affected_rows($DBLink) == 0) { $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Link_Stat3 (CampaignLinks_id, Clicks, ADateTime, IdentField) VALUES ( $V9bf300f7, 1, ".db_GetNow().", ".quote($V4afe66d9)." )";
db_query($Vac5c74b6); }
 $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."Opening_Stat3 WHERE Campaign_id=$Campaign_id AND IdentField=".quote($V4afe66d9);
$Vb4a88417 = db_query($Vac5c74b6); if(!$Vb4a88417 || db_num_rows($Vb4a88417) == 0) { $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Opening_Stat3 (Campaign_id, Clicks, ADateTime, IdentField) VALUES ( $Campaign_id, 1, ".db_GetNow().", ".quote($V4afe66d9)." )";
db_query($Vac5c74b6); }
 } } $V47ae9ec4 = ""; $Vac5c74b6="SELECT Link FROM ".$tablePrefix."CampaignLinks WHERE id=$V9bf300f7 AND Campaign_id=$Campaign_id";
$Vb4a88417=db_query($Vac5c74b6); if (db_num_rows($Vb4a88417) == 0) { print '<p>Link nicht gefunden!</p>';
print '<p>Link not found!</p>'; exit; } $Vf1965a85=db_fetch_array($Vb4a88417); if(count($Vf1965a85) > 0) {
 $V2a304a13 = $Vf1965a85[0]; if(strpos($V2a304a13, "#") !== false) { $V47ae9ec4 = substr($V2a304a13, strpos($V2a304a13, "#"));
if(strpos($V47ae9ec4, '?') !== false || strpos($V47ae9ec4, '&') !== false) $V47ae9ec4 = ""; else $V2a304a13 = substr($V2a304a13, 0, strpos($V2a304a13, "#"));
} $V21ffce5b = ""; if(strpos($V2a304a13, "?") !== false) $V21ffce5b = substr($V2a304a13, strpos($V2a304a13, "?") + 1);
if($V21ffce5b != ""){ $V83878c91 = explode("&", $V21ffce5b); reset($_GET); foreach($_GET as $V3c6e0b8a => $V2063c160){
 if($V3c6e0b8a == "click") continue; for($V865c0c0b=0; $V865c0c0b<count($V83878c91); $V865c0c0b++){
 if(strpos($V83878c91[$V865c0c0b], $V3c6e0b8a."=") === false) continue; $V9dd4e461 = explode("=", $V83878c91[$V865c0c0b]);
if(count($V9dd4e461) < 2) continue; if( strpos($V9dd4e461[1], "[") !== false && strpos($V9dd4e461[1], "]") !== false ) {
 $V2a304a13 = str_replace($V83878c91[$V865c0c0b], "$V3c6e0b8a=$V2063c160", $V2a304a13); } } } } reset($_GET);
$V49c1f6ba = array(); foreach($_GET as $V3c6e0b8a => $V2063c160){ if( strpos($V3c6e0b8a, "utm_source") !== false ||
 strpos($V3c6e0b8a, "utm_medium") !== false || strpos($V3c6e0b8a, "utm_term") !== false || strpos($V3c6e0b8a, "utm_content") !== false ||
 strpos($V3c6e0b8a, "utm_campaign") !== false ) $V49c1f6ba[] = "$V3c6e0b8a=$V2063c160"; } if(count($V49c1f6ba) > 0) {
 if(strpos($V2a304a13, "?") === false) $V2a304a13 .= "?".join("&", $V49c1f6ba); else $V2a304a13 .= "&".join("&", $V49c1f6ba);
} $V2a304a13 = str_replace("&amp;", "&", $V2a304a13); header ("Location: ".$V2a304a13.$V47ae9ec4); print '<p>Das angeforderte Dokument befindet sich nun hier: <a href="'.$V2a304a13.$V47ae9ec4.'">'.$V2a304a13.$V47ae9ec4.'</a></p>';
print '<p>The requested document has moved to: <a href="'.$V2a304a13.$V47ae9ec4.'">'.$V2a304a13.$V47ae9ec4.'</a></p>';
} else { print '<p>Link nicht gefunden!</p>'; print '<p>Link not found!</p>'; } exit; } print "<p>Es ist ein Fehler beim Verbindungen mit der Seite aufgetreten.</p>";
print "<p>An Error occured while connecting to URL.</p>"; ?>