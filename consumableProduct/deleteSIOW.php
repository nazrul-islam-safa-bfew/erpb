<?  
include("../includes/session.inc.php");  
 //if($siowId){
  include("../includes/config.inc.php");
  include("../includes/myFunction1.php");
  include("../includes/myFunction.php");  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

print $sqls1 = "SELECT issuedQty  from `issue$project` WHERE siowId='$siowId'";
//echo $sqls1;
$sqlruns1= mysqli_query($db, $sqls1);
$sqlr=mysql_num_rows($sqlruns1);
if($sqlr>=1){
echo inerrMsg("Your given information can't saved <br> There are maybe some ERROR!!");
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"5; URL=../index.php?keyword=site+view+dma&iow=$iow\">";
}
 else {
 
  print $sqlp = "DELETE from siowtemp where siowId=$siowId";
//echo $sqlp.'<br>';
mysqli_query($db, $sqlp);

  print $sqlp1 = "DELETE from dmatemp where dmasiow=$siowId";
//echo $sqlp1.'<br>';
mysqli_query($db, $sqlp1);

echo "SIOW has been deleting...";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+view+dma&iow=$iow\">";
 
 }

//}
?>