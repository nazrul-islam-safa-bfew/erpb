<style>
	.strip-table{}
	.strip-table tr:nth-child(odd){background:#efefef;}
	textarea{width:98%; min-height:100px;}
	a{cursor:not-allowed;}
</style>
<?php
// if($_FILES[ws]["tmp_name"])$ws=pdfUpload_function("docx",$_FILES[ws]["tmp_name"],"/workFileStorage",$iow."_ws");
if($_FILES[wp]["tmp_name"])$wp=pdfUpload_function("docx",$_FILES[wp]["tmp_name"],"/workFileStorage",$iow."_wp");

$preWorkApproval;
$pwq;
$ongoing;
$postWork;
$safty;
if($_FILES[df]["tmp_name"])$df=pdfUpload_function("",$_FILES[df]["tmp_name"],"/workFileStorage",$iow."_".rand(100,99999999999999).$iow."_".rand(100,99999999999999)."_df".$_FILES[df]["name"]);

if($_FILES[detailingF]["tmp_name"])$detailingF=pdfUpload_function("",$_FILES[detailingF]["tmp_name"],"/workFileStorage",$iow."_".rand(100,99999999999999)."_detailingF".$_FILES[detailingF]["name"]);

if($_FILES[prescribedWork]["tmp_name"])$prescribedWork=pdfUpload_function("",$_FILES[prescribedWork]["tmp_name"],"/workFileStorage",$iow."_".rand(100,99999999999999)."_prescribedWork".$_FILES[prescribedWork]["name"]);

if($_FILES[prescribedQC]["tmp_name"])$prescribedQC=pdfUpload_function("",$_FILES[prescribedQC]["tmp_name"],"/workFileStorage",$iow."_".rand(100,99999999999999)."_prescribedQC".$_FILES[prescribedQC]["name"]);

$billingDoc;

if($_FILES[video]["tmp_name"])$video=pdfUpload_function("",$_FILES[video]["tmp_name"],"/workFileStorage",$iow."_".rand(100,99999999999999)."_video".$_FILES[video]["name"]);




	$old_df[]=$df;
	$all_old_df=json_encode($old_df);

	$old_detailingF[]=$detailingF;
	$all_old_detailingF=json_encode($old_detailingF);


$sql="select * from auxiliary_iow where iow='$iow'";
mysqli_query($db,$sql);

if(mysqli_affected_rows($db)<1){
	$sql="insert into auxiliary_iow (iow,ws,wp,preWorkApproval,pwq,ongoing,postWork,safty,df,detailingF,prescribedWork,prescribedQC,billingDoc,video,sic,cp) values ('$iow','$ws','$wp','$preWorkApproval','$pwq','$ongoing','$postWork','$safty','$df','$detailingF','$prescribedWork','$prescribedQC','$billingDoc','$video','$cp','$sic')";
	mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)>0)echo "<p>Your information has been updated.</p>";
}elseif($iow && $formSubmit){
	$sql="update auxiliary_iow set ";
	if($ws)$sqlQ[]="ws='$ws'";
	if($wp)$sqlQ[]="wp='$wp'";
	if($sic)$sqlQ[]="sic='$sic'";
	if($cp)$sqlQ[]="cp='$cp'";
	if($preWorkApproval)$sqlQ[]="preWorkApproval='$preWorkApproval'";
	if($pwq)$sqlQ[]="pwq='$pwq'";
	if($ongoing)$sqlQ[]="ongoing='$ongoing'";
	if($postWork)$sqlQ[]="postWork='$postWork'";
	if($safty)$sqlQ[]="safty='$safty'";
	if($prescribedWork)$sqlQ[]="prescribedWork='$prescribedWork'";
	if($prescribedQC)$sqlQ[]="prescribedQC='$prescribedQC'";
	if($billingDoc)$sqlQ[]="billingDoc='$billingDoc'";
	if($video)$sqlQ[]="video='$video'";
	
	if(count($sqlQ)>0)
		$sql.=implode(",",$sqlQ);
	$sql.=",df='$all_old_df',detailingF='$all_old_detailingF' where iow='$iow'";
	mysqli_query($db,$sql);
	if(mysqli_affected_rows($db)>0)echo "<p>Your information has been updated.</p>";
}

$sql="select * from auxiliary_iow where iow='$iow'";
$q=mysqli_query($db,$sql);
$row=mysqli_fetch_array($q);


