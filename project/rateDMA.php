<? 
//echo "HIiiiiiiiiii";
  $lastMonth =date("Y-m-d",mktime(0, 0, 0, date("m")+1, date("d"),   date("Y")));

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqlp = "SELECT distinct dmaItemCode, dmaProjectCode from `dmatemp` 
WHERE (dmaItemCode Between '01-00-000' AND '69-0-000') OR (dmaitemCode>='99-00-000') 
ORDER by dmaProjectCode ASC,dmaItemCode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
?>

<table  align="center" width="98%" border="1" bordercolor="#666666" cellpadding="5" cellspacing="1" style="border-collapse:collapse">
  <? while($iow=mysql_fetch_array($sqlrunp))
  { 
		  $sqlitem = "SELECT quotation.* from `quotation`  WHERE
		   quotation.itemCode = '$iow[dmaItemCode]' AND pCode IN ('000','$iow[dmaProjectCode]')";
			//echo $sqlitem.'<br>';
			$sqlruni= mysql_query($sqlitem);
			$rows= mysql_num_rows($sqlruni);
		//echo $rows;
			if($rows==0){
			 $sql="SELECT itemCode from store where itemCode = '$iow[dmaItemCode]' ";
			 //echo $sql;
			 $sqlQuery=mysql_query($sql);
			 $rows=mysql_num_rows($sqlQuery);
              }
			if($rows==0){
			 $sql="SELECT itemCode from equipment where itemCode = '$iow[dmaItemCode]' ";
			 //echo $sql;
			 $sqlQuery=mysql_query($sql);
			 $rows=mysql_num_rows($sqlQuery);
              }
/*  			if($rows==0){
			 $sql="SELECT itemCode from toolrate where itemCode = '$iow[dmaItemCode]' ";
			 //echo $sql;
			 $sqlQuery=mysql_query($sql);
			 $rows=mysql_num_rows($sqlQuery);
			 $c=1;
              }
*/
		?>	

			<? if($rows==0){?>
		  <tr bgcolor="#CCCCCC">  
			<td align="center" colspan="2"><? echo myprojectName($iow[dmaProjectCode]);?></td>
			<td align="left"><? 
			$temp=itemDes($iow[dmaItemCode]);
			
			echo $iow[dmaItemCode];
			//echo $temp[unit];
			echo ', '.$temp[des].', '. $temp[spc].', '.$temp[unit];
			?></td>
		  </tr>
			
		 <tr bgcolor=#FFFFEE><td colspan=5> NO Vendor Found! <a href='index.php?keyword=enter+Quotation'>Enter Rate</a></td></tr>
					  <tr><td colspan="5"></td></tr>
					<tr><td colspan="5"><br></td></tr>
					
		  <? } //if
		  elseif(!$c) { ?>
		  <?  while($result=mysql_fetch_array($sqlruni)){
		        $temp1= vendorName($result[vid]);
				if($temp1=="Not found")continue;
				//$t1=date("d-m-Y", strtotime($result[valid]));
				//$t2=date("d-m-Y", strtotime($lastMonth));
		       $t1=strtotime($result[valid]);
			   $t2=strtotime($lastMonth);
			    if($t2>$t1){?>
		  <tr bgcolor="#CCCCCC">  
			<td align="center" colspan="2"><? echo myprojectName($iow[dmaProjectCode]);?></td>
			<td align="left"><? 
			$temp=itemDes($iow[dmaItemCode]);
			
			echo $iow[dmaItemCode];
			//echo $temp[unit];
			echo ', '.$temp[des].', '. $temp[spc].', '.$temp[unit];
			?></td>
		  </tr>
			 <tr bgcolor="#E0E0E0">
				 <td>Rating</td>		 
				 <td>Vendor Name</td>
				 <td>Offer Valid Till</td>		 
			   </tr>
		  
				   
				 <tr>
					 <td><? echo $temp1[rating];?></td>
					 <td><? echo $temp1[vname];?></td>
					 <td><? echo date("d-m-Y", strtotime($result[valid]));?>
					 <a href='./index.php?keyword=enter+Quotation&Go=1&vid=<? echo $result[vid]; ?>'>Update</a></td>
                  </tr> 
				  					<tr><td colspan="5"><br></td></tr>			
			<? 	}//if		      
		   }//while
     }//else
  }//while?>  
</table>
