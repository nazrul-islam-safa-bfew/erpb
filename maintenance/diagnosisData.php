<?php
if($submit){
  $eqSqlInsert="insert into diagonosis_info (problemFound,problemFoundTxt,driverID,driverIncident,technicianName,repeatFailure,repeatFailureTxt ,diagonosisPlan,descFailureFindings,casesFailure,correctiveAction,estimatedLifeRepairing) values ('$problemFound','$problemFoundTxt','$driverID','$driverIncident','$technicianName','$repeatFailure','$repeatFailureTxt ','$diagonosisPlan','$descFailureFindings','$casesFailure','$correctiveAction','$estimatedLifeRepairing')";
mysqli_query($db,$eqSqlInsert);
// echo $eqSqlInsert;
  if(mysqli_affected_rows($db)>0){
    echo "<h1>Diagnosis information has been updated.</h1>";
    $_SESSION[diagonosisID]=mysqli_insert_id($db);
  }else{
    echo "<h1>Error while saving diagnosis information.</h1>";
    exit;
  }
}


echo "<form method='post' action=''>
<table align=\"center\" class='dAndT' width=\"800\" border=\"1\" bordercolor=\"#E4E4E4\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse\">
<tr bgcolor=\"#EEEEEE\">
 <th align=\"center\"><b>Diagnosis & Treatment</b></th>
</tr>
<tr><td>
";


echo "Complaint Details:
<select name='problemFound' id='problemFound'>";
foreach(getAllProblemData() as $signleProblem){
  echo "<option value='$signleProblem'>$signleProblem</option>";
}
  echo "<option value='other'>Other</option>";
echo "</select>";
?>
</td>
</tr>
  
<tr>
<td>
Other Complaint Details:
<input type="text" name="problemFoundTxt" id="problemFoundTxt" disabled>
</td>
</tr>

<tr>
<td>

Name of the Operator:
<select name="driverID">
  <?php
  $designation[]='75-50-001%'; // driver
  $designation[]='75-70-006%'; // operator
  $designation[]='75-50-%'; // driver
  $designation[]='80-02-%'; // operator
  $designation[]='80-08-%'; //electician
  $designation[]='80-10-%'; //
  $designation[]='80-15-%'; // plunmber
  $designation[]='80-16-%'; // pump operator
  $designation[]='80-17-%'; // tructor operator
  $designation[]='87-%'; // driver
  $designation[]='81-%';
  $allDriver=getEmployeeByDesignation($designation);
  
  foreach($allDriver as $sDriver){
    echo "<option value='$sDriver[empId]'>".empId($sDriver[empId],$sDriver[designation])." - $sDriver[name], ".hrDesignation($sDriver[designation])."</option>";
  }
?>
</select>
</td>
</tr>
  
<tr>
<td>
Driver's description of the incident:<br>
<textarea name='driverIncident' cols='52'></textarea>
</td>
</tr>

<tr>
<td>
Name of the Technician:
<input type='text' name='technicianName'>
</td>
</tr>



<tr>
<td>
Diagnosis Plan:<br>
<textarea name='diagonosisPlan' cols='52'></textarea>
</td>
</tr>

<tr>
<td>
Complete Description of the Failure/Findings:<br>
<textarea name='descFailureFindings' cols='52'></textarea>
</td>
</tr>

<tr>
<td>
Causes of Failure:<br>
<textarea name='casesFailure' cols='52'></textarea>
</td>
</tr>

<tr>
<td>
Corrective Action Rocommanded:<br>
<textarea name='correctiveAction' cols='52'></textarea>
</td>
</tr>

<tr>
<td>
Estimated Life of Repairing or Servicing:
<input type="number" name='estimatedLifeRepairing' value=""> days
</td>
</tr>

<tr>
<td>
  <input type="submit" value='Save' name='submit'>
</td>
</tr>

</table>
</form>

<style>
  .dAndT textarea{width:99%; min-height:100px;}
  .dAndT input[type="text"]{min-width:200px;}
  .dAndT select{min-width:200px;}
  .dAndT td{padding:10px 0 10px 0;}
  .dAndT tr:nth-child(odd){background:#f4f4f4;}
</style>
<script type="text/javascript">
$(document).ready(function(){
  $("#problemFound").change(function(){
    if(this.value=="other"){
      $("input#problemFoundTxt").prop("disabled",false);      
    }
    else{
      $("input#problemFoundTxt").prop("disabled",true);
    }
  });
  
  
  

  

});
</script>
