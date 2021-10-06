<? 
  if($_SESSION[jQuery]!=1){
    $_SESSION[jQuery]=1;
    header("Refresh:0");
		exit;
  }


include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);  
  if($loginDesignation=="Chairman & Managing Director" && $_GET[apid]){
    $sql="update empsalaryad set amount=amountTmp, amountTmp='' where id=".$_GET[apid];
    mysqli_query($db,$sql);
    if(mysqli_affected_rows($db)>0)echo "<h1>Success</h1>";
    else echo "<h1>Error</h1>";
  }


if($mdsalaryPayment){
  
  
$todat=todat();
$posl=rand(0,99999999);
$pcode=$_GET["pcode"];
function pdfUpload($test,$testTemp,$loc,$qid){
   //echo "Still Here";
	$filemain = "$loc/$qid.$test";
	//echo $filemain.'<br>';
	//echo $test.'<br>';
	//print_r( $testTemp); echo '<br>';	
	if (move_uploaded_file($testTemp, $filemain)) {
	   echo "File is valid, and was successfully uploaded.\n";
	   return $filemain;
	} else {
	   echo "Possible file upload attack!\n";
	   return 0;
	}
}
$path="./salaryAdv";
$todat=todat_new_format("Y-m-d h:i");

  
  
  
	
for($i=1;$i<$n;$i++){
	if(!$_FILES["pdf_".$i]){echo "PDF not found!.";continue;}
  $todat=todat_new_format("Y-m-d h:i");

    $the_pmonth = ${pmonth.$i};
    if($the_pmonth > 11){
        echo "<h1>Payback month must be less than 12 months.</h1>";
        continue;
    }

	if(${approveAmount.$i}>0){
		$sqlp = "INSERT INTO empsalaryad(id,empId,designation,amountTmp,pmonth,paymentSL,pdate,approvedDate,amount,status,approvedby)".
		" VALUES('','${empId.$i}','${designation.$i}','${approveAmount.$i}','${pmonth.$i}','','','$todat','','1','1')";
// 		echo '<br>'.$sqlp.'<br>';
		$sqlq=mysqli_query($db, $sqlp);
    
    $lastID=mysqli_insert_id($db);
    
    
if($_FILES["pdf_".$i])
	$upload=pdfUpload("pdf",$_FILES["pdf_".$i]["tmp_name"],$path,$posl);
if($upload && $lastID){
	 $sql="update empsalaryad set pdf='$upload' where id='$lastID'";
	mysqli_query($db, $sql);
	
	if(mysqli_affected_rows($db)>0)
		echo "<h1>succesful.</h1>";
	else
		echo "<br>Error: ".mysqli_error($db);
	
}
    
    
    
    

	${approveAmount.$i}=0;
	${pmonth.$i}=0;	
    
    
    
    
    
	}//${approveAmount.$i}
}
$mdsalaryPayment=0;
//$mdsalaryPayment=0;
}//mdsalaryPayment
?>

<table   width="800" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
      <form action="" method="post">
        
        <tr>
          <td colspan=2>  
            <h3>
              <center>Advance Salary Payment</center>              
            </h3>
          </td>
        </tr>
        
        <tr>
          <td width="100">    
            Project: 
          </td>
          <td>    
            <select name="pcode">
              <?php
              $sql="select * from project where status=1 order by pcode asc";
              $q=mysqli_query($db,$sql);
              while($row=mysqli_fetch_array($q)){
                echo "<option ".($pcode==$row[pcode] ? " selected " : "")." value='$row[pcode]'>$row[pcode] - $row[pname]</option>";
              }
              ?>
              
            </select>
          </td>
        </tr>
        
<!--         <tr>
          <td>    
            Employee: 
          </td>
          <td> 
            <select>
              <option>Dulal Chandra Das</option>
            </select>
          </td>
        </tr> -->
        
        <tr>
          <td colspan=2>  
            <input type="submit" value="Search">
          </td>
        </tr>
      </form>  
