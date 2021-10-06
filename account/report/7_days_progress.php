<?php
class project{
  public $project_rows;
  public function __construct($pcodes=[]){
    $project_rows=implode(",",$pcodes);
    global $db;
    $sql="select * from project where `status`='0' and pcode in ($project_rows) order by pcode desc";
    $q=mysqli_query($db,$sql);
    while($this->project_rows[]=mysqli_fetch_array($q)){}
  }
  public function store_inventory($pcode,$the_date){
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
  public function cash_amount($the_date,$pcode){
    global $db;
    $sql3="select * from `accounts` ORDER by accountID ASC";
    $fromDate="2014-01-01";
    $toDate=date("Y-m-d");
    $sqlq=mysqli_query($db, $sql3);
    while($re=mysqli_fetch_array($sqlq)){
      if($re[accountID]=='5502000'){
        $baseOpening=baseOpening('5502000',$pcode);
        $openingBalance=$baseOpening+openingBalance('5502000',$fromDate,$pcode);
        $balanceSideCash1=cashonHand($pcode,$fromDate,$the_date,'2');
        $balanceSideCash=$openingBalance+$balanceSideCash1;
      }
    }
    return $balanceSideCash;
  }

	public function cash_in($the_date,$project){
		global $db;
		$sql="select sum(examount) as examount from ex130 where paymentSL like 'CT_000_%' and exDate='$the_date' and exgl like '%-$project' ";
		$q=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($q);
		return $row["examount"] > 0 ? $row["examount"] : 0;
	}

	public function cash_out($the_date,$project){
		global $db;
		$sql="SELECT sum(paidAmount) as paidAmount FROM `purchase` where location='$project' and paymentDate='$the_date' ";
		$q=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($q);
		return $row[paidAmount] > 0 ? $row[paidAmount] : 0;
	}

  public function digit_fixed($amount){
    return number_format($amount);
  }
}
?>
	<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
	<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date(); 
	var cal = new CalendarPopup("testdiv1");
    	//cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); 
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;
	</SCRIPT>
<style>
  .project_table{ font-size:10px;}
  .project_table tr:nth-child(odd){background:#ededed;}
  .project_table tr{}
</style>
<br><br>

<table align="center" class="dblue project_table" width="300">
  <form name="searchForm" action="./index.php?keyword=Daily+Site+Cash+Report" method="post">
    

 <tr>
   <td align="right" bgcolor="#0066FF" colspan="2"><font class="englishhead"><center>Daily Site Cash Report</center></font></td>
 </tr>
 <tr>
   <form>
   <td align="left" colspan="2">Project:
     <select multiple style="    height: 200px;" name='pcodes[]'>
      <?php
       global $db;
       $sql="select * from project where `status`='0' and pcode!='000' order by pcode desc";
       $q=mysqli_query($db,$sql);
       while($row=mysqli_fetch_array($q)){
         if(in_array($row[pcode],$pcodes)==1)$extra=" selected ";else $extra="";
         echo "<option value='$row[pcode]' $extra >$row[pcode] - $row[pname]</option>";
       }
      ?>
     </select>
    </font></td>
 </tr>
 <tr>
  <td>From <input type="text" name="fdate" style="width:100px;" value="<?php echo $fdate; ?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['searchForm'].fdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a><br>  
  </td>
  <td>To <input type="text" name="tdate" style="width:100px;" value="<?php echo $tdate; ?>"> <a id="anchor" href="#"
   onClick="cal.select(document.forms['searchForm'].tdate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a><br> </td>
  </tr>
 </tr>
  <tr>
    <td colspan=2><br><center><input type="submit" value="Search"></center><br></td>
  </tr>
  </form>
</table>
<br>
<br>
<br>
<?php
      $fdate=formatDate($fdate,'Y-m-j');
      $tdate=formatDate($tdate,'Y-m-j');
      $range=(strtotime($tdate)-strtotime($fdate))/86400;
?>
<table align="center" class="project_table" width="98%" style="border:1px solid #000;">
  <tr>
     <th width="400" rowspan=2>Project</th>
     <th align="center" colspan="<?php echo $range+1; ?>">Site Cash</th>
   </tr>
  <tr>
    <?php      
      for($i=0;$i<=$range;$i++){
        echo "<th><i>".date("d/m/y",strtotime($fdate)+(86400*$i))."</i></th>";
      }
    ?>
  </tr>
  <?php
    $p=new project($pcodes);
    foreach($p->project_rows as $project){
      if(!$project["pcode"])continue;
      echo "<tr><td>";
      echo $project["pcode"]." ".$project["pname"];
      echo "</td>";
      for($i=0;$i<=$range;$i++){
        echo "<td align='right'>";
        $the_date=date("Y-m-d",strtotime($fdate)+(86400*$i));
				
// 				cash in
				if($project["pcode"]=="000")
					$cash_out=$p->digit_fixed($p->cash_out($the_date,$project["pcode"]));
				else
					$cash_in=$p->digit_fixed($p->cash_in($the_date,$project["pcode"]));
				
				echo $cash_in>0 ? "<font color='#00f'>" : "";
				echo "+$cash_in";
				echo $cash_in>0 ? "</font>" : "";

// 				cash out
				echo "<br>";
				if($project["pcode"]!="000")
					$cash_out=$p->digit_fixed($p->cash_out($the_date,$project["pcode"]));
				else
					$cash_in=$p->digit_fixed($p->cash_in($the_date,$project["pcode"]));
				echo $cash_out>0 ? "<font color='#f00'>" : "";
				echo "-$cash_out";
				echo $cash_out>0 ? "</font>" : "";

// 				cash closing
				echo "<br>";
        $the_date_n=date("Y-m-d",strtotime($fdate)+(86400*($i)));
				$cash_amount=$p->digit_fixed($p->cash_amount($the_date_n,$project["pcode"]));
					
				echo $cash_amount>0 ? "<font color='#000'>" : "";
				echo "$cash_amount";
				echo $cash_amount>0 ? "</font>" : "";

        echo "</td>";
      }
        //echo $p->digit_fixed($p->cash_amount($project["pcode"],$the_date));
      echo "</tr>";
			echo "<tr height='5'><td></td></tr>";
    }
  ?>
</table>
<div id=testdiv1
      style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>