?>
<form action="#" method="post" enctype="multipart/form-data">
<table width="98%"  align="center" border="1" bordercolor="#9999CC" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="strip-table" >
	<tr><td colspan="2" bgcolor="#cca277" height="20" align="center">
		<b><font color="#FFFFFF"></font></b>

		</td></tr>
  
    <tr><td width="30%">Task specification: <font class="out"></font></td><td>
      <textarea style=" width:98%" name="ws"><?php echo $row[ws]; ?></textarea>
			</td></tr>
  
    <tr><td width="30%">Construction procedure: <font class="out"></font></td><td>
			<input type="file" style=" width:98%" name="wp" value="<?php echo $row[wp]; ?>">
		</td></tr>
	
    <tr><td width="30%">List of prework activities, resource selection criteria/approvals and possession requirements: <font class="out"></font></td>
			<td>	
			<textarea name="preWorkApproval" class="editor"><?php echo $row[preWorkApproval]; ?></textarea>
			</td>
		</tr>	
	
    <tr><td width="30%">List of quality records with frequency require for running bills: <font class="out"></font></td>
			<td>	
			<textarea name="pwq"><?php echo $row[pwq]; ?></textarea>
			</td>
		</tr>
	
    <tr><td width="30%">List of quantity records with frequency require for running bills: <font class="out"></font></td><td><textarea name="ongoing"><?php echo $row[ongoing]; ?></textarea></td></tr>
	
    <tr><td width="30%">List of additional documents require for final bill: <font class="out"></font></td><td><textarea name="postWork"><?php echo $row[postWork]; ?></textarea></td></tr>	
	
	
<!--  New box  -->
    <tr><td width="30%">Quality inspection checklist (mention approved margin of tolerance where applicable): <font class="out"></font></td><td><textarea name="prescribedWork"><?php echo $row[prescribedWork]; ?></textarea></td></tr>
  
    <tr><td width="30%">Safety inspection checklist:: <font class="out"></font></td><td><textarea name="sic"><?php echo $row[sic]; ?></textarea></td></tr>
	
<!--  New box  -->
    <tr><td width="30%">Contingency plan (preventive action to unusual event that might disrupt operations): <font class="out"></font></td><td><textarea name="cp"><?php echo $row[cp]; ?></textarea></td></tr>

    <tr><td width="30%">Health, environment &amp; seasonal interventions, community &amp; local political affairs, legal &amp; taxation, utility &amp; resource avilability, accessibility, storage &amp; logistic difficulties, security &amp; local support issues etc: <font class="out"></font></td><td><textarea name="safty"><?php echo $row[safty]; ?></textarea></td></tr>
	
    <tr><td width="30%">Drawing files: <font class="out"></font></td><td>
			<input type="file" name="df" value="<?php echo $row[df]; ?>">
			<?php
			$df=json_decode($row[df],false);
			foreach($df as $sdf){
			?>
			<a href="#"><?php echo solidFileName($sdf); ?><input type="hidden" name="old_df[]" value="<?php echo $sdf; ?>"></a>
			<?php } ?>
		</td></tr>
	
    <tr><td width="30%">Detailing files: <font class="out"></font></td><td><input type="file" name="detailingF" value="<?php echo $row[detailingF]; ?>">
		<?php
			$df=json_decode($row[detailingF],false);
			foreach($df as $sdf){
			?>
			<a href="#"><?php echo solidFileName($sdf); ?><input type="hidden" name="old_detailingF[]" value="<?php echo $sdf; ?>"></a>
			<?php } ?>
			</td></tr>
	
<!--     <tr><td width="30%">Prescribed Work Progress forms: <font class="out"></font></td><td><input type="file" name="prescribedWork" value="<?php echo $row[prescribedWork]; ?>"></td></tr> -->
	
<!--     <tr><td width="30%">Prescribed QC forms: <font class="out"></font></td><td>
			<input type="file" name="prescribedQC" value="<?php echo $row[prescribedQC]; ?>"></td></tr> -->
	
<!--     <tr><td width="30%">Billing documentation requirements: <font class="out"></font></td><td><textarea name="billingDoc"><?php echo $row[billingDoc]; ?></textarea>
			<br> -->
			
		

			
			</td></tr>
	
    <tr><td width="30%">4D work plan: <font class="out"></font></td><td><input type="file" name="video" value="<?php echo $row[video]; ?>" >
			<a href="#" name="ws"><?php echo solidFileName($row[video]); ?></a></td></tr>
	
    <tr><td colspan="2"><center><input type="submit" name="formSubmit" value="Submit"></center></td></tr>
	
	

<?php


?>
  
	</table>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("a").click(function(){
		$(this).remove();
	});
});
</script>
