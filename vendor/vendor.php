<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS, $SESS_DBNAME);

error_reporting(0);
function myUpload($test,$testTemp,$loc,$qid){
   //echo "Still Here";
	$filemain = "$loc/$qid.$test";
//	echo $filemain.'<br>';
	//echo $test.'<br>';
	//echo $testTemp.'<br>';	
	if (move_uploaded_file($testTemp, $filemain)) {
	   echo "File is valid, and was successfully uploaded.\n";
	   return $filemain;
	} else {
	   echo "Possible file upload attack!\n";
	   return 0;
	}
}
?>
<?

if($saveVendor){
include("./includes/config.inc.php");
	$as="SELECT vname FROM vendor ";
	$bbv = mysqli_query($db, $as);
	//echo $as;

	while($bbval = mysqli_fetch_array($bbv))
	{
		if($bbval[vname]==$vname)
			{
			echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>Please Change your user name </font></p>";
			echo "<b><font face=Verdana size=1><a href=./index.php?keyword=vendor>Back to Previous page</a></font></b><br><br>";
			//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=new+user\">";
			exit();
			}

     }//while ends


if($vname){
	
	
	
	$point= $type + $quality + $orgBehavior + $mngCulture+ $experienceM + $experienceB + $cfacility + $advance;
	
	if($type==-10 || $quality==-10 || $orgBehavior==-10 || $mngCulture==-10 || $experienceM==-10 || $experienceB==-10 || $cfacility==-10 || $advance==-10)
		$point="Disqualified";


    $sql = "INSERT INTO `vendor` (
	`vid`
	, `vname`
	, `address`
	, `contactName`
	, `designation`
	, `mobile`, `accInfo`, `vGL`, `type`, `quality`, `qualityText`, `reliability`, `reliabilityText`, `ManagementCulture`, `ManagementCultureTxt`, `experienceM`, `experienceMText`, `experienceB`, `experienceBText`, `service`, `serviceText`, `advance`, `advanceText`, `cfacility`, `cfacilityText`, `camount`, `cduration`, `datev`, `point`)";
	 $sql.= " VALUES ('', '$vname', '$address', '$contactName', '$designation', '$mobile', '$accInfo', '$vGL','$type', '$quality', '$qualityText', '$reliability', '$reliabilityText', '$mngCulture', '$mngCultureTxt', '$experienceM', '$experienceMText', '$experienceB', '$experienceBText', '$service', '$serviceText', '$advance', '$advanceText', '$cfacility', '$cfacilityText', '$camount', '$cduration', '$todat', '$point')";

	$adduserdb = mysqli_query($db, $sql);
// echo $sql;

    $qid= mysqli_insert_id($db);	
	
    $sql = "INSERT INTO `vendorrating` (
   `id`
   ,`vid`
   ,`quality`
   , `qualityText`
   , `reliability`
   , `reliabilityText`
   , `availability`
   , `availabilityText`
   , `experienceM`
   , `experienceMText`
   , `experienceB`
   , `experienceBText`
   , `service`
   , `serviceText`
   , `advance`
   , `advanceText`
   , `cfacility`
   , `cfacilityText`
   , `camount`
   , `cduration`
   , `datev`
   , `point`
   ,`ratedBy`
   
   ,`ManagementCulture`
   ,`ManagementCultureTxt` 
   ,`OrganizationBehavior`
   ,`OrganizationBehaviorTxt`
   ,`advanceType`
   )";
	 $sql.= " VALUES (
	 ''
	 ,'$qid'
	 , '$vname'
	 , '$address'
	 , '$contactName'
	 , '$designation'
	 , '$mobile'
	 , '$accInfo'
	 , '$vGL'
	 , '$type'
	 , '$quality'
	 , '$qualityText'
	 , '$reliability'
	 , '$reliabilityText'
	 , '$availability'
	 , '$availabilityText'
	 , '$experienceM'
	 , '$experienceMText'
	 , '$experienceB'
	 , '$experienceBText'
	 , '$service'
	 , '$serviceText'
	 , '$advance'
	 , '$advanceText'
	 , '$cfacility'
	 , '$cfacilityText'
	 , '$camount'
	 , '$cduration'
	 , '$todat'
	 , '$point'
	 ,'$ratedBy'
	 
	 ,'$mngCulture'
	 ,'$mngCultureTxt'
	 ,'$orgBehavior'
	 ,'$orgBehaviorTxt'
	 ,'$advanceType'
	 )";
	
	     $sql = "INSERT INTO `vendorrating` (`id`,`vid`,`quality`, `qualityText`, `reliability`, `reliabilityText`, `availability`, `availabilityText`, `experienceM`, `experienceMText`, `experienceB`, `experienceBText`, `service`, `serviceText`, `advance`, `advanceText`, `cfacility`, `cfacilityText`, `camount`, `cduration`, `datev`, `point`,`ratedBy`
	    
   ,`ManagementCulture`
   ,`ManagementCultureTxt` 
   ,`OrganizationBehavior`
   ,`OrganizationBehaviorTxt`
   ,`advanceType`
   
	 )";
	 $sql.= " VALUES ('','$qid', '$quality', '$qualityText', '$reliability', '$reliabilityText', '$availability', '$availabilityText', '$experienceM', '$experienceMText', '$experienceB', '$experienceBText', '$service', '$serviceText', '$advance', '$_POST[advanceText]', '$cfacility', '$_POST[cfacilityText]', '$camount', '$cduration', '$todat', '$point','$ratedBy'
	 ,'$mngCulture'
	 ,'$mngCultureTxt'
	 ,'$orgBehavior'
	 ,'$orgBehaviorTxt'
	 ,'$advanceType'
	 )";
	
