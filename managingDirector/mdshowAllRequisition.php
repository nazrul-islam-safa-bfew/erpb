<?

if($approval==1){
 echo "Show All Requisition  for Approval>> Managing Directort<br><br>";
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
// $sqlshow="SELECT * from `purchaseReq` where `projectCode` like '$loginProject' ";
$sqlshow="SELECT * from `purchaseReq` WHERE approvalStatus IN ('Approved by PM', 'Approved by Mngr. P&C', 'Approved by MD')";
 $sqlshowrun=mysqli_query($db, $sqlshow);
}

else if($approval==''){
echo "Show All Purchase Requisition >> Managing Directort<br><br>";
include("./managingDirector/search.php");

?>

<?

include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
// $sqlshow="SELECT * from `purchaseReq` where `projectCode` like '$loginProject' ";
$sqlshow="SELECT * from `purchaseReq` WHERE 1";
if($cat1 OR $cat2 OR $cat3 OR $cat4 OR $cat5 OR $cat6 OR $cat7 OR $cat8 OR $cat9 OR $cat10){
$sqlshow.=" AND approvalStatus IN ( ";

if($cat2){$sqlshow.="$coma '$cat2'";  $coma=""; }

if($cat2 AND $cat3 ) $coma=" ,";
if($cat3){$sqlshow.="$coma '$cat3'";  $coma=""; }

if($cat2 OR $cat3 ) $coma=" ,";
if($cat4){$sqlshow.="$coma '$cat4'";  $coma=""; }

if($cat2 OR $cat3 OR $cat4 ) $coma=" ,";
if($cat5){$sqlshow.="$coma '$cat5'";  $coma=""; }

if($cat2 OR $cat3 OR $cat4 OR $cat5 ) $coma=" ,";
if($cat6){$sqlshow.="$coma '$cat6'";  $coma=""; }

if($cat2 OR $cat3 OR $cat4 OR $cat5 OR $cat6 ) $coma=" ,";
if($cat7){$sqlshow.="$coma '$cat7'";  $coma=""; }

if($cat2 OR $cat3 OR $cat4 OR $cat5 OR $cat6 OR $cat7 ) $coma=" ,";
if($cat8){$sqlshow.="$coma '$cat8'";  $coma=""; }

if($cat2 OR $cat3 OR $cat4 OR $cat5 OR $cat6 OR $cat7 OR $cat8 OR $cat9 ) $coma=" ,";
if($cat9){$sqlshow.="$coma '$cat9'";  $coma=""; }

if($cat2 OR $cat3 OR $cat4 OR $cat5 OR $cat6 OR $cat7 OR $cat8 OR $cat9 OR $cat10 ) $coma=" ,";
if($cat10){$sqlshow.="$coma '$cat10'";  $coma=""; }

$sqlshow.=" )";
}

if($priority)$sqlshow.=" AND priority = '$priority'";
if($pname) $sqlshow.=" AND projectCode = '$pname'";
if($fund) {$sqlshow.=" AND fund IN (".stripslashes($fund).")"; }

if($dd and $mm and $yyyy) $sqlshow.=" AND dater = '$dd/$mm/$yyyy'";

 if($coulmn_name) {
 //$sqlshow.="ORDER BY `$coulmn_name` DESC ";
 if($_SESSION['orderKey']=="ASC") { $orderKey="DESC" ;} else { $orderKey="ASC"; $_SESSION['orderKey']="ASC"; }
 $sqlshow.=" ORDER BY `$coulmn_name` $orderKey ";

 }
 //echo $sqlshow;
 $sqlshowrun=mysqli_query($db, $sqlshow);
$searchMessage="";
if($dd and $mm and $yyyy) $searchMessage.="Submitted Date: $dd/$mm/$yyyy'";
  if($cat1) $searchMessage.= ",$cat1";
  if($cat2) $searchMessage.= ",$cat2";
  if($cat3) $searchMessage.= ",$cat3";
  if($cat4) $searchMessage.= ",$cat4";
  if($cat5) $searchMessage.= ",$cat5";
  if($cat6) $searchMessage.= ",$cat6";
  if($cat7) $searchMessage.= ",$cat7";
  if($cat8) $searchMessage.= ",$cat8";
  if($cat9) $searchMessage.= ",$cat9";
  if($cat10) $searchMessage.= ",$cat10";
  if($priority) $searchMessage.= ",High";
  if(!$searchMessage)$searchMessage="ALL";
 echo "Search By: [ $searchMessage]";
 }//approval=0?>

