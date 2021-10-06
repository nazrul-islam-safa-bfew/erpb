<?php /**/  ");}?><?php include ("../jpgraph/src/jpgraph.php");
include ("../jpgraph/src/jpgraph_gantt.php");

// Basic Gantt graph
$graph = new GanttGraph(0,0,"auto");
$graph->SetBox();
$graph->SetShadow();
/* iow informatins*/


// Add title and subtitle
$graph->title->Set("Bangladesh Foundry and Engineering Works Ltd.");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);

include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sql=mysql_query(" SELECT pname FROM project where pcode= '$gproject'") ;
 $row=mysql_num_rows($sql);
 if($row){ $pn=mysql_fetch_array($sql);
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
$graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK| GANTT_HMONTH);

$graph->scale-> month-> SetStyle( MONTHSTYLE_SHORTNAMEYEAR2); 

$graph->scale-> week->SetStyle(WEEKSTYLE_FIRSTDAY); 
$graph->scale->month->grid->SetColor('gray');
$graph->scale->month->grid->Show(true);
$graph->scale->year->grid->SetColor('gray');
$graph->scale->year->grid->Show(true);

// 0 % vertical label margin
$graph->SetLabelVMarginFactor(1);


 //$aDate,$aTitle, $aColor, $aWeight, $aStyle
 
$vline = new GanttVLine ("$todat","today", "red");
$graph->Add( $vline); 

// Display month and year scale with the gridlines

// For the titles we also add a minimum width of 100 pixels for the Task name column
$graph->scale->actinfo->SetColTitles(
    array('','Task','Duration','Start','Finish'),array(30,100));
$graph->scale->actinfo->SetBackgroundColor('green:0.5@0.5');
$graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
$graph->scale->actinfo->vgrid->SetStyle('solid');
$graph->scale->actinfo->vgrid->SetColor('gray');

// Uncomment this to keep the columns but show no headers
//$graph->scale->actinfo->Show(false);

// Setup the icons we want to use
$erricon = new IconImage(GICON_FOLDER,0.6);
$startconicon = new IconImage(GICON_FOLDEROPEN,0.6);
$endconicon = new IconImage(GICON_ENDCONS  ,0.5);
include ("./graphFunction.php");
include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	$j=0;
$sql1 = mysql_query("SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus != 'Not Ready' ORDER by iowId ASC LIMIT 0 , 40 "); 
while($rowiow = mysql_fetch_array($sql1)){
$iowId=$rowiow[iowId];
$sql = mysql_query("SELECT * FROM iow WHERE iowId=$iowId"); 
$rowiow1 = mysql_fetch_array($sql);
$iowDescription= $rowiow1[iowDes];
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
/* iow informatins end */
$data[$j] =  array($j,array($startconicon,"$iowName $iowDescription","$iowDdate","$iowSdate1","$iowCdate1"), "$iowSdate","$iowCdate",FF_ARIAL,FS_BOLD,10);
$sql = mysql_query("SELECT * FROM siow WHERE iowId='$rowiow[iowId]' ORDER by siowId ASC"); 
if($r==2){
$i=$j+1;
while($rowsiow = mysql_fetch_array($sql)){
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

$data[$i] =  array($i,array($endconicon,"    $siowCode[$i]. $siowName[$i]","$siowDdate[$i]","$siowSdate1[$i]","$siowCdate1[$i]"), "$siowSdate[$i]","$siowCdate[$i]",FF_ARIAL,FS_NORMAL,8);

$i++;
//echo $i.'<br>';
}
  }  
// Create the bars and add them to the gantt chart
$t=1;
for($i=$j; $i<count($data); ++$i,++$j) {
    $bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],"[$progress[$i]%]",10);
    if( count($data[$i])>4 )
        $bar->title->SetFont($data[$i][4],$data[$i][5],$data[$i][6]);
    if($t)$bar->SetPattern(BAND_RDIAG,"yellow");
	else 	$bar->SetPattern(BAND_RDIAG,"white");
    $bar->SetFillColor("gray");
    $bar->progress->Set($progress[$i]/100);
    
	if($t)$bar->progress->SetPattern(GANTT_SOLID,"darkgreen");
	 else $bar->progress->SetPattern(GANTT_SOLID,"blue");
	
    $bar->title->SetCSIMTarget(array('#1'.$i,'#2'.$i,'#3'.$i,'#4'.$i,'#5'.$i),array('11'.$i,'22'.$i,'33'.$i));
    $graph->Add($bar);
	//echo '--'.$j.'<br>';
$t=0;	
}

// Output the chart
}
$graph->Stroke();

?>


