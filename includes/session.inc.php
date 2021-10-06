<?
session_start();

if(!$_SESSION["loginUid"]){
  $_SESSION["errorCode"]=0;
}


$_SESSION["errorLimit"]=20;

$_SESSION["loginUname"];
$_SESSION["loginUid"];
$_SESSION["loginDesignation"];
$_SESSION["loginProject"];
//echo session_id();
$_SESSION["loginFullName"];
$_SESSION["loginProjectName"];
//echo $_SESSION["loginFullName"];
?>
