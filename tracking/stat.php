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
 include("config.inc.php"); include("dbfcts.inc.php"); function F973bceda($V9e3669d1){
 $V9e3669d1 = str_replace("\r\n", " ", $V9e3669d1); $V9e3669d1 = str_replace("\r", " ", $V9e3669d1);
$V9e3669d1 = str_replace("\n", " ", $V9e3669d1); return $V9e3669d1; } function F97931abe($V9e3669d1){
 $V9e3669d1 = str_replace("\r\n", "*~CRLF~*", $V9e3669d1); $V9e3669d1 = str_replace("\r", "*~CRLF~*", $V9e3669d1);
$V9e3669d1 = str_replace("\n", "*~CRLF~*", $V9e3669d1); return $V9e3669d1; } function SetHTMLHeaders($DefaultPageEncoding) {
 
 @header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
 @header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
 
 @header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0') ; @header('Cache-Control: post-check=0, pre-check=0', false) ;
 
 @header('Pragma: no-cache') ; @header( 'Content-Type: text/html; charset='.$DefaultPageEncoding ) ;
} SetHTMLHeaders('utf-8'); if(isset($_POST['TrackingScriptVersion'])) $V268c8b22=$_POST['TrackingScriptVersion'];
if(isset($_POST['AppName'])) $V3ce53270=$_POST['AppName']; if(isset($_POST['Action'])) $V6670aba0=$_POST['Action'];
if(isset($_POST['Command'])) $V243253ac=$_POST['Command']; if(isset($_POST['CampaignName'])) $V664f825b=$_POST['CampaignName'];
if(isset($_POST['CampaignId'])) $Va751637b=intval($_POST['CampaignId']); if(isset($_POST['Userpassword']))
 $V29c76090=$_POST['Userpassword']; $V75f23c2e=$_POST['MySQLServerName']; $V0d0311fd=$_POST['MySQLUserName'];
$V9ec70870=$_POST['MySQLPassword']; $Ve097d10c=$_POST['MySQLDBName']; if(isset($_POST['IsMSSQL'])) if ( $_POST['IsMSSQL'] == 'true' )
 $MSSQL = true; if(get_magic_quotes_gpc()) $V75f23c2e = stripslashes($V75f23c2e); if($DBLink) db_close($DBLink);
