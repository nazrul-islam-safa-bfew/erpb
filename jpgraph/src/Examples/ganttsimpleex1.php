<?php // content="text/plain; charset=utf-8"
// Gantt example
require_once ('../jpgraph.php');
require_once ('../jpgraph_gantt.php');

// 
// The data for the graphs
//
$data = array(
  array(0,ACTYPE_GROUP,    "Phase 1",        "2001-10-26","2001-11-23",''),
  array(1,ACTYPE_NORMAL,   "  Label 2",      "2001-10-26","2001-11-13",'[KJ]'),
  array(2,ACTYPE_NORMAL,   "  Label 3",      "2001-11-20","2001-11-22",'[EP]'),
  array(3,ACTYPE_MILESTONE,"  Phase 1 Done", "2002-11-23",'M2') );

$data2=array(
  array(4,ACTYPE_GROUP,"Main head",'2001-10-26','2001-12-26',20)
);

// Create the basic graph
$graph = new GanttGraph();
$graph->title->Set("Gantt Graph using CreateSimple()");

// Setup scale
$graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH );
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);

// Add the specified activities
$graph->CreateSimple($data);
$graph->CreateSimple($data2);

// .. and stroke the graph
$graph->Stroke();

?>


