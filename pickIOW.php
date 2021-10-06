<?php
//formate date function
include("./includes/global_hack.php");
include("./includes/session.inc.php");
include("./includes/config.inc.php");
include("./includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	


$iow=intval($_GET["iow"]);
if($iow>0){

  //iow
  $sql="select * from iow where iowId=$iow";
  $q=mysqli_query($db, $sql);
  $iow_row=mysqli_fetch_array($q);

  //siow  
  $sql="select * from siow where iowId=$iow";
  $q=mysqli_query($db, $sql);
  while($siow_row=mysqli_fetch_array($q)){
		$siow_ids[]=$siow_row[siowId];
	}
	$siow_id=implode(",",$siow_ids);
  $siow_row_count=mysqli_affected_rows($db);

	//dma
	$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` in (".$siow_id.") order by dmaItemCode ASC";
  $qr=mysqli_query($db, $sqlp);
  $dma_row_count=mysqli_affected_rows($db);
	
	
	
	$iowPos=$_POST["iowPos"];
	$iowCode=$_POST["iowCode"];
	$itemCode=$_POST["itemCode"];
	if($iowPos && $iowCode && $itemCode){

		//iow insert
		$iow_insert="insert into iowtemp (iowProjectCode, itemCode, iowCode, iowDes, iowQty, iowUnit, iowPrice, iowTotal, iowType, iowStatus, iowDate, position )
														  values ('$_SESSION[loginProject]','$itemCode', '$iowCode', '$iow_row[iowDes]', '$iow_row[iowQty]', '$iow_row[iowUnit]', '$iow_row[iowPrice]', '$iow_row[iowTotal]', '$iow_row[iowType]', 'Not Ready', '".todat()."', '$iowPos')";
		mysqli_query($db, $iow_insert);
		if(mysqli_affected_rows($db)>0){ //iow inserted
			$iow_l_id=mysqli_insert_id($db);
			
			
			$sqlitem = "INSERT INTO `itemlist` (itemCode, itemDes, itemSpec, itemUnit, iowSales,GLsit,GLsales,GLinventory, GLcost,itemType)".
 "VALUES ('$itemCode', '$iow_row[iowDes]', '', '$iow_row[iowUnit]', '','','', '', '','')";
//echo  $sqlitem;
$sqlrunItem= mysqli_query($db, $sqlitem);
			
			
			  //siow  loop
			$sql="select * from siow where iowId=$iow";
			$q=mysqli_query($db, $sql);
			while($siow_rows=mysqli_fetch_array($q)){

				//siow insert
				$siow_insert="insert into siowtemp (siowPcode, iowId, siowCode, siowName, siowQty, siowUnit, analysis, siowDate) values 																				('$_SESSION[loginProject]', '$iow_l_id', '$siow_rows[siowCode]".rand(11,99)."', '$siow_rows[siowName]', '$siow_rows[siowQty]', '$siow_rows[siowUnit]', '$siow_rows[analysis]', '".todat()."')";
				mysqli_query($db, $siow_insert);
				
				
				
				if(mysqli_affected_rows($db)>0){ //siow inserted
					$siow_l_id=mysqli_insert_id($db);
					
					//dma loop
					$sqlp ="SELECT * FROM `dma` WHERE `dmasiow` in (".$siow_id.") order by dmaItemCode ASC";
					$qr=mysqli_query($db, $sqlp);
					while($dma_rows=mysqli_fetch_array($qr)){
						 $dma_insert="insert into dmatemp (dmaProjectCode, dmaiow, dmasiow, dmaItemCode, dmaQty, dmaRate, dmaVid, dmaDate, dmaType ) values ('$_SESSION[loginProject]', '$iow_l_id', '$siow_l_id', '$dma_rows[dmaItemCode]', '$dma_rows[dmaQty]', '$dma_rows[dmaRate]', '$dma_rows[dmaVid]', '".todat()."', '$dma_rows[dmaType]')";
						mysqli_query($db, $dma_insert);
					}//loop of dma
				}//if siow inserted
			}//siow while		
		}//if iow inserted
		?>
	<small>New IOW has been saved!</small>
	<script type="text/javascript">
	tt=setTimeout(function(){window.close()},100000000000);
	</script>
		<?php
	} // if have iow code	
	
?>
<script type="text/javascript">
function check(){
  val=document.getElementById("iowPos").value;
  f=val.slice(3,4);
  s=val.slice(7,8);
  t=val.slice(11,12);
  
 if(f=="." && s=="." && t=="." && val.length==15){
    document.getElementById("theForm").submit();
 }
  else{
    alert("Please check the position");
    document.getElementById("iowPos").focus();
  }
}
</script>
  
  <form method="post" id="theForm">   

<table border=0 align="center" style="border: 1px solid #ccc;
    box-shadow: 0 0 1px 1px #ccc; padding:5px;">
  <tr>
    <th>
      IOW Copy
    </th>
  </tr>
  <tr>
    <td>
      <p>
        IOW Description: <font color="blue"><?php echo $iow_row[iowDes]; ?></font><br>
        SIOW Found: <font color="blue"><?php echo $siow_row_count; ?></font> Nos<br>
        Resources Found: <font color="blue"><?php echo $dma_row_count; ?></font> Nos<br><br>
      </p>
    </td>
  </tr>
  <tr>
    <td>
      <label for="iowPos">IOW Position: </label><input type="text" name="iowPos" id="iowPos" style="float:right" placeholder="000.000.000.000" size="15" maxlength="15">
    </td>
  </tr>
  
  <tr>
    <td>      
      <label for="iowCode">IOW Code: </label><input type="text" name="iowCode" style="float:right" placeholder="IOW Code">
    </td>
  </tr>
  <tr>
    <td>      
      <label for="iowCode">Item Code: </label><input type="text" name="itemCode" style="float:right" placeholder="Item Code">
    </td>
  </tr>
  <tr>
    <td>      
      <input type="submit" value="SAVE As" onClick="check();return false;" />
    </td>
  </tr>
</table>
    </form>
  

<?php
}
?>