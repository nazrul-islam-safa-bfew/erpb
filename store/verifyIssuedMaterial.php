<? 
error_reporting(0);
header('Access-Control-Allow-Origin: *');
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";
 //datbase_connection
include($localPath."/includes/session.inc.php");
include($localPath."/includes/myFunction.php"); // some general function
include_once($localPath."/includes/myFunction1.php"); // some general function
include_once($localPath."/includes/accFunction.php"); //all accounts function
include_once($localPath."/includes/eqFunction.inc.php"); // equipment function




include($localPath."/includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
	
$todat=todat();


// nacessary action

if(!empty($_GET["issueID"])){
	
	$issueID=intval($_GET["issueID"]);
	$sql="update issue$loginProject set issuedQty=issuedQtyTemp, issuedQtyTemp='' where issueSL=$issueID and issuedQtyTemp>0 limit 1";
	
	mysqli_query($db,$sql);
	
	if(mysqli_affected_rows($db))echo "1";
	else echo 0;
	
	exit();
}

//end of action


?>
<!DOCTYPE html>
<html>
<head>
	<title>Verify Issued Material</title>
	
	<link href="http://localhost/erpb/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  
<script src="http://localhost/erpb/datatable/jquery-1.12.2.min.js"></script>
		<script src="http://localhost/erpb/datatable/jquery.dataTables.min.js"></script>
	
	
	<style>
	.issueTbl td {
		    font-family: Verdana;
    font-weight: normal;
    font-size: 11px;
    color: #404040;
		}
	.issueTbl th {
    font-size: 12px;
    border: 1px solid #CCCC99;
    background-color: #DDDDBB;
		}
	</style>
	
</head>
<body>

<div class="container">
<center><h1>
	Verify Issued Material
	</h1></center>
<table id="example" class="display issueTbl" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Item Code</th>
            <th>Quantity</th>
            <th>Issue Date</th>
            <th>Task/Sub Task</th>
            <th>Equipment</th>
            <th>Site Engineer</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Item Code</th>
            <th>Quantity</th>
            <th>Issue Date</th>
            <th>Task/Sub Task</th>
            <th>Equipment</th>
            <th>Site Engineer</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>
      <?php
			
			$sql="select * from issue$loginProject where issuedQtyTemp>0";
			$q=mysqli_query($db,$sql);
			while($row=mysqli_fetch_array($q)){ ?>
			
		
			   <tr>
            <td><?php $temp=itemDes($row["itemCode"]);echo $row["itemCode"]."<br>".$temp["des"]; ?></td>
            <td><?php echo $row["issuedQtyTemp"]; ?></td>
            <td><?php echo $row["issueDate"]; ?></td>
            <td><?php $iow=iowID2iow($row["iowId"]); echo $iow["iowCode"].": ".$iow["iowDes"]; ?><?php $siow=siowIdID2siow($row["siowId"]); echo $siow["siowCode"].": ".$siow["siowName"]; ?></td>
            <td>
					 <?php
							$eqIDArr=explode("_",$row[eqID]);
							echo "<b>$eqIDArr[1]$eqIDArr[0]</b>";
							$itemDesc=itemDes($eqIDArr[1]);
							echo ": ".$itemDesc[des];
						?>
					 </td>
            <td><?php $user=siteEngID2SiteEng($row["supervisor"]);echo $user["uname"]."<br>".$user["fullName"]; ?></td>
            <td><button id="btn_<?php echo $row["issueSL"]; ?>" onClick="acceptIt(<?php echo $row["issueSL"]; ?>);">Accept</button></td>
        </tr>
			
			
			<?php			} //while			?>
			

        </tbody>
        </table>



	
</div>




        <script type="text/javascript">
        	$(document).ready(function() {
						$('#example').DataTable();
					});

					function acceptIt(aID){
						$(document).ready(function() {
    					$.get("http://localhost/erpb/store/verifyIssuedMaterial.php",{issueID:aID},function(data,status){
								
 								if(data==1){
									$("#btn_"+aID).parent().html("Doneee");
								}else{									
									$("#btn_"+aID).parent().html("Error");
								}
							});
						});
					}
        </script>

	
	</body>
</html>