// 	echo $sql;
	
	$adduserdb = mysqli_query($db, $sql);
	//print $sql;
	$vrid= mysqli_insert_id($db);
	
$fileName=$_FILES['quoUpload']['name'];
if($fileName)
 {
	$fileTemp=$_FILES['quoUpload']['tmp_name'];
	$uploadFile= myUpload($fileName, $fileTemp, './vendor/attachment', $qid);
	//echo $uploadFile;
	if($uploadFile)
	  { 
	   $sql ="UPDATE `vendor` SET att='$uploadFile' WHERE vid=$qid;UPDATE `vendorrating` SET att='$uploadFile' WHERE id=$vrid;";
	  // echo "<br>$sql";
	   $sqlrunp= mysqli_query($db, $sql);
	   }
  }
}

echo "<div id='msg' style='background:#FFFF99; width:200px;' >Your information has been updated.. Please wait </div>";
echo "<script>setTimeout('removeMsg()',3000);</script>";
//echo $sql;

//echo " <meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=vendor\">";	
}//signup ends


?>
<?
if($vid)
 {
	
$sqlp11 = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlrunp11= mysqli_query($db, $sqlp11);
$vendor= mysqli_fetch_array($sqlrunp11);
	
}
?>
<? if($vid) echo '<form name="ven" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./vendor/vendorupdate.sql.php?vid='.$vid.'" method="post" enctype="multipart/form-data">';
 else echo '<form name="ven" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./index.php?keyword=vendor" method="post" enctype="multipart/form-data">';?>
<table   class="vendorTable" align="center"  width="95%"   >
<tr>
    <td colspan="3" class="vendorAlertHd" >Create New Vendor</td>
</tr>	
<tr>
    <td width="16%"  class="vendorTdl"><LABEL for=vname> Company Name</LABEL></td>
	<td ><input name="vname" type="text" size="50" maxlength="45" value="<? echo $vendor[vname];?>" alt=blank ></td>
	<td width="50%">Accounts Payable account: 
    <input type="text" name="vGL" value="<? echo $vendor[vGL];?>"></td>
</tr>	

<tr>
   <td  class="vendorTdl"><LABEL for=address>Address</LABEL></td> 
<td colspan="2"><input name="address" type="text" size="50" maxlength="100" value="<? echo $vendor[address];?>" alt=blank ></td>
</tr>	
<tr>
 <td  class="vendorTdl"> <LABEL for=contactName>Contact Name</LABEL></td> 
<td colspan="2"><input name="contactName" type="text" size="50" maxlength="100" value="<? echo $vendor[contactName];?>"  alt=blank></td>
</tr>	
<tr>
    <td  class="vendorTdl"> -  Designation</td>
	<td colspan="2"><input name="designation" type="text" size="50" maxlength="100" value="<? echo $vendor[designation];?>" ></td>
</tr>	
<style>
	.radio_group p{ margin:0px;}
