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
<title>BFEW :: Print IOW</title>
</head>

<body  topmargin="1" leftmargin="5" rightmargin="5" bgcolor="#FFFFFF" >
<div class="dialog">
<table  width="800" align="center" border="0" class="blue" >
<tr>
 <th align="center"><font class="englishheadBlack">Bangladesh Foundry and Engineering Works Ltd.</font></th>
</tr>
 <tr >
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

<table  width="780" align="left" border="0" cellpadding="5" cellspacing="2" style="font-size: 10px;" >
 <tr bgcolor="#CCFF99">
   <th align="center" valign="top" width="80">Date</th>
   <th align="center" valign="top">Reference</th>
   <th align="center" valign="top" >Account ID</th>   
   <th align="center" valign="top" width="180">Description</th>   
   <th align="right" valign="top" width="95">Debit Amount</th>   
   <th align="right" valign="top" width="95">Credit Amount</th> 
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
/*  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate'".
  " AND (account='5501000-000' OR account BETWEEN '5600000' AND '5699999')  order by paymentDate DESC";  
  */
  $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate'";
if($type=='all')$sql.=" AND (account='5501000-000' OR account BETWEEN '5600000' AND '5699999')";
elseif($type=='cash')$sql.=" AND (account='5501000-000' )";
elseif($type=='bank')$sql.=" AND ( account BETWEEN '5600000' AND '5699999')";
    $sql.=" order by paymentDate DESC,paymentSL DESC";    
//  echo $sql;
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
   <td valign="top"><? echo $reff[$i]; ?></td>   
   <td> <?  echo $account[$i].'<br>'.accountName($account[$i]);?></td>
   <td valign="top" align="left"><? echo $paidTo[$i];?></td> 
   <td></td>      
   <td valign="top" align="right"><? echo number_format($amount[$i],2);?></td> 
 </tr>
  <? 
  $temp=explode('_',$reff[$i]);
//  echo "<br>$reff[$i]<br>";
  if($temp[0]=='CP' OR $temp[0]=='ex'  OR $temp[0]=='ct' OR $temp[0]=='CT' ){
   $sql1="SELECT * FROM ex130 WHERE paymentSl='$reff[$i]'";
  // echo $sql1.'<be>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $exre[exgl].'<br>'.accountName($exre[exgl]);?></td>
   <td> <?  echo $exre[exDescription];?></td>
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while 
	}//if
	elseif($temp[0]=='SP'  OR $ht[0]=='ss') { ?> 
   <? 
    $sql1="select amount  as examount,paymentSl,DATE_FORMAT(month, ' %M %Y') as month,glCode,empId,designation from `empsalary`".
        " WHERE paymentSl='$reff[$i]'  order by pdate ASC";
   //echo $sql1.'<be>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $exre[glCode].'<br>'.accountName($exre[glCode]);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while  ?>
	<? 
    $sql1="select amount as examount,paymentSL,DATE_FORMAT(pdate, ' %M %Y') as month,empId,designation from `empsalaryadc`".
        " WHERE paymentSL='$reff[$i]'";
   //echo $sql1.'<be>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '5201000<br>'.accountName(5201000);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td></td>      
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while  ?>

	<? 
    $sql1="select amount as examount,paymentSL,DATE_FORMAT(pdate, ' %M %Y') as month,empId,designation from `empsalaryadc`".
        " WHERE paymentSL='$reff[$i]'";
   //echo $sql1.'<be>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '5501000-000<br>'.accountName(5501000);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
   <td></td>         
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while  ?>
	
	
<?	}//else
	elseif($temp[0]=='AS') { ?> 
   <? 

    $sql1="select amount as examount,paymentSL,DATE_FORMAT(pdate, ' %M %Y') as month,empId,designation from `empsalaryad`".
        " WHERE paymentSL='$reff[$i]'";
   //echo $sql1.'<be>';
   $sqlq1= mysql_query($sql1);
   while($exre=mysql_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '5201000<br>'.accountName(5201000);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
   <td></td>      
 </tr>
   <?
     $drtotal+=$exre[examount];
    }//while  
	}//else

 elseif($temp[0]=='PP' OR $temp[0]=='pp') { ?> 
   <? 
    $sql1="select * from `vendorpayment`".
        " WHERE paymentSl='$reff[$i]'  order by paymentDate ASC";

   ///echo $sql1.'<be>';
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
  <td colspan="4" align="right">Total</td>
  <td align="right"><? echo number_format($drtotal,2);?>  </td>
  <td align="right"><? echo number_format($crtotal,2);?>  </td>  
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
</div>  
</body>

</html>
 
