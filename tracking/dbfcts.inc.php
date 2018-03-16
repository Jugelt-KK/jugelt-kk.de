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

 include("dbaccess.inc.php");

 ################ MS SQL emulation with sqlsrv_ functions
 $sqlsrv_functions = false;
 if(!function_exists("mssql_connect") && function_exists("sqlsrv_connect")){
   $sqlsrv_functions = true;
   function mssql_connect($SQLServerName, $SQLUserName, $SQLPassword, $SQLDatabase = "") {
      if($SQLDatabase != "")
         $connectionInfo = array("UID" => $SQLUserName, "PWD" => $SQLPassword, "Database"=>$SQLDatabase, "CharacterSet"=>"UTF-8");
         else
         $connectionInfo = array("UID" => $SQLUserName, "PWD" => $SQLPassword, "CharacterSet"=>"UTF-8");
      return sqlsrv_connect( $SQLServerName, $connectionInfo);
   }

   function mssql_select_db($db, $dummy){
     global $DBLink;
     if($DBLink)
       return true;
       else
       return false;
   }

   function mssql_close($conn){
     sqlsrv_close($conn);
   }

   function mssql_free_result($stmt){
     sqlsrv_free_stmt($stmt);
   }

   function mssql_get_last_message(){
     $s = sqlsrv_errors();
     if(is_array($s)) {
       $text = "";
       foreach($s as $key => $value)
         if(!is_array($value))
           $text .= "$key: $value";
           else
           foreach($value as $k => $v)
             $text .= "\r\n".$v;

       $s = $text;
     }
     return $s;
   }


   function mssql_query($sql){
     global $DBLink;
     return sqlsrv_query($DBLink, $sql, array(), array( "Scrollable" => 'static' )); #static because sqlsrv_num_rows() doesn't work without it
   }

   function mssql_rows_affected($ressource){
     return sqlsrv_rows_affected($ressource);
   }

   function mssql_num_fields($ressource){
     return sqlsrv_num_fields($ressource);
   }

   function mssql_field_name($ressource, $fieldindex){
     return sqlsrv_get_field($ressource, $fieldindex);
   }

   function mssql_num_rows($ressource){
     return sqlsrv_num_rows($ressource);
   }

   function mssql_fetch_array($ressource){
     $ret = sqlsrv_fetch_array($ressource, SQLSRV_FETCH_BOTH);
     if($ret == null)
      return false;
      else
       return $ret;
   }
 }

######### database connections
 $DBLink = db_connect($SQLServerName, $SQLUserName, $SQLPassword, $SQLDBName);
 if ($DBLink == FALSE) {
   print ("State: ".$ServerAccessFailure. "\t". db_error()."\n");
   exit;
 }

 if(!$MSSQL) {
   # for mysql only!!!
   // UTF-8 connection
   @mysql_query("SET NAMES 'utf8'", $DBLink);
   @mysql_query("SET CHARACTER SET 'utf8'", $DBLink);
   // not STRICT mode
   @mysql_query('SET SQL_MODE=""', $DBLink);
 }

 if (db_select_db("$SQLDBName") == FALSE) {
   print ("State: ".$DatabaseSelectFailure. "\t". db_error()."\n");
   exit;
 }

 if(!$MSSQL) {
   # for mysql only!!!
   // UTF-8 connection
   @mysql_query("SET NAMES 'utf8'", $DBLink);
   @mysql_query("SET CHARACTER SET 'utf8'", $DBLink);
   // not STRICT mode
   @mysql_query('SET SQL_MODE=""', $DBLink);
 }

###########################################################

 function mysql_escape_mimic($inp) {
     if(is_array($inp))
       if( version_compare(PHP_VERSION, "5.0.0", "<") )
         return array_map(__FUNCTION__, $inp);
         else
         return array_map(__METHOD__, $inp);

     if(!empty($inp) && is_string($inp)) {
         return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
     }

     return $inp;
 }

 function quote($s) {
   global $MSSQL, $DBLink;
   if($MSSQL){
    $s = mysql_escape_mimic($s);
   } else {
     if(function_exists("mysql_real_escape_string") && isset($DBLink) && $DBLink)
       $s = mysql_real_escape_string($s, $DBLink);
       else {
         $s = mysql_escape_mimic($s);
       }
   }
   $s = "'".$s."'";

   return $s;
 }

