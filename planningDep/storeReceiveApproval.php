<?php
if($trigger){
  $uSql="update store$loginProject set receiveQty=receiveQty+receiveQtyTemp, currentQty=currentQty+receiveQtyTemp, receiveQtyTemp=0 where rsid='$trigger' and receiveQtyTemp>0 and receiveQty<=0 and currentQty<=0";
  mysqli_query($db,$uSql);
  if(mysqli_affected_rows($db)>0)echo "Your information has been updated!";

	$rrrSql="select paymentSL from store$loginProject where rsid='$trigger' and paymentSL like 'PO%'";
	$rrrQ=mysqli_query($db,$rrrSql);
	$rrrRow=mysqli_fetch_array($rrrQ);
	if($rrrRow[paymentSL])completePO($rrrRow[paymentSL]);
}

if($loginDesignation=='Store Officer'){
	$uSql="select * from storet$loginProject where receiveQtyTemp>0 and paymentSL like 'EP_%'";
	$rQ[0]=mysqli_query($db,$uSql);

	$uSql="select * from store$loginProject where receiveQtyTemp>0 and paymentSL like 'EP_%'";
	$rQ[1]=mysqli_query($db,$uSql);
	
}else{
	$rSql="select * from store$loginProject where receiveQtyTemp>0 and paymentSL like 'PO_%'";
	$rQ[0]=mysqli_query($db,$rSql);
}



// echo $uSql;
// echo $rSql;
// $rRow=mysqli_fetch_array($rQ);
// if(mysqli_affected_rows($db)>0)
{
?>
<div>
	<?php echo btnPDFstyle(); ?>
  <style>
    .hiddenDiv{display:none}
    .popUP{position:absolute;left:0px;top:0px;width:100%;}
  </style>
		<table align="center" width="98%" border="3" bordercolor="#99CC99" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tbody>
	<tr bgcolor="#99CC99">
		<td colspan=6 align=center><b>Waiting For Acceptance</b></td>
	</tr>
	<tr bgcolor="#99CC99">
		<td>Receiving Date</td>
		<td>ItemCode</td>
		<td>Reference</td>
		<td>Quantity</td>
		<td>Action</td>
	</tr>
	<?php
 foreach($rQ as $rrQ)
	while($rRow=mysqli_fetch_array($rrQ)){
	echo '<tr>
					<td>'.date("d/m/Y",strtotime($rRow[todat])).'</td>
					<td>'.$rRow[itemCode].'</td>
					<td>'.$rRow[reference].'</td>
					<td align=right>'.number_format($rRow[receiveQtyTemp],3).'</td>
          <td>
            <a href=\'\' class=\'btnPDF btnAccept\'>View</a>
            <div class=\'hiddenDiv popUP\'>
              '.pdf_json_files_viewer($rRow[pdf_files],2).'
              <a href="./index.php?keyword=purchase+order+store+receive&s=0&trigger='.$rRow[rsid].'" class="btnPDF">Accept</a>
              <a href="" class="btnPDF closeBTN">Close</a>
            </div></td>
	</tr>';
	}
	?>
	</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("a.btnAccept").click(function(){
    $(this).next("div.hiddenDiv").show();
    return false;
  });
  $("a.closeBTN").click(function(){
    $(this).parent("div").fadeIn();
  });
});
</script>
<?php }  ?>