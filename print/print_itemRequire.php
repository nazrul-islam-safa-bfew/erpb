<? include_once("../includes/eqFunction.inc.php");
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
$todat=todat();
?>
<html>
<head>

<LINK href="style/indexstyle.css" type=text/css rel=stylesheet>
<link href="style/basestyles.css" rel="stylesheet" type="text/css">
<link href="js/fValidate/screen.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print IOW</title>
</head>
<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<a name="top"></a>
<table width="500" border="0"  align="center" cellpadding="5" cellspacing="5">
<tr>
 <th>Bangladesh Foundry and Engineering Works Ltd.</th>
</tr>
<tr>
 <th>IOW detail Report of &nbsp;<? echo date('D',strtotime($todat)).'  '; echo mydate($todat); ?></th>
</tr>
</table>
<br>
<br>
 <? if($pcode){?>
<table width="98%" align="center" border="1" bordercolor="#999999" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
 <tr bgcolor="#F8F8F8">
   <th class="th1">Project</th>
   <th class="th1">Itemcode</th>
   <th class="th1">Description</th>
   <th class="th1">Approved</th>   
   <th class="th1">PO Given</th>
   <th class="th1">Unit</th>
   <th class="th1">10 days Req.</th>   
   <th class="th1">Quotation<br> at Hand</th>   
 </tr>
 <?
 include("../includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

$sql="SELECT dmaItemCode,dmaProjectCode,SUM(dmaQty) as dmaTotal,iowStatus,iow.iowId from dma,iow WHERE".
"  iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow AND dmaProjectCode='$pcode' Group by dmaItemCode ";
//echo $sql;
	$sqlquery=mysql_query($sql);
	while($sqlresult=mysql_fetch_array($sqlquery)){
	$temp=itemDes($sqlresult[dmaItemCode]);
    $tt = explode( '-',$sqlresult[dmaItemCode] );

	
    //echo $sqlresult[dmaItemCode].'--'.$sqlresult[dmaTotal].'-<font class=out>'.$order.'</font>='; 
	if($tt[0]<50 OR $tt[0]=='99'){
	    $order=orderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		$current=$sqlresult[dmaTotal]-$order; 
		}
	if($tt[0]>=50 AND $tt[0]<=70) {   
		 $order=eqorderQty($sqlresult[dmaProjectCode],$sqlresult[dmaItemCode]);
		 
		 $current=($sqlresult[dmaTotal]*3600)-($order*3600); 	
    	 }
	 //else $current=$sqlresult[dmaTotal]-$order; 	

	if(($current>0 AND $tt[0]<50) OR $tt[0]>=50){
   if($tt[0]<50) $bg=' bgcolor=#FFFFFF';
     else if($tt[0]<70) $bg=' bgcolor= #FFDDDD';
	  else $bg=' bgcolor = #DDDDFF';
	?>				
 <tr >
   <td align="center"><? echo $sqlresult[dmaProjectCode];?></td>
   <td align="center" width="100"><? echo $sqlresult[dmaItemCode];?></td>
   <td><? echo $temp[des].', '.$temp[spc];?></td>
	<td align="right"><? if($tt[0]>=50 AND $tt[0]<99) {echo sec2hms( $sqlresult[dmaTotal],$padHours=false); }
	 else echo number_format($sqlresult[dmaTotal],3); ?> 
	</td>
    <td align="right"> 
<? 	 	if($tt[0]>=50 AND $tt[0]<99) {echo sec2hms( $order,$padHours=false); }
	 else echo number_format($order,3); ?>   </td>


   <td align="center"><?    if($tt[0]>=50 AND $tt[0]<99) echo 'Hr.';
    else 
   echo $temp[unit];?>
   </td>
   <td align="right">
   <?
   if($tt[0]<50 OR $tt[0]=99){
   $nextten = date('Y-m-d',strtotime($todat)+(84600*10));
 
    $estimatdTotalIssue = next10daysReq($todat,$nextten,$sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);?>
	
    <?  echo number_format($estimatdTotalIssue);?> 
	 <? }
	 elseif($tt[0]>=50 AND $tt[0]<70){
	    $nextten = date('Y-m-d',strtotime($todat)+(84600*10));
 
    $estimatdTotalIssue = eqnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
	?>
   		
    <?  echo $estimatdTotalIssue;?>

	 <? }
	 elseif($tt[0]>=70 AND $tt[0]<99){
	    $nextten = date('Y-m-d',strtotime($todat)+(84600*10));
 
    $estimatdTotalIssue = empnext10daysReq($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]);
	?>
      <? echo $estimatdTotalIssue;?>
	 <? }  ?>
   </td>
   <td align="center">
   <? if($p==1){?>
   <? echo quotationNo($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode]).'nos';}
   else {
   ?>
   
   <? echo quotationNo($sqlresult[dmaItemCode],$sqlresult[dmaProjectCode])?> nos
   <? }//else?>
   </td>
 </tr>

<? 
  }//if damTotal>0
$order=0;} 
//}//iow
?>
</table>
<? }//pcode?>
  <br>
  <br>
<? include('../bottom.php');?>
</body>

</html>