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
 $V0d8d8a24=$_GET['click']; $V0cc175b9=explode("-", $V0d8d8a24); $Vb80bb774=intval($V0cc175b9[0]); $Campaign_id=intval($V0cc175b9[1]);
$V8812c2d4=intval($V0cc175b9[2]); $V4afe66d9=""; if (count($V0cc175b9) > 3) $V4afe66d9=$V0cc175b9[3];
$REMOTE_ADDR = getOwnIP(); if(!isset($_SERVER)) if(isset($HTTP_SERVER_VARS)) $_SERVER = $HTTP_SERVER_VARS;
else $_SERVER = array(); if(empty($_SERVER['REQUEST_METHOD'])) $_SERVER['REQUEST_METHOD'] = "GET";
if ($_SERVER['REQUEST_METHOD'] != "HEAD") { $Vac5c74b6 = "SELECT OpeningStatPicture FROM ".$tablePrefix."CampaignOptions WHERE Campaign_id=$Campaign_id";
$Vb4a88417 = db_query($Vac5c74b6); $Vf1965a85=db_fetch_array($Vb4a88417); db_free_result($Vb4a88417);
if(!empty($Vf1965a85["OpeningStatPicture"])) $OpeningStatPicture = $Vf1965a85["OpeningStatPicture"];
F6e8aaee0($V7a1c9344, $V17bc1009); $V7a1c9344 = utf8_encode($V7a1c9344); $V17bc1009 = utf8_encode($V17bc1009);
 
 $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."UserAgents WHERE Campaign_id=$Campaign_id AND IP=".quote($REMOTE_ADDR)." AND UserAgent=".quote($V7a1c9344);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if(db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."UserAgents (Campaign_id, Clicks, UserAgent, IP) VALUES( $Campaign_id, 1, ".quote($V7a1c9344).", ".quote($REMOTE_ADDR)." )";
db_query($Vac5c74b6); } else{
 } db_free_result($Vb4a88417); $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."OSs WHERE Campaign_id=$Campaign_id AND IP=".quote($REMOTE_ADDR)." AND OS=".quote($V17bc1009);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if(db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."OSs (Campaign_id, Clicks, OS, IP) VALUES( $Campaign_id, 1, ".quote($V17bc1009).", ".quote($REMOTE_ADDR)." )";
db_query($Vac5c74b6); } else{
 } db_free_result($Vb4a88417); if ($V8812c2d4 == 1) { $Vac5c74b6 = "UPDATE ".$tablePrefix."Opening_Stat1 SET Clicks=Clicks+1 WHERE id=$Vb80bb774 AND Campaign_id=$Campaign_id";
db_query($Vac5c74b6); } if ($V8812c2d4 == 2) { $Va12a3079 = $REMOTE_ADDR; if($IPBlocking == true) {
 $Vac5c74b6 = "SELECT Campaign_id FROM ".$tablePrefix."Opening_Stat2 WHERE Campaign_id=$Campaign_id AND IP=".quote($Va12a3079);
if(!$MSSQL) $Vac5c74b6 .= " LIMIT 0,1"; $Vb4a88417 = db_query($Vac5c74b6); if (db_num_rows($Vb4a88417) == 0) {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Opening_Stat2 (Campaign_id, Clicks, ADateTime, IP) VALUES ( $Campaign_id, 1, ".db_GetNow().", ".quote($Va12a3079)." )";
db_query($Vac5c74b6); } db_free_result($Vb4a88417); } else { $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Opening_Stat2 (Campaign_id, Clicks, ADateTime) VALUES ( $Campaign_id, 1, ".db_GetNow()." )";
db_query($Vac5c74b6); } } if ($V4afe66d9 != "") { $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Opening_Stat3 (Campaign_id, Clicks, ADateTime, IdentField) VALUES ( $Campaign_id, 1, ".db_GetNow().", ".quote($V4afe66d9)." )";
db_query($Vac5c74b6); } } if ( isset($OpeningStatPicture) && ($OpeningStatPicture != "") ) header ("Location: ".$OpeningStatPicture);
else header ("Location: ".$HTTPURL."point.gif"); ?>