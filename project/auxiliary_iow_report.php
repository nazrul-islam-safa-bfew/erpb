<style>
	.strip-table{}
	.strip-table tr:nth-child(odd){background:#efefef;}
</style>
<?php
  $sql="select * from auxiliary_iow where iow='$iow'";
  $q=mysqli_query($db,$sql);
  $row=mysqli_fetch_array($q);
?>
<table width="98%"  align="center" border="1" bordercolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="strip-table" >
	<tr><td colspan="2" bgcolor="#cca277" height="20" align="center">
		<b><font color="#FFFFFF"></font></b><div style='float:right'>
      <?php if($_SESSION[loginDesignation]=="Project Engineer"){ ?><a href="./index.php?keyword=auxiliary+iow+entry&iow=<?php echo $iow; ?>" target='_blank'>Edit</a> &nbsp;
      <?php } ?>
		</div>
		</td></tr>
  <?php 
	$sql="select itemCode,iowCode,iowDes from iow where iowId='$iow'";
// 	echo $sql;
	$q=mysqli_query($db,$sql);
	$iowRow=mysqli_fetch_array($q);
	?>
  <tr><td width="30%">Task generic code, name: <font class="out"></font></td><td><font class="out"><?php echo "<b>".$iowRow[itemCode]."</b>: ".$iowRow[iowCode]." ".$iowRow[iowDes]; ?></font></td></tr>  
  
    <tr><td width="30%">Task specification: <font class="out"></font></td><td>
      <font class="out"><?php echo $row["ws"]; ?></font>
    </td></tr>
  
    <tr><td width="30%">Construction procedure: <font class="out"></font></td><td><font class="out"><a href="./<?php echo $row["wp"]; ?>">File</a></font></td></tr> 
	
    <tr><td width="30%">List of prework activities, resource selection criteria/approvals and possession requirements: <font class="out"></font></td><td><font class="out"><?php if($row["preWorkApproval"])echo nl2br($row["preWorkApproval"]); ?></font></td></tr>
	
    <tr><td width="30%">List of quality records with frequency require for running bills: <font class="out"></font></td><td><font class="out"><?php if($row["pwq"])echo nl2br($row["pwq"]); ?></font></td></tr>
	
    <tr><td width="30%">List of quantity records with frequency require for running bills: <font class="out"></font></td><td><font class="out"><?php if($row["ongoing"])echo nl2br($row["ongoing"]); ?></font></td></tr>	
		
    <tr><td width="30%">List of additional documents require for final bill: <font class="out"></font></td><td><font class="out"><?php if($row["postWork"])echo nl2br($row["postWork"]); ?></font></td></tr>
	
<!--  New box  -->
    <tr><td width="30%">Quality inspection checklist (mention approved margin of tolerance where applicable): <font class="out"></font></td><td><font class="out"><?php if($row["prescribedWork"])echo nl2br($row["prescribedWork"]); ?></font></td></tr>
  
  
    <tr><td width="30%">Safety inspection checklist: <font class="out"></font></td><td><font class="out"><?php if($row["sic"])echo nl2br($row["sic"]); ?></font></td></tr>

<!--  New box  -->
    <tr><td width="30%">Contingency plan (preventive action to unusual event that might disrupt operations): <font class="out"></font></td><td><font class="out"><?php if($row["cp"])echo nl2br($row["cp"]); ?></font></td></tr>


    <tr><td width="30%">Health, environment &amp; seasonal interventions, community &amp; local political affairs, legal &amp; taxation, utility &amp; resource avilability, accessibility, storage &amp; logistic difficulties, security &amp; local support issues etc: <font class="out"></font></td><td><font class="out"><?php if($row["safty"])echo nl2br($row["safty"]); ?></font></td></tr>
	
    <tr><td width="30%">Drawing files: <font class="out"></font></td><td>
		<?php
			$df=json_decode($row[df],false);
			foreach($df as $sdf){
			?>
				<a href="./<?php echo $sdf; ?>" target='_blank'><?php echo solidFileName($sdf); ?></a>&nbsp;&nbsp;
		<?php } ?>
		</td></tr>
			
    <tr><td width="30%">Detailing files: <font class="out"></font></td><td>		<?php
			$df=json_decode($row[detailingF],false);
			foreach($df as $sdf){
			?>
			<a href="./<?php echo $sdf; ?>" target='_blank'><?php echo solidFileName($sdf); ?></a>&nbsp;&nbsp;
		<?php } ?></td></tr>
	
<!--<tr><td width="30%">Prescribed Work Progress reporting forms: <font class="out"></font></td><td><font class="out"><a href='./<?php echo $row["prescribedWork"]; ?>' target='_blank'><?php echo solidFileName($row["prescribedWork"]); ?></a></font></td></tr> -->

<!--<tr><td width="30%">Prescribed QC forms: <font class="out"></font></td><td><font class="out"><a href='./<?php echo $row["prescribedQC"]; ?>' target='_blank'><?php echo solidFileName($row["prescribedQC"]); ?></a></font></td></tr> -->

<!--<tr><td width="30%">Billing documentation requirements: <font class="out"></font></td><td><font class="out"><?php echo $row["billingDoc"]; ?></font></td></tr> -->

<tr><td width="30%">4D work plan: <font class="out"></font></td><td><font class="out"><a href='.<?php echo $row["video"]; ?>' target='_blank'><?php echo solidFileName($row["video"]); ?></a></font></td></tr>
	
<tr><td width="30%" height="0"></td></tr>
	
<tr><td width="30%">
	Billing document status:</td><td>
<?php
foreach(getBillingDocRows($iow,1) as $rows){
	if(!$rows[edate])continue;
  //echo "<font color='#00f'>$rows[bParcent]%</font> ";
	echo "(<font class=\"out\">".date("d/m/Y",strtotime($rows[edate]))."</font>): <i><font color='#f00'>".$rows[bDes]."</font></i>	<br>
";
}	
?></td></tr>
<?php

?>  
</table>