<?php
##############################################################################
#                    SUPERMAILER TRACKING SCRIPT                             #
#      Copyright (c) 2003-2016 Mirko Boeer Softwareentwicklungen Leipzig     #
#                 http://www.supermailer.de/                                 #
#                                                                            #
# Dieses Script ist URHEBERRECHTLICH GESCHUETZT und KEIN Open Source Script! #
#                                                                            #
# Es ist NICHT gestattet dieses Script ohne Einverstaendnis des Autors       #
# weiterzugeben oder in anderen Anwendungen einzusetzen.                     #
#                                                                            #
# Systemvoraussetzungen: PHP 4+ und Windows/Unix                             #
#                                                                            #
# Aufruf: http://www.<domain.tld>/tracking-dir/webstat.php                   #
#                                                                            #
# 26.01.2015                                                                 #
##############################################################################

  include("config.inc.php");
  include("dbfcts.inc.php");
  error_reporting( 0 );
  #ini_set("display_errors", 1);

  if (!function_exists('quote') ) {
     function quote($s) {
       $s = str_replace ('\"', '"', $s);
       $s = str_replace ("'", '\'', $s);
       $s = "'".$s."'";
       return $s;
     }
  }

  // Fix for removed Session functions > PHP 5.4
  // http://php.net/manual/de/function.session-register.php
  function fix_session_register(){
       function session_register(){
           $args = func_get_args();
           foreach ($args as $key){
               $_SESSION[$key]=$GLOBALS[$key];
           }
       }
       function session_is_registered($key){
           return isset($_SESSION[$key]);
       }
       function session_unregister($key){
           unset($_SESSION[$key]);
       }
  }
  if (!function_exists('session_register')) fix_session_register();

  if ((isset($Language)) && ($Language != "german") ) {
    $rsCreateOpening_Stat1 = "Opening statistic without date/time";
    $rsCreateOpening_Stat2 = "Opening statistic with date/time";
    $rsCreateLink_Stat1 = "Clicks on hyperlinks without date/time";
    $rsCreateLink_Stat2 = "Clicks on hyperlinks with date/time";
    $rsUserAgents = "UserAgents";
    $rsSum = "Total";
    $rsLongDate = "%Y/%m/%d";

    $rsUserAgentsHeadline = 'Most used email clients/browsers';
    $rsUserAgent = 'Email client/Browser';
    $rsUserAgent_OS_Count = 'Count';
    $rsOSsHeadline = 'Most used operating system';
    $rsOS = 'OS';
    $rsUserAgentOSInfo = 'Email client/browser statistics is made possible by ';
    $rsUnknownEMailClient = 'Unknown';
    $rsUnknownOS = 'Unknown';

    $rsRecipients = "Recipients";
    $rsOpeningsRate = "Openings rate";

    # Set timezone PHP 5.3+ required
    @setlocale (LC_ALL, 'en_US');
    @setlocale (LC_TIME, 'en_US');
    if(function_exists("date_default_timezone_set"))
      @date_default_timezone_set("Europe/London");

  } else {
    $rsCreateOpening_Stat1 = "&Ouml;ffnungsstatistik ohne Datum/Uhrzeit";
    $rsCreateOpening_Stat2 = "&Ouml;ffnungsstatistik mit Datum/Uhrzeit";
    $rsCreateLink_Stat1 = "Klicks auf Hyperlinks ohne Datum/Uhrzeit";
    $rsCreateLink_Stat2 = "Klicks auf Hyperlinks mit Datum/Uhrzeit";
    $rsUserAgents = "UserAgents";
    $rsSum = "Gesamt";
    $rsLongDate = "%d.%m.%Y";

    $rsUserAgentsHeadline = 'Am h&auml;ufigsten verwendete E-Mail-Programme/Browser';
    $rsUserAgent = 'E-Mail-Programm/Browser';
    $rsUserAgent_OS_Count = 'Anzahl';
    $rsOSsHeadline = 'Am h&auml;ufigsten verwendete Betriebssysteme';
    $rsOS = 'Betriebssystem';
    $rsUserAgentOSInfo = 'Die E-Mail-Programm/Betriebssystem-Statistik wird u.a. erm&ouml;glicht durch';
    $rsUnknownEMailClient = 'Unbekannt';
    $rsUnknownOS = 'Unbekannt';

    $rsRecipients = "Empf&auml;nger";
    $rsOpeningsRate = "&Ouml;ffnungsrate";

    @setlocale (LC_ALL, 'de_DE');
    @setlocale (LC_TIME, 'de_DE');
    if(function_exists("date_default_timezone_set"))
      @date_default_timezone_set("Europe/Berlin");
  }

  $CSS = '
  <style type="text/css">
  <!--
  body           {font-family:Verdana,Arial,Helvetica;font-size:9pt;background-color:#FFFFFF}
  a              {color:#0000FF;}
  a:link         {color:#0000FF;}
  a:active            {color:#996699;}
  a:visited      {color:#000000;}
  a:hover        {color:#FF0000; text-decoration: none;}
  input          {color: #000000; font-size: 11px; font-family: Verdana,Arial,Helvetica; }
  select         {color: #000000; font-size: 11px; font-family: Verdana,Arial,Helvetica; }
  textarea       {color: #000000; font-size: 11px; font-family: Verdana,Arial,Helvetica; }
  p              {font-family:Verdana,Arial,Helvetica;font-size:9pt}
  table          {font-size:9pt;font-family:Verdana,Arial,Helvetica;}
  td             {font-size:9pt;font-family:Verdana,Arial,Helvetica;}
  td.lblue       {background-color: #99CCFF;font-size:8pt;}
  td.lbluebig    {background-color: #99CCFF;font-size:10pt;}
  li             {font-size:9pt;font-family:Verdana,Arial,Helvetica}
  h2             {font-family:Verdana,Arial,Helvetica;font-size:14pt;font-weight:bold; color:#003399;}
  h4             {font-family:Verdana,Arial,Helvetica;font-size:18pt;font-weight:bold; color:#003399; text-align:center}
  h5             {font-family:Verdana,Arial,Helvetica; font-size:12pt; font-weight:bold; color:#003399; text-align:left}
  h6             {font-family:Verdana,Arial,Helvetica;font-size:13pt;font-weight:bold;color:#000000; margin-bottom:0; text-align:center}
  -->
  </style>
  ';

  $pageheadGerman = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="Content-Language" content="de">
  <title>Abruf der Tracking-Statistik</title>'.$CSS.'
  </head><body><h2 align="center">Abruf der Tracking-Statistik</h2>';

  $pageheadEnglish = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="Content-Language" content="en-us">
  <title>Retrieve tracking statistics</title>'.$CSS.'
  </head><body><h2 align="center">Retrieve tracking statistics</h2>';

  $loginGerman = '
  <form method="POST" action="webstat.php">
    <p>Name der Kampagne:<br>
    <input type="text" name="lCampaignName" size="52"></p>
    <p>Passwort f&uuml;r die Kampagne:<br>
    <input type="password" name="lCampaignPassword" size="20"></p>
    <p>&nbsp;</p>
    <p><input type="submit" value="Anmelden" name="Login"></p>
  </form>
  <p>&nbsp;</p>
  <p><a href="http://www.supermailer.de/" target="_blank">SuperMailer
  Tracking-Statistik &copy; 2006-'.strftime('%Y').' Mirko B&ouml;er Softwareentwicklungen, Leipzig</a></p>
  ';

  $loginEnglish = '
  <form method="POST" action="webstat.php">
    <p>Campaign name:<br>
    <input type="text" name="lCampaignName" size="52"></p>
    <p>Password for campaign:<br>
    <input type="password" name="lCampaignPassword" size="20"></p>
    <p>&nbsp;</p>
    <p><input type="submit" value="Login" name="Login"></p>
  </form>
  <p>&nbsp;</p>
  <p><a href="http://www.supermailer.de/" target="_blank">SuperMailer
  Tracking statistics &copy; 2006-'.strftime('%Y').' Mirko Boeer, Leipzig/Germany</a></p>
  ';

  $mailingSelectGerman = '
    <form method="POST" action="webstat.php">
      <input type="hidden" name="Action" value="CreateStat">
      <p>W&auml;hlen Sie den Versandeintrag f&uuml;r den die Statistik erstellt werden soll:</p>
      <table border="0" cellpadding="2" cellspacing="1" width="50%">
        <!--MAILINGENTRIES//-->
      </table>
      <p>&nbsp;</p>
      <p><input type="submit" value="Statistik f&uuml;r Versandeintrag erstellen" name="CreateStatBtn"></p>
      <p>&nbsp;</p>
      <p><input type="submit" value="Abmelden" name="logout"></p>
    </form> ';

  $mailingSelectEnglish = '
    <form method="POST" action="webstat.php">
      <input type="hidden" name="Action" value="CreateStat">
      <p>Please select the send entry for which the statistics should be created:</p>
      <table border="0" cellpadding="2" cellspacing="1" width="50%">
        <!--MAILINGENTRIES//-->
      </table>
      <p>&nbsp;</p>
      <p><input type="submit" value="Create statistics" name="CreateStatBtn"></p>
      <p>&nbsp;</p>
      <p><input type="submit" value="Logout" name="logout"></p>
    </form> ';


  $statOverviewGerman =
  '<p>&nbsp;</p>
  <p>Kampagne: <b><!--CampaignName//--></b></p>
  <p>E-Mail versendet am: <b><!--CampaignSendDateTime//--></b></p>
  <p>Empf&auml;ngergruppe: <b><!--CampaignRecipientsGroup//--></b></p>
  <p>Anzahl Empf&auml;nger: <b><!--CampaignRecipientsCount//--></b></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>W&auml;hlen Sie die gew&uuml;nschte Statistikvariante.</p>
  <table border="0" cellpadding="2" width="75%">
    <tr>
      <td width="50%" class="lbluebig"><!--CreateOpening_Stat1//--></td>
      <td width="50%" class="lbluebig"><!--CreateOpening_Stat2//--></td>
    </tr>
    <tr>
      <td width="50%" class="lbluebig"><!--CreateLink_Stat1//--></td>
      <td width="50%" class="lbluebig"><!--CreateLink_Stat2//--></td>
    </tr>
    <tr>
      <td width="50%" class="lbluebig"><!--UserAgents//--></td>
      <td width="50%" class="lbluebig">&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%">&nbsp;</td>
    </tr>
    <tr>
      <td class="lbluebig" width="50%"><a href="webstat.php?Action=ShowSentList">Versandeintrag
        wechseln</a></td>
      <td width="50%"></td>
    </tr>
    <tr>
      <td width="50%" class="lbluebig"><a href="webstat.php?Action=logout">Abmelden</a></td>
      <td width="50%"></td>
    </tr>
  </table>';

  $statOverviewEnglish =
  '<p>&nbsp;</p>
  <p>Campaign: <b><!--CampaignName//--></b></p>
  <p>Email sent: <b><!--CampaignSendDateTime//--></b></p>
  <p>Recipients group: <b><!--CampaignRecipientsGroup//--></b></p>
  <p>Count of recipients: <b><!--CampaignRecipientsCount//--></b></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>Please select the statistic variant.</p>
  <table border="0" cellpadding="2" width="75%">
    <tr>
      <td width="50%" class="lbluebig"><!--CreateOpening_Stat1//--></td>
      <td width="50%" class="lbluebig"><!--CreateOpening_Stat2//--></td>
    </tr>
    <tr>
      <td width="50%" class="lbluebig"><!--CreateLink_Stat1//--></td>
      <td width="50%" class="lbluebig"><!--CreateLink_Stat2//--></td>
    </tr>
    <tr>
      <td width="50%" class="lbluebig"><!--UserAgents//--></td>
      <td width="50%" class="lbluebig">&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%">&nbsp;</td>
    </tr>
    <tr>
      <td class="lbluebig" width="50%"><a href="webstat.php?Action=ShowSentList">Change to another send entry</a></td>
      <td width="50%"></td>
    </tr>
    <tr>
      <td width="50%" class="lbluebig"><a href="webstat.php?Action=logout">Logout</a></td>
      <td width="50%"></td>
    </tr>
  </table>';

  $statGerman = '
      <!--STAT//-->

      <p>&nbsp;</p>
      <form method="POST" action="webstat.php">
        <input type="hidden" name="Action" value="CreateStat"><input type="hidden" name="xCampaign_id">
        <table border="0" cellpadding="2" width="75%">
          <tr>
            <td width="100%" class="lbluebig"><input type="submit" name="backbtn" value="%BACKTEXT%"></td>
          </tr>
        </table>
      </form>
  ';

  $statEnglish = '
      <!--STAT//-->

      <p>&nbsp;</p>
      <form method="POST" action="webstat.php">
        <input type="hidden" name="Action" value="CreateStat"><input type="hidden" name="xCampaign_id">
        <table border="0" cellpadding="2" width="75%">
          <tr>
            <td width="100%" class="lbluebig"><input type="submit" name="backbtn" value="%BACKTEXT%"></td>
          </tr>
        </table>
      </form>
  ';

 $statUserAgents = '<fieldset style="border: 0px;">
  <legend><b><USERAGENTS_HL></USERAGENTS_HL></b></legend>
  <br>
  <table class="FixedTable">
    <thead>
      <tr>
        <td style="WIDTH: 400px" class="lbluebig"><b><USERAGENT_HL></USERAGENT_HL></b></td>
        <td class="lbluebig"><b><COUNT_HL></COUNT_HL></b></td>
      </tr>
    </thead>
    <tbody>
      <BROWSERLINE>
      <tr>
        <td><img border="0" alt="<USERAGENT></USERAGENT>" src="<USERAGENT_IMAGE></USERAGENT_IMAGE>" width="16" height="16">&nbsp;<USERAGENT></USERAGENT></td>
        <td><USERAGENTCOUNT></USERAGENTCOUNT></td>
      </tr>
      </BROWSERLINE>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  </fieldset><br><fieldset style="border: 0px;">
    <legend><b><OSS_HL></OSS_HL></b></legend>
    <br>
    <table class="FixedTable">
      <thead>
        <tr>
          <td style="WIDTH: 400px" class="lbluebig"><b><OS_HL></OS_HL></b></td>
          <td class="lbluebig"><b><COUNT_HL></COUNT_HL></b></td>
        </tr>
      </thead>
      <tbody>
        <OSLINE>
        <tr>
          <td><img border="0" alt="<OS_NAME></OS_NAME>" src="<OS_IMAGE></OS_IMAGE>" width="16" height="16">&nbsp;<OS_NAME></OS_NAME></td>
          <td><OSCOUNT></OSCOUNT></td>
        </tr>
        </OSLINE>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </fieldset>
  ';

 SetHTMLHeaders('utf-8');

 if($MSSQL) {
   print "MS SQL nicht unterst&uuml;tzt<br>MS SQL not supported.";
   exit;
 }

 if ( (count($_POST) == 0) && (count($_GET) == 0) ) {
    if ((isset($Language)) && ($Language != "german") ) {
      $page = $pageheadEnglish.$loginEnglish;
      }
      else {
      $page = $pageheadGerman.$loginGerman;
      }
    print $page."</body></html>";
    exit;
 }

 if (isset($_POST["logout"]))
    $vlogout = $_POST["logout"];
    else
    if (isset($_GET["logout"]))
      $vlogout = $_GET["logout"];

 if( isset($_POST["Action"]) )
   $vAction = $_POST["Action"];
   else
   if( isset($_GET["Action"]) )
      $vAction = $_GET["Action"];

 if(!isset($vAction))
   $vAction = "";

 if( isset($_POST["Login"]) ) {
   if(!$MSSQL)
     $v = "date_format(SendDateTime,'$rsLongDate&nbsp;%T')";
     else
     $v = "SendDateTime";

   $sql = "SELECT id, $v As ASendDateTime FROM ".$tablePrefix."Campaigns LEFT JOIN ".$tablePrefix."CampaignOptions ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignOptions.Campaign_id WHERE CampaignName=".quote($_POST['lCampaignName'])." AND PASSWORD=".quote($_POST['lCampaignPassword'])." ORDER BY SendDateTime DESC";
   $result = db_query($sql);
   if(db_num_rows($result) == 0) {
     if ((isset($Language)) && ($Language != "german") )
       ErrorPage("<h5>Error: Campaign name or password incorrect.</h5>" );
     else
       ErrorPage("<h5>Fehler: Name der Kampagne oder Passwort f&uuml;r die Kampagne nicht korrekt.</h5>");
     exit;
   }

   @session_start();
   session_register("CampaignName", "CampaignPassword", "CampaignId", "CampaignSendDateTime", "RecipientsCount", "CreateOpening_Stat1", "CreateOpening_Stat2", "CreateLink_Stat1", "CreateLink_Stat2", "TrackingRecipientsGroup");
   $_SESSION['CampaignName'] = $_POST["lCampaignName"];
   $_SESSION['CampaignPassword'] = $_POST["lCampaignPassword"];
   $_SESSION['CampaignId'] = 0;
   $_SESSION['CampaignSendDateTime'] = "";
   $_SESSION['CreateOpening_Stat1'] = False;
   $_SESSION['CreateOpening_Stat2'] = False;
   $_SESSION['CreateLink_Stat1'] = False;
   $_SESSION['CreateLink_Stat2'] = False;
   $_SESSION['TrackingRecipientsGroup'] = "";
   $_SESSION['RecipientsCount'] = 0;

   ShowSentList($result);
   exit;
 }


 # Pruefung ob Session OK ist
 @session_start();
 if ( (!session_is_registered("CampaignName")) Or (!session_is_registered("CampaignId")) Or (!session_is_registered("CampaignSendDateTime")) ) {
   if ((isset($Language)) && ($Language != "german") )
     ErrorPage("<h5>Error: Your session has expired, please relogin.</h5>");
   else
     ErrorPage("<h5>Fehler: Ihre Sitzung ist abgelaufen, melden Sie sich erneut an.</h5>");
   exit;
 }

 $CampaignName = $_SESSION['CampaignName'];
 $CampaignPassword = $_SESSION['CampaignPassword'];
 $CampaignId = intval($_SESSION['CampaignId']);
 $CampaignSendDateTime = $_SESSION['CampaignSendDateTime'];
 $CreateOpening_Stat1 = $_SESSION['CreateOpening_Stat1'];
 $CreateOpening_Stat2 = $_SESSION['CreateOpening_Stat2'];
 $CreateLink_Stat1 = $_SESSION['CreateLink_Stat1'];
 $CreateLink_Stat2 = $_SESSION['CreateLink_Stat2'];
 $TrackingRecipientsGroup = $_SESSION['TrackingRecipientsGroup'];
 $RecipientsCount = $_SESSION['RecipientsCount'];

// -------------------------------------------------------------------------------------------
 if ($vAction == "ShowSentList") {
   ShowSentList(0);
   exit;
 }

 if ( ($vAction == "CreateStat") || (isset($_POST["CreateStatBtn"])) ) {
   if ((isset($Language)) && ($Language != "german") )
     $page = $pageheadEnglish.$statOverviewEnglish;
     else
     $page = $pageheadGerman.$statOverviewGerman;

   if (isset($_POST['xCampaign_id']))
     $xCampaign_id = intval($_POST['xCampaign_id']);
     else
     if (isset($_GET['xCampaign_id']))
       $xCampaign_id = intval($_GET['xCampaign_id']);

   if(!$MSSQL)
     $v = "date_format(SendDateTime,'$rsLongDate&nbsp;%T')";
     else
     $v = "SendDateTime";

   $sql = "SELECT $v As ASendDateTime, CreateOpening_Stat1, CreateOpening_Stat2, CreateLink_Stat1, CreateLink_Stat2, TrackingRecipientsGroup, RecipientsCount FROM ".$tablePrefix."Campaigns LEFT JOIN ".$tablePrefix."CampaignOptions ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignOptions.Campaign_id WHERE CampaignName=".quote($CampaignName)." AND PASSWORD=".quote($CampaignPassword)." AND ".$tablePrefix."Campaigns.id=".$xCampaign_id;
   $result = db_query($sql);
   if(db_num_rows($result) == 0) {
     if ((isset($Language)) && ($Language != "german") )
       ErrorPage( "<h5>Error: Campaign name or password incorrect. Query returns 0 records.</h5>" );
     else
       ErrorPage("<h5>Fehler: Name der Kampagne oder Passwort f&uuml;r die Kampagne nicht korrekt. SQL-Abfrage lieferte 0 Datens&auml;tze.</h5>" );
     exit;
   }

   $row = db_fetch_array($result);

   $CampaignId = $xCampaign_id;
   $CampaignSendDateTime = $row["ASendDateTime"];
   $CreateOpening_Stat1 = $row["CreateOpening_Stat1"];
   $CreateOpening_Stat2 = $row["CreateOpening_Stat2"];
   $CreateLink_Stat1 = $row["CreateLink_Stat1"];
   $CreateLink_Stat2 = $row["CreateLink_Stat2"];
   $TrackingRecipientsGroup = $row["TrackingRecipientsGroup"];
   $RecipientsCount = $row["RecipientsCount"];

   # UTF-8 check
   if(!IsUtf8String( $TrackingRecipientsGroup )) {
      $TrackingRecipientsGroup =  utf8_encode($TrackingRecipientsGroup);
      $row["TrackingRecipientsGroup"] = utf8_encode($row["TrackingRecipientsGroup"]);
   }

   # register globals off?
   $_SESSION['CampaignId'] = $xCampaign_id;
   $_SESSION['CampaignSendDateTime'] = $row["ASendDateTime"];
   $_SESSION['CreateOpening_Stat1'] = $row["CreateOpening_Stat1"];
   $_SESSION['CreateOpening_Stat2'] = $row["CreateOpening_Stat2"];
   $_SESSION['CreateLink_Stat1'] = $row["CreateLink_Stat1"];
   $_SESSION['CreateLink_Stat2'] = $row["CreateLink_Stat2"];
   $_SESSION['TrackingRecipientsGroup'] = $row["TrackingRecipientsGroup"];
   $_SESSION['RecipientsCount'] = $row["RecipientsCount"];

   $page = str_replace("<!--CampaignName//-->", $CampaignName, $page);
   $page = str_replace("<!--CampaignSendDateTime//-->", $row["ASendDateTime"], $page);
   $page = str_replace("<!--CampaignRecipientsCount//-->", $row["RecipientsCount"], $page);
   if ($row["TrackingRecipientsGroup"] != "") {
       $s = $row["TrackingRecipientsGroup"];
       $s = str_replace("<", "&lt;", $s);
       $s = str_replace(">", "&gt;", $s);
       $page = str_replace("<!--CampaignRecipientsGroup//-->", $s, $page);
      }
      else
      $page = str_replace("<!--CampaignRecipientsGroup//-->", "n/a", $page);

   if($row["CreateOpening_Stat1"])
     $page = str_replace("<!--CreateOpening_Stat1//-->", '<a href="webstat.php?Action=ShowStat&type=CreateOpening_Stat1">'.$rsCreateOpening_Stat1.'</a>', $page);
   if($row["CreateOpening_Stat2"])
    $page = str_replace("<!--CreateOpening_Stat2//-->", '<a href="webstat.php?Action=ShowStat&type=CreateOpening_Stat2">'.$rsCreateOpening_Stat2.'</a>', $page);
   if($row["CreateLink_Stat1"])
     $page = str_replace("<!--CreateLink_Stat1//-->", '<a href="webstat.php?Action=ShowStat&type=CreateLink_Stat1">'.$rsCreateLink_Stat1.'</a>', $page);
   if($row["CreateLink_Stat2"])
     $page = str_replace("<!--CreateLink_Stat2//-->", '<a href="webstat.php?Action=ShowStat&type=CreateLink_Stat2">'.$rsCreateLink_Stat2.'</a>', $page);

   $page = str_replace("<!--UserAgents//-->", '<a href="webstat.php?Action=ShowStat&type=UserAgents">'.$rsUserAgents.'</a>', $page);

   print $page."</body></html>";
   exit;
 }

 if ( ($vAction=="ShowStat") && isset($_GET["type"]) && ($_GET["type"] == "CreateOpening_Stat1") ) {
    $sql="SELECT Clicks FROM ".$tablePrefix."Opening_Stat1 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."Opening_Stat1.Campaign_id=$CampaignId";
    $result=db_query($sql);
    $row=db_fetch_array($result);

    if ((isset($Language)) && ($Language != "german") ) {
        $page = $pageheadEnglish.$statEnglish;

        $s = '<p><b>'.$rsCreateOpening_Stat1.'</b></p><table border="0" cellpadding="2" width="75%">';

        $s .= '<tr><td width="50%">'.$rsRecipients.':</td><td>'.$RecipientsCount.'</td></tr>';
        $s .= '<tr><td width="50%">Numbers of openings:</td><td>'.$row[0].'</td></tr>';

        $x = sprintf("%01.2f%%", $row[0] * 100 / $RecipientsCount);

        $s .= '<tr><td width="50%">'.$rsOpeningsRate.':</td><td>'.$x.'</td></tr>';

        $s .= '</table>';

        $s .= "<br><br>Hint: All openings of email are sumed, also multiple openings.";


      }
      else {
        $page = $pageheadGerman.$statGerman;
        $s = '<p><b>'.$rsCreateOpening_Stat1.'</b></p><table border="0" cellpadding="2" width="75%">';

        $s .= '<tr><td width="50%">'.$rsRecipients.':</td><td>'.$RecipientsCount.'</td></tr>';
        $s .= '<tr><td width="50%">Anzahl &Ouml;ffnungen:</td><td>'.$row[0].'</td></tr>';

        $x = sprintf("%01.2f%%", $row[0] * 100 / $RecipientsCount);

        $s .= '<tr><td width="50%">'.$rsOpeningsRate.':</td><td>'.$x.'</td></tr>';

        $s .= '</table>';

        $s .= "<br><br>Hinweis: Es werden alle &Ouml;ffnungen, ebenfalls Mehrfach&ouml;ffnungen, summiert.";
      }


    $page = str_replace("<!--STAT//-->", $s, $page);
    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);

    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to overview', $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zur &Uuml;bersicht', $page);

    print $page;
    exit;
 }


 if ( ($vAction=="ShowStat") && ( ( isset($_GET["type"]) && ($_GET["type"] == "CreateOpening_Stat2") ) || ( isset($_POST["type"]) && ($_POST["type"] == "CreateOpening_Stat2") ) ) && !isset($_GET["date"]) ) {

    if(!$MSSQL)
      $v = "date_format(ADateTime,'$rsLongDate')";
      else
      $v = "ADateTime";

    $sql="SELECT Clicks, ADateTime, $v As sADateTime FROM ".$tablePrefix."Opening_Stat2 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."Opening_Stat2.Campaign_id=$CampaignId ORDER BY ADateTime";
    $result=db_query($sql);

    if ((isset($Language)) && ($Language != "german") )
      $page = $pageheadEnglish.$statEnglish;
      else
      $page = $pageheadGerman.$statGerman;
    if ((isset($Language)) && ($Language != "german") ) {
      $s = '<p><b>'.$rsCreateOpening_Stat2.'</b></p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Date</b></td><td width="50%" class="lbluebig"><b>Clicks</b></td></tr>';
    } else {
      $s = '<p><b>'.$rsCreateOpening_Stat2.'</b></p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Datum</b></td><td width="50%" class="lbluebig"><b>Klicks</b></td></tr>';
    }

    $sum = array();
    while ($row=db_fetch_array($result)) {
       $key = $row['sADateTime'];
       if (!array_key_exists($key, $sum))
           $sum[$key] = $row['Clicks'];
           else
           $sum[$key] += $row['Clicks'];
    }
    $Asum = 0;
    foreach ($sum as $key => $value) {
      $s .= '<tr><td width="50%"><a href="webstat.php?Action=ShowStat&type=CreateOpening_Stat2&date='.$key.'">'.$key.'</a></td><td width="50%">'.$value.'</td></tr>';
      $Asum += $value;
    }

    $s .= '<tr><td width="50%">&nbsp;</td><td width="50%">&nbsp;</td></tr>';
    $s .= '<tr><td width="50%"><b>'.$rsSum.'</b></td><td width="50%"><b>'.$Asum.'</b></td></tr>';

    if($IPBlocking){
     $s .= '<tr><td width="50%">&nbsp;</td><td width="50%">&nbsp;</td></tr>';

     $s .= '<tr><td width="50%"><b>'.$rsRecipients.'</b></td><td width="50%">'.$RecipientsCount.'</td></tr>';
     $x = sprintf("%01.2f%%", $Asum* 100 / $RecipientsCount);
     $s .= '<tr><td width="50%"><b>'.$rsOpeningsRate.'</b></td><td width="50%">'.$x.'</td></tr>';
    }

    $s .= '</table>';

    $page = str_replace("<!--STAT//-->", $s, $page);
    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);
    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to overview', $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zur &Uuml;bersicht', $page);

    print $page."</body></html>";
    exit;
 }

 if ( ($vAction=="ShowStat") && isset($_GET["type"]) && ($_GET["type"] == "CreateOpening_Stat2") && isset($_GET["date"]) ) {

    if(!$MSSQL)
      $v = "date_format(ADateTime,'%H:%i:%s')";
      else
      $v = "ADateTime";

    if(!$MSSQL)
      $adate = "date_format(ADateTime,'$rsLongDate')";
      else
      $adate = "ADateTime";

    $comparedate=$_GET["date"];

    $sql="SELECT Clicks, ADateTime, $v As sADateTime FROM ".$tablePrefix."Opening_Stat2 LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."Opening_Stat2.Campaign_id=$CampaignId AND $adate='".$comparedate."' ORDER BY ADateTime";
    $result=db_query($sql);

    if ((isset($Language)) && ($Language != "german") )
      $page = $pageheadEnglish.$statEnglish;
      else
      $page = $pageheadGerman.$statGerman;

    if ((isset($Language)) && ($Language != "german") ) {
       $s = '<p><b>'.$rsCreateOpening_Stat2.' at '.$_GET["date"].'</b></p>';
       $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Time</b></td><td width="50%" class="lbluebig"><b>Clicks</b></td></tr>';
    } else {
       $s = '<p><b>'.$rsCreateOpening_Stat2.' f&uuml;r den '.$_GET["date"].'</b></p>';
       $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Uhrzeit</b></td><td width="50%" class="lbluebig"><b>Klicks</b></td></tr>';
    }

    $sum = array();
    while ($row=db_fetch_array($result)) {
       $key = $row['sADateTime'];
       if (!array_key_exists($key, $sum))
           $sum[$key] = $row['Clicks'];
           else
           $sum[$key] += $row['Clicks'];
    }
    foreach ($sum as $key => $value) {
      $s .= '<tr><td width="50%">'.$key.'</td><td width="50%">'.$value.'</td></tr>';
    }

    $s .= '</table>';

    $page = str_replace("<!--STAT//-->", $s, $page);
    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);
    $page = str_replace('<input type="hidden" name="Action" value="CreateStat">', '<input type="hidden" name="Action" value="ShowStat"><input type="hidden" name="type" value="CreateOpening_Stat2">', $page);

    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to '.$rsCreateOpening_Stat2, $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zu '.$rsCreateOpening_Stat2, $page);

    print $page."</body></html>";
    exit;
 }

 if ( ($vAction=="ShowStat") && isset($_GET["type"]) && ($_GET["type"] == "CreateLink_Stat1") ) {
    $sql="SELECT Clicks, Link, Description FROM ".$tablePrefix."Link_Stat1 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat1.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$CampaignId ORDER BY Clicks";
    $result=db_query($sql);

    if ((isset($Language)) && ($Language != "german") )
      $page = $pageheadEnglish.$statEnglish;
      else
      $page = $pageheadGerman.$statGerman;
    if ((isset($Language)) && ($Language != "german") ) {
      $s = '<p><b>'.$rsCreateLink_Stat1.'</b></p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Link</b></td><td width="50%" class="lbluebig"><b>Clicks</b></td></tr>';
    } else {
      $s = '<p><b>'.$rsCreateLink_Stat1.'</b></p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Link</b></td><td width="50%" class="lbluebig"><b>Klicks</b></td></tr>';
    }

    $Asum = 0;
    while ($row=db_fetch_array($result)) {
      $link = $row["Link"];
      $descr = $row["Description"];
      if($descr == "")
        $descr = $link;

      # UTF-8 check
      if(!IsUtf8String( $descr )) {
         $descr =  utf8_encode($descr);
      }

      # UTF-8 check
      if(!IsUtf8String( $link )) {
         $link =  utf8_encode($link);
      }

      $s .= '<tr><td width="50%"><a href="'.$link.'" target="_blank">'.$descr.'</a></td><td width="50%">'.$row["Clicks"].'</td></tr>';
      $Asum += $row["Clicks"];
    }

    $s .= '<tr><td width="50%">&nbsp;</td><td width="50%">&nbsp;</td></tr>';
    $s .= '<tr><td width="50%"><b>'.$rsSum.'</b></td><td width="50%"><b>'.$Asum.'</b></td></tr>';

    $s .= '</table>';

    $page = str_replace("<!--STAT//-->", $s, $page);
    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);
    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to overview', $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zur &Uuml;bersicht', $page);

    print $page."</body></html>";
    exit;
 }

 if ( ($vAction=="ShowStat") && ( ( isset($_GET["type"]) && ($_GET["type"] == "CreateLink_Stat2") ) || ( isset($_POST["type"]) && ($_POST["type"] == "CreateLink_Stat2") ) ) && !isset($_GET["date"]) ) {

    if(!$MSSQL)
      $v = "date_format(ADateTime,'$rsLongDate')";
      else
      $v = "ADateTime";

    $sql="SELECT SUM(Clicks) As AClicks, ADateTime, Link, Description, $v As sADateTime FROM ".$tablePrefix."Link_Stat2 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat2.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$CampaignId GROUP BY Link ORDER BY ADateTime, Clicks";
    $result=db_query($sql);

    if ((isset($Language)) && ($Language != "german") )
      $page = $pageheadEnglish.$statEnglish;
      else
      $page = $pageheadGerman.$statGerman;

    if ((isset($Language)) && ($Language != "german") ) {
      $s = '<p><b>'.$rsCreateLink_Stat2.'</b></p><p>Total</p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Link</b></td><td width="50%" class="lbluebig"><b>Clicks</b></td></tr>';
    } else {
      $s = '<p><b>'.$rsCreateLink_Stat2.'</b></p><p>Gesamt</p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Link</b></td><td width="50%" class="lbluebig"><b>Klicks</b></td></tr>';
    }

    $sum = 0;
    while ($row=db_fetch_array($result)) {
       $key = $row['Link'];
       $descr = $row["Description"];
       if ($descr == "")
         $descr = $key;

       # UTF-8 check
       if(!IsUtf8String( $descr )) {
          $descr =  utf8_encode($descr);
       }

       # UTF-8 check
       if(!IsUtf8String( $link )) {
          $link =  utf8_encode($link);
       }

       $s .= '<tr><td width="50%"><a href="'.$key.'" target="_blank">'.$descr.'</a></td><td width="50%">'.$row["AClicks"].'</td></tr>';
       $sum += $row["AClicks"];
    }

    $s .= '<tr><td width="50%">&nbsp;</td><td width="50%">&nbsp;</td></tr>';
    $s .= '<tr><td width="50%"><b>'.$rsSum.'</b></td><td width="50%"><b>'.$sum.'</b></td></tr>';

    $s .= '</table>';

    if(!$MSSQL)
      $v = "date_format(ADateTime,'$rsLongDate')";
      else
      $v = "ADateTime";

    $sql="SELECT Clicks, ADateTime, $v As sADateTime FROM ".$tablePrefix."Link_Stat2 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat2.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$CampaignId ORDER BY ADateTime";
    $result=db_query($sql);

    $dates = array();
    while ($row=db_fetch_array($result)) {
       $key = $row['sADateTime'];
       if (!array_key_exists($key, $dates))
           $dates[$key] = $row['Clicks'];
           else
           $dates[$key] += $row['Clicks'];
    }


    if ((isset($Language)) && ($Language != "german") ) {
      $s .= '<p>For one day</p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Date</b></td><td width="50%" class="lbluebig"><b>Clicks</b></td></tr>';
    } else {
      $s .= '<p>F&uuml;r einen bestimmten Tag</p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Datum</b></td><td width="50%" class="lbluebig"><b>Klicks</b></td></tr>';
    }

    $sum = 0;
    foreach ($dates as $key => $value) {
      $s .= '<tr><td><a href="webstat.php?Action=ShowStat&type=CreateLink_Stat2&date='.$key.'">'.$key.'</a></td><td>'.$value.'</td></tr>';
      $sum += $value;
    }
    $s .= '<tr><td width="50%">&nbsp;</td><td width="50%">&nbsp;</td></tr>';
    $s .= '<tr><td width="50%"><b>'.$rsSum.'</b></td><td width="50%"><b>'.$sum.'</b></td></tr>';
    $s .= '</table>';


    $page = str_replace("<!--STAT//-->", $s, $page);
    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);
    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to overview', $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zur &Uuml;bersicht', $page);

    print $page."</body></html>";
    exit;
 }

 if ( ($vAction=="ShowStat") && isset($_GET["type"]) && ($_GET["type"] == "CreateLink_Stat2") && isset($_GET["date"]) ) {
    if(!$MSSQL)
      $v = "date_format(ADateTime,'".$rsLongDate." - %H:%i:%s')";
      else
      $v = "ADateTime";

    if(!$MSSQL)
      $comparevalue = "date_format(ADateTime,'$rsLongDate')";
      else
      $comparevalue = "ADateTime";

    $sql="SELECT Clicks, ADateTime, Link, Description, $v As sADateTime FROM ".$tablePrefix."Link_Stat2 LEFT JOIN ".$tablePrefix."CampaignLinks ON ".$tablePrefix."Link_Stat2.CampaignLinks_id=".$tablePrefix."CampaignLinks.id LEFT JOIN ".$tablePrefix."Campaigns ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignLinks.Campaign_id WHERE ".$tablePrefix."Campaigns.Password=".quote($CampaignPassword)." AND ".$tablePrefix."CampaignLinks.Campaign_id=$CampaignId AND $comparevalue='".$_GET["date"]."' ORDER BY ADateTime";
    $result=db_query($sql);

    if ((isset($Language)) && ($Language != "german") )
      $page = $pageheadEnglish.$statEnglish;
      else
      $page = $pageheadGerman.$statGerman;


    if ((isset($Language)) && ($Language != "german") ) {
      $s = '<p><b>'.$rsCreateLink_Stat2.' at '.$_GET["date"].'</b></p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="50%" class="lbluebig"><b>Link</b></td><td width="50%" class="lbluebig"><b>Clicks</b></td></tr>';
    } else {
      $s = '<p><b>'.$rsCreateLink_Stat2.' f&uuml;r den '.$_GET["date"].'</b></p>';
      $s .= '<table border="0" cellpadding="2" width="75%"><tr><td width="33%" class="lbluebig"><b>Datum/Uhrzeit</b></td><td width="33%" class="lbluebig"><b>Klicks</b></td><td width="33%" class="lbluebig"><b>Link</b></td></tr>';
    }

    $sum = 0;
    while ($row=db_fetch_array($result)) {
       $key = $row['Link'];
       $descr = $row["Description"];
       if ($descr == "")
         $descr = $key;

       # UTF-8 check
       if(!IsUtf8String( $descr )) {
          $descr =  utf8_encode($descr);
       }

       # UTF-8 check
       if(!IsUtf8String( $key )) {
          $key =  utf8_encode($key);
       }

       $s .= '<tr><td width="33%">'.$row["sADateTime"].'</td><td width="33%">'.$row["Clicks"].'</td><td width="33%"><a href="'.$key.'" target="_blank">'.$descr.'</a></td></tr>';
       $sum += $row["Clicks"];
    }
    $s .= '<tr><td width="33%">&nbsp;</td><td width="33%">&nbsp;</td><td width="33%">&nbsp;</td></tr>';
    $s .= '<tr><td width="33%"><b>'.$rsSum.'</b></td><td width="33%"><b>'.$sum.'</b></td><td width="33%">&nbsp;</td></tr>';

    $s .= '</table>';

    $page = str_replace("<!--STAT//-->", $s, $page);
    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);
    $page = str_replace('<input type="hidden" name="Action" value="CreateStat">', '<input type="hidden" name="Action" value="ShowStat"><input type="hidden" name="type" value="CreateLink_Stat2">', $page);
    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to '.$rsCreateLink_Stat2, $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zu '.$rsCreateLink_Stat2, $page);

    print $page."</body></html>";
    exit;
 }

 // $statUserAgents
 if ( ($vAction=="ShowStat") && isset($_GET["type"]) && ($_GET["type"] == "UserAgents")  ) {
    $HTML = $statUserAgents;

    $HTML = ReplaceBlock($HTML, '<USERAGENTS_HL>', '</USERAGENTS_HL>', $rsUserAgentsHeadline);
    $HTML = ReplaceBlock($HTML, '<USERAGENT_HL>', '</USERAGENT_HL>', $rsUserAgent);
    $HTML = ReplaceBlock($HTML, '<OSS_HL>', '</OSS_HL>', $rsOSsHeadline);
    $HTML = ReplaceBlock($HTML, '<OS_HL>', '</OS_HL>', $rsOS);
    $HTML = ReplaceBlock($HTML, '<COUNT_HL>', '</COUNT_HL>', $rsUserAgent_OS_Count);
    $HTML = ReplaceBlock($HTML, '<USERAGENT_OS_INFO>', '</USERAGENT_OS_INFO>', $rsUserAgentOSInfo);

    $Line = GetBlock($HTML, '<BROWSERLINE>', '</BROWSERLINE>');
    $SumCount = 0;
    $counter = array();
    $S = '';
    $i = 0;

    $sql = "SELECT UserAgent, SUM(Clicks) AS ClicksCount FROM ".$tablePrefix."UserAgents WHERE Campaign_id=$CampaignId GROUP BY UserAgent ORDER BY ClicksCount DESC LIMIT 0, 20";
    $result=db_query($sql);
    while ($row=db_fetch_array($result)) {
      $S .= $Line;
      $temp = $row["UserAgent"];
      if ($temp == "")
        $temp = 'name=' . $rsUnknownEMailClient . ';icon=ua/unknown.gif';
      $name = substr($temp, 0, strpos($temp, ";"));
      $name = substr($name, 5);
      $icon = substr($temp, strpos_reverse($temp, ";") + 1);
      $icon = substr($icon, 5);

      # UTF-8 check
      if(!IsUtf8String( $name )) {
         $name =  utf8_encode($name);
      }

      $S = ReplaceBlock($S, '<USERAGENT>', '</USERAGENT>', $name);

      if (strpos($icon, 'ua/') !== false)
        $icon = 'http://www.supermailer.de/images/' . $icon;
        else
        $icon = 'http://www.superwebmailer.de/pub/img/ua/' . $icon;

      $S = ReplaceBlock($S, '<USERAGENT_IMAGE>', '</USERAGENT_IMAGE>', $icon);
      $SumCount += $row["ClicksCount"];
      $counter[] = $row["ClicksCount"];
      $S = ReplaceBlock($S, '<USERAGENTCOUNT>', '</USERAGENTCOUNT>', $row["ClicksCount"] . '&nbsp;(<EMAILCLIENT_COUNT_PERCENT' . $i . '></EMAILCLIENT_COUNT_PERCENT' . $i . '>)');
      $i++;

    }
    db_free_result($result);

    if($SumCount == 0)
      $SumCount = 0.01;
    for($i=0; $i<count($counter); $i++)
       $S = ReplaceBlock($S, '<EMAILCLIENT_COUNT_PERCENT' .$i. '>', '</EMAILCLIENT_COUNT_PERCENT' .$i. '>', sprintf("%1.1f%%", $counter[$i] * 100 / $SumCount));

    $HTML = ReplaceBlock($HTML, '<BROWSERLINE>', '</BROWSERLINE>', $S);


    $Line = GetBlock($HTML, '<OSLINE>', '</OSLINE>');
    $SumCount = 0;
    $counter = array();
    $S = '';
    $i = 0;

    $sql = "SELECT OS, SUM(Clicks) AS ClicksCount FROM ".$tablePrefix."OSs WHERE Campaign_id=$CampaignId GROUP BY OS ORDER BY ClicksCount DESC LIMIT 0, 20";
    $result=db_query($sql);
    while ($row=db_fetch_array($result)) {
      $S .= $Line;
      $temp = $row["OS"];
      if ($temp == "")
        $temp = 'name=' . $rsUnknownOS . ';icon=ua/unknown.gif';
      $name = substr($temp, 0, strpos($temp, ";"));
      $name = substr($name, 5);
      $icon = substr($temp, strpos_reverse($temp, ";") + 1);
      $icon = substr($icon, 5);

      # UTF-8 check
      if(!IsUtf8String( $name )) {
         $name =  utf8_encode($name);
      }

      $S = ReplaceBlock($S, '<OS_NAME>', '</OS_NAME>', $name);

      if (strpos($icon, 'ua/') !== false)
        $icon = 'http://www.supermailer.de/images/' . $icon;
        else
        $icon = 'http://www.superwebmailer.de/pub/img/os/' . $icon;

      $S = ReplaceBlock($S, '<OS_IMAGE>', '</OS_IMAGE>', $icon);
      $SumCount += $row["ClicksCount"];
      $counter[] = $row["ClicksCount"];
      $S = ReplaceBlock($S, '<OSCOUNT>', '</OSCOUNT>', $row["ClicksCount"] . '&nbsp;(<OS_COUNT_PERCENT' . $i . '></OS_COUNT_PERCENT' . $i . '>)');
      $i++;
    }
    db_free_result($result);

    if($SumCount == 0)
      $SumCount = 0.01;
    for($i=0; $i<count($counter); $i++)
       $S = ReplaceBlock($S, '<OS_COUNT_PERCENT' .$i. '>', '</OS_COUNT_PERCENT' .$i. '>', sprintf("%1.1f%%", $counter[$i] * 100 / $SumCount));

    $HTML = ReplaceBlock($HTML, '<OSLINE>', '</OSLINE>', $S);

    if ((isset($Language)) && ($Language != "german") )
      $page = $pageheadEnglish.$statEnglish;
      else
      $page = $pageheadGerman.$statGerman;


    $page = str_replace('name="xCampaign_id"', 'name="xCampaign_id" value="'.$CampaignId.'"', $page);

    if ((isset($Language)) && ($Language != "german") )
      $page = str_replace('%BACKTEXT%', 'Back to overview', $page);
      else
      $page = str_replace('%BACKTEXT%', 'Zur&uuml;ck zur &Uuml;bersicht', $page);

    $HTML = '<p><b>'.$rsUserAgents.'</b></p>'.$HTML;

    $page = str_replace("<!--STAT//-->", $HTML, $page);

    print $page."</body></html>";
    exit;

 }

 // default
 $vAction = "logout";

 if ( ($vAction == "logout") || (isset($vlogout)) ) {
    @session_unregister("CampaignName");
    @session_destroy();
    if ( (isset($Language)) && ($Language != "german") )
      ErrorPage("<h5>Logout successfully.</h5>");
      else
      ErrorPage("<h5>Sie wurden abgemeldet.</h5>");
 }


 function ShowSentList($result) {
   global $MSSQL, $CampaignName, $CampaignPassword, $Language, $pageheadGerman, $pageheadEnglish, $mailingSelectGerman, $mailingSelectEnglish, $rsLongDate, $tablePrefix;

   $line = '<tr><td><input type="radio" value="<!--ID-->" name="xCampaign_id" <!--checked//-->></td><td width="100%" class="lblue"><!--SENDDATE--></td></tr>';

   if($result == 0) {

    if(!$MSSQL)
      $v = "date_format(SendDateTime,'".$rsLongDate."&nbsp;%T')";
      else
      $v = "SendDateTime";

     $sql = "SELECT id, $v As ASendDateTime FROM ".$tablePrefix."Campaigns LEFT JOIN ".$tablePrefix."CampaignOptions ON ".$tablePrefix."Campaigns.id=".$tablePrefix."CampaignOptions.Campaign_id WHERE CampaignName=".quote($CampaignName)." AND PASSWORD=".quote($CampaignPassword)." ORDER BY SendDateTime DESC";
     $result = db_query($sql);
     if(db_num_rows($result) == 0) {
       if ((isset($Language)) && ($Language != "german") )
         ErrorPage( "<h5>Error: Campaign name or password incorrect.</h5>" );
       else
         ErrorPage( "<h5>Fehler: Name der Kampagne oder Passwort f&uuml;r die Kampagne nicht korrekt.</h5>" );
       exit;
     }
   }

   if ((isset($Language)) && ($Language != "german") )
     $page = $pageheadEnglish.$mailingSelectEnglish;
     else
     $page = $pageheadGerman.$mailingSelectGerman;

   $html = "";
   while ($row=db_fetch_array($result)) {
      $s = $line;
      $s = str_replace("<!--ID-->", $row["id"], $s);
      $s = str_replace("<!--SENDDATE-->", $row["ASendDateTime"], $s);
      if($html == "")
       $s = str_replace("<!--checked//-->", "checked", $s);
       else
       $s = str_replace("<!--checked//-->", "", $s);

      $html .= $s;
   }

   $page = str_replace("<!--MAILINGENTRIES//-->", $html, $page);

   print $page."</body></html>";
 }

 function ErrorPage($errorText, $backlink = "") {
   global $pageheadGerman, $pageheadEnglish, $Language;

   if ((isset($Language)) && ($Language != "german") )
     $page = $pageheadEnglish;
   else
     $page = $pageheadGerman;

   if(mysql_error() != "")
     $errorText .= " ".mysql_error();
   print $page.$errorText.$backlink."</body></html>";
 }

 function strpos_reverse($string, $charToFind, $relativePos = -1) {
     // from http://de.php.net/manual/en/function.strpos.php
     // modified
     // $relativePos = strpos($string,$relativeChar);
     if($relativePos < 0)
       $relativePos = strlen($string);
     $searchPos = $relativePos;
     $searchChar = '';
     //
     while ($searchChar != $charToFind) {
         $newPos = $searchPos-1;
         $searchChar = substr($string,$newPos,strlen($charToFind));
         if($searchChar === false) return FALSE;
         $searchPos = $newPos;
     }
     //
     if (!empty($searchChar)) {
         //
         return $searchPos;
         return TRUE;
     }
     else {
         return FALSE;
     }
     //
 }

 function RemoveBlock($html, $commentstart, $commentend) {
    if (strpos($html, $commentstart) === false || strpos($html, $commentend) === false )
      return $html;
    $top = substr($html, 0, strpos($html, $commentstart));
    $bottom = substr($html, strpos($html, $commentend) + strlen($commentend));
    return RemoveBlock($top.$bottom, $commentstart, $commentend);

 }

 function ReplaceBlock($html, $commentstart, $commentend, $value) {
    if (strpos($html, $commentstart) === false || strpos($html, $commentend) === false )
      return $html;
    $top = substr($html, 0, strpos($html, $commentstart));
    $bottom = substr($html, strpos($html, $commentend) + strlen($commentend));
    return ReplaceBlock($top.$value.$bottom, $commentstart, $commentend, $value);

 }

 function GetBlock($html, $commentstart, $commentend) {
    if (strpos($html, $commentstart) === false || strpos($html, $commentend) === false )
      return "";
    $html = substr($html, strpos($html, $commentstart) + strlen($commentstart));
    $html = substr($html, 0, strpos($html, $commentend) - 1);
    return $html;
 }

 function SetHTMLHeaders($DefaultPageEncoding) {
   // Prevent the browser from caching the result.
   // Date in the past
   @header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
   // always modified
   @header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
   // HTTP/1.1
   @header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0') ;
   @header('Cache-Control: post-check=0, pre-check=0', false) ;
   // HTTP/1.0
   @header('Pragma: no-cache') ;

   // Set the response format.
   @header( 'Content-Type: text/html; charset='.$DefaultPageEncoding ) ;
 }

 function check_utf8_helper($str) {
     $len = strlen($str);
     for($i = 0; $i < $len; $i++){
         $c = ord($str[$i]);
         if ($c > 128) {
             if (($c > 247)) return false;
             elseif ($c > 239) $bytes = 4;
             elseif ($c > 223) $bytes = 3;
             elseif ($c > 191) $bytes = 2;
             else return false;
             if (($i + $bytes) > $len) return false;
             while ($bytes > 1) {
                 $i++;
                 $b = ord($str[$i]);
                 if ($b < 128 || $b > 191) return false;
                 $bytes--;
             }
         }
     }
     return true;
 } // end of check_utf8

 function IsUtf8String( $s ) {
     return check_utf8_helper($s);

     # problem segmentation fault one some apache webserver because of bug in libs for text > 10KB
     $ptrASCII  = '[\x00-\x7F]';
     $ptr2Octet = '[\xC2-\xDF][\x80-\xBF]';
     $ptr3Octet = '[\xE0-\xEF][\x80-\xBF]{2}';
     $ptr4Octet = '[\xF0-\xF4][\x80-\xBF]{3}';
     $ptr5Octet = '[\xF8-\xFB][\x80-\xBF]{4}';
     $ptr6Octet = '[\xFC-\xFD][\x80-\xBF]{5}';
     $result = preg_match("/^($ptrASCII|$ptr2Octet|$ptr3Octet|$ptr4Octet|$ptr5Octet|$ptr6Octet)*$/s", $s);

     if($result)
       $result = (utf8_decode($s) != "");

     return $result;
 }

?>