###########################################################

 function db_connect($SQLServerName, $SQLUserName, $SQLPassword, $SQLDBName = "") {
   global $MSSQL, $sqlsrv_functions;

   if($MSSQL) {
       if($sqlsrv_functions)
         return mssql_connect($SQLServerName, $SQLUserName, $SQLPassword, $SQLDBName);
         else {
           $conn = mssql_connect($SQLServerName, $SQLUserName, $SQLPassword);
           if($SQLDBName != "" && $conn !== false)
             mssql_select_db("[$SQLDBName]", $conn);
           return $conn;
         }
     }
    else {
     $conn = mysql_connect($SQLServerName, $SQLUserName, $SQLPassword);
     if($SQLDBName != "" && $conn !== false)
       mysql_select_db($SQLDBName, $conn);
     return $conn;
    }
 }

 function db_select_db($SQLDBName) {
   global $MSSQL, $DBLink;

   if($MSSQL)
     return mssql_select_db("[$SQLDBName]", $DBLink);
    else
     return mysql_select_db($SQLDBName, $DBLink);
 }

 function db_close($link) {
   global $MSSQL;

   if($MSSQL)
     mssql_close($link);
    else
     mysql_close($link);
 }

 function db_free_result($ressource) {
   global $MSSQL;

   if($MSSQL)
     return mssql_free_result($ressource);
    else
     return mysql_free_result($ressource);
 }

 function db_error() {
   global $MSSQL;

   if($MSSQL){
       $s = mssql_get_last_message();
       if(db_errno() == 0)
         $s = "";
       return $s;
     }
     else
     return mysql_error();
 }

 function db_errno() {
   global $MSSQL, $DBLink;

   if($MSSQL) {
       if($DBLink == 0) return 1;
       $sql = "SELECT @@ERROR as ErrorCode";
       $result=db_query($sql);
       if($result && $row=db_fetch_array($result)){
         db_free_result($result);
         return $row[0];
       }
       return 0;
     }
     else
     return mysql_errno();
 }

 function db_query($sql) {
   global $MSSQL, $DBLink;
   if($MSSQL)
     return mssql_query($sql);
     else
     return mysql_query($sql);
 }

 function db_affected_rows($ressource) {
   global $MSSQL;
   if($MSSQL)
     return mssql_rows_affected($ressource);
     else
     return mysql_affected_rows();
 }

 function db_num_fields($ressource) {
   global $MSSQL;
   if($MSSQL)
    return mssql_num_fields($ressource);
    else
    return mysql_num_fields($ressource);
 }

 function db_field_name($ressource, $fieldindex) {
   global $MSSQL;
   if($MSSQL)
    return mssql_field_name($ressource, $fieldindex);
    else
    return mysql_field_name($ressource, $fieldindex);
 }

 function db_num_rows($ressource) {
   global $MSSQL;
   if(!$ressource) return 0;
   if($MSSQL)
    return mssql_num_rows($ressource);
    else
    return mysql_num_rows($ressource);
 }

 function db_fetch_array($ressource) {
   global $MSSQL;
   if($MSSQL)
    return mssql_fetch_array($ressource);
    else
    return mysql_fetch_array($ressource);
 }

 function db_GetNow() {
   global $MSSQL;
   if(!$MSSQL)
     return "NOW()";
     else
     return "GETDATE()";
 }

 function db_LASTINSERTID($tablename) {
   global $MSSQL;
   if(!$MSSQL)
    return db_query("SELECT LAST_INSERT_ID()");
    else
    return db_query("SELECT IDENT_CURRENT('$tablename')");
 }

?>