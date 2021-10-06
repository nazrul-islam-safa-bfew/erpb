<?php
if($eqitemCode){
  $Fsql="select * from  eqconsumsiontemp where eqitemCode='$eqitemCode'";
  mysqli_query($db,$Fsql);
  
  if(mysqli_affected_rows($db)>0){
    
    if($action=="approved"){
      $Dsql="delete from  eqconsumsion where eqitemCode='$eqitemCode'";
      $Dq=mysqli_query($db,$Dsql);
      usleep(1000);  

      $Asql="insert into eqconsumsion (select * from eqconsumsiontemp where eqitemCode='$eqitemCode')";
      $Aq=mysqli_query($db,$Asql);
    }

      usleep(2000);
      $Dsql="delete from  eqconsumsiontemp where eqitemCode='$eqitemCode'";
      $Dq=mysqli_query($db,$Dsql);
    
  }
  
}
?>
<link href="http://win4win.biz/erp/bfew/style/indexstyle.css"  rel="stylesheet" type="text/css">
<table align="center">
  <tr>
  <td align="center">
Equipment Fuel Consumption Approval
  </td>
  </tr>
</table>
<table align="center" width="98%" border="3" bordercolor="CC9999" cellpadding="2" cellspacing="0" style="border-collapse:collapse">
<tbody>
  <tr bgcolor="#CC9999"> 
    <td align="left">
      Equipment
    </td> 
   <td align="center" >
     Fuel/Oil/Lubricant
   </td>
   <td align="right" >
    Action
   </td>
  </tr>
  
  
  <?php
  $sql="select * from eqconsumsiontemp group by eqitemCode order by eqitemCode";
  $q=mysqli_query($db,$sql);
  while($eqRow=mysqli_fetch_array($q)){
    $itemDes=itemDes($eqRow[eqitemCode]);
    echo "<tr>
      <td>
        $eqRow[eqitemCode]; $itemDes[des];
      </td><td>"; 
    $conSql="select * from eqconsumsiontemp where eqitemCode='$eqRow[eqitemCode]'";
    $conQ=mysqli_query($db,$conSql);
    while($conRow=mysqli_fetch_array($conQ)){
      $conDes=itemDes($conRow[uitemCode]);
     echo "$conRow[uitemCode]: $conDes[des]; $conRow[consumption] $conRow[measureUnit]/$conRow[consumptionUnit] <br>";
    }
echo "
      </td>
      <td align=center><a href='./index.php?keyword=itemcode+approval&eqitemCode=$eqRow[eqitemCode]&action=approved'>Approved</a> / <a href='./index.php?keyword=itemcode+approval&eqitemCode=$eqRow[eqitemCode]&action=BfR'>BfR</a></td>
    </tr>";
  }
  ?>
  

</tbody>
</table>