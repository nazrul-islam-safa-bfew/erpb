<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>

<form name="cdj" action="./index.php?keyword=cash+disbursment" method="post">
<table  width="600" align="center" border="0" class="ablue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4" bgcolor="#0099FF"><font class='englishhead'>cash disbursment journal</font></td>
</tr>
 <tr>
	   <td colspan="4">Project: 
<!-- 	  <select name='pcode' size='1' onChange="location.href='index.php?keyword=cash+disbursment&pcode='+cdj.pcode.options[document.cdj.pcode.selectedIndex].value+'&fromDate='+cdj.fromDate.value+'toDate='+cdj.toDate.value";> -->
  <select name="pcode" size="1">
	  <option value="0">Select Project</option>  
	<? 
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	$sqlp = "SELECT * from `project` order by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode]) echo "SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
	 }
	 ?>
	</select>
		</td>
	</tr>
<!--  <tr>
	<td colspan="4"><input type="checkbox" name="hd" value="000" <? if($hd) echo 'checked';?> >	with Head Office</td> 
 </tr>
 --> 
  <tr>
 	<SCRIPT LANGUAGE="JavaScript">
		var now = new Date();
		var cal = new CalendarPopup("testdiv1");
		cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;
	</SCRIPT>
    <td>From </td>
      <td><input type="text" maxlength="10" name="fromDate" value="<? echo $fromDate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['cdj'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['cdj'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>

 <tr><td colspan="4" align="center" bgcolor="#0099FF">
 <input type="button" name="go" value="Go" onClick="cdj.submit();" class="ablue">
 </td></tr>
</table>

</form>
<br>
<br>
<? //echo 'Report for Project: <b>'.myprojectName($pcode).'</b>('.$pcode.') From <b>'.$fromDate.'</b> To <b>'.$toDate.'</b>';?>
<table  width="850" align="center" border="0" cellpadding="5" cellspacing="2" style="font-size: 10px;" >
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
 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j'); 
 $amount=0;
 $exc=0;
 $cash=0;
 $pre=0;
 $pp=0; 
 $account=array();
 $date=array();
 $paidTo=array(); 
 $amount=array(); 
 
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
  
  if($pcode=='000')$sql="select * from `purchase` WHERE 
   paymentDate between '$fromDate' and '$toDate' 
   AND (account='5501000-000'/* OR account BETWEEN '5600000' AND '5699999'*/) order by paymentDate DESC";  
  else{
	   $sql="select * from `purchase` WHERE  paymentDate between '$fromDate' and '$toDate' AND";
		 if($hd)$sql.=" (exFor='$pcode' OR account='5502000-$pcode') order by paymentSL ASC";  
		 else $sql.="  account='5502000-$pcode' order by paymentDate DESC";  
    }
  //echo $sql;
  $sqlQ=mysqli_query($db, $sql);
  $i=1;
  while($re=mysqli_fetch_array($sqlQ)){
  $account[$i]=$re[account];
  $date[$i]=$re[paymentDate];
  $reff[$i]=$re[paymentSL];
  $paidTo[$i]=$re[paidTo];
  $amount[$i]=$re[paidAmount];
  $i++;
 
  }//while
  ?>
 <? for($i=1;$i<=sizeof($account);$i++){?>
 <tr>
   <td valign="top"><? echo mydate($date[$i]);?></td>
   <td valign="top"><? echo $reff[$i];?></td>   
   <td> <?  echo $account[$i].'<br>'.accountName($account[$i]);?></td>
   <td valign="top" align="left"><? echo $paidTo[$i];?></td> 
   <td></td>      
   <td valign="top" align="right"><? echo number_format($amount[$i],2);   $crtotal+=$amount[$i];?></td> 
 </tr>
  <? 
  $temp=explode('_',$reff[$i]);
//  echo "<br>$reff[$i]<br>";
  if($temp[0]=='CP' OR $temp[0]=='ex'  OR $temp[0]=='ct' OR $temp[0]=='CT' ){
   $sql1="SELECT * FROM ex130 WHERE paymentSl='$reff[$i]'";
  // echo $sql1.'<be>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $exre[exgl].'<br>'.accountName($exre[exgl]);?></td>
   <td> <?  echo $exre[exDescription];?></td>
   <td align="right"> <? $drtotal+=$exre[examount];  echo number_format($exre[examount],2);?> </td>
   <td></td>      
 </tr>
   <?
     
    }//while 
	}//if
  else if($temp[0]=='EP' OR $temp[0]=='cash'){
   $sql1="SELECT SUM(receiveQty*rate) as amount,itemCode  FROM storet$pcode WHERE paymentSl='$reff[$i]' GROUP by itemCode";
  // echo '<br>'.$sql1.'<br>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '4800000-'.$loginProject.'<br>'.accountName(4800000);?></td>
   <td> <?  echo $exre[itemCode];
   $temp= itemDes($exre[itemCode]); echo '<br><i>'.$temp[des].'</i>';
   ?></td>
   <td align="right"> <? $drtotal+=round($exre[amount],2); echo number_format(round($exre[amount],2),2);?></td>
   <td></td>      
 </tr>
   <?
     //$exre[receiveQty]*$exre[rate];
    }//while  
   }//if

	elseif($temp[0]=='SP'  OR $temp[0]=='ss' OR $temp[0]=='WP') { ?> 
   <? 
    $sql1="select amount,paymentSl,DATE_FORMAT(month, ' %M %Y') as month,glCode,empId,designation 
	from `empsalary` WHERE paymentSl='$reff[$i]' order by pdate ASC";// GROUP BY glCode,pdate order by pdate ASC";
   //echo $sql1.'<be>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $exre[glCode].'<br>'.accountName($exre[glCode]);?></td>
   <td> <?  echo $exre[month].'['.empId($exre[empId],$exre[designation]).']';?></td>   
   <td align="right"> <?   $drtotal+=$exre[amount]; echo number_format($exre[amount],2);?></td>
   <td></td>      
 </tr>
   <?
    
    }//while  ?>
	<? 
    $sql1="select amount as examount,paymentSL,DATE_FORMAT(pdate, ' %M %Y') as month,empId,designation from `empsalaryadc`".
        " WHERE paymentSL='$reff[$i]'";
   //echo $sql1.'<be>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '5201000<br>'.accountName(5201000);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td></td>      
   <td align="right"> <?  echo number_format($exre[examount],2);?></td>
 </tr>
   <?      $crtotal+=$exre[examount];
       }//while  ?>

	<? 
    $sql1="select amount as examount,paymentSL,DATE_FORMAT(pdate, ' %M %Y') as month,empId,designation from `empsalaryadc`".
        " WHERE paymentSL='$reff[$i]'";
   //echo $sql1.'<be>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '5501000-000<br>'.accountName(5501000);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td align="right"> <? $drtotal+=$exre[examount]; echo number_format($exre[examount],2);?></td>
   <td></td>         
 </tr>
   <?
     
    }//while  ?>
	
	
