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

 include("config.inc.php"); include("dbfcts.inc.php"); $V268c8b22=$_POST['TrackingScriptVersion'];
$V3ce53270=$_POST['AppName']; $V6670aba0=$_POST['Action']; if(isset($_POST['Campaign_id'])) $Vb0fe958e=intval($_POST['Campaign_id']);
if(isset($_POST['TrackingRecipientsGroup'])) $Vc747a98a = $_POST['TrackingRecipientsGroup']; if(isset($_POST['TrackingRecipientsCount']))
 $V02d924d9 = intval($_POST['TrackingRecipientsCount']); else $V02d924d9 = 0; if(isset($_POST['LinkStat1']))
 $Vaa1c91d2=$_POST['LinkStat1']; if(isset($_POST['Links'])) $V04f1b044=$_POST['Links']; if(isset($_POST['CampaignName']))
 $V664f825b=$_POST['CampaignName']; if(isset($_POST['CampaignPassword'])) $Vddbb793f=$_POST['CampaignPassword'];
if(isset($_POST['CreateOpening_Stat1'])) $Va348f783=$_POST['CreateOpening_Stat1']; if(isset($_POST['CreateOpening_Stat2']))
 $V99670059=$_POST['CreateOpening_Stat2']; if(isset($_POST['CreateOpening_Stat3'])) $Vc75dda94=$_POST['CreateOpening_Stat3'];
if(isset($_POST['CreateLink_Stat1'])) $Vbcc6b58d=$_POST['CreateLink_Stat1']; if(isset($_POST['CreateLink_Stat2']))
 $V789de835=$_POST['CreateLink_Stat2']; if(isset($_POST['CreateLink_Stat3'])) $V19dfde85=$_POST['CreateLink_Stat3'];
$V5986673d=""; if(isset($_POST['NewsletterText'])) $V5986673d=$_POST['NewsletterText']; $Va17670b6="";
if(isset($_POST['OpeningStatPicture'])) $Va17670b6=$_POST['OpeningStatPicture']; function F973bceda($V9e3669d1){
 $V9e3669d1 = str_replace("\r\n", " ", $V9e3669d1); $V9e3669d1 = str_replace("\r", " ", $V9e3669d1);
$V9e3669d1 = str_replace("\n", " ", $V9e3669d1); return $V9e3669d1; } if ($V6670aba0 == "AddCampaign") {
 $Vac5c74b6 = "INSERT INTO ".$tablePrefix."Campaigns (CampaignName, SendDateTime, Password) VALUES (".quote($V664f825b).", ".db_GetNow().", ".quote($Vddbb793f).")";
$Vb4a88417=db_query($Vac5c74b6); if ($Vb4a88417 == FALSE || db_error() != "") { print ("State: ".$V32a19a28. "\t". $Vac5c74b6 . " " . db_error()."\n");
exit; } $Vb4a88417 = db_LASTINSERTID($tablePrefix."Campaigns"); if ($Vb4a88417 == FALSE || db_error() != "") {
 print ("State: ".$V5fea6ef8. "\t". db_error()."\n"); exit; } $Vf1965a85=db_fetch_array($Vb4a88417);
$Vb339fa15 = $Vf1965a85[0]; if($Vb339fa15 == 0) { print ("State: ".$Vbfbd569f. "\t". db_error()."\n");
exit; } $Vac5c74b6="INSERT INTO ".$tablePrefix."CampaignOptions (Campaign_id, OpeningStatPicture, RecipientsCount, TrackingRecipientsGroup, CreateOpening_Stat1, CreateOpening_Stat2, CreateOpening_Stat3, CreateLink_Stat1, CreateLink_Stat2, CreateLink_Stat3, NewsletterText) VALUES ($Vb339fa15, ".quote($Va17670b6).", $V02d924d9, ".quote($Vc747a98a).", $Va348f783, $V99670059, $Vc75dda94, $Vbcc6b58d, $V789de835, $V19dfde85, ".quote($V5986673d).")";
$Vb4a88417=db_query($Vac5c74b6); if ($Vb4a88417 == FALSE || db_error() != "") { print ("State: ".$V3b8753ae. "\t". db_error()."\n");
exit; } print "OK ".$Vb339fa15; exit; } else if ($V6670aba0 == "ModifyCampaign") { $Vac5c74b6="UPDATE ".$tablePrefix."CampaignOptions SET RecipientsCount=$V02d924d9 WHERE Campaign_id=$Vb0fe958e";
$Vb4a88417=db_query($Vac5c74b6); if ($Vb4a88417 == FALSE || db_error() != "") { print ("State: ".$V3b8753ae. "\t". db_error()."\n");
exit; } print "OK ".$Vb0fe958e; exit; } else if ($V6670aba0 == "AddOpeningStat1") { $Vac5c74b6="INSERT INTO ".$tablePrefix."Opening_Stat1 (Campaign_id, Clicks) VALUES($Vb0fe958e, 0)";
$Vb4a88417=db_query($Vac5c74b6); if ($Vb4a88417 == FALSE || db_error() != "") { print ("State: ".$V5fea6ef8. "\t". db_error()."\n");
exit; } $Vb4a88417 = db_LASTINSERTID($tablePrefix."Opening_Stat1"); $Vf1965a85=db_fetch_array($Vb4a88417);
$V0dbde4c8 = $Vf1965a85[0]; if($V0dbde4c8 == 0) { print ("State: ".$Vbfbd569f. "\t". db_error()."\n");
exit; } print "OK ".$V0dbde4c8; } else if ($V6670aba0 == "AddCampaignLinks") { $Vbf516925=array();
for($V865c0c0b=0; $V865c0c0b<count($V04f1b044); $V865c0c0b++) { if($V04f1b044[$V865c0c0b] != "") {
 $V97e7c9a7=substr($V04f1b044[$V865c0c0b], 0, strpos($V04f1b044[$V865c0c0b], "\t")); $Description=substr($V04f1b044[$V865c0c0b], strpos($V04f1b044[$V865c0c0b], "\t") + 1, strlen($V04f1b044[$V865c0c0b]));
$V97e7c9a7 = str_replace("\r\n", " ", $V97e7c9a7); $V97e7c9a7 = str_replace("\r", " ", $V97e7c9a7);
$V97e7c9a7 = str_replace("\n", " ", $V97e7c9a7); $Description = str_replace("\r\n", " ", $Description);
$Description = str_replace("\r", " ", $Description); $Description = str_replace("\n", " ", $Description);
$Vac5c74b6="INSERT INTO ".$tablePrefix."CampaignLinks (Campaign_id, Link, Description) VALUES ( $Vb0fe958e, ".quote($V97e7c9a7).", ".quote($Description)." )";
$Vb4a88417=db_query($Vac5c74b6); if ($Vb4a88417 == FALSE || db_error() != "") { print ("State: ".$V58a46475. "\t". db_error()."\n"." SQL: $Vac5c74b6"."\n");
exit; } $Vb4a88417 = db_LASTINSERTID($tablePrefix."CampaignLinks"); $Vf1965a85=db_fetch_array($Vb4a88417);
$Vb80bb774 = $Vf1965a85[0]; if($Vb80bb774 == 0) { print ("State: ".$Vbfbd569f. "\t". db_error()."\n");
exit; } $Vbf516925[] = $Vb80bb774; if($Vaa1c91d2 != 0) { $Vac5c74b6="INSERT INTO ".$tablePrefix."Link_Stat1 (CampaignLinks_id, Clicks) VALUES ($Vb80bb774, 0)";
$Vb4a88417=db_query($Vac5c74b6); if ($Vb4a88417 == FALSE || db_error() != "") { print ("State: ".$V1795b35d. "\t". db_error()."\n");
exit; } } } } print "OK ".count($Vbf516925)."\n"; for($V865c0c0b=0; $V865c0c0b<count($Vbf516925); $V865c0c0b++) {
 print $Vbf516925[$V865c0c0b]."\n"; } } else if ($V6670aba0 == "GetExistingCampaignIDs") { $Vac5c74b6 = "SELECT ".$tablePrefix."Campaigns.id, OpeningStatPicture FROM ".$tablePrefix."Campaigns LEFT JOIN ".$tablePrefix."CampaignOptions ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignOptions.Campaign_id WHERE id=$Vb0fe958e AND CampaignName=".quote($V664f825b)." AND PASSWORD=".quote($Vddbb793f);
$Vb4a88417=db_query($Vac5c74b6); if(!($Vf1965a85=db_fetch_array($Vb4a88417))){ print ("State: ".$V78002216. "\t". db_error()."\n");
exit; } print "Result: \n"; print "OpeningStatPicture\t".$Vf1965a85["OpeningStatPicture"]."\n"; db_free_result($Vb4a88417);
$Vac5c74b6 = "SELECT id FROM ".$tablePrefix."Opening_Stat1 WHERE Campaign_id=$Vb0fe958e"; $Vb4a88417=db_query($Vac5c74b6);
if($Vf1965a85=db_fetch_array($Vb4a88417)){ print "Opening_Stat1_id\t".$Vf1965a85["id"]."\n"; } db_free_result($Vb4a88417);
$Vac5c74b6 = "SELECT id, Link FROM ".$tablePrefix."CampaignLinks WHERE Campaign_id=$Vb0fe958e"; $Vb4a88417=db_query($Vac5c74b6);
while ($Vf1965a85=db_fetch_array($Vb4a88417)) { print $Vf1965a85["id"]."\t".F973bceda($Vf1965a85["Link"])."\n";
} db_free_result($Vb4a88417); } ?>