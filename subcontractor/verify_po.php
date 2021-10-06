<? 
error_reporting(0);
include_once("../includes/session.inc.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);

include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/accFunction.php");
include_once("../includes/eqFunction.inc.php");
/*
include_once("../includes/empFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
*/
	
$todat=todat();
$posl=$_GET["posl"];
if(check_posl_approved($posl)){
	echo "<center><h1>Verified</h1></center>";
	exit();
}
$pcode=$_GET["pcode"];
function pdfUpload($test,$testTemp,$loc,$qid){
   //echo "Still Here";
	$filemain = "$loc/$qid.$test";
	//echo $filemain.'<br>';
	//echo $test.'<br>';
	//print_r( $testTemp); echo '<br>';	
	if (move_uploaded_file($testTemp, ".".$filemain)) {
	   echo "File is valid, and was successfully uploaded.\n";
	   return $filemain;
	} else {
	   echo "Possible file upload attack!\n";
	   return 0;
	}
}
$path="./poApprovalPDF";
$todat=todat_new_format("Y-m-d h:i");
if($_FILES["pdf"])
	$upload=pdfUpload("pdf",$_FILES["pdf"]["tmp_name"],$path,$posl);
if($upload){
	if($_POST["force"])mysqli_query($db, "delete from verify_vendor_payable where posl='$posl'");
	$sql="insert into porder_approval (posl,pdf,updated_at) values ('$posl','$upload','$todat')";
	mysqli_query($db, $sql);
	
	if(mysqli_affected_rows($db)>0)
		echo "<h1>succesfuly verified.</h1>";
	else
		echo "<br>Error: ".mysqli_error($db);	
}

?>
<html>
<head>
<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Purchase Order Verify</title>
</head>
<body topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF">
<a name="top"></a>
<table width="700" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th bgcolor="#3366FF"><h1>Bangladesh Foundry and Engineering Works Ltd.</h1></th>
</tr>
<tr>
 <th align="left" style="font-size:10px; font-weight:100;">
  Project <? echo myProjectName($_GET["pcode"]);?><br>
  POSL <?php echo $_GET["posl"] ?>
 </th>
</tr>  
  <tr>
  	<td height=50>
	<?php
	$poTypeCC=getPoTypePOSL($_GET["posl"]);
	 if($poTypeCC==2){
		 echo "<h3>Please attach billing documents of purchase order.</h3>";
	 }
	?>
		
		</td>
  </tr>
  
  
  <tr>
  <td>
    <form method="post"  enctype="multipart/form-data">
			<label for="force">
				<input type="checkbox" name="force"> Force upload to file replace.
			</label><br>
      <label for="pdf"?>Attachment File <input type="file" name="pdf" accept="application/pdf"></label>      
      <input type="submit" value="Attached">
    </form>
    </td>
  </tr>

</table>
<br>
<br>


<br>
<br>


<table align="center" width="95%" border="0" bordercolor="#0099FF" 
cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="dblue">


<?
$sqlv="select * from verify_vendor_payable WHERE posl='$posl'";
//echo "<br>$sqlv<br>";
$sqlqv=mysql_query($sqlv);
?>
 


</table>