</style>
<tr>
    <td class="vendorTdl"> -  Contract Phone No</td> 
	<td colspan="2"><input name="mobile" type="text" size="50" maxlength="100" value="<? echo $vendor[mobile];?>" ></td>
</tr>	
<tr>
    <td  class="vendorTdl"> Accounts Information</td>
	<td colspan="2"><input name="accInfo" type="text" size="50" maxlength="100" value="<? echo $vendor[accInfo];?>" ></td>
</tr>
<tr>
    <td  class="vendorTdl"> Vendor Type</td> 
	  <td width="34%">
	  <div style="margin:5px 0px;" class="radio_group">
	  <p><input type="radio" name="service" value="10" <? if($vendor[service]=='10') echo 'CHECKED';?> onChange="selector6(document.ven,this.value)">
	  National Player: Manufacture/ Importer/ 1st Class national contractor
 (10 Points)</p>
<p>	       <input type="radio" name="service" value="5" <? if($vendor[service]=='5') echo 'CHECKED';?> onChange="selector6(document.ven,this.value)">
Regional Player: Distributor/ Wholeseller/ 2nd class & regional contractor
 (5 points),</p>
<p>		   <input type="radio" name="service" value="0" <? if($vendor[service]=='0') echo 'CHECKED';?> onChange="selector6(document.ven,this.value)">
Local Plyer: Retailer/ Local Vendor/ Local contractor
 (0 points)</p>
<p>			<input type="radio" name="service" value="-10" <? if($vendor[service]=='-10') echo 'CHECKED';?> onChange="selector6(document.ven,this.value)">
Opportunist company/person/lobbyest (<span style="color:red">Disqualified</span>),</p>
</div>
       </td>
	   <td align="left"><input type="text" name="serviceText" id="serviceText" value="<? echo $vendor[serviceText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>


<tr>
    <td  class="vendorTdl"> Local Leadership</td>
	<td width="34%">
	  <div style="margin:5px 0px;" class="radio_group" >

               <p> <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="10" <? if($vendor[quality]=='10') echo 'CHECKED';?>> Leader (10 points)</p>
<p>                 <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="5" <? if($vendor[quality]=='5') echo 'CHECKED';?>>
Challenger (5 points)</p>
       <p>          <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="0" <? if($vendor[quality]=='0') echo 'CHECKED';?>>
       Follower (0 points)</p>
    </div></td>
	<td align="left"><input type="text" name="qualityText" value="<? echo $vendor[qualityText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>




<tr>
    <td  class="vendorTdl"> Management Culture</td>
	<td width="34%">
	  <div style="margin:5px 0px;" class="radio_group">
               <p><input onchange="selector4Cul(document.ven,this.value)" type="radio" name="mngCulture"  value="10" <? if($vendor[ManagementCulture]=='10') echo 'CHECKED';?>> Task Culture (10 points)</p>
							<p><input onchange="selector4Cul(document.ven,this.value)" type="radio" name="mngCulture"  value="5" <? if($vendor[ManagementCulture]=='5') echo 'CHECKED';?>>
Role Culture (5 points)</p>
       				<p><input onchange="selector4Cul(document.ven,this.value)" type="radio" name="mngCulture"  value="0" <? if($vendor[ManagementCulture]=='0') echo 'CHECKED';?>>
       Power Culture (0 points)</p>
    </div></td>
	<td align="left"><input type="text" name="mngCultureTxt" id="mngCultureTxt" value="<? echo $vendor[ManagementCultureTxt];?>" disabled class="disabled" style="width:470px"></td></tr>



<tr>
    <td  class="vendorTdl"> Organization Behavior</td>
	<td width="34%">
	  <div style="margin:5px 0px;" class="radio_group">
               <p><input  onchange="selector2(document.ven,this.value)" type="radio" name="reliability"  value="10" <? if($vendor[reliability]=='10') echo 'CHECKED';?>> Prospect (10 points)</p>
		<p><input  onchange="selector2(document.ven,this.value)" type="radio" name="reliability"  value="5" <? if($vendor[reliability]=='5') echo 'CHECKED';?>>
Analyzer (5 points)</p>
       				 <p><input  onchange="selector2(document.ven,this.value)" type="radio" name="reliability"  value="0" <? if($vendor[reliability]=='0') echo 'CHECKED';?>>
       Defender (0 points)</p>
       				 <p><input  onchange="selector2(document.ven,this.value)" type="radio" name="reliability"  value="0" <? if($vendor[reliability]=='0') echo 'CHECKED';?>>
       Reactor (-5 points)</p>
    </div></td>
	<td align="left"><input type="text" name="reliabilityText" id="reliabilityText" value="<? echo $vendor[reliabilityText];?>" disabled class="disabled"  style="width:470px"></td>	