$DBLink = db_connect ($V75f23c2e, $V0d0311fd, $V9ec70870, $Ve097d10c); if ($DBLink == FALSE) { print ("State: ".$ServerAccessFailure. "\t". db_error()."\n");
exit; } if(!$MSSQL) {
 @mysql_query("SET NAMES 'utf8'", $DBLink); @mysql_query("SET CHARACTER SET 'utf8'", $DBLink);
 
 @mysql_query('SET SQL_MODE=""', $DBLink); } if (db_select_db ($Ve097d10c) == FALSE) { print ("State: ".$DatabaseSelectFailure. "\t". db_error()."\n");
exit; } if(!$MSSQL) {
 @mysql_query("SET NAMES 'utf8'", $DBLink); @mysql_query("SET CHARACTER SET 'utf8'", $DBLink);
 
 @mysql_query('SET SQL_MODE=""', $DBLink); } if ($V243253ac=="LIST") { if($MSSQL) $V9e3669d1="CONVERT(char(4), DATEPART(yyyy, SendDateTime)) + '-' + CONVERT(char(2), DATEPART(mm, SendDateTime)) + '-' + CONVERT(char(2), DATEPART(dd, SendDateTime)) + 'T' + CONVERT(char(2), DATEPART(hh, SendDateTime)) + ':' + CONVERT(char(2), DATEPART(mi, SendDateTime)) + ':' + CONVERT(char(2), DATEPART(ss, SendDateTime))";
else $V9e3669d1="SendDateTime"; $Vac5c74b6="SELECT id, $V9e3669d1, CreateOpening_Stat1, CreateOpening_Stat2, CreateLink_Stat1, CreateLink_Stat2, CreateOpening_Stat3, CreateLink_Stat3, TrackingRecipientsGroup, RecipientsCount FROM ".$tablePrefix."Campaigns LEFT JOIN ".$tablePrefix."CampaignOptions ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignOptions.Campaign_id WHERE CampaignName=".quote($V664f825b)." AND PASSWORD=".quote($V29c76090)." ORDER BY SendDateTime DESC";
$Vb4a88417=db_query($Vac5c74b6); print "Result:\n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(10, count($Vf1965a85)); $V865c0c0b++) { print $Vf1965a85[$V865c0c0b];
if ($V865c0c0b != count($Vf1965a85) - 1) print "\t"; } print "\n"; } exit; } if ($V243253ac == "GETOPENINGSTAT1") {
 $Vac5c74b6="SELECT Clicks FROM ".$tablePrefix."Opening_Stat1 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."Opening_Stat1.Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; $Vf1965a85=db_fetch_array($Vb4a88417); print $Vf1965a85[0]."\n";
exit; } if ($V243253ac == "GETOPENINGSTAT2") { if($MSSQL) $V9e3669d1="CONVERT(char(4), DATEPART(yyyy, ADateTime)) + '-' + CONVERT(char(2), DATEPART(mm, ADateTime)) + '-' + CONVERT(char(2), DATEPART(dd, ADateTime)) + 'T' + CONVERT(char(2), DATEPART(hh, ADateTime)) + ':' + CONVERT(char(2), DATEPART(mi, ADateTime)) + ':' + CONVERT(char(2), DATEPART(ss, ADateTime))";
else $V9e3669d1="ADateTime"; $Vac5c74b6="SELECT Clicks, $V9e3669d1 FROM ".$tablePrefix."Opening_Stat2 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."Opening_Stat2.Campaign_id=$Va751637b ORDER BY ADateTime";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(2, count($Vf1965a85)); $V865c0c0b++) { print $Vf1965a85[$V865c0c0b];
if ($V865c0c0b != min(2, count($Vf1965a85)) - 1) print "\t"; } print "\n"; } exit; } if ($V243253ac == "GETOPENINGSTAT3") {
 if($MSSQL) $V9e3669d1="CONVERT(char(4), DATEPART(yyyy, ADateTime)) + '-' + CONVERT(char(2), DATEPART(mm, ADateTime)) + '-' + CONVERT(char(2), DATEPART(dd, ADateTime)) + 'T' + CONVERT(char(2), DATEPART(hh, ADateTime)) + ':' + CONVERT(char(2), DATEPART(mi, ADateTime)) + ':' + CONVERT(char(2), DATEPART(ss, ADateTime))";
else $V9e3669d1="ADateTime"; $Vac5c74b6="SELECT Clicks, $V9e3669d1, IdentField FROM ".$tablePrefix."Opening_Stat3 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."Opening_Stat3.Campaign_id=$Va751637b ORDER BY IdentField, ADateTime";
$Vb4a88417=db_query($Vac5c74b6); $Vd9f3d1d3 = ""; $V6114cee4 = ""; $V80f703d6 = 0; print "Result: \n";
while ($Vf1965a85=db_fetch_array($Vb4a88417)) { if ($Vd9f3d1d3 != $Vf1965a85[2]) { $Vd9f3d1d3 = $Vf1965a85[2];
if ($V6114cee4 != "") { $Vd9567975 = explode ("\t", $V6114cee4); $Vd9567975[0] = $Vd9567975[0] + $V80f703d6 - 1;
$V6114cee4 = implode("\t", $Vd9567975); print $V6114cee4; $V6114cee4 = ""; } $V80f703d6 = 0; for($V865c0c0b=0; $V865c0c0b<min(3, count($Vf1965a85)); $V865c0c0b++) {
 print $Vf1965a85[$V865c0c0b]; if ($V865c0c0b != min(3, count($Vf1965a85)) - 1) print "\t"; } print "\n";
} else { $V6114cee4 = ""; $V80f703d6 = $V80f703d6 + $Vf1965a85[0]; for($V865c0c0b=0; $V865c0c0b<min(3, count($Vf1965a85)); $V865c0c0b++) {
 $V6114cee4 .= $Vf1965a85[$V865c0c0b]; if ($V865c0c0b != min(3, count($Vf1965a85)) - 1) $V6114cee4 .= "\t";
} $V6114cee4 .= "\n"; } } if ($V6114cee4 != "") { $Vd9567975 = explode ("\t", $V6114cee4); $Vd9567975[0] = $Vd9567975[0] + $V80f703d6 - 1;
$V6114cee4 = implode("\t", $Vd9567975); print $V6114cee4; } exit; } if ($V243253ac == "GETGEOOPENINGSTAT") {
 $Vac5c74b6="SELECT DISTINCT IP FROM ".$tablePrefix."Opening_Stat2 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."Opening_Stat2.Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(1, count($Vf1965a85)); $V865c0c0b++) { print $Vf1965a85[$V865c0c0b];
} print "\n"; } exit; } if($V243253ac == "GETLINKSTAT1") { $Vac5c74b6="SELECT Clicks, Link, Description FROM ".$tablePrefix."Link_Stat1 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat1.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$Va751637b ORDER BY Clicks DESC";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(3, count($Vf1965a85)); $V865c0c0b++) { print F973bceda($Vf1965a85[$V865c0c0b]);
if ($V865c0c0b != min(3, count($Vf1965a85)) - 1) print "\t"; } print "\n"; } exit; } if($V243253ac == "GETLINKSTAT2") {
 if($MSSQL) $V9e3669d1="CONVERT(char(4), DATEPART(yyyy, ADateTime)) + '-' + CONVERT(char(2), DATEPART(mm, ADateTime)) + '-' + CONVERT(char(2), DATEPART(dd, ADateTime)) + 'T' + CONVERT(char(2), DATEPART(hh, ADateTime)) + ':' + CONVERT(char(2), DATEPART(mi, ADateTime)) + ':' + CONVERT(char(2), DATEPART(ss, ADateTime))";
else $V9e3669d1="ADateTime"; $Vac5c74b6="SELECT Clicks, $V9e3669d1, Link, Description FROM ".$tablePrefix."Link_Stat2 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat2.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$Va751637b ORDER BY ADateTime DESC, Clicks DESC";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(4, count($Vf1965a85)); $V865c0c0b++) { print F973bceda($Vf1965a85[$V865c0c0b]);
if ($V865c0c0b != min(4, count($Vf1965a85)) - 1) print "\t"; } print "\n"; } exit; } if($V243253ac == "GETLINKSTAT3") {
 $Vac5c74b6="SELECT Clicks, Link, Description, IdentField FROM ".$tablePrefix."Link_Stat3 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat3.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$Va751637b ORDER BY IdentField, Link";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(4, count($Vf1965a85)); $V865c0c0b++) { print F973bceda($Vf1965a85[$V865c0c0b]);
if ($V865c0c0b != min(4, count($Vf1965a85)) - 1) print "\t"; } print "\n"; } exit; } if($V243253ac == "GETGEOLINKSTAT") {
 $Vac5c74b6="SELECT IP FROM ".$tablePrefix."Link_Stat2 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat2.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($V29c76090)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(1, count($Vf1965a85)); $V865c0c0b++) { print $Vf1965a85[$V865c0c0b];
} print "\n"; } exit; } if ($V243253ac == "GETUSERAGENTSTAT") { if(!$MSSQL) $Vac5c74b6 = "SELECT UserAgent, SUM(Clicks) AS ClicksCount FROM ".$tablePrefix."UserAgents WHERE Campaign_id=$Va751637b GROUP BY UserAgent ORDER BY ClicksCount DESC LIMIT 0, 20";
else $Vac5c74b6 = "SELECT TOP 20 UserAgent, SUM(Clicks) AS ClicksCount FROM ".$tablePrefix."UserAgents WHERE Campaign_id=$Va751637b GROUP BY UserAgent ORDER BY ClicksCount DESC";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(2, count($Vf1965a85)); $V865c0c0b++) { print $Vf1965a85[$V865c0c0b];
if ($V865c0c0b != min(2, count($Vf1965a85)) - 1) print "\t"; } print "\n"; } exit; } if ($V243253ac == "GETOSSTAT") {
 if(!$MSSQL) $Vac5c74b6 = "SELECT OS, SUM(Clicks) AS ClicksCount FROM ".$tablePrefix."OSs WHERE Campaign_id=$Va751637b GROUP BY OS ORDER BY ClicksCount DESC LIMIT 0, 20";
else $Vac5c74b6 = "SELECT TOP 20 OS, SUM(Clicks) AS ClicksCount FROM ".$tablePrefix."OSs WHERE Campaign_id=$Va751637b GROUP BY OS ORDER BY ClicksCount DESC";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 for($V865c0c0b=0; $V865c0c0b<min(2, count($Vf1965a85)); $V865c0c0b++) { print $Vf1965a85[$V865c0c0b];
if ($V865c0c0b != min(2, count($Vf1965a85)) - 1) print "\t"; } print "\n"; } exit; } if($V243253ac == "GETNEWSLETTERTEXT") {
 $Vac5c74b6="SELECT NewsletterText FROM ".$tablePrefix."CampaignOptions WHERE Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); print "Result: \n"; while ($Vf1965a85=db_fetch_array($Vb4a88417)) {
 print F97931abe($Vf1965a85[0]); print "\n"; } exit; } if ($V243253ac == "REMOVECAMPAIGN") { $Vac5c74b6="DELETE FROM ".$tablePrefix."Campaigns WHERE Password=".quote($V29c76090)." AND id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); if (db_errno() != 0) { print "ERROR(1): ".db_error(); print "\n";
exit; } $Vac5c74b6="SELECT id FROM ".$tablePrefix."CampaignLinks WHERE Campaign_id=$Va751637b"; $Vb4a88417=db_query($Vac5c74b6);
while ($Vf1965a85=db_fetch_array($Vb4a88417)) { for($V865c0c0b=0; $V865c0c0b<min(1, count($Vf1965a85)); $V865c0c0b++) {
 $Vac5c74b6="DELETE FROM ".$tablePrefix."Link_Stat1 WHERE CampaignLinks_id=".$Vf1965a85[$V865c0c0b];
db_query($Vac5c74b6); $Vac5c74b6="DELETE FROM ".$tablePrefix."Link_Stat2 WHERE CampaignLinks_id=".$Vf1965a85[$V865c0c0b];
db_query($Vac5c74b6); $Vac5c74b6="DELETE FROM ".$tablePrefix."Link_Stat3 WHERE CampaignLinks_id=".$Vf1965a85[$V865c0c0b];
db_query($Vac5c74b6); } } db_free_result($Vb4a88417); $Vac5c74b6="DELETE FROM ".$tablePrefix."CampaignLinks WHERE Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); if (db_errno() != 0) { print "ERROR(2): ".db_error(); print "\n";
exit; } $Vac5c74b6="DELETE FROM ".$tablePrefix."CampaignOptions WHERE Campaign_id=$Va751637b"; $Vb4a88417=db_query($Vac5c74b6);
if (db_errno() != 0) { print "ERROR(3): ".db_error(); print "\n"; exit; } $Vac5c74b6="DELETE FROM ".$tablePrefix."Opening_Stat2 WHERE Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); if (db_errno() != 0) { print "ERROR(4): ".db_error(); print "\n";
exit; } $Vac5c74b6="DELETE FROM ".$tablePrefix."Opening_Stat3 WHERE Campaign_id=$Va751637b"; $Vb4a88417=db_query($Vac5c74b6);
if (db_errno() != 0) { print "ERROR(6): ".db_error(); print "\n"; exit; } $Vac5c74b6="DELETE FROM ".$tablePrefix."Opening_Stat1 WHERE Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); if (db_errno() != 0) { print "ERROR(5): ".db_error(); print "\n";
exit; } $Vac5c74b6="DELETE FROM ".$tablePrefix."UserAgents WHERE Campaign_id=$Va751637b"; $Vb4a88417=db_query($Vac5c74b6);
if (db_errno() != 0) { print "ERROR(5): ".db_error(); print "\n"; exit; } $Vac5c74b6="DELETE FROM ".$tablePrefix."OSs WHERE Campaign_id=$Va751637b";
$Vb4a88417=db_query($Vac5c74b6); if (db_errno() != 0) { print "ERROR(5): ".db_error(); print "\n";
exit; } print "OK:DONE"; exit; } ?>