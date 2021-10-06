<?php
//==========================================================================================================================
//==========================================================================================================================
//==========================================================================================================================
//==========================================================================================================================
//==============================?><?php //error_reporting(0);
//==========================================================================================================================
//==========================================================================================================================
//==========================================================================================================================

putenv ('TZ=Asia/Dhaka'); 

include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

include ("../includes/global_hack.php");
include ("../includes/myFunction.php");
include ("../jpgraph/src/jpgraph.php");
include ("../jpgraph/src/jpgraph_gantt.php");


// Add title and subtitle
$title=("Bangladesh Foundry and Engineering Works Ltd.");
//$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);

	

$sql=mysqli_query($db, " SELECT pname FROM project where pcode= '$gproject'") ;
 $row=mysqli_num_rows($sql);
 if($row){ $pn=mysqli_fetch_array($sql);
	  $projectName = "$pn[pname]";
  	  
	   }

$subTitme="Progress Report of ".$projectName.' Dated '.date('l jS F Y'); //hold title

 //$aDate,$aTitle, $aColor, $aWeight, $aStyle
 $todat = date("Y-m-d H:s"); //to day with time
 

include ("./graphFunction.php");
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$twoDate=project_duration($gproject);
$pDuration=date2dateRange($twoDate[0],$twoDate[1]);
	
	$j=0;
$sql1 = mysqli_query($db, "SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus != 'Not Ready'  and iowSdate>'0000-00-00' and iowCdate>'0000-00-00' ORDER by position ASC "); 
$allRow=mysqli_affected_rows($db);
while($rowiow = mysqli_fetch_array($sql1)){
$iowId=$rowiow[iowId];
$sql = mysqli_query($db, "SELECT * FROM iow WHERE iowId=$iowId"); 
$rowiow1 = mysqli_fetch_array($sql);
$iowDescription= str_replace(array("\r", "\n"), '', $rowiow1[iowDes]);
$iowName= $rowiow1[iowCode];
$iowSdate= $rowiow1[iowSdate];
$iowCdate= $rowiow1[iowCdate];
$iowSdate1= date('d-m-Y',strtotime($rowiow1[iowSdate]));
$iowCdate1= date('d-m-Y',strtotime($rowiow1[iowCdate]));
$iowDdate= round((strtotime($iowCdate)-strtotime($iowSdate))/86400)+1;
	


//$progress[$j]=iowActualProgress(date('Y-m-d',time()+86400),$iowId,0);
putenv ('TZ=Asia/Dacca'); 
$ed=date('Y-m-d');
//$ed=formatDate($edate,'Y-m-j');
	$progress[$j]=gp_iowActualProgress($rowiow1[iowId],$gproject,$ed,$$rowiow[iowQty],$rowiow[iowUnit],0);
// echo "<br>$rowiow[iowCode]==$rowiow1[iowId]**".$progress[$j];
//$progress[$j]=iowActualProgress('2006-02-25',$iowId,0);
//$progress[0]=10/100;

$complete =array ("0","80","20","0","0");
// iow informatins end
$data[$j] =  array($j,array($startconicon,"$iowName $iowDescription","$progress[$i]","$iowSdate1","$iowCdate1"), "$iowSdate","$iowCdate");
$sql = mysqli_query($db, "SELECT * FROM siow WHERE iowId='$rowiow[iowId]' ORDER by siowId ASC"); 
if($r==2){
$i=$j+1;
while($rowsiow = mysqli_fetch_array($sql)){
	$siowCode[$i] = $rowsiow[siowCode];
	$siowName[$i] = $rowsiow[siowName];
	$siowSdate[$i]= $rowsiow[siowSdate];
	$siowCdate[$i]= $rowsiow[siowCdate];

	//$progress[$i]=0;//siowActualProgress(date('Y-m-d',time()+86400),$rowsiow[siowId],0);
	$progress[$i]=gp_siowActualProgress($rowsiow[siowId],$gproject,$ed,$rowsiow[siowQty],$rowiow[siowUnit],0);

	//	echo "<br>--$siowCode[$i]=$rowsiow[siowId]==$progress[$i]";
	if($progress[$i]>100) $progress[$i]=100;
	$siowSdate1[$i]= date('d-m-Y',strtotime($rowsiow[siowSdate]));
	$siowCdate1[$i]= date('d-m-Y',strtotime($rowsiow[siowCdate]));

	$siowDdate[$i]= round((strtotime($siowCdate[$i])-strtotime($siowSdate[$i]))/86400)+1;

	$siowDdate[$i] = date('d-m-y',strtotime($siowDdate[$i]));
	$siowSdate1[$i] = date('d-m-y',strtotime($siowSdate1[$i]));
	$siowCdate1[$i] = date('d-m-y',strtotime($siowCdate1[$i]));
	$siowSdate[$i] = date('d-m-y',strtotime($siowSdate[$i]));
	$siowCdate[$i] = date('d-m-y',strtotime($siowCdate[$i]));

	$data[$i] =  array($i,array($endconicon,"    $siowCode[$i]. $siowName[$i]","$siowDdate[$i]","$siowSdate1[$i]","$siowCdate1[$i]"), "$siowSdate[$i]","$siowCdate[$i]");

	$i++;
	//echo $i.'<br>';
}
  }  
// Create the bars and add them to the gantt chart
$t=1;
for($i=$j; $i<count($data); ++$i,++$j) {

 
	
	$data_raw.=" ['". ($i+1) ."','".$data[$i][1][1]."',new Date(".jsDateExploder($data[$i][1][3])."),new Date(".jsDateExploder($data[$i][1][4])."),null,".$data[$i][1][2].",null ],
	";


	
$t=0;	
}

// Output the chart
}



?>












<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
	body,html{
		margin:0;
		padding:0;
	}	
</style>
</head>
<body>
		 <div align=center style="margin:10px 0; ">
			 <h3 style="margin: 0;
    padding: 0;">
				 <?php echo $title; ?>
			 </h3>
			 <h5 style="margin: 0;
    padding: 0;">
				 <?php echo $subTitme; ?>
			 </h5>
	</div>
     <div id="chart_div"></div> 
  
  
  <script type="text/javascript">
  
   google.charts.load('current', {'packages':['gantt']});
   google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task Code');
      data.addColumn('string', 'Description');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([

				
 				<?php echo $data_raw; ?>
				
      ]);

      var options = {
        width: <?php echo ($pDuration*.7)*11; ?>,
        height: <?php echo $allRow*21; ?>,
        gantt: {
          trackHeight: 20,
					barHeight:12,
					barCornerRadius:0,
					
					labelMaxWidth:800,
          labelStyle: {
            color: '#000'
          },
          innerGridTrack: {fill: '#fff'},
          innerGridDarkTrack: {fill: '#eee'}
        }
   
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

  </script>
</body>
</html>