</table>
<br>

<form name="mdsalaryad" action="./index.php?keyword=mdsalary+advance" method="post" enctype="multipart/form-data">
<table   width="800" align="center" border="2" bordercolor="#999999" cellspacing="0" cellpadding="5" style="border-collapse:collapse">
<tr><td colspan="10" align="right">Advance salary</td></tr>
 <tr bgcolor="#EEEEEE">
   <th valign="top" >SL</th>
   <th valign="top"  width="100">EmployeeID,<br> Designation</th>
   <th valign="top" >Employee Name</th>
   <th valign="top" >Working<br> in BFEW</th>  
   <th valign="top" >Salary Amount</th>   
   <th valign="top" >Advance required</th>     
   <th valign="top" >Payback Period (Months) </th> 
   <th valign="top" >Approved Amount</th>    
   <th valign="top" >Attatchment</th>    
   <th valign="top" >Remarks</th>    
 </tr>
 <?
include("./includes/config.inc.php");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
if($loginProject){
$sqlp = "SELECT * from `employee` WHERE salaryType in (/*'Wages Monthly', */'Salary') and designation>'71-01-001' AND status='0' and location='$pcode' order by designation ASC ";
// echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);
//$monthlyWork=monthlyWork($month);
$i=1;
$totalAmount=0;
while($re=mysqli_fetch_array($sqlrunp)){
if($loginDesignation=="Chairman & Managing Director")
  if(!advancePaymentFound($re[empId]))continue;
  
  if(remainAdv($re[empId])>0){
    $lock_val=" disabled ";
  }else{
    $lock_val="";
  }
?>
 <tr <? if($i%2==0) echo 'bgcolor=#FFFFEE';?> >
   <td valign="top" align="center"><? echo $i;?>
    <input type="hidden" name="empId<? echo $i;?>" value="<? echo $re[empId];?>">
    <input type="hidden" name="designation<? echo $i;?>" value="<? echo $re[designation];?>">   
   </td>
   <td valign="top" ><? echo '<font class=out>'.empId($re[empId],$re[designation]).'</font>';
    echo '<br>'.hrDesignation($re[designation]);?> 
   </td>
   <td valign="top" align="left" width="150"><? echo $re[name];?> </td>   
   <td valign="top" align="center"><? $work=workYear($re[empDate]); echo $work.' years';
    if($re[empDate])
     echo "<br>".date("d/m/Y",strtotime($re[empDate]));
     ?></td>
   <td valign="top" align="right"><? echo number_format($re[salary],2);?> </td>   
   <td valign="top" align="right">
		 <? 
  $advancePaid=remainAdv($re[empId]);
	if($advancePaid>0){
    echo number_format($advancePaid,2);
    echo "<br>";
    echo remainAdv_period($re[empId]);
  }
	else{
		$tmpAmount=remainAdvMD($re[empId]);
		if($tmpAmount>0)
			echo number_format($tmpAmount,2);
	}
		 ?>
	 </td>   
   <?php if($loginDesignation!="Chairman & Managing Director"){ ?>
   <td valign="top" align="right"><input type="text" name="pmonth<? echo $i;?>" size="5" maxlength="2" value="<? echo ${pmonth.$i}; ?>" <? echo $lock_val; ?> > </td>   
   <td valign="top" align="right">
      <input type="text" name="approveAmount<? echo $i;?>" alt='cal' size="10" width="10" value="<?  echo ${approveAmount.$i};?>" <? echo $lock_val; ?>> 
   </td>  
   <td valign="top" align="right">
      <input type="file" style='width:90px;' name="pdf_<? echo $i;?>" alt='pdf' size="10" width="10" accept="application/pdf" <? echo $lock_val; ?>> 
   </td>     
    <?php }else{ ?>
   <td valign="top" align="center"><?  echo advancePaymentMonths($re[empId]);?></td>
   <td valign="top" align="right">
     <?  if(advancePaymentFound($re[empId])>0){?>     
     <a href="./index.php?keyword=mdsalary+advance&apid=<?php echo advancePaymentID($re[empId]); ?>" target="_blank" class="approvedBTN">Approved</a>
   <?php }else echo "-"; ?>
     <div class="theBox" style="display:none; background:#fff; border: 1px solid #ccc; position:absolute; left:10%; top:0; width:79%; height:90%;">
       
        <a style="cursor:pointer;color:#fff; background:#525659; display:inline-block; padding:10px; margin:5px;" href="./index.php?keyword=mdsalary+advance&apid=<?php echo advancePaymentID($re[empId]); ?>" >Approved
       </a>
        |  
       
       <div class="closeBTN" style="cursor:pointer;color:#fff; background:#525659; display:inline-block; padding:10px; margin:5px;">Close</div>
       <object type="application/pdf" data="<?  echo advancePaymentPDF($re[empId]);?>" width="100%" height="100%">
        </object>
     </div>
   </td>
      
   <td valign="top" align="center">
     <?  if(advancePaymentPDF($re[empId])){?>
     <a href="<?  echo advancePaymentPDF($re[empId]);?>" target="_blank">Application Scan Copy</a>
     <?php }else echo "-"; ?>
   </td>
     <?php } ?>
   <td valign="top" width=200>
    <textarea name="remarks" style="width:100%; min-height:30px; margin-right:10px;" <? echo $lock_val; ?>  <?php 
  if($loginDesignation=="Chairman & Managing Director"){ ?>
      readonly
  <?php } ?>></textarea>
   </td>
 </tr> 
 <? 
 $totalAmount+= ${approveAmount.$i};

 $i++;} //while?>
  <?php 
  if($loginDesignation!="Chairman & Managing Director") { 
  ?>
  
 <tr>
  <td  align="center" colspan="4"><input type="button" value="calculate" name="calculate" onClick="calc(this.form);"></td>
  <td colspan="4" align="right"> Total Amount:<input type="text" readonly="" name="total" style=" border:0;background: #FFFFCC;text-align:right"></td>
 </tr>
  <input type="hidden" name="n" value="<? echo $i;?>">
  <tr>
    <td colspan="10" align="center">
      <input type="button"  value="<?php echo ($loginDesignation=="Chairman & Managing Director" ? " Approved " : "Forward for approval"); ?>" name="Approved"  onClick="mdsalaryad.mdsalaryPayment.value=1; mdsalaryad.submit();">
      <input type="hidden" value="0" name="mdsalaryPayment">
    </td>
 </tr>
        <?php } ?>
 <? }?>
 </table>
 <input type="hidden" name="n" value="<? echo $i;?>">
</form> 
Note:<br>
<ul>
  <li>No Advance is allowed for employees working less than 1 year.</li>
  <li>For the employees working 1 to 3 years in BFEW the Advance Amount Limit equivalent to 2 months salary and payable in 4 months.</li>
  <li>For the employees working 4 to 6 years in BFEW the Advance Amount Limit equivalent to 4 months salary and payable in 8 months.</li>
  <li>For the employees working above 7 years in BFEW the Advance Amount Limit equivalent to 6 months salary and payable in 11 months.</li>
  <li>Line Managers will recommand Advance Amount to the executives working under them and HR Manager will approve the same.</li>
  <li>Managing Director will appove Advance Amount and Repayment duration (months) for the Directors and Managers.</li>
  <li>Only Managing Director can approve any deviation in Advance Limit and payback period to any employee.</li>
  <li>No Adavnced will be allowed untill complete the repayment of current advance.</li>
  <li>Employee will get 1 months gress period.</li> 
</ul>
<script type="text/javascript">
$(document).ready(function(){
  $(".closeBTN").click(function(){
    $(this).parent().hide();
  });
  $(".approvedBTN").click(function(){
    $(this).next().slideDown();
    return false;
  });
});
</script>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>