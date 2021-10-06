<?
include("../includes/config.inc.php");
include("../includes/session.inc.php");
include("../includes/accFunction.php");


$save=$_POST['save'];
$update=$_POST['update'];
$delete=$_POST['delete'];

$accountID=$_POST['accountID'];
$description=$_POST['description'];
$active=$_POST['active'];
$accountType=$_POST['accountType'];
$balance=$_POST['balance'];

$ID=$_GET['ID'];


$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

if($save){
$sql = "INSERT INTO `accounts`(accountID, description, active, accountType, balance) 
VALUES ('$accountID','$description','$active','$accountType','$balance')";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
}
if($update){
$sql = "UPDATE `accounts` SET accountID='$accountID',description='$description', 
active='$active', accountType='$accountType', balance='$balance' 
WHERE ID='$ID'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
}
if($delete){
if(acctBalance($p)==0){
$sql = "DELETE from `accounts` WHERE ID='$ID'";
//echo $sql;
$sqlQuery = mysqli_query($db, $sql);
}
else {echo inerrMsg("Information can't Update!!");
	  echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=mca+report\">";
	  }
}

echo "information updating.....";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=mca+report\">";
?>