</tr>



<!--
<tr>
    <td  class="vendorTdl">Quality</td>
	<td>
	
	  <div style="margin:5px 0px;" class="radio_group" >
        <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="10" <? if($vendor[OrganizationBehavior]=='10') echo 'CHECKED';?>>
        Brand items that gives us competiteve advantage (10 points)</p>
        <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="0" <? if($vendor[OrganizationBehavior]=='0') echo 'CHECKED';?>>
        Meet the requirements (0 points)</p>
       <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="-10" <? if($vendor[OrganizationBehavior]=='-10') echo 'CHECKED';?>>
       Donot meet the requirements (<span style="color:red">Disqualified</span>)</p>
      </div></td>
	<td><input type="text" name="orgBehaviorTxt" id="orgBehaviorTxt" value="<? echo $vendor[OrganizationBehaviorTxt];?>" disabled class="disabled"  style="width:470px"></td>
</tr>
 -->




<!-- <tr>
    <td  class="vendorTdl">Resource Availability (Labour force, Materials, Equipments, Working capital, Safety items, Management personnel, Qualification certificate, Local presence, Business connections, Enlistment, etc.)</td>
	<td>
	

	  <div style="margin:5px 0px;" class="radio_group" >
	<p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="10" <? if($vendor[reliability]=='10') echo 'CHECKED';?>>
	Able to meet delivery schedule, able to influence market (10 points)</p>
	   <p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="5" <? if($vendor[reliability]=='5') echo 'CHECKED';?>>
	   Able to meet delivery schedule, able to support contingency events (5 points)</p>
	    <p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="0" <? if($vendor[reliability]=='0') echo 'CHECKED';?>>
	    Able to meet delivery schedule, limited ability to support contingency events (0 points)</p>
                 <p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="-10" <? if($vendor[reliability]=='-10') echo 'CHECKED';?>>
                 No visible assurance of ability to meet delivery schedule (-10 points)</p>
	             
</div>
		
		</td>
	<td><input type="text" name="reliabilityText" value="<? echo $vendor[reliabilityText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>	 -->
<!--<tr>
    <td  class="vendorTdl">Availability</td>
	<td><select name="availability" onchange="selector3(document.ven,document.ven.availability.options[document.ven.availability.selectedIndex].value)" >
                 <option value="0" <? if($vendor[availability]=='0') echo 'SELECTED';?>>Unknown (0 points)</option>
                 <option value="-2" <? if($vendor[availability]=='-2') echo 'SELECTED';?>>Unsatisfactory (-2 points)</option>
                 <option value="3" <? if($vendor[availability]=='3') echo 'SELECTED';?>>Good (3 points)</option>
	             <option value="5" <? if($vendor[availability]=='5') echo 'SELECTED';?>>Outstanding (5 points)</option>
		</select></td>
	<td><input type="text" name="availabilityText" value="<? echo $vendor[availabilityText];?>" disabled class="disabled"  style="width:470px" ></td>
</tr>-->


















	
<tr>
  <td  class="vendorTdl">Similar Experience</td>
	<td>
	  <div style="margin:5px 0px;" class="radio_group" >
        <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="10" <? if($vendor[experienceM]=='10') echo 'CHECKED';?>>
        Above 5 years (10 points)</p>
        <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="5" <? if($vendor[experienceM]=='5') echo 'CHECKED';?>>
        Above 2 years (5 points)</p>
       <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="0" <? if($vendor[experienceM]=='0') echo 'CHECKED';?>>
        Less then 2 year (0 points)</p>
        <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="-10" <? if($vendor[experienceM]=='-10') echo 'CHECKED';?>>
        No Experience (<span style="color:red">Disqualified</span>)</p>
      </div></td>
	<td><input type="text" name="experienceMText" value="<? echo $vendor[experienceMText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>


	
<!-- <tr>
  <td  class="vendorTdl">Alarming Issue</td>
	<td>
<!-- 		<input name="vname" type="text" size="50" maxlength="45" value="" alt="blank">	
	</td>
	<td></td>
</tr> -->
	
	

