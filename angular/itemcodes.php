<?php
header('Content-Type: text/html; charset=ISO-8859-1');
$folder="../includes/";
include($folder."config.inc.php");
$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include($folder."myFunction.php");
$sql="select * from itemlist order by itemcode asc";
$q=mysqli_query($db,$sql);
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<body>

<div ng-app="all_item_code">
 <div class="container-fluid">
  <div class="row">
    <div class="col-12 text-center">
      <h1>
        <input type="text" class="form-control" ng-model='codefilter' placeholder="Search">
      </h1>
    </div>
   </div>
  <div class="row">
    <div class="col-12">
      <table class="table table-striped" ng-controller="table_controller">
        <thead>
          <tr>
            <th scope="col" width='200'>Itemcode</th>
            <th scope="col">Descriptoin</th>
            <th scope="col">Specification</th>
            <th scope="col">Unit</th>
          </tr>
        </thead> 
        <tbody>
          <tr ng-repeat='row in rows | filter:codefilter'>
            <td><small>{{row.itemCode}}</small></td>
            <td><small>{{row.itemDes}}</small></td>
            <td><small>{{row.itemSpec}}</small></td>
            <td><small>{{row.itemUnit}}</small></td>
          </tr>
        </tbody>      
      </table>
    </div>
   </div>
 </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  
<script>  
var item_app=angular.module("all_item_code",[]);
item_app.controller("table_controller",function($scope){
  $scope.rows=[<?php    
while($row=mysqli_fetch_array($q)){
  echo "{'itemCode':'".addslashes($row[itemCode])."', 'itemDes':'".str_replace(array("\r\n", "\n", "\r"), ' ', addslashes($row[itemDes]))."', 'itemUnit':'".addslashes($row[itemUnit])."', 'itemSpec':'".addslashes($row[itemSpec])."'}, ";
}
?>];
});
</script>
</body>
</html>
