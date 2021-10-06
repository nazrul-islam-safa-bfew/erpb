<?php
ini_set('memory_limit', '46309M' );
//set_time_limit(2000000000000000);
//==========================================================================================================================
//==========================================================================================================================
//==========================================================================================================================
//==========================================================================================================================
//==============================?><?php //error_reporting(0);
//==========================================================================================================================
//==========================================================================================================================
//==========================================================================================================================

putenv ('TZ=Asia/Dhaka'); 
$localPath = $_SERVER["DOCUMENT_ROOT"]."/erpb";

include($localPath."/includes/config.inc.php");


include ($localPath."/includes/global_hack.php");
include ($localPath."/jpgraph/src/jpgraph.php");
include ($localPath."/jpgraph/src/jpgraph_gantt.php");

// Basic Gantt graph
$graph = new GanttGraph(0,0,"auto");
$graph->SetBox();
$graph->SetShadow();
// $graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);
/* iow informatins*/

// debuging mode
// $gproject="206";

// end of debuging mode


// Add title and subtitle
$graph->title->Set("Bangladesh Foundry and Engineering Works Ltd.");
//$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);

	

$sql=mysqli_query($db, " SELECT pname FROM project where pcode= '$gproject'") ;
 $row=mysqli_num_rows($sql);
 if($row){ $pn=mysqli_fetch_array($sql);
	  $projectName = "$pn[pname]";
  	  
}

$subTitme="Progress Report of ".$projectName.' Dated '.date('l jS F Y');
$graph->subtitle->Set($subTitme);

// 1.5 line spacing to make more room
$graph->SetVMarginFactor(1.5);

// Setup some nonstandard colors
$graph->SetMarginColor('lightgreen@0.8');
$graph->SetBox(true,'yellow:0.6',2);
$graph->SetFrame(true,'darkgreen',4);
$graph->scale->divider->SetColor('yellow:0.6');
$graph->scale->dividerh->SetColor('yellow:0.6');
// $graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK| GANTT_HMONTH);
switch($_GET[dateType]){
	case "d":
		$graph->ShowHeaders(GANTT_HMONTH | GANTT_HDAY | GANTT_HWEEK);
		break;
	case "w":
		$graph->ShowHeaders(GANTT_HMONTH | GANTT_HWEEK);
		break;
	case "m":
		$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH);
		$timeScale="m";
		break;
	default:
		$graph->ShowHeaders(GANTT_HMONTH | GANTT_HDAY | GANTT_HWEEK);
}
if($timeScale!="m")
	$graph->scale-> month-> SetStyle( MONTHSTYLE_SHORTNAMEYEAR2); 
	

// $graph->scale-> week->SetStyle(WEEKSTYLE_FIRSTDAY); 
$graph->scale->month->grid->SetColor('gray');
$graph->scale->month->grid->Show(true);
$graph->scale->year->grid->SetColor('gray');
$graph->scale->year->grid->Show(true);

// 0 % vertical label margin
$graph->SetLabelVMarginFactor(1);

 //$aDate,$aTitle, $aColor, $aWeight, $aStyle
 $todat = date("Y-m-d H:s");
 
$vline = new GanttVLine ("$todat","today", "red");
$graph->Add( $vline); 

// Display month and year scale with the gridlines

// For the titles we also add a minimum width of 100 pixels for the Task name column
$graph->scale->actinfo->SetColTitles(
    array('','Task','Duration','Status','Start','Finish'),array(30,100));
$graph->scale->actinfo->SetBackgroundColor('green:0.5@0.5');
//$graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
$graph->scale->actinfo->vgrid->SetStyle('solid');
$graph->scale->actinfo->vgrid->SetColor('gray');
// Uncomment this to keep the columns but show no headers
//$graph->scale->actinfo->Show(false);

// Setup the icons we want to use
$erricon = new IconImage(GICON_FOLDER,0.6);
$startconicon = new IconImage(GICON_FOLDEROPEN,0.6);
$endconicon = new IconImage(GICON_ENDCONS  ,0.5);
include($localPath."/graph/graphFunction.php");


	
$j=0;
// echo "SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus not in ('Not Ready') ORDER by position ASC/* LIMIT $start , 15 */";

if($_GET['taskType']=="Started")
	$extraSql=" and iowSdate<='$todat' and iowStatus!='Completed' ";
if($_GET['taskType']=="completed")
	$extraSql=" and `iowStatus` LIKE 'Completed' ";
if($_GET['taskType']=="Not-Started")
	$extraSql=" and iowSdate>'$todat' ";

// Maintenance	
$extraC="";
$iowType=" and iowType=1 ";
		if($gproject=="004" && $_GET["maintenance"]==1){
			$extraC=" and position like '888.%' ";
			$iowType=" ";
		}elseif($gproject=="004" && $_GET["maintenance"]==0){
			$extraC=" and position not like '888.%' ";
		}
