<style>
  .pending_table td,th{border:1px solid;}
  .pending_table tr:nth-child(odd){background:#eee;}
  .pending_table{font-size:10px;}
</style>
<?php
error_reporting(E_ERROR | E_PARSE);
class cash_purchase_temp{
  public $db;
  public function __construct(){
    global $db;
    if(!$db)die("Database not connected");
    $this->db=$db;    
  }
  public function get_query_data(){
		global $loginProject;
		$project=$loginProject;
		global $loginDesignation;
		global $loginUid;
		
		
		if($loginProject!='000')$extra_url="site+";

		if($loginDesignation=="Chairman & Managing Director"){
			$empSql="select designation,empId from employee where ccr='73-11-003'";
		}else{

			$empSql = "select designationCode from user where id='$loginUid'";
			$empQ=mysqli_query($this->db,$empSql);
			$empRow=mysqli_fetch_array($empQ);
			// print_r($empRow);
			if($empRow['designationCode']==""){
				$empSql="select designation,empId from employee where ccr in (select itemCode from itemlist where itemDes=(select designation from user where id='$loginUid'))";
			}else{				
				$empSql="select designation,empId from employee where ccr=(select designationCode from user where id='$loginUid')";
			}
		}
	// echo $empSql;

		$empQ=mysqli_query($this->db,$empSql);
		while($empRow=mysqli_fetch_array($empQ)){
			$empLineArr[]="'".$empRow[designation].$empRow[empId]." %'";
		}
		foreach($empLineArr as $empLineArrS)
			$empArr[]=" paid_to like $empLineArrS";

		$empLine=implode(" or ",$empArr);

		// echo $empLine;

    $sql="select * from cash_purchase_temp where accepted!='1'";
		
		

		if($loginDesignation!="Chairman & Managing Director" && $loginDesignation!="Site Cashier"){ //manager
			$sql.=" and (paid_to not like '71-%' and (paid_to like '73-11-%' or ($empLine))) ";
			$sql.=" and project='$project' ";
		}elseif($loginDesignation=="Site Cashier"){ //cashier
			$sql.=" and project='$project' ";
		}else{ // MD
			$sql.=" and ((paid_to like '73-%' or paid_to like '71-%' ) ";
			$sql.=" or ($empLine)) ";
			$sql.=" order by project,paid_to desc ";
		}
// 	$sql.=" or paid_to like '') ";
	// echo $sql;

    $q=mysqli_query($this->db,$sql);
    while($row=mysqli_fetch_array($q)){
				$pos=substr($row[paid_to],0,9);
				$expPos=explode("-",$pos);
// 			echo $pos;
			if($loginDesignation=="Chairman & Managing Director"){
				if(!($pos>="73-10-000" && $pos<="73-19-999")){
					continue;
				}
			}elseif($pos>="73-10-000" && $pos<="73-19-999"){
					continue;
			}
// 			echo 444;
			
			$exp=explode(" ",$row[paid_to]);
			$exxp=explode("-",$exp[0]);
			
// 			print_r($exp);
			$nameColl="";
			for($i=1;$i<count($exp);$i++){
				$nameColl.=$exp[$i]. " ";
			}
			$expName=explode(",",$nameColl);
			
			$designationColl="";
			for($i=1;$i<count($expName);$i++){
				$designationColl.=$expName[$i]. ", ";
			}
			

			$designationColl=trim($designationColl,", ");
			
			$des=accountDes($row["account_id1"]);
      echo "
      <tr>
        <td width='100'>".date("d/m/Y",strtotime($row[payment_date]))
        ."<br>".
        ($row[voucher_date]!='0000-00-00' ? date("d/m/Y",strtotime($row[voucher_date])) : "")."</td>
        <td width='200'>
				<b>$exp[0]</b>:
				<font color='#00f'>$expName[0]</font>
				<font>$designationColl</font>
				</td>
        <td width='250'>";
			
			echo "$row[account_id1]-$row[for_project]: $des<br>";
			
			
				$revision_history=$this->get_revision_history($row[id]);
				if($revision_history){
					echo "<font color='#f00'>[$revision_history[text]]</font><br>";
				}
			
			echo "<font color='#00f'>$row[description1]</font><br>";
      
      $exp_data=$this->get_insufficient_text($row[id]);
      foreach($exp_data as $e_data){
        if($e_data[2] && $e_data[4])
          echo "<font>".$e_data[4]."</font>: ".$e_data[2]."</br>";
      }
      
      echo $this->get_iow_formated_info($row[id])."<br>";
			
			echo "".(($row[amount2]>0) ? ("$row[account_id2]-$row[for_project]: <b>Tk.".$this->amount_format($row[amount2])."</b> $row[description2]") : "" )."
				";
			
			if(($row[accepted]==3 || $this->weather_resubmit_enabled($row[id])) && $loginDesignation=="Site Cashier"){  
			/*
				accepted 3 means Insufficient Details
				if cash_purchase_temp_history has the similar id means it's editable enabled.
			*/
			echo "<input type='text' value='$row[description1]' id='edit_des_$row[id]'>
						<input type='button' value='Submit' onClick=\" window.location.href='./index.php?keyword=".$extra_url."payments&w=2&exfor=000&edit_id=$row[id]&text='+document.getElementById('edit_des_$row[id]').value; \">
						";
			}
			echo "</td>
        <td>$row[gl_account]</td>";

		{
			$exp=explode(" ",$row[paid_to]);
			$exxp=explode("-",$exp[0]);
			
			if($exxp[0]."-".$exxp[1]=="73-11" || $exxp[0]=="71"){
				$managerArr[name]="Managing Director";
				$managerArr[designation]="71-01-000";
			}else{
				$manager=$exxp[0]."-".$exxp[1]."-".$exxp[2][0].$exxp[2][1].$exxp[2][2];
				$managerArr=getManager($manager,$row[project]);
				if(!$managerArr){
					$managerArr[name]="<font color='#f00'>No manager found</font>";
				}else
					$managerArr[name]=itemCode2Des($managerArr["designation"]);
			}
// 			print_r($managerArr);
			echo "<td>";
			if($row[accepted]==2){
// 				echo "<i style='color:'> Rejected by $row[accepted_by]</i>";
			}
			if($row[accepted]==3)
				echo "'INSUFFICIENT DETAILS' by <b>$managerArr[name]</b>";
			elseif($row[accepted]==2)
				echo "Rejected by <br><b>$managerArr[name]</b>";
			else
				echo "Forwarded for approval <br><b>$managerArr[name]</b>";
				
				if($loginDesignation=="Site Cashier"){
					if($row[accepted]==2){
						echo "<p align=center style='margin:0;padding:0;'><a href='./index.php?keyword=".$extra_url."payments&w=2&exfor=000&entry_id=$row[id]' style='color:#f00;font-weight:600'>Delete</a></p>";
					}
				}
			echo "</td>";
		}
    echo " <td align=right>".$this->amount_format($row[total]);
		echo "</td>";
			
			
    global $loginDesignation;
// 		echo $loginDesignation;
		
		if($loginDesignation!='Site Cashier' && !(($expPos[0]=="73" && ($expPos[1]<="20" && $expPos[1]<="10")) && ($loginDesignation=="Construction Manager" || $loginDesignation=="Workshop Manager"))){
        echo "<td align=center>";
			
			
			
				if($row[accepted]==0 || ($row[accepted]==3 && $this->weather_resubmit_enabled($row[id])) || 1==1){
        	echo "<a href='./index.php?keyword=cash+payment+approval&id=$row[id]&activity=approved'  class='approve_class'>Approve</a>";
					
					if($this->weather_resubmit_enabled($row[id])){
						echo " | <a href='./index.php?keyword=cash+payment+approval&id=$row[id]&activity=suspend' style='color:#f00'>Reject</a>";
					}
					
					
			if(!$this->weather_resubmit_enabled($row[id]) && $row[accepted]!=3){
        echo "<br>
				<a href='./index.php?keyword=cash+payment+approval&id=$row[id]&activity=ins_dtls' style='color:#000' class='insufficient'>Insufficient Details</a>
				</td>";
			}
					
				}
			
    }elseif($expPos[0]=="73" && $loginDesignation=="Construction Manager"){
			echo "<td></td>";
		}
			
     echo " </tr>
      ";
    }
  }
	
	
	public function weather_resubmit_enabled($cpt_id){
		$sql="select count(*) as rows from cash_purchase_temp_history where cpt_id='$cpt_id'";
		$q=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_array($q);
		return $row["rows"]>0 ? true : false;
	}
	
	public function get_revision_history($cpt_id){
		$sql="select text from cash_purchase_temp_history where cpt_id='$cpt_id'";
		$q=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_array($q);
		return $row;
	}
	
	
	
	public function without_manager_responsibility(){
			$p_sql="select pname,pcode from project where status='0' order by pcode asc";
			$p_q=mysqli_query($this->db,$p_sql);
			while($p_row=mysqli_fetch_array($p_q)){
				$emp_sql="select * from ";
				echo "<tr><td colspan='7'><h2 align='left'>$p_row[pcode]: $p_row[pname]</h2></td></tr>";
				$this->designation_work($p_row);
			}
	}
	
	
	public function push_history($cpt_id){
		$sql="select description1 as des from cash_purchase_temp where id='$cpt_id'";
		$q=mysqli_query($this->db,$sql);
		$row=mysqli_fetch_array($q);
    
		$sql="insert into cash_purchase_temp_history (cpt_id,text) values ('$cpt_id','$row[des]')";
		mysqli_query($this->db,$sql);
	}
	
	
	public function designation_group(){
			$p_sql="select pname,pcode from project where status='0' and pcode<='100' order by pcode asc";
			$p_q=mysqli_query($this->db,$p_sql);
			while($p_row=mysqli_fetch_array($p_q)){
				echo "<tr><td colspan='7'><h2 align='left'>$p_row[pcode]: $p_row[pname]</h2></td></tr>";
				$this->designation_work($p_row);
			}
			
			$p_sql="select pname,pcode from project where status='0' and pcode>='100' order by pcode desc";
			$p_q=mysqli_query($this->db,$p_sql);
			while($p_row=mysqli_fetch_array($p_q)){
				echo "<tr><td colspan='7'><h2 align='left'>$p_row[pcode]: $p_row[pname]</h2></td></tr>";
				$this->designation_work($p_row);
			}
	}
	
	public function designation_work($p_row){
				$sql="select designation from employee where designation between '73-10-000' and '73-19-999' and location='$p_row[pcode]' group by designation order by designation asc";
				$q=mysqli_query($this->db,$sql);
				while($row=mysqli_fetch_array($q)){
					$des=itemDes($row[designation]);
					echo "<tr><td colspan='7'><h3 align='left'>$row[designation]: $des[des]</h3></td></tr>";
					$this->get_query_data_temp($row["designation"],$p_row[pcode]);
				}
	}
	
	
	public function delete_entry($entry_id){
		$sql="delete from cash_purchase_temp where id='$entry_id' and accepted='2'";
		mysqli_query($this->db,$sql);
		if(mysqli_affected_rows($this->db)>0){
			echo "Payment request has been deleted.";
		}
	}
	
	public function edit_entry($entry_id,$text){
		$this->push_history($entry_id);
		$sql="update cash_purchase_temp set description1='$text', accepted='0' where id='$entry_id'";
		mysqli_query($this->db,$sql);
		if(mysqli_affected_rows($this->db)>0){
			echo "Payment request has been forwarded.";
		}
	}
	
	
  public function get_query_data_temp($designation=null,$pcode=null){
		global $loginProject;
		$project=$loginProject;
		global $loginDesignation;
		global $loginUid;
		
	
		
		$empSql="select designation,empId from employee where ccr='$designation' and location='$pcode' ";
		//echo $empSql;
		$empQ=mysqli_query($this->db,$empSql);
		while($empRow=mysqli_fetch_array($empQ)){
			$empLineArr[]="'".$empRow[designation].$empRow[empId]." %'";
		}
		foreach($empLineArr as $empLineArrS)
			$empArr[]=" paid_to like $empLineArrS";

		$empLine=implode(" or ",$empArr);
		
		
    $sql="select * from cash_purchase_temp where accepted!='1' and project='$pcode'";
		$sql.="and ($empLine) ";
		//$sql.=" and (paid_to not like '71-%' and (paid_to like '73-11-%' or ($empLine))) ";
		
// 		if($designation=="73-11-006")
echo "<br>";
		echo $sql;
		
    $q=mysqli_query($this->db,$sql);
    while($row=mysqli_fetch_array($q)){
				$pos=substr($row[paid_to],0,9);
				$expPos=explode("-",$pos);
			
			
			if($pos>="73-10-000" && $pos<="73-19-999"){
				continue;
			}
			
			$exp=explode(" ",$row[paid_to]);
			$exxp=explode("-",$exp[0]);
			
// 			print_r($exp);
			$nameColl="";
			for($i=1;$i<count($exp);$i++){
				$nameColl.=$exp[$i]. " ";
			}
			$expName=explode(",",$nameColl);
			
			$designationColl="";
			for($i=1;$i<count($expName);$i++){
				$designationColl.=$expName[$i]. ", ";
			}
			
			$designationColl=trim($designationColl,", ");
			

			$des=accountDes($row["account_id1"]);
      echo "
      <tr>
        <td width='100'>".date("d/m/Y",strtotime($row[payment_date]))
        ."<br>".
        ($row[voucher_date]!='0000-00-00' ? date("d/m/Y",strtotime($row[voucher_date])) : "")."</td>
        <td width='200'>
				<b>$exp[0]</b>:
				<font color='#00f'>$expName[0]</font>
				<font>$designationColl</font>
				</td>
        <td width='250'>";
			
			echo "
          $row[account_id1]-$row[for_project]: $des<br>";
      
      $exp_data=$this->get_insufficient_text($row[id]);
      foreach($exp_data as $e_data){ 
        if($e_data[2] && $e_data[4])
          echo "<font color='#00f'>".$e_data[4]."</font>: ".$e_data[2]."</br>";
      }
			
			
				$revision_history=$this->get_revision_history($row[id]);
				if($revision_history){
					echo "<font color='#f00'>[$revision_history[text]]</font><br>";
				}
			
			echo "<font color='#00f'>$row[description1]</font><br>";    
      
      echo $this->get_iow_formated_info($row[id])."<br>";
					
				echo "".(($row[amount2]>0) ? ("$row[account_id2]-$row[for_project]: <b>Tk.".$this->amount_format($row[amount2])."</b> $row[description2]") : "" )."
        </td>
        <td>$row[gl_account]</td>";

		{
			$exp=explode(" ",$row[paid_to]);
			$exxp=explode("-",$exp[0]);
			

			
			if($exxp[0]."-".$exxp[1]=="73-11" || $exxp[0]=="71"){
				$managerArr[name]="Managing Director";
				$managerArr[designation]="71-01-000";
			}else{
				$manager=$exxp[0]."-".$exxp[1]."-".$exxp[2][0].$exxp[2][1].$exxp[2][2];
				$managerArr=getManager($manager,$row[project]);
				if(!$managerArr){
					$managerArr[name]="<font color='#f00'>No manager found</font>";
				}else
					$managerArr[name]=itemCode2Des($managerArr["designation"]);
			}
			echo "<td>";
// 			print_r($row);
			if($row[accepted]==2){
				echo "<span style='color:#f00'> Rejected by $row[accepted_by]</font>";
			}
			elseif($row[accepted]==3)
				echo "(Insufficient Details) by<br><b>$managerArr[name]</b>";
			else
				echo "Forwarded for approval <br><b>$managerArr[name]</b>";
			echo "</td>";
		}
    echo " <td align=right>".$this->amount_format($row[total]);
		echo "</td>";
			
			
    global $loginDesignation;
		if($loginDesignation!='Site Cashier' && !($expPos[0]=="73" && ($loginDesignation=="Construction Manager" || $loginDesignation=="Workshop Manager"))){
        echo "<td align=center>";
				if($row[accepted]==0 || ($row[accepted]==3 && $this->weather_resubmit_enabled($row[id])) || 1==1){
        	echo "<a href='./index.php?keyword=cash+payment+approval&id=$row[id]&activity=approved' class='approve_class'>Approve</a>";
					
					if($this->weather_resubmit_enabled($row[id])){
						echo " | <a href='./index.php?keyword=cash+payment+approval&id=$row[id]&activity=suspend' style='color:#f00'>Reject</a>";
					}
					
			if(!$this->weather_resubmit_enabled($row[id]) && $row[accepted]!=3){
        echo "<br>
				  <a href='./index.php?keyword=cash+payment+approval&id=$row[id]&activity=ins_dtls' style='color:#000' class='insufficient'>Insufficient Details</a>
				</td>";
			}
					
				}
        echo "
				</td>";
    }elseif($expPos[0]=="73" && $loginDesignation=="Construction Manager"){
			echo "<td></td>";
		}
			
     echo " </tr>
      ";
    }
  }
	
	
	
	
	
	
	
	
	
	
  public function formatDate($date,$format){
  	$regs = explode("/", $date);
    $the_date = date($format, strtotime($regs[2].'-'.$regs[1].'-'.$regs[0]));
    return $the_date;
  }
  public function expencess_execute(){
//     print_r($_POST);
//     exit;
  	if(!$_POST[voucherDate])$_POST[voucherDate]=$_POST[paymentDate];
    $payment_date=$this->formatDate($_POST[paymentDate],"Y-m-d");
    $voucher_date=$this->formatDate($_POST[voucherDate],"Y-m-d");
    $paid_to=$_POST[paidTo];
    $for_project=$_POST[exfor];
    
    $description1=$_POST[exdes1];
    $account_id1=$_POST[account1];
    $amount1=$_POST[examount1];
    
    $description2=$_POST[exdes2];
    $account_id2=$_POST[account2];
    $amount2=$_POST[examount2];
		
		global $loginProject;
		$project=$loginProject;
    
    $total=$_POST[total];    
    $gl_account=$_POST[account];    
    if($_POST[expencess] && $_POST[calculate] && $payment_date && $paid_to && $total){
      $this->push_query_data($payment_date, $voucher_date, $paid_to, $description1, $description2, $gl_account, $project, $for_project, $account_id1, $account_id2, $amount1, $amount2, $total);
    }
//     $_POST[paidAmount];  
//     ============== unused variable
  }
  public function amount_format($amount){
    return number_format($amount,2);
  }
  
  public function push_query_data($payment_date, $voucher_date, $paid_to, $description1, $description2, $gl_account, $project, $for_project, $account_id1, $account_id2, $amount1, $amount2, $total){
    $sql="insert into cash_purchase_temp (payment_date,voucher_date,paid_to,description1,description2,gl_account,project,for_project,account_id1,account_id2,amount1,amount2,total)
    values ('$payment_date', '$voucher_date', '$paid_to', '$description1', '$description2', '$gl_account', '$project', '$for_project', '$account_id1', '$account_id2', '$amount1', '$amount2', '$total')
    ";
// 		echo $sql;
//     exit;    
    $q=mysqli_query($this->db,$sql);     
    if(mysqli_affected_rows($this->db)>0){
      $cash_payment_temp_id=mysqli_insert_id($this->db);
      $this->iow_insert($paid_to."; ".$description1."; ".$description2,$for_project,$payment_date,$cash_payment_temp_id);
      return "Your cash payment is waiting for verification";
    }
  }
	
	
	public function verify_processor(){
		$id=$_GET["id"];
		$activity=$_GET["activity"];
		$activityTxt=$_GET["activityTxt"];
		global $loginDesignation;
// 		echo "!$id || !$activity || !$loginDesignation";
		if(!$id || !$activity || !$loginDesignation)return false;
		echo $this->verify_query_data($id,$loginDesignation,date("Y-m-d"),$activity,$activityTxt);
    exit;
	}
	
  private function verify_query_data($id,$accepted_by,$accepted_date,$activity,$activityTxt=null){
		if($activity=="suspend"){
				$sql="update cash_purchase_temp set accepted='2', accepted_by='$accepted_by', accepted_date='$accepted_date', activityTxt='$activityTxt' where id='$id' and accepted='0'";
				$q2=mysqli_query($this->db,$sql);
				return "Cash payment has been suspended successfully.";
		}
		if($activity=="ins_dtls"){      
        $text_pq=$_GET["text_pq"];
        $sql_pq="insert into cash_purchase_temp_query (cpt_id,text,edate,desig) values ('$id','$text_pq','$accepted_date','$accepted_by')";
        mysqli_query($this->db,$sql_pq);      
      
				$sql="update cash_purchase_temp set accepted='3', accepted_by='$accepted_by', accepted_date='$accepted_date', activityTxt='$activityTxt' where id='$id' and accepted='0'";
				$q2=mysqli_query($this->db,$sql);
				return 3;
		}
			
    $sql="select * from cash_purchase_temp where id='$id' and accepted!='1'";
    $q1=mysqli_query($this->db,$sql);
    $unv_row=mysqli_fetch_array($q1); //unverified row
		if(mysqli_affected_rows($this->db)<1)return;
		
		$paymentSL=generatePaymentSL(2,$unv_row[project],$unv_row[payment_date]);
    
    $iow_info=$this->get_iow_formated_info($row[id],true);
    
    $sql="INSERT INTO `ex130` (exDescription, exgl,examount,paymentSL,exDate,account) values (
    '$unv_row[description1]', '$unv_row[account_id1]', '$unv_row[amount1]', '$paymentSL', '$unv_row[payment_date]', '$unv_row[gl_account]'
    )";
    mysqli_query($this->db,$sql);
//     echo $sql;
		
    $sql="INSERT INTO purchase (paymentSL, paymentDate, paidTo, account, exFor, paidAmount, reff, location)
    values ('$paymentSL', '$unv_row[payment_date]', '$unv_row[paid_to], $iow_info', '$unv_row[gl_account]', '$unv_row[for_project]', '$unv_row[amount1]', '$unv_row[reff]', '$unv_row[project]')
    ";
//     echo $sql;
    mysqli_query($this->db,$sql);
    
    $sql="update cash_purchase_temp set accepted='1', accepted_by='$accepted_by', accepted_date='$accepted_date' where id='$id'";
    $q2=mysqli_query($this->db,$sql);  
    
    $this->iow_update($id);
    
    if(mysqli_affected_rows($this->db)>0)return "Cash payment has been verified successfully.";
  }
	private function redirect($url="/index.php?keyword=cash+payment+approval"){
		
	}
  public function iow_insert($paymentDes,$location,$entryDate,$cash_payment_temp_id){
    if(!$cash_payment_temp_id)return false;
    $iowId_cp=$_POST["iowId_cp"];
    $iow_data=$this->iow_info($iowId_cp);
    $sql="insert into cash_payment_iow (iowId,iowCode,iowDes,paymentDes,location,entryDate,cash_payment_temp_id,cp_status) values ('$iowId_cp','$iow_data[iowCode]','$iow_data[iowDes]','$paymentDes','$location','$entryDate','$cash_payment_temp_id',0)";
    mysqli_query($this->db,$sql);
  }
  public function iow_update($cash_payment_temp_id=null){
    if(!$cash_payment_temp_id)return false;
    $sql="update cash_payment_iow set cp_status='1' where cash_payment_temp_id='$cash_payment_temp_id'";
    mysqli_query($this->db,$sql);
  }
  public function iow_info($iowId_cp){
    $sql="select iowCode,iowDes from iow where iowId='$iowId_cp'";
    $q=mysqli_query($this->db,$sql);
    $row=mysqli_fetch_array($q);
    return array("iowCode"=>$row[iowCode],"iowDes"=>$row[iowDes]);    
  }
  public function get_cash_payment_iow($cash_payment_temp_id){
    $sql="select * from cash_payment_iow where cash_payment_temp_id='$cash_payment_temp_id'";
    $q=mysqli_query($this->db,$sql);
    return mysqli_fetch_array($q);
  }
  public function get_iow_formated_info($cash_payment_temp_id,$plain_text=false){
    $data=$this->get_cash_payment_iow($cash_payment_temp_id);
    if(!$data || !$data[iowCode])return false;
    if($plain_text==true)return "Task: ".$data[iowCode].": ".$data[iowDes]."";
    
    return "<b>Task</b>: <i>".$data[iowCode].": ".$data[iowDes]."</i>";
  }
  public function get_insufficient_text($cash_payment_temp_id){
    $sql="select * from cash_purchase_temp_query where cpt_id='$cash_payment_temp_id' order by id desc limit 1";
    $q=mysqli_query($this->db,$sql);
    while($row[]=mysqli_fetch_array($q)){}
    return $row;   
  }
}
?>
<table class="pending_table" style="
    width:  1000px;
    margin: 50px auto;
    border: 1px solid #999;
    border-collapse: collapse;