<tr>
    <td  class="vendorTdl">Experience with BFEW</td>
	<td>
	 <div style="margin:5px 0px;" class="radio_group" >
	
                 	<p><input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="10" <? if($vendor[experienceB]=='10') echo 'CHECKED';?>>
                 	Above 3 years (10 points)</p>
                 	<p><input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="5" <? if($vendor[experienceB]=='5') echo 'CHECKED';?>>
                 	Less then 3 years (5 points)</p>
                 	<p><input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="0" <? if($vendor[experienceB]=='0') echo 'CHECKED';?>>
                 	No Experience (0 points)</p>

		
			              	<input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="-10" <? if($vendor[experienceB]=='-10') echo 'CHECKED';?> id="theValue" title=""/>
			              	Record of quality problem with BFEW in last 10 years (Failed to maintain delivery schedule in terms of quantlty or quality for materials, equipment, work  or labour; BFEW was forced to support the vendor with equipment, materials, labour or working capital to complete the work on time).   
</i> in last 5 years  (<span style="color:red">Disqualified</span>) </p>
	  </div>				  
		</td>
		<script type="text/javascript">
	function theTitle(receiver,switcher){
		vtitle=receiver.checked;
			switcher.disabled=vtitle;
	}
		
		</script>
	<td><input type="text" name="experienceBText" value="<? echo $vendor[experienceMText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>	
<!-- <tr>
    <td  class="vendorTdl">After Sales service</td>
	<td><select name="service" onchange="selector6(document.ven,document.ven.service.options[document.ven.service.selectedIndex].value)" >
                 <option value="0" <? if($vendor[service]=='0') echo 'SELECTED';?>>Unknown (0 points)</option>
                 <option value="-2" <? if($vendor[service]=='-2') echo 'SELECTED';?>>Unsatisfactory (-2 points)</option>
                 <option value="3" <? if($vendor[service]=='3') echo 'SELECTED';?>>Good (3 points)</option>
	             <option value="5" <? if($vendor[service]=='5') echo 'SELECTED';?>>Outstanding (5 points)</option>
		</select></td>
	<td><input type="text" name="serviceText" value="<? echo $vendor[serviceText];?>" disabled class="disabled"  style="width:470px" ></td>
</tr>	 -->
<tr>
  <td  class="vendorTdl"> Attachment Hard Copy</td>  
  <td> <input type="file" id="pdf_file" name="quoUpload"></td> 
</tr>
<tr>
 <td class="vendorTdl">Certified By</td>
  <td>
   <select name="ratedBy" size="1"> 
<? 

//if($loginProject=='000')
 $sql=@mysqli_query($db, "SELECT * FROM employee WHERE (salaryType='Salary' OR salaryType='Salaried' OR salaryType='Consolidated' )  ORDER by designation") or die('Please try later!!');
//else $sql=@mysqli_query($db, "SELECT * FROM employee WHERE salaryType='Salary' AND location='$loginProject' ORDER by designation") or die('Please try later!!');
 while($typel= mysqli_fetch_array($sql)){

 $plist.= "<option value='".$typel[empId]."'";
 if($empId==$typel[empId]) $plist.=" SELECTED ";
 $plist.= ">".empId($typel[empId],$typel[designation])."--$typel[name]</option>  ";
 }
 echo $plist;
?>
</select>
</td>
</tr>
<tr>
    <td  colspan="3" align="center"> <input type="submit" value="Save" name="saveVendor" class="vendor" onMouseOver="this.className='vendorhov'" onMouseOut="this.className='vendor'" onclick="if(checkThisOut()==0)return false;"></td>
</tr>	
<script type="text/javascript">
function checkThisOut(){
pdf_file=document.getElementById("pdf_file");
file_name=pdf_file.value;
if(file_name){
file_ext=file_name.split(".").pop();
	if(file_ext!="pdf"){
		alert("Please attatch pdf file!");
		return 0;
	}
}
else{
alert("Please attatch pdf file!");
return 0;
}
    var theVendor;
    theVendor={
        qualityText:document.ven.qualityText,
        reliabilityText:document.ven.reliabilityText,
        availabilityText:document.ven.availabilityText,
        experienceMText:document.ven.experienceMText,
        experienceBText:document.ven.experienceBText,
        serviceText:document.ven.serviceText,
        advanceText:document.ven.advanceText
        
    };
}
</script>
</table>
</form>