<?	}//else
	elseif($temp[0]=='AS') { ?> 
   <? 

    $sql1="select amount as examount,paymentSL,DATE_FORMAT(pdate, ' %M %Y') as month,empId,designation from `empsalaryad`".
        " WHERE paymentSL='$reff[$i]'";
   //echo $sql1.'<be>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo '5201000<br>'.accountName(5201000);?></td>
   <td> <?  echo $exre[month].', '.empName($exre[empId]);?></td>
   <td align="right"> <? $drtotal+=$exre[examount]; echo number_format($exre[examount],2);?></td>
   <td></td>      
 </tr>
   <?
     
    }//while  
	}//else

 elseif($temp[0]=='PP' OR $temp[0]=='pp') { ?> 
   <? 
    $sql1="select * from `vendorpayment`".
        " WHERE paymentSl='$reff[$i]'  order by paymentDate ASC";

   //echo $sql1.'<br>';
   $sqlq1= mysqli_query($db, $sql1);
   while($exre=mysqli_fetch_array($sqlq1)){
   
   $potype=poType($exre[posl]);
   if($potype=='1') $glCode='2401000';
	  elseif($potype=='2') $glCode='2402000';   
		  elseif($potype=='3') $glCode='2403000';         
   ?>
 <tr>
   <td valign="top"></td>
   <td valign="top"></td>
   <td> <?  echo $glCode.'<br>'.accountName($glCode);?></td>
   <td> <?  echo viewposl($exre[posl]);?></td>
   <td align="right"> <? $drtotal+=$exre[paidAmount]; echo number_format($exre[paidAmount],2);?></td>
   <td></td>      
 </tr>
   <?
     
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
  <td colspan="4" align="right">total</td>
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
 
 
  <div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>