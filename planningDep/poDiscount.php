<?php
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$posl=$_GET[posl];
$amount=$_POST[amount];
$edate=todat();
if($posl && $amount){
  $deleteSql="delete from poDiscount where posl='$posl'";
  mysqli_query($db,$deleteSql);
  $sql="insert into poDiscount (posl,amount,edate) values ('$posl','$amount','$edate')";
  mysqli_query($db,$sql);
  echo "<p>Your information has been updated!</p>";
}



?>

<table width="100%">
	
	<form action="" method="post">
		<tr>
			<td></td>
			<td colspan="2" align="center">
			  <div style="    height: 10px;
    width: 300px;
    background: #06f;">
				
				</div>
			</td>
			<td></td>
		</tr>
    
    
    <tr style="">
			<td></td>
			<td colspan="2" align="center">
				<div style="width: 300px; border:1px solid #ddd;">
					<span>
      <b>POSL:</b> <?php echo $posl ?> 
          [<a target="_blank" href="./poUnder/printpurchaseOrder1.php?posl=<? echo $posl;?>">VIEW</a>]
          </span>
      <br>
      <br>
          <input type="hidden" name="posl" value="<? echo $posl;?>">
						Discount Tk.<input type="number" value="<?php echo getDiscountAmount($posl); ?>" name="amount" id="amount" required>
      <br>
      <br>
						<input type="submit" value="Submit" name="Submit" id="Submit">
					<h3></h3>
						
				
				</div>
				</td>
			<td></td>
		</tr>
    
    
  </form>
  
</table>