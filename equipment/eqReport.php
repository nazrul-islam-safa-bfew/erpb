<?php
include("../includes/config.inc.php");
$db=mysqli_connect($SESS_DBHOST,$SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
include("../includes/myFunction.php");
include("../includes/eqFunction.inc.php");
$todat=todat();
$todatFormated=date("d/m/Y",strtotime($todat));
$days=$month*30;
$formdatFormated=date("d/m/Y",strtotime(getXdaysAgo($days)));
?>
<link href="http://win4win.biz/erp/bfew/style/indexstyle.css"  rel="stylesheet" type="text/css">
<table align="center">
  <tr>
  <td align="center">
    <?php
      echo "<p>$itemCode$assetID: ";
      $itemDes=itemDes($itemCode);
      if($itemDes)echo $itemDes[des];
    $sql="select teqSpec from equipment where itemcode='$itemCode' and assetId='$assetID'";
    $q=mysqli_query($db,$sql);
    $eq_row__=mysqli_fetch_array($q);
    $eq_row_arr=explode("_",$eq_row__["teqSpec"]);
    echo "<br>";
    echo implode(", ",$eq_row_arr);
      echo "</p>";
    echo "<p>Equipment consumption report between $formdatFormated to $todatFormated</p>";
    ?>
  </td>
  </tr>
</table>
<table align="center" width="98%" border="3" bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tbody>
  <tr bgcolor="#CC9999"> 
    <td align="left">
      Date
    </td> 
   <td align="center" >
     Usage
   </td>
   <td align="right" >
     Fuel
   </td>
  </tr>
  <?php
  $i=0;
 while($days>$i++){
  $amount=0;
  $xDaysAgo=getXdaysAgo($i);
  ?>   
  <tr>
    <td align="left"><?php echo date("d/m/Y",strtotime($xDaysAgo)); ?></td>   
    <td align="center">
  <?php
//    From utilization
   $eq_sql="select issueDate,km_h_qty,issuedQty,issueRate,unit,itemCode from issue$pcode where eqID='$assetID"."_"."$itemCode' and issueDate='$xDaysAgo' order by km_h_qty desc";
//   echo $eq_sql;
  $eq_q=mysqli_query($db,$eq_sql);   
  while($eq_row=mysqli_fetch_array($eq_q)){
    if($eq_row["unit"]=="ue")$eq_row["km_h_qty"]=getUsageofEQ($itemCode,$assetID,$xDaysAgo); //erp hr
$measureUnit=$eq_row["unit"]=="ue" ? "Hour " : "";
    



    
if($eq_row["km_h_qty"]>0)                       
    if($eq_row["unit"]!="km" && $eq_row["unit"]!="ue")
     $eq_row["km_h_qty"]=sec2hms(round($eq_row["km_h_qty"],2));
    elseif($eq_row["unit"]=="km")
     $eq_row["km_h_qty"]=round($eq_row["km_h_qty"],2);        
    
    
    if(strpos($eq_row["km_h_qty"],":")>-1){
      $exp=explode(":",$eq_row["km_h_qty"]);
      $current_cons=$exp[0].".".(60/$exp[1]);
    }
    
    if($eq_row["km_h_qty"])$rowA[]="<font color='#00f'>".number_format($current_cons,2)."</font> ".$measureUnit.measuerUnti()[$eq_row["unit"]];

    $itemDesC=itemDes($eq_row[itemCode]);
    $fuelA[]="<b>".$itemDesC[des]."</b>: <font color='#00f'>".number_format($eq_row["issuedQty"],2)."</font> Ltr";  
//     $amount+=$eq_row["issueRate"] * $eq_row["issuedQty"];
  }
//  End of utilization
//  Accounts payment start
   $eqacc_sql="select edate,km,qty,amount,uItemCode from accEqConsumption where eqID='$assetID' and eqItemCode='$itemCode' and edate='$xDaysAgo' order by km desc";
//    echo $eqacc_sql;
  $eqacc_q=mysqli_query($db,$eqacc_sql);  
   $amount=0; 
  while($eqacc_row=mysqli_fetch_array($eqacc_q)){
    if($eqacc_row["km"])$rowA[]="<font color='#00f'>".number_format($eqacc_row["km"],2)."</font> ".measuerUnti()[getEqLocalUnit($itemCode)];
    $itemDesC=itemDes($eqacc_row[uItemCode]);
    $fuelA[]="<b>".$itemDesC[des]."</b>: <font color='#00f'>".number_format($eqacc_row["qty"],2)."</font> Ltr; Tk. ".number_format($eqacc_row["amount"],2);
  }
   
   
if($rowA){
  echo implode("<br> ",$rowA);
  unset($rowA);
}
  ?></td>
    <td align="right">
    <?php  
if($fuelA){
  echo implode("<br> ",$fuelA);
  
//   if(count($fuelA)>1)      echo ";<font color='#00f'> Tk. ".number_format($tk,2)."</font>";
  
  unset($fuelA);
}
    ?></td>
  </tr>
  <?php }
  ?>
  

</tbody>
</table>