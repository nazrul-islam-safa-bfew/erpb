<?php 
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db=mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
$posl=$_GET[posl];

$chkSql="select * from po_revision where acceptDate='' and posl='$posl'";
mysqli_query($db,$chkSql);
if(mysqli_affected_rows($db)>0){
  echo "<center><h1>PO revision already in progress.</h1></center>";
  exit;
}

$todat=todat();
if($_POST[reasonBtn]){
  $totalNoOfRows=$_POST["n"];
  for($i=0;$i<=$totalNoOfRows;$i++){
    if(!$_POST["po".$i])continue;
    $thePoArray=explode(":",$_POST["po".$i]);

    $dp=explode("/",$_POST["datepicker".$i]);    
    $datepicker=$dp[2]."-".$dp[1]."-".$dp[0];

    $reason_for_revision_txt=$_POST['reason_for_revision_txt'];
    $revisoinNoQ=mysqli_query($db,"select revisionNo from po_revision where posl='$thePoArray[0]' and itemCode='$thePoArray[1]'");
    $revisoinNoR=mysqli_fetch_array($revisoinNoQ);
    $revisoinNo=$revisoinNoR["revisionNo"]+1;
    $uSQL="insert into po_revision (posl,itemCode,sdate,revisionText,revisionNo,revisionStatus,revisionDate) values
  ('$thePoArray[0]','$thePoArray[1]','$datepicker','$reason_for_revision_txt','$revisoinNo','Waiting for approval','$todat')";
    mysqli_query($db,$uSQL);
  }
    if(mysqli_affected_rows($db)>0)echo "<center><h3>Your request has been submited.</h2></center>";
}
?>
<!DOCTYPE HTML>
<html>
 <head>
    <title></title>  
    <link href="../style/bootstrap.min.css" rel="stylesheet">  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script src="../js/bootstrap.min.js"></script>
 </head>
  <body>
 <form action="" method="post">
    <div class="container" ng-app="poApp" ng-controller="poController" ng-init="j=0">
      <div class="row">
        <div class="col-xs-12">    
          <div class="panel panel-default">
            <div class="panel-heading">
              PO Revision <small><i>{{poname}}</i></small>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-12">
                  <table class="table table-striped">
                    <tr>
                      <th>ItemCode</th>
                      <th>Description</th>
                      <th>Qty</th>
                      <th>Date</th>
                      <th>Last Present</th>
                      <th>New Date</th>
                    </tr>
                    <tr ng-repeat="row in Description">
                      <td>{{row[0]}}</td>
                      <td>{{row[1]}}</td>
                      <td>{{row[2]}}</td>
                      <td>{{row[3]}}</td>
                      <td>{{row[3]}}</td>
                      <td>
                        <input type="text" name="datepicker{{$index}}" value="{{row[3]}}" id="datepicker{{$index}}">
                        <input type="hidden" name="po{{$index}}" value="{{poname + ':' + row[0] + ':'}}">
                        
                      </td>
                    </tr>
                  </table>                  
                </div>
              </div>               
      <div class="row">
        <div class="col-xs-12">
          <label for="reason_for_revision_txt">
            Reason of Revision:
          </label>
          <textarea name="reason_for_revision_txt" required class="form-control"></textarea>
        </div>        
      </div>               
      <div class="row">
        <div class="col-xs-1">
          <input type="submit" name="reasonBtn" value="Submit" class="btn btn-default">
        </div>
      </div>              
            </div>
          </div>          
<?php
    
?>
        </div>
      </div> 
   <input type="hidden" name="n" value="{{n-1}}">
    </div>
</form>
  </body>
  <style>
  
  </style>
  <?php
  $poSql="select location,activeDate from porder where posl='$posl'";
//   echo $poSql;
  $poQ=mysqli_query($db,$poSql);
  $poRow=mysqli_fetch_array($poQ);
  
  
  $poSql="select * from poschedule p where posl='$posl'";
  $q=mysqli_query($db,$poSql);
  ?>  
  <script>
    var app=angular.module("poApp",[]);
    app.controller("poController",function($scope){
    $scope.poname="<?php echo $posl; ?>";
    

<?php      
  while($row=mysqli_fetch_array($q)){
    $pcode=explode("_",$posl)[1];
    $attendanceLastDate=getEQlastAttendance($posl,$row[itemCode],$poRow[location]);
    if(!$attendanceLastDate)$attendanceLastDate=$poRow[activeDate];
    $itemDes=itemDes($row[itemCode]);    
    $theArray[]="['$row[itemCode]','$itemDes[des]','$row[qty]','".date("d/m/Y",strtotime($row[sdate]))."']";
  }
  echo '$scope'.".Description=[".implode(",",$theArray)."];";
  echo '$scope'.".n=".count($theArray) ;
?>      

});
    
  $(function(){
    var i=-1;
    while(i++<<?php echo count($theArray) ? count($theArray) : 0; ?>)
      $("#datepicker"+i).datepicker({
        <?php echo $attendanceLastDate ? "minDate: ".date_diff(date_create(todat()),date_create($attendanceLastDate))->format("%R%a")."," : ""; ?>
        dateFormat: 'dd/mm/yy' });
  });
  </script>
</html>
