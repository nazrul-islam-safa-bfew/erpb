<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$(":submit").click(function(){
		$("input:checked").each(function(){
//			$.post("./vendor/deleveryMode.sql.php",{$(this).attr("name"):$(this).val()});
			$.post("./vendor/deleveryMode.sql.php",{s:"a"})
			 .done(function( data ) {
			 	console.log($(this).val()+data);
			 });
			
		});	
		return false;
	});
});
</script>
<?php 
	include("config.inc.php");
	$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
		mysql_select_db($SESS_DBNAME,$db);
		
if($_POST["submit"]){


	$sqlp = "SELECT itemCode,itemDes,itemSpec,itemUnit from `itemlist`  ORDER by itemCode ASC";
	//echo $sqlp;
	$sqlrunp= mysql_query($sqlp);
	
	 while($typel= mysql_fetch_array($sqlrunp))
	{
		$the_var[]="'".$_GET[$typel[itemCode]."_".$loginProject]."'";
	}//while
	print_r($the_var);

}//if

?>
<form action="" method="post">
  <table   class="vendorTable" border="1" align="center"  width="98%"   >
        <tr > 
          <td class="vendorAlertHdt"> Item Code</td>
          <td class="vendorAlertHdt"> Description</td>
          <td class="vendorAlertHdt"> Receive Type</td>
		</tr>	
		<?php 
		

$sqlp = "SELECT itemCode,itemDes,itemSpec,itemUnit from `itemlist`  ORDER by itemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);

 while($typel= mysql_fetch_array($sqlrunp))
{


		
		?>
		<tr>
			<td align="center"><?php echo $typel[itemCode]; ?></td>
			<td align="left"><?php echo $typel[itemDes]; ?></td>
			<td align="left">
				<input checked="checked" type="radio" name="<?php echo $typel[itemCode]."_".$loginProject;?>" value="s"><label for="<?php echo $typel[itemCode]."_".$loginProject;?>">Self Collection</label>
				<input type="radio" name="<?php echo $typel[itemCode]."_".$loginProject;?>" value="d"><label for="<?php echo $typel[itemCode]."_".$loginProject;?>">Delivery at Site</label>
			</td>
		</tr>

		<?php
		//break;
		} ?>
				<tr>
			<td><input type="submit" name="submit" value="submit"></td>
		
		</tr>
	</table>
	
</form>
