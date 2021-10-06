<?php
class project{
  public $sql;
  public $project_rows;
  public function __construct(){
    global $db;
    $sql="select pcode,pname from project where `status`='0'";
    $q=mysqli_query($db,$sql);
    while($this->project_rows[]=mysqli_fetch_array($q)){}
  }
  public function store_inventory($pcode){
    global $db;
    //$sql="SELECT DISTINCT itemCode FROM store$pcode WHERE 1 AND currentQty <> 0 ";	
    $sql="SELECT DISTINCT itemCode FROM store$pcode WHERE itemCode between '01-01-001' and '35-99-999' ";
    $TI=0;
    $sqlquery=mysqli_query($db, $sql);
    while($sqlresult=mysqli_fetch_array($sqlquery))
    {	
      $toDate=date("Y-m-d");
      $amount=mat_stock_rate($pcode,$sqlresult[itemCode],$toDate);
      $TI+=$amount;    //TI = total inventory
    }
    return $TI;
  }
  public function cash_amount($pcode){
    global $db;
    $sql3="select * from `accounts` ORDER by accountID ASC";
    $fromDate="2014-01-01";
    $toDate=date("Y-m-d");
    $sqlq=mysqli_query($db, $sql3);
    while($re=mysqli_fetch_array($sqlq)){
      if($re[accountID]=='5502000'){
        $baseOpening=baseOpening('5502000',$pcode);
        $openingBalance=$baseOpening+openingBalance('5502000',$fromDate,$pcode);
        $balanceSideCash1=cashonHand($pcode,$fromDate,$toDate,'2');
        $balanceSideCash=$openingBalance+$balanceSideCash1;
      }
    }
    return $balanceSideCash;
  }
  
  public function digit_fixed($amount){
    return number_format($amount,2);
  }
}
?>
<style>
  .project_table{}
  .project_table tr:nth-child(odd){background:#ededed;}
  .project_table tr{}
</style>
<br><br>
<table align="center" class="dblue project_table" width="98%">
 <tr>
   <td align="right" bgcolor="#0066FF" colspan="6"><font class="englishhead">Closing Cash &amp; Inventory</font></td>
 </tr>
  <tr>
     <th width="350">Project</th>
     <th align="center">Store Inventory</th>
     <th align="center">Site Cash</th>
   </tr>
  <?php
    $p=new project;
    foreach($p->project_rows as $project){
      if(!$project["pcode"])continue;
      echo "<tr><td>";
      echo $project["pcode"]." ".$project["pname"];
      echo "</td><td align='right'>";
      echo $p->digit_fixed($p->store_inventory($project["pcode"]));
      echo "</td><td align='right'>";
      echo $p->digit_fixed($p->cash_amount($project["pcode"]));      
      echo "</td></tr>";
    }
  ?>
</table>