">
  <caption><center><h3>
    Pending/Suspended cash payment
    </h3></center></caption>
	<tr>
		<th>Payment Date
      <br>Voucher date
    </th>
		<th>Paid to</th>
		<th>Payment Info.</th>
		<th>GL Account</th>
		<th>Status</th>
    <th>Total</th>
    <?php
    if($loginDesignation!='Site Cashier'){
      echo "<th>Activity</th>";
    }
    ?>
	</tr>
  <?php
  $cpt=new cash_purchase_temp;
	
	if($entry_id && $loginDesignation=="Site Cashier"){
		$cpt->delete_entry($entry_id);
	}	
	elseif($edit_id && $loginDesignation=="Site Cashier"){
		$cpt->edit_entry($edit_id,$text);
	}
	
	
  $cpt->verify_processor();  
  $cpt->expencess_execute(); 
  $cpt->get_query_data();  
	
	if($loginDesignation=="Chairman & Managing Director"){
  	$cpt->designation_group();
	}
  ?>	
</table>
<script>
  $("a.insufficient").click(function(){ 
    var that=$(this);
    var title="<?php if($loginDesignation=="Chairman & Managing Director")echo "MD's Query:";else echo "Manager's Query:"; ?>";
    var text=prompt(title,"");
    that.parent().css("pointer-event","none");
    if(text){
      var that_url=that.attr("href")+"&text_pq="+text;
      $.get(that_url,function(data){if(data){that.parent().html("<font color='#00f'>Insufficient Details Success: "+text+"</font>");}});
      return false;  
    }
    return false;
  });
  $("a.approve_class").click(function(){ 
    var that=$(this);
    var that_tr=$(this).parent().parent();
    that.parent().css("pointer-event","none");
    var that_url=that.attr("href");
    $.get(that_url,function(data){
      if(data){
        that.parent().html("<font color='#00f'>Approved</font>");
        that_tr.css("background","yellow");        
        setTimeout(function(){
          that_tr.fadeOut("slow");
        },1000);
      }
    });
    return false;
  });
</script>