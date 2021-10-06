<?
//main
$loginDesignation = $_SESSION['loginDesignation'];
echo "This is the main page"; 
 if($loginDesignation=='Task Supervisor'){
   include("./project/taskDailyReport.php");
 }
?>