//End of maintenance

$sql1 = mysqli_query($db, "SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus not in ('Not Ready') $iowType and position!='999.000.000.000' $extraSql $extraC ORDER by position ASC /* LIMIT $start , 25*/ ");

// echo "SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus not in ('Not Ready') $iowType and position!='999.000.000.000' $extraSql $extraC ORDER by position ASC/* LIMIT $start , 25*/ ";

while($rowiow = mysqli_fetch_array($sql1)){
$iowId=$rowiow[iowId];
$sql = mysqli_query($db, "SELECT * FROM iow WHERE iowId=$iowId"); 
$rowiow1 = mysqli_fetch_array($sql);
$iowDescription= $rowiow1[iowDes];
$iowName= $rowiow1[iowCode];
	
if($rowiow1[iowStatus]=="noStatus"){
// 	print_r($rowiow1);
	$headDate=head_duration($gproject,$rowiow1[position]);
// 	print_r($headDate);
// 	echo "<br>";
	$rowiow1[iowSdate]=$headDate[start];
	$rowiow1[iowCdate]=$headDate[finish];
	$iowName="";
	if(!$rowiow1[iowSdate] || !$rowiow1[iowCdate])continue;
}

	$position=count_dot_number($rowiow1[position]);
	$positionVal=md_IOW_headerFormat($position);
	$iowName=$positionVal." ".$iowName;

	$iowSdate= $rowiow1[iowSdate];
	$iowCdate= $rowiow1[iowCdate];
	
// 	debuging
// 	echo $iowId."==".$iowSdate.">>".$iowCdate."<br>";
// 	end of debuging
	
$iowSdate1= date('d-m-Y',strtotime($rowiow1[iowSdate]));
$iowCdate1= date('d-m-Y',strtotime($rowiow1[iowCdate]));
$iowDdate= round((strtotime($iowCdate)-strtotime($iowSdate))/86400)+1;

//$progress[$j]=iowActualProgress(date('Y-m-d',time()+86400),$iowId,0);
putenv ('TZ=Asia/Dacca'); 
$ed=date('Y-m-d');
//$ed=formatDate($edate,'Y-m-j');
$progress[$j]=gp_iowActualProgress($rowiow1[iowId],$gproject,$ed,$rowiow[iowQty],$rowiow[iowUnit],0);
// echo "<br>$rowiow[iowCode]==$rowiow1[iowId]**".$progress[$j];
//$progress[$j]=iowActualProgress('2006-02-25',$iowId,0);
//$progress[0]=10/100;

$complete =array ("0","80","20","0","0");
// iow informatins end
if($rowiow1[iowStatus]=="noStatus")$selectIcon=$startconicon;
else $selectIcon=$endconicon;
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
	if(!$progress[$i])$progress[$i]=0;
$data[$j] =  array($j,array($selectIcon,"$iowName $iowDescription","$iowDdate","$progress[$i]%","$iowSdate1","$iowCdate1"), "$iowSdate","$iowCdate");  
// Create the bars and add them to the gantt chart
$t=1;
for($i=$j; $i<count($data); ++$i,++$j) {
	$headData=null;
	$bar=null;
		if($rowiow1[iowStatus]=="noStatus"){
			if($position==1){ //main head
				$headData=array(
  				array($data[$i][0],ACTYPE_GROUP,$data[$i][1],$data[$i][2],$data[$i][3],"[$progress[$i]%]")
				);				
				$graph->CreateSimple($headData);
			}elseif($position==2){ //sub head
    		$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],"[$progress[$i]%]",10);
				$bar->SetPattern(GANTT_HLINE,"red"); //sub head pattern				
			}elseif($position==3){ //sub sub head
    		$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],"[$progress[$i]%]",10);
				$bar->SetPattern(GANTT_DIAGCROSS,"blue"); //sub sub head pattern				
			} //if sub sub head
		} //if noStatus
		else {			
    	$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],"[$progress[$i]%]",10);
			$bar->SetPattern(BAND_RDIAG,"white");			
		if( count($data[$i])>4 )$bar->title->SetFont($data[$i][4],$data[$i][5],$data[$i][6]);
    if($t)$bar->SetPattern(BAND_RDIAG,"yellow");
		}
	if($bar){
			$bar->SetFillColor("gray");
			$bar->progress->Set($progress[$i]/100);
    
	if($t)$bar->progress->SetPattern(GANTT_SOLID,"darkgreen");
	 else $bar->progress->SetPattern(GANTT_SOLID,"blue");
	
    $bar->title->SetCSIMTarget(array('#1'.$i,'#2'.$i,'#3'.$i,'#4'.$i,'#5'.$i),array('11'.$i,'22'.$i,'33'.$i));
    $graph->Add($bar);
	}
	//echo '--'.$j.'<br>';
$t=0;	
}

// Output the chart
}

$graph->Stroke();

?>


