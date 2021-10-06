<?php
include("../includes/config.inc.php");
include("../includes/session.inc.php");
include("../includes/myFunction1.php");

require_once("../includes/global_hack.php"); 
 $iow=$_GET['iow'];
 $siow=$_GET['siow'];

if($loginDesignation=="Equipment Co-ordinator")
	$loginProject='004';

if($save)
{	

	echo 'Login Project'.$loginProject;
	if($loginProject){
		$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
		$todat=date('Y-m-d');
		for($i=1; $i<$n; $i++)
		{
			if(${ch.$i})
			{
				//echo "ANS$ana<br>".${dmaQty.$i}."**";
				$qty=${dmaQty.$i}*$ana;
				$dmaItemCode=${ch.$i};

				if($s>=70) $dmaType=3;
				else if($s>=50)  $dmaType=2;
				else $dmaType=1;
				$qty=round($qty,3);

				if($loginProject)
				{ 
					 $sqldma = "INSERT INTO dmatemp (dmaId, dmaProjectCode, dmaiow,dmasiow, dmaItemCode, dmaQty, dmaDate, dmaType  )
					VALUES ('', '$loginProject', '$iow','$siow', '$dmaItemCode', '$qty', '$todat', '$dmaType'  )";


// 				echo $sqldma.'<br>';
				$sqlrunp=mysqli_query($db, $sqldma);

				 $sqlrate="Select * from itemrate where rateItemCode ='$dmaItemCode' and rateProjectCode = '$loginProject'";
				//echo $sqlrate;
				$sqlrunrate= mysqli_query($db, $sqlrate);
				$num_rows = mysqli_num_rows($sqlrunrate);
				//echo "<br>$num_rows Rows<br>";
				if($num_rows <=0)
				{
					 $sqldrate = "INSERT INTO itemrate (rateId, rateProjectCode, rateItemCode, rate, rateDate  ) 
					VALUES ('', '$loginProject', '$dmaItemCode', '', '$todat'  )";
				//echo $sqldrate.'<br>';
				$sqlrunrate= mysqli_query($db, $sqldrate);
				//echo $sqlrunrate;
			}
		}//if loginProject
	}//if qty
}//for 
echo "Your Information is Updating.. Please wait..";

echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../consumableProduct/saveItem.php?iow=$iow&siow=$siow&ana=$ana\">";
}
else echo "ERROR Please try Later";

}//dma	 
?>