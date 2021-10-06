<? 
if($go){
// Gantt example
include ("../includes/session.inc.php");
include ("../jpgraph/src/jpgraph.php");
include ("../jpgraph/src/jpgraph_gantt.php");

$graph = new GanttGraph(0,0,"auto");
$graph->SetBox();
$graph->SetShadow();

// Add title and subtitle
$graph->title->Set("IOW Progress Report");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
//$graph->subtitle->Set("(with SIOW Progress)");

// Setup some nonstandard colors
$graph->SetMarginColor('lightgreen@0.8');
$graph->SetBox(true,'yellow:0.6',2);
$graph->SetFrame(true,'darkgreen',4);
$graph->scale->divider->SetColor('yellow:0.6');
$graph->scale->dividerh->SetColor('yellow:0.6');

// Show day, week and month scale
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

/*$db = mysql_connect("localhost", "root","12345678") or die(mysql_error()); 
mysql_select_db("bfewdb",$db) or die(mysql_error()); 
//$sql = mysql_query("SELECT * FROM iow WHERE iowId=$iow"); 
*/
include("../includes/config.inc.php");

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sql1 = mysql_query("SELECT * FROM iow WHERE iowProjectCode='$gproject' AND iowStatus = 'Not Ready' LIMIT 0, 3"); 
$j=0;
while($rowiow = mysql_fetch_array($sql1)){

//echo $rowiow[iowCode];

$iowName= $rowiow[iowCode];
$iowSdate= $rowiow[iowSdate];
$iowCdate= $rowiow[iowCdate];
$complete =array ("0","80","20","0","0");

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity = new GanttBar($j,"$iowName","$iowSdate","$iowCdate","[10%]");

// Yellow diagonal line pattern on a red background
$activity->SetPattern(BAND_RDIAG,"yellow");
//$activity->SetFillColor("yellow:0.6");

// Set absolute height
$activity->SetHeight(10);

// Specify progress to 60%
$activity->progress->Set(0.1);
$activity->progress->SetPattern(BAND_HVCROSS,"blue");
$graph->Add($activity);
$j++;
}
/*-------------------------*/

/*--------------------------*/

// ... and display it

?>
<? $graph->Stroke();

}?>