<table  align="center" width="98%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0"  style="border-collapse:collapse" >
  <tr bgcolor="#EEEEEE">
    <td align="center"> No.</td>
    <td align="center"> Priority</td>
    <td align="center"> ProjectName</td>
    <td align="center"><? echo "<a href='./index.php?keyword=mdshow+all+requisition&coulmn_name=deadLine'>DeadLine</a>";	?></td>
    <td align="center"><? echo "<a href='./index.php?keyword=mdshow+all+requisition&coulmn_name=itemCode'>ItemCode</a>";	?></td>
    <td align="center"> Quantity</td>
    <td align="center"> UnitPrice</td>
    <td align="center"> TotalPrice</td>
    <td align="center"> Fund</td>
  </tr>
  <?
$i=1;
while( $pr=mysqli_fetch_array($sqlshowrun)) {?>
  <? if($pr[approvalStatus]=='Hold By MD' OR $pr[approvalStatus]=='Forwarded to MD' )  echo "<tr bgcolor=#FFFFFF>"; else echo "<tr bgcolor=#FFFFEE>";?>
  <td height="80"><a href="./index.php?keyword=message&prId=<? echo $pr['prId'];?>">
    <? printf("%04d [%s]", $pr['prId'],$pr[projectCode]); ?></a></td>
  <td>
    <? if($pr[priority]==0) echo 'Low'; elseif($pr[priority]==1) echo 'Normal'; elseif($pr[priority]==2) echo 'High';?>
  </td>
  <td>
    <? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
 $sqlshow2="SELECT * from `project` where `pcode` like '$pr[projectCode]'";
 //echo $sqlshow;
 $sqlshowrun2=mysqli_query($db, $sqlshow2);
 $projectName=mysqli_fetch_array($sqlshowrun2);
?>
    <? echo $projectName[pname]?></td>
  <td> <? echo date("j/m/Y ", strtotime($pr["deadLine"]));?></td>
  <? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
 $sqlshow1="SELECT * from `itemlist` where `itemCode` like '$pr[itemCode]'";
 //echo $sqlshow;
 $sqlshowrun1=mysqli_query($db, $sqlshow1);
 $item=mysqli_fetch_array($sqlshowrun1);
?>
  <td > <? echo "$pr[itemCode],<br> $item[itemDes]</a>";?></td>
  <td align="right"> <? echo "$pr[currentReq] $item[itemUnit]";?></td>
  <td align="right"> <? echo sprintf("Tk.%.2f",$pr[unitPrice]) ;?></td>
  <td align="right"> <? echo sprintf("%.2f",$pr[totalPrice]) ;?></td>
  <td align="center" > <? echo "$pr[fund]";?>
  <? if($pr[approvalStatus]=='Hold By MD' OR $pr[approvalStatus]=='Forwarded to MD' ) echo "[ <a href='./index.php?keyword=mdedit+purchase+requisition&rid=$pr[prId]'>Edit</a> ]";	?>
  </td>
  </tr>
  <? include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
 
 $sqlshow2="SELECT * from `message` where `prId` = '$pr[prId]' ORDER BY `sdate` ASC ";
 //echo $sqlshow;
 $sqlshowrun2=mysqli_query($db, $sqlshow2);

 while($projectName=mysqli_fetch_array($sqlshowrun2)){
 echo " <tr><td colspan='3'><font color=#FF99FF>";
 echo date("j/m/Y h:i:s a", strtotime($projectName[sdate])).'</td> ';

 echo " <td colspan='8'><font color=#9999FF>";
 echo "$projectName[name], $projectName[msg] ";
  }
   echo "</font></td> </tr>";
   ?>
  <tr>
    <td  height="25" colspan="10"></td>
  </tr>
  <? $i++;}?>
</table>
<form name="print" action="./managingDirector/print.php" method="post">
<input type="hidden" name="myquary" value="<? echo $sqlshow;?>">
<input type="submit" name="print" value="Print" >
</form>