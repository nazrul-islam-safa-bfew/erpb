<?php
session_start();
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
include_once("../includes/myFunction.php"); // some general function
include_once("../includes/eqFunction.inc.php"); // some general function
include_once("../includes/empFunction.inc.php"); // some general function

// include('./project/siteMaterialReportEntry.f.php');
include('../project/siteDailyReport.f.php');
// include('./project/findProject.f.php');

ini_set("memory_limit","4000M");
ini_set("max_execution_time","9600000000");



class daily_iow_progress_counter{
  
  
  
  protected $db;
  public function __construct(){
    global $db;
    $this->db=$db;
  }
  public function daily_progress($iow,$p,$ed,$c=''){
    $approvedTotalAmount=iowApprovedCost($iow);

    $totalMaretialCost=totalMaretialCost($iow,$p,$ed,$c);
    $totalempCost=totalempCost($iow,$p,$ed,$c);
    $totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
    $totalSubconCost=totalSubconCost($iow,$p,$ed,$c);
    $totaleqCost=totaleqCost($iow,$p,$ed,$c);
    $actualTotalAmount=$totalMaretialCost+$totalempCost+$totalSubconCost+$totaleqCost;
//     return $progressp=($actualTotalAmount*100)/$approvedTotalAmount;       
    return $actualTotalAmount;
  }
  
 public function iow_progress($d,$id){
   $sql="SELECT * FROM `iow` WHERE iowId=$id and iowStatus!='noStatus'";
  //echo $sql;
   $sqlQuery=mysqli_query($this->db, $sql);
   $rr=mysqli_fetch_array($sqlQuery);
   $sd=$rr[iowSdate];
   $cd=$rr[iowCdate]; 
  if($sd<=$d){
     if($d<=$cd){
       $duration=round((strtotime($cd)-strtotime($sd))/(84000));
       $qty=$rr[iowQty];
       if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
       $perdayWork=$qty/$duration;
       $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
       $tillyesterdayWork=round($dayesGone*$perdayWork);
       $ptillyesterdayWorkP = round(($tillyesterdayWork*100)/$qty);   
       $amount_s=$rr["iowPrice"]/100;
       return $ptillyesterdayWorkP*$amount_s;
    }
    else
      return $rr["iowPrice"];
  }
    else
      return 0;
  }
  public function get_all_iow($project,$date){
    $sql="select * from iow where iowProjectCode='$project' and iowId not in (select iowId from daily_iow_progress where project='$project' and edate='$date')";
    $q=mysqli_query($this->db,$sql);
    while($row=mysqli_fetch_array($q)){
      $planned=$this->daily_progress($row["iowId"],$project,$date);
      $actual=$this->iow_progress($date,$row["iowId"]);
      $this->insert_data($row["iowId"], $planned, $actual, $date, $project);   
    }
  }
  public function insert_data($iow,$planned,$actual,$edate,$project){
    $sql="insert into daily_iow_progress (iow_id, actual_progress, planned_progress, edate,	project) values ('$iow','$actual','$planned','$edate','$project')";
    mysqli_query($this->db,$sql);    
  }
  public function date_range(){
    $sql="select * from project where pcode>=200 and status='0' order by pcode desc";
    $q=mysqli_query($this->db,$sql);
    while($row=mysqli_fetch_array($q)){
      $this->get_all_iow($row["pcode"],date("Y-m-d",strtotime(date("Y-m-d"))-86400));
    }
  }
}

$dipc=new daily_iow_progress_counter;
$dipc->date_range();
?>










