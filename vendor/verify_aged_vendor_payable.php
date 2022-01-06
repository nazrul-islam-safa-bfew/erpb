<? 
error_reporting(0);
include_once("../includes/session.inc.php");

include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/accFunction.php");
include_once("../includes/eqFunction.inc.php");
/*include_once("../includes/empFunction.inc.php");

include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
*/

include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$todat=todat();
$posl=$_GET["posl"];
$pcode=$_GET["pcode"];
$type=$_GET["type"];
$invoiceDate=$_GET["invoiceDate"];
if(strtotime($invoiceDate)<1 && $type!="c"){
	echo "<h1>Error #404, invoice date not found.</h1>";
	exit;
}
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
$path="./vendorPaymentApprovalPDF";
$todat=todat_new_format("Y-m-d h:i");
if($_FILES["pdf"])
	$upload=pdfUpload("pdf",$_FILES["pdf"]["tmp_name"],$path,$posl."_".$invoiceDate);
if($upload){
	
	$deleteSql="delete from verify_vendor_payable where posl='$posl' and invoiceDate='$invoiceDate'";
	if($type=="c")$deleteSql.=" and type='$type' ";

	if($_POST["force"])mysqli_query($db, $deleteSql);
	$sql="insert into verify_vendor_payable (posl,pdf,invoiceDate,updated_at,type) values ('$posl','$upload','$invoiceDate','$todat','$type')";
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
<title>BFEW :: Aged Vendor Payment Verify</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="700" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th bgcolor="#3366FF" colspan=2><h1>Bangladesh Foundry and Engineering Works Ltd.</h1></th>
</tr>
<tr>
 <th align="left" style="font-size:10px; font-weight:100;">
  Project <? echo myProjectName($_GET["pcode"]);?><br>
  POSL <?php echo $_GET["posl"]; 
	 if($type!="c"){?><br>
  Invoice Date <?php echo date("d-m-Y",strtotime($invoiceDate)); 
	 }
	 ?>
 </th>
</tr>
  
  <tr>
  <td height=50>
		<?php
		$posl_data=explode("_",$posl);
		$project=$posl_data[1];
		
// 	porder approval pdf
		$porder_approval_sql="select pdf from porder_approval where posl='$posl'";
		$porder_approval_q=mysqli_query($db,$porder_approval_sql);
		$porder_approval_row=mysqli_fetch_array($porder_approval_q);
// 	chalan pdf
		$chalan_sql="select reference,pdf_files from store$project where paymentSL='$posl' and pdf_files!=''";
		$chalan_q=mysqli_query($db,$chalan_sql);
		while($chalan_row[]=mysqli_fetch_array($chalan_q)){}
		
		
		?>

			<tr>
			<td>
				PO Attachment Files<br>
				<?php if($porder_approval_row[pdf]){ ?>
					<a href="../<?php echo $porder_approval_row[pdf];	?>" target="_blank">PDF</a>
				<?php } ?>
				
			</td>
			<td>
				Chalan/voucher Attachment Files<br>
				<?php
				foreach($chalan_row as $chalanS) if($chalanS){
				$arra=json_decode($chalanS[pdf_files]);
				
				?>
					<a href="../<?php echo $arra[0];	?>" target="_blank">PDF</a>
				<? } ?>
				
				
				
			</td>
			</tr>
		
		</td>
  </tr>
  
  
  <tr>
  <td>
    <form method="post"  enctype="multipart/form-data">
			<label for="force">
				<input type="checkbox" name="force"> Force upload to file replace.
				<input type="hidden" name="invoiceDate" value="<?php echo $invoiceDate; ?>">
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

<? 






?>
<table align="center" width="95%" border="0" bordercolor="#0099FF" 
cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="dblue">


<?
$sqlv="select * from verify_vendor_payable WHERE posl='$posl'";
//echo "<br>$sqlv<br>";
$sqlqv=mysql_query($sqlv);
 ?>
 


</table>



