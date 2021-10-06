<? 
error_reporting(0);
include_once("../includes/session.inc.php");

include_once("../includes/myFunction1.php");
include_once("../includes/myFunction.php");
include_once("../includes/accFunction.php");
include_once("../includes/eqFunction.inc.php");


include("../includes/config.inc.php");
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
	
	<link href="http://win4win.biz/erp/bfew/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  
<script src="http://win4win.biz/erp/bfew/datatable/jquery-1.12.2.min.js"></script>
		<script src="http://win4win.biz/erp/bfew/datatable/jquery.dataTables.min.js"></script>
	
	
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
            <th>Task</th>
            <th>Sub Task</th>
            <th>Site Engineer</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Item Code</th>
            <th>Quantity</th>
            <th>Issue Date</th>
            <th>Task</th>
            <th>Sub Task</th>
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
            <td><?php $iow=iowID2iow($row["iowId"]); echo $iow["iowCode"].": ".$iow["iowDes"]; ?></td>
            <td><?php $siow=siowIdID2siow($row["siowId"]); echo $siow["siowCode"].": ".$siow["siowName"]; ?></td>
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
    					$.get("http://www.win4win.biz/erp/bfew/store/verifyIssuedMaterial.php",{issueID:aID},function(data,status){
								
 								if(data==1){
									$("#btn_"+aID).parent().html("Done");
								}else{									
									$("#btn_"+aID).parent().html("Error");
								}
							});
						});
					}
        </script>

	
	</body>
</html>



