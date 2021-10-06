<? 
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$edate=formatDate($edate, 'Y-m-d');
$todat = todat();

for($i=1;$i<$n;$i++){
$itemCode=${itemCode.$i};
$qty=${dqty.$i};
$rate=${rate.$i};
	    $sqls = "SELECT * from store where itemCode ='$itemCode' AND currentQty <> 0 ORDER by rsid ASC";
         //echo $sqls.'<br>';
		$sqlsq=mysqli_query($db, $sqls);
		while($sr=mysqli_fetch_array($sqlsq)){
		  if($qty <= $sr[currentQty])
		  {

			$sqlitem1 = "INSERT INTO `storet$project` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
						 "VALUES ('','$itemCode', '$qty','$qty', '$rate',  'ST_$eqtsl','$posl', '$remark', '$edate')";

						echo '<br>'.$sqlitem1.'<br>';
						
			$query= mysqli_query($db, $sqlitem1);	 
			
			  $sql= "UPDATE store set currentQty=($sr[currentQty]-$qty) where rsid=$sr[rsid] ";
			  //echo $sql.'<br>';
			  mysqli_query($db, $sql);
	
			
			 
			break;
		  }//if
		  else if($qty > $sr[currentQty])
		  {

			$sqlitem1 = "INSERT INTO `storet$project` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
						 "VALUES ('','$itemCode', '$sr[currentQty]','$sr[currentQty]', '$rate',  'ST_$eqtsl','$posl', '$remark', '$edate')";

				//		echo '<br>'.$sqlitem1.'<br>';
						
			$query= mysqli_query($db, $sqlitem1);	  
						
		   $qty=$qty-$sr[currentQty];

		  $sql= "UPDATE store set currentQty=0 where rsid=$sr[rsid] ";
		  // echo $sql.' 2<br>';
			 mysqli_query($db, $sql);
		  }//else if
       } //while
		  $remainQty = remainQty_storet($posl,$itemCode,$project);
		 // echo "--remainQty:$remainQty--";
		  if($remainQty==0){
  			$sqlitem11 = "UPDATE `porder` SET status='2' WHERE posl='$posl' AND itemCode='$itemCode'";
			// echo '<br>'.$sqlitem11.'<br>';
			$query= mysqli_query($db, $sqlitem11);						
			}		
	   
}//for
echo "Your informations are saving...<br> wait Please.. ";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=store+transfer\">";

?>