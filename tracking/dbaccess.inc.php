<?php
$Language="german";
$IPBlocking=true;
$MSSQL=false;
$SQLDBName="web002_sm";
$SQLServerName="localhost";
$SQLUserName="web002_smusr";
$SQLPassword='tE6ji1_9';
$HTTPURL="http://jugelt-kk.de/tracking/";
$OpeningStatPicture="http://nms.vodafone-sales-news.de/uploads/newsletters/2017/kw01/neujahrsgruss/Logo_JKK_top.png";
$tablePrefix="sm_";

if(!$MSSQL){if(!function_exists("mysql_connect")) {
  require_once("mysql_definitions.php");
  require_once("mysql.php");
  require_once("mysql_functions.php");
}
}
?>