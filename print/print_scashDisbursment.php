<? 
include_once("../includes/session.inc.php");
include_once("../includes/myFunction1.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/accFunction.php");

$todat=todat();
?>
<html>
<head>

<LINK href="../style/print.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Language" content="en-us">
<meta name="author" content="<? echo $mauthor;?>">
<meta name="copyright" content="<? echo $tt;?>">
<meta name="keywords" content="<? echo $kword;?>">
<META NAME="description" CONTENT="<? echo $des;?>">
<title>BFEW :: Print</title>
</head>

<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<div class="dialog">
<table  width="750" align="center" border="0" class="blue" >
<tr>
 <th align="center"><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>
<tr>
 <td align="center" ><font class='englishheadblack'>cash disbursment journal</font><br>  of<br> <? echo myprojectName($loginProject);?></td>
</tr>
<tr>
    <td align="center">From <? echo myDate($fromDate);?> To <? echo myDate($toDate);?></td>
</tr>
 </table>
 </div>
<br>
<br>
<div class="dialog">
<table  width="750" align="left" border="0" cellpadding="5" cellspacing="2" style="font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top" width="100">Date</th>
   <th align="center" valign="top">Reference</th>
   <th align="center" valign="top" width="200">Account ID</th>   
   <th align="center" valign="top" width="200">Description</th>   
   <th align="right" valign="top" width="100">Debit Amount</th>   
   <th align="right" valign="top" width="100">Credit Amount</th> 
 </tr>
  <tr><td colspan="8" height="3" bgcolor="#FFCC66"></td></tr>
 <?
 // $fromDate=formatDate($fromDate,'Y-m-j');
// $toDate=formatDate($toDate,'Y-m-j'); 

 $amount=0;
 $exc=0;
 $cash=0;
 $pre=0;
 $pp=0; 
 $account=array();
 $date=array();
 $paidTo=array(); 
 $amount=array(); 
 
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
   $sql="select * from `purchase` WHERE  account='5502000-$loginProject' AND".
  "  paymentDate between '$fromDate' and '$toDate' order by paymentDate,prId DESC";  
  //echo $sql;
  $sqlQ=mysql_query($sql);
  $i=1;
  while($re=mysql_fetch_array($sqlQ)){
  $account[$i]=$re[account];
  $date[$i]=$re[paymentDate];
  $reff[$i]=$re[paymentSL];
  $paidTo[$i]=$re[paidTo];
  $amount[$i]=$re[paidAmount];
  $i++;
  $crtotal+=$re[paidAmount];
  }//while
  ?>
 <? for($i=1;$i<=sizeof($account);$i++){?>
 <tr>
   <td valign="top"><? echo mydate($date[$i]);?></td>
   <td valign="top"><? echo $reff[$i];?></td>   
   <td> <?  echo $account[$i].'<br>'.accountName($account[$i]);?></td>
   <td valign="top" align="left"><? echo $paidTo[$i];?></td> 
   <td></td>      
   <td valign="top" align="right"><? echo number_format($amount[$i],2);?></td> 
 </tr>
  <? 
  $ht=explode('_',$reff[$i]);
  if($ht[0]=='CP' OR $ht[0]=='ex' ){
   $sql1="SELECT * FROM ex130 WHERE paymentSl='$reff[$i]'";
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
    <td> 
      <?  echo $exre[exgl].'<br>'.accountName($exre[exgl]);?>
    </td>
   <td> <?  echo $exre[exDescription];?></td>
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while  
   }//if
   ?>
   <?   
  $ht=explode('_',$reff[$i]);
 // echo '<br>+++**'.$reff[$i].'  =='.$ht[0].'**+++<br>';
  if($ht[0]=='EP' OR $ht[0]=='cash'){
   $sql1="SELECT SUM(receiveQty*rate) as amount,itemCode  
   FROM storet$loginProject 
   WHERE paymentSl='$reff[$i]' 
   GROUP by itemCode";
  // echo '<br>'.$sql1.'<br>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '4800000-'.$loginProject.'<br>'.accountName(4800000);?></td>
   <td> <?  echo $exre[itemCode];
   $temp= itemDes($exre[itemCode]); echo '<br><i>'.$temp[des].'</i>';
   ?></td>
   <td align="right"> <?  echo number_format(round($exre[amount],2),2);//echo number_format($exre[receiveQty]*$exre[rate],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=round($exre[amount],2);//$exre[receiveQty]*$exre[rate];
    }//while  
   }//if
   ?>
   <?
  $ht=explode('_',$reff[$i]);   
  if($ht[0]=='SP' OR $ht[0]=='ss' OR $ht[0]=='WP'){
   $sql1="SELECT * FROM empsalary WHERE paymentSl='$reff[$i]'";
   //echo $sql1;
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $exre[glCode].'<br>'.accountName($exre[glCode]);?></td>
   <td> <?  echo 'Salary of '.$exre[empId];?></td>
   <td align="right"> <?  echo number_format($exre[amount],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[amount];
    }//while  
   }//if

  $ht=explode('_',$reff[$i]);
  if($ht[0]=='PP'  OR $ht[0]=='pp') { ?> 
   <? 
    $sql1="select * from `vendorpayment`".
        " WHERE paymentSl='$reff[$i]'  order by paymentDate ASC";

  //echo $sql1.'<be>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){
   $glCode='2400000';
   ?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $glCode.'<br>'.accountName($glCode);?></td>
   <td> <?  echo viewposl($exre[posl]);?></td>
   <td align="right"> <?  echo number_format($exre[paidAmount],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[paidAmount];
    }//while  
	}//else?> 

<? 
}//for?>
<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>
<tr>
 <td colspan="6" bgcolor="#FFFFFF"></td>
</tr>
<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>

<tr>
  <th colspan="4" align="right">Total</th>
  <th align="right"><? echo number_format($drtotal,2);?>  </th>
  <th align="right"><? echo number_format($crtotal,2);?>  </th>  
</tr>

<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>
<tr>
 <td colspan="6" bgcolor="#FFFFFF"></td>
</tr>
<tr>
 <td colspan="4"></td>
 <td bgcolor="#FF6600"></td>
 <td bgcolor="#FF6600"></td>
</tr>

 </table>
</div> 

 <br>
 <br>

<? include('../bottom.php');?>
</body>

</html>
 
