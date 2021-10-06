<?php
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);
$itemcode=$_GET["itemcode"];
$pcode=$_GET["pcode"];

$st_sql="select sum(receiveQty*rate)/sum(receiveQty) as avg_rate,itemCode from store$pcode  where itemCode='$itemcode' group by itemCode";
$st_q=mysqli_query($db,$st_sql);
while($st_row=mysqli_fetch_array($st_q)){
//   issue
  $is_sql="select * from issue$pcode where itemCode='$st_row[itemCode]' /*and reference='$st_row[reference]'*/ and issueRate!='$st_row[avg_rate]'";
  $is_q=mysqli_query($db,$is_sql);
  
  if(mysqli_affected_rows($db)<1)continue;
  echo "$st_row[itemCode] = > $st_row[avg_rate]<br>";
  
//   issue
  while($is_row=mysqli_fetch_array($is_q)){
    echo "====> $is_row[issueRate] > $is_row[issuedQty] <br>";
    
    $update_sql="update issue$pcode set issueRate='$st_row[avg_rate]' where issueSL='$is_row[issueSL]' /*and reference='$st_row[reference]'*/ and itemCode='$st_row[itemCode]'";
//     echo $update_sql."<br>";
    mysqli_query($db,$update_sql);
    
    $previousTotal+=$is_row[issueRate]*$is_row[issuedQty];
    $total+=$is_row[issuedQty]*$st_row[rate];
  }
  
    echo "====>=======> Previous Total $is_row[itemCode] $previousTotal <br>";
    echo "====>=======> Total $is_row[itemCode] $total <br>";
  
  
}
?>