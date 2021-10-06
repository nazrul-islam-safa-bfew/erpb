<?php
error_reporting(1);

function check_competition($pid,$all_com){
	global $db;
	global $compay_id_sql;
       $com_sql="select * from cbp where cp_name='$all_com' and pid='$pid'  $compay_id_sql";
       $com_q=mysqli_query($db, $com_sql);
       if(mysqli_affected_rows($db)>0)
            return mysqli_affected_rows($db);
        else
            return 0;
}
?>
<?
function check_behavior($pid,$all_beh){
	global $db;
	global $compay_id_sql;
       $beh_sql="select * from cbp where org_behavior='$all_beh' and pid='$pid' $compay_id_sql";
       $beh_q=mysqli_query($db, $beh_sql);
       if(mysqli_affected_rows($db)>0)
            return mysqli_affected_rows($db);
        else
            return 0;
}
?>
<?
function check_management($pid,$all_man){
	global $db;
	global $compay_id_sql;
       $man_sql="select * from cbp where org_culture='$all_man' and pid='$pid' $compay_id_sql";
       $man_q=mysqli_query($db, $man_sql);
       if(mysqli_affected_rows($db)>0)
            return mysqli_affected_rows($db);
        else
            return 0;
}
?>
<?


	$sql="select * from agenda $compay_id_sql";
	if($a_loginDesignation =="Marketing Executive"){
		$q=unameToAgenda4ME($a_loginUname); // for only me
		$me_agenda=me_agenda_area_info($a_loginUid);
	}else
		$q=unameToAgenda($a_loginUname); //for bdm & others
	$ag_row=mysqli_fetch_array($q);$agenda_id=$ag_row[id];


function check_lifecycle_position($pid,$all_lp){
	   global $db;
	   global $compay_id_sql;
       $lp_sql="select * from cbp where clp_name='$all_lp' and pid='$pid' $compay_id_sql";
       $lp_q=mysqli_query($db, $lp_sql);
       if(mysqli_affected_rows($db)>0)
            return mysqli_affected_rows($db);
        else
            return 0;
}


?>


<SCRIPT LANGUAGE="JavaScript" SRC="js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<script language="JavaScript">
    var now = new Date();
    var cal = new CalendarPopup("testdiv1");
    cal.setWeekStartDay(6); // week is Monday - Sunday
    cal.setCssPrefix("TEST");
    cal.offsetX = 0;
    cal.offsetY = 0;
</script>

		<script language="JavaScript">
        var now = new Date();
        var cal = new CalendarPopup("testdiv1");
        //cal.showNavigationDropdowns();
       // cal.setWeekStartDay(6); // week is Monday - Sunday
       //cal.addDisabledDates(null,formatDate(now,"MM/dd/yyyy"));
      // al.setCssPrefix("TEST");
        //cal.offsetX = 25;
       // .offsetY = -120;
        </script>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".the_print_option").mouseover(function(){
		$(this).find("td input.org_btn").show();
	}).mouseout(function(){	
		$(this).find("td input.org_btn").hide();		
	}).next("tr").mouseover(function(){
		$(this).prev().trigger("mouseover");
	}).mouseout(function(){
		$(this).prev().trigger("mouseout");		
	});
	
	$("input.print_btn").click(function(){
		if($(this).attr("title")=="District"){
			dis_tiriger_print=$(this).attr("rel");
			ppc_tiriger_print="";
		}
		
		if($(this).attr("title")=="Postal Code"){
			dis_tiriger_print="";
			ppc_tiriger_print=$(this).attr("rel");
		}
		
		the_user_id="<?php echo $a_loginUid; ?>";
		type="<?php echo $_GET["type2"]; ?>";
		if(dis_tiriger_print || ppc_tiriger_print){
			window.open("print_address_single.php?user="+the_user_id+"&dis="+dis_tiriger_print+"&ppc="+ppc_tiriger_print+"&type="+type);
		}
	});
	
	$("input.org_btn").click(function(){
		org_map_id=$(this).attr("rel");
		if(org_map_id){
			url_hole_location=window.location.href;
			window.location=url_hole_location+"&org_map_id="+org_map_id;
		}
	});
	
	<?php if($org_map_id=$_GET["org_map_id"]){ ?>
	
	$('body, html').animate({scrollTop:$('#tt_<?php echo $org_map_id; ?>').offset().top});
		
	
	<?php } ?>
	 
	
});
</script>

		
<style>
	.the_print_option{border-top: 1px solid #fff;}
.the_print_option:hover{ animation-name:tr_tr; animation-duration:1s;  border-top: 1px solid #CECECE; }
	
	
.print_btn{ float:right; height: 20px; font-size: 10px;}
.org_btn{ margin-left:90%; position:absolute; display:none;}
	
@keyframes tr_tr{
	from{border-top: 1px solid #fff; }
	to{border-top: 1px solid #CECECE;}
}
	
	
	
.colorBlue{color:#00F; font-weight:bold; font-size:12px;}
.colorRed{ color:#F00;} 
.x2strong{ text-transform:uppercase; font-style:uppercase;}
	
.normalFont{ font-size:12px; margin:0px 0px 0px 0px;}

.center_org_map{
	margin:auto;}

div.opinionleader {

 text-align:left;
 margin:0px auto;
 color:#f00;
 background-color:#85DBFF;
 float: left;
 FONT-SIZE: 11px; FONT-FAMILY:Verdana, Helvetica,Arial, sans-serif; COLOR:#000000; 
 border:2px solid;
 border-color:#FFFFFF;
}
	
div.approver {
 text-align:left;
 margin:0px auto;
 color:#f00;
 background-color:#EAD5FF;
 float: left;
 FONT-SIZE: 11px; FONT-FAMILY:Verdana, Helvetica,Arial, sans-serif; COLOR:#000000; 
 border:2px solid;
 border-color:#FFFFFF;
}

div.decisionMaker {
 text-align:left;
 margin:0px auto;
 color:#f00;
 background-color:#DADADA;
 float: left;
 FONT-SIZE: 11px; FONT-FAMILY:Verdana, Helvetica,Arial, sans-serif; COLOR:#000000;
 border:2px solid;
 border-color:#FFFFFF;
}

div.evaluator {
 text-align:left;
 margin:0px auto;
 color:#f00;
 background-color:#D8D8AF;
 float: left;
 FONT-SIZE: 11px; FONT-FAMILY:Verdana, Helvetica,Arial, sans-serif; COLOR:#000000; 
 border:2px solid;
 border-color:#FFFFFF;
 }

div.user {
 text-align:left;
 margin:0px auto;
 color:#f00;
 background-color:#66CC99;
 float: left;
 FONT-SIZE: 11px; FONT-FAMILY:Verdana, Helvetica,Arial, sans-serif; COLOR:#000000; 
 border:2px solid;
 border-color:#FFFFFF;
}
div.lobbyist {
 text-align:left;
 margin:0px auto;
 color:#f00;
 background-color:#85DBF0;
 float: left;
 FONT-SIZE: 11px; FONT-FAMILY:Verdana, Helvetica,Arial, sans-serif; COLOR:#000000; 
 border:2px solid;
 border-color:#FFFFFF;
}
div.blank {
float: left;
width:3;
height:1;

}
.bprime{
font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; color:#FF0000
}
.rl {text-align:right; }
.jj {
background: #EDEDED;
color: black;
border: 2px outset white;
}
.style11 {color: #CC3300; font-weight: bold; }
.style13 {color: #77773C;}


</style>





<script>
function call_record(cr_pid,cr_repid,cr_uid,cr_number) {
    var w=700;
    var h=300;
    var scroll='yes';
    var mypage='./project/call_record.php?cr_pid='+cr_pid+'&cr_repid='+cr_repid+'&cr_uid='+cr_uid+'&cr_number='+cr_number;
    var winl = (screen.width - w) / 2;
    var wint = (screen.height - h) / 2;
    winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
    win = window.open(mypage, 'myname', winprops)
    if (parseInt(navigator.appVersion) >= 4) { win.window.focus();}
}
</script>

<?
$userId=$_SESSION["a_loginUid"];


function address_counter($typeId,$userId){
	global $db;
	global $compay_id_sql;
    mysqli_query($db, "select * from marketing_address where typeId='$typeId' and userId='$userId' $compay_id_sql");
    return mysqli_affected_rows($db);
}



function is_address_accessable($typeId,$userId){
	global $db;
	global $compay_id_sql;
$psl=me_se_to_product_service_line($userId);
me_se_product_line_to_prospect_type($psl["agendaID"]);
return ;
}

function get_me_se_prospect_type($userId){
	global $db;
	global $compay_id_sql;
	$psl=me_se_to_product_service_line($userId);
	$row=me_se_product_line_to_prospect_type($psl["agendaID"]);
	return $row;
}

function is_address_accessable_for_bdm($typeId,$userId){
	global $db;
	global $compay_id_sql;
	global $a_company_id;
	//mysqli_query($db, "select marketing_address.* from marketing_address where marketing_address.typeId='$typeId' and marketing_address.userId=(select roof_bdm from user where id='$userId')");	 // for roof bdm access
	//echo "select ma.* from marketing_address as ma where ma.typeId='$typeId' and ma.userId in (select id from user where bdmid='$userId') ";
	mysqli_query($db, "select ma.* from marketing_address as ma where ma.typeId='$typeId' and ma.userId in (select id from user where bdmid='$userId') and ma.company_id='$a_company_id'");	//access for bdm
    return mysqli_affected_rows($db);
}


if($_POST['submit']=="Save")
{
$edate = date("Y-m-d", strtotime($_POST['edate']));
//$edate=date("Y-m-d");
$activity=$_POST['activity'];
$ptype=$_POST['ptype'];
$amount=$_POST['amount'];
$repname=$_POST['repname'];
$agenda_type=$_POST['agenda_type'];

$the_user_query=mysqli_query($db, "select fullName from user where id='$a_loginUid' $compay_id_sql");
$the_row_fullname=mysqli_fetch_array($the_user_query);

$fullname=$the_row_fullname[fullName];



$q="insert into new_prime_activity(pid,uid,repname,probability,edate,activity,ptype,amount,agenda_type,fullname,company_id) values($id,'$a_loginUid','$repname','$probability','$edate','$activity','$ptype','$amount','$agenda_type','$fullname','$a_company_id')";
	mysqli_query($db, $q);
	$r=mysqli_affected_rows($db);
	if($r>0)
	echo "Data added successfully";
}







/*




////////////////// for personal phone number with link . it was situated after cell for every single persons
 for($pi=0;$pi<=sizeof($re2[repphone]);$pi++){
                        ?>
                        <a  href="#" onclick="call_record(<? echo $re[id];?>,<? echo $re2[id];?>,<? echo $_SESSION[a_loginUid];?>,'<? echo $contact_no[$pi];?>');">
                        <? echo $contact_no[$pi];?></a>,
                    <? }//for
*/
//project main
//include('./includes/project.inc');
$eproject = $_POST['eproject'];
$c = $_GET['c'];
$p = $_GET['p'];
$mm_id = $_REQUEST['mm_id'];
$type2 = $_REQUEST['type2'];
$id = $_GET['id'];
//$repid = $_REQUEST['repid'];
$repid = $_GET['repid'];
$repname = mysqli_real_escape_string($db, $_POST['repname']);
$repdesignation = mysqli_real_escape_string($db, $_POST['repdesignation']);
$buyingRole=mysqli_real_escape_string($db, $_POST['buyingRole']);
$edate=date("Y-m-d");


$bir_date = date("Y-m-d", strtotime($_POST['bir_date']));
$marriage_date = date("Y-m-d", strtotime($_POST['marriage_date']));

$personal_details=$_POST['personal_details'];
$repaddress1 = mysqli_real_escape_string($db, $_POST['repaddress1']);
$repaddress2 = mysqli_real_escape_string($db, $_POST['repaddress2']);
$repcity = mysqli_real_escape_string($db, $_POST['repcity']);
$reppcode = mysqli_real_escape_string($db, $_POST['reppcode']);
$repphone = mysqli_real_escape_string($db, $_POST['repphone']);
$reptelno = mysqli_real_escape_string($db, $_POST['reptelno']);
$repfax = mysqli_real_escape_string($db, $_POST['repfax']);
$repemail = mysqli_real_escape_string($db, $_POST['repemail']);
$nationid_no=$_POST['nationid_no'];
$pid=$_REQUEST['pid'];
$pname=mysqli_real_escape_string($db, $_POST['pname']);
$project_name=mysqli_real_escape_string($db, $_POST['project_name']);
$behaviour=mysqli_real_escape_string($db, $_POST['behaviour']);
$des=$_POST['des'];
$paddress1=mysqli_real_escape_string($db, $_POST['paddress1']);
$paddress2=mysqli_real_escape_string($db, $_POST['paddress2']);
$pdiv=mysqli_real_escape_string($db, $_POST['pdiv']);
$pcity=mysqli_real_escape_string($db, $_POST['pcity']);
$ppcode=mysqli_real_escape_string($db, $_POST['ppcode']);
$pphone=mysqli_real_escape_string($db, $_POST['pphone']);
$pphone=mysqli_real_escape_string($db, $_POST['pphone']);
$pfax=mysqli_real_escape_string($db, $_POST['pfax']);
$pemail=mysqli_real_escape_string($db, $_POST['pemail']);
$purl=mysqli_real_escape_string($db, $_POST['purl']);
$type=mysqli_real_escape_string($db, $_POST['type']);




if($_FILES["fileToUpload"]["name"]){
	$target_dir = "profile_picture/".rand(11111,999999)."_";
	$image_name = $target_dir . $_FILES["fileToUpload"]["name"];


$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }
}


}

/////////////////////////////////////////////////////////////////////
if($linker_person & $eproject){
$root_person_info=find_root_person($repid);
$new_adpChange=implode(",",$new_adpChange);
$old_person_sql="update repname set	
										repname='$new_repname',
										nationid_no='$new_nationid_no',
										bir_date='$new_bir_date',
										marriage_date='$new_marriage_date',
										personal_details='$new_personal_details',
										adpChange='$new_adpChange',
										relation='$new_relation'
										"; 
	if($image_name)
    $old_person_sql.=", image='$image_name' ";

		$old_person_sql.="where id='$linker_person' $compay_id_sql";
	
	//echo $old_person_sql.="where id='$root_person_info[link_up_other]' ";
	
	$old_person_q=mysqli_query($db, $old_person_sql);
	
	
		$new_relation_sql="update repname set	
	repdesignation='$repdesignation',
	buyingRole='$buyingRole',
	repphone='$repphone',
	reptelno='$reptelno',
	repemail='$repemail',
	political='$political' 
	where id='$repid'  $compay_id_sql";
	$new_relation_q=mysqli_query($db, $new_relation_sql);
   	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./$_SESSION[path]?keyword=selected_address_enter_activity#$pid\">";	
	exit;
}

if($eproject AND $c==1){
    $sqlp = "UPDATE `project` SET pname='$pname',`paddress1` ='$paddress1',paddress2='$paddress2',
    pdiv='$pdiv',pcity='$pcity',ppcode='$ppcode',pphone='$pphone',pfax='$pfax',pemail='$pemail',purl='$purl',type='$type' WHERE id=$pid  $compay_id_sql";
//    echo "$sqlp<br>"; exit;
    $sqlrunp= mysqli_query($db, $sqlp);
	
	 /*$sqlq2="SELECT  * from cbp where pid='$pid' ";
	$sqlr2=mysqli_query($db, $sqlq2);
	$num=mysqli_num_rows($sqlr2);
	//$res2=mysqli_fetch_array($sqlr2);
	if($num>0)
	 $sqlcbp="UPDATE cbp set des='$des' WHERE pid='$pid'";
	else
	 $sqlcbp="INSERT INTO cbp(id,pid,uid,des,revenue,profit,fyearend,corAff) VALUES ('','$pid','$a_loginUid','$des','','','','')";
 	mysqli_query($db, $sqlcbp); stop by salma*/
		
    echo "Updating..<br>";
   	echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./$_SESSION[path]?keyword=selected_address_enter_activity#tt_$pid\">";
    exit;
}




if(($eproject) AND ($p==1)) {
    if(($repid) and ($repname!='') or ($linker_person)){


foreach($adpChange as $adpC){
	if($a)
		$a=$adpC.",".$a;
	else
		$a=$adpC;
}
$adpChange=$a;



if($image_name)
  $sql="UPDATE repname set repName='$repname',repdesignation='$repdesignation',nationid_no='$nationid_no',bir_date='$bir_date',image='$image_name', marriage_date='$marriage_date',personal_details='$personal_details',buyingRole='$buyingRole',repphone='$repphone',
        reptelno='$reptelno',repemail='$repemail',adpChange='$adpChange',relation='$relation',political='$political' where id='$repid'  $compay_id_sql";
else
 $sql="UPDATE repname set repName='$repname',repdesignation='$repdesignation',nationid_no='$nationid_no',bir_date='$bir_date',marriage_date='$marriage_date',personal_details='$personal_details',buyingRole='$buyingRole',repphone='$repphone',
        reptelno='$reptelno',repemail='$repemail',adpChange='$adpChange',relation='$relation',political='$political' where id='$repid'  $compay_id_sql";
         mysqli_query($db, $sql);
         echo "Updating..<br>";
        echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./$_SESSION[path]?keyword=selected_address_enter_activity#tt_$pid\">";
         exit;
    }
		if($repname=='' & !$linker_person)
		{
		$sql="delete  from repname where id='$repid'  $compay_id_sql";
		 mysqli_query($db, $sql);
		echo "Deleting..<br>";
			 echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./$_SESSION[path]?keyword=selected_address_enter_activity#tt_$pid\">";
			 exit;
		}
    else {
       
	 
	    $sql="INSERT INTO repname(id,pid,repName,repdesignation,nationid_no,bir_date,marriage_date,image,personal_details,buyingRole,repaddress1,repaddress2,repcity,reppcode,repphone,reptelno,repfax,repemail,adpChange,relation,political,company_id)
         VALUES ('','$pid','$repname','$repdesignation','$nationid_no','$bir_date','$marriage_date','$target_file','$personal_details','$buyingRole','','','','','$repphone','$reptelno','','$repemail','$adpChange','$relation','$political','$a_company_id')";
        //echo "$sql<br>";

	         $new_person_flag=mysqli_query($db, $sql);
        print $ro=mysqli_affected_rows($db,$new_person_flag);
        echo "Data Insert successfully.";
      echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./$_SESSION[path]?keyword=selected_address_enter_activity#tt_$pid\">";
         exit;
    }
}

if($c==1){
    $sqlp = "SELECT * FROM `project` WHERE `id` = '$id' $compay_id_sql";
    //echo $sqlp;
    $sqlrunp= mysqli_query($db, $sqlp);
    $re=mysqli_fetch_array($sqlrunp);
	$_SESSION['a_loginProject']=$re[id];
	 
	$sql2="SELECT  * from cbp where pid='$id' ";
		$sqlq2=mysqli_query($db, $sql2);
			$re2=mysqli_fetch_array($sqlq2);
	$sqlt="select uproducttype from project where uproducttype <>'' $compay_id_sql";
		$sqlqt=mysqli_query($db, $sqlt);
            while($rt=mysqli_fetch_array($sqlqt))
			{
                print $rp=$rt[uproducttype];
            }
			  $pi = explode(",",$rp);
	
	
	/////////////////////////////////////////////////////////////////////////////////Search Form///////////////////////////////////////
	
	
	
    ?>
    <form name="createProject" action="./<?= $_SESSION["path"] ?>?keyword=selected_address_enter_activity&c=1&pid=<? echo $re[id];?>"  method="post">
	<table width="90%">
	<tr><td width="45%" valign="top">
    <div style="width:500px; margin:0 auto">
    <div id="fgeneral" class="boxed">
        <h4 class="title"> Prospects</h4>
        <div class="content">
            <label for="inputtext1">Prospect Name:</label>
            <input id="inputtext1" type="text" name="pname" value="<? echo $re["pname"];?>"  style="width:300px" ><br>
			<!--<label for="inputtext1">Business Profile:</label>      
            <textarea  name="des" cols="22" rows="5"><? 
			echo $re2['des']; ?></textarea><br>-->
          <!--  <label for="inputtext1">Prospect Type</label> 
            <select name="producttype[]" multiple="multiple" style="width:195px">
		<option value="0">Select Type</option>
        <?
		 $sqlp = "SELECT * FROM categorie where cat_type!='2' order by cat_des $compay_id_sql";   
		$sqlrunp= mysqli_query($db, $sqlp);
        while($typel= mysqli_fetch_array($sqlrunp))
		{
			
		         $productListManager.="<option value='".$typel[cat_id]."'";
                foreach($pi as $d2){
                    if($d2 == $typel[cat_id]) $productListManager.= "SELECTED";
                }
               
                $productListManager.= ">$typel[cat_des]</option>  ";
           }//while end
           
			  echo $productListManager;
		?>
		</select><br />    -->
            <label for="inputtext1">Address 1</label>
            <input id="inputtext1" type="text" name="paddress1" value="<? echo $re[paddress1];?>"  style="width:300px" ><br>
            <label for="inputtext1">Address 2</label>
            <input id="inputtext1" type="text" name="paddress2" value="<? echo $re[paddress2];?>"  style="width:300px" ><br>
            <label for="inputtext1">Division:</label>
			<select id="inputtext3" name="pdiv">
				
				<? 
				$sqlp = "SELECT * FROM `division` order by div_des ASC";
				
				//echo $sqlp;
				$sqlrunp= mysqli_query($db, $sqlp);				
				while($re1=mysqli_fetch_array($sqlrunp)){?>					
				<option value='<? echo $re1[div_id];?>'
				<? 
				//if($re[type])$type=$re[type];
				if($sqlr[pdiv]==$re1[div_id]) echo ' selected ' ;?>><? echo $re1[div_des];?></option>		
				<? }//while ?>		
			</select><br>
            <label for="inputtext1">City</label>
            <select name="pcity">
                <option <?php if($re[pcity]=='-1') echo 'selected';?> value='-1'>Select</option>
                <option <?php if($re[pcity]=='1') echo 'selected';?> value='1'>B. Baria</option>
                <option <?php if($re[pcity]=='2') echo 'selected';?> value='2'>Bagerhat</option>
                <option <?php if($re[pcity]=='3') echo 'selected';?> value='3'>Bandarban</option>
                <option <?php if($re[pcity]=='4') echo 'selected';?> value='4'>Barisal</option>
                <option <?php if($re[pcity]=='5') echo 'selected';?> value='5'>Bhola</option>
                <option <?php if($re[pcity]=='6') echo 'selected';?> value='6'>Bogra</option>
                <option <?php if($re[pcity]=='7') echo 'selected';?> value='7'>Borguna</option>
                <option <?php if($re[pcity]=='8') echo 'selected';?> value='8'>Chandpur</option>
                <option <?php if($re[pcity]=='9') echo 'selected';?> value='9'>Chapainawabganj</option>
                <option <?php if($re[pcity]=='10') echo 'selected';?> value='10'>Chittagong</option>
                <option <?php if($re[pcity]=='11') echo 'selected';?> value='11'>Chuadanga</option>
                <option <?php if($re[pcity]=='12') echo 'selected';?> value='12'>Comilla</option>
                <option <?php if($re[pcity]=='13') echo 'selected';?> value='13'>Cox's Bazar</option>
                <option <?php if($re[pcity]=='14') echo 'selected';?> value='14'>Dhaka</option>
                <option <?php if($re[pcity]=='15') echo 'selected';?> value='15'>Dinajpur</option>
                <option <?php if($re[pcity]=='16') echo 'selected';?> value='16'>Faridpur</option>
                <option <?php if($re[pcity]=='17') echo 'selected';?> value='17'>Feni</option>
                <option <?php if($re[pcity]=='18') echo 'selected';?> value='18'>Gaibandha</option>
                <option <?php if($re[pcity]=='19') echo 'selected';?> value='19'>Gazipur</option>
                <option <?php if($re[pcity]=='20') echo 'selected';?> value='20'>Gopalgonj</option>
                <option <?php if($re[pcity]=='21') echo 'selected';?> value='21'>Hobigonj</option>
                <option <?php if($re[pcity]=='22') echo 'selected';?> value='22'>Jamalpur</option>
                <option <?php if($re[pcity]=='23') echo 'selected';?> value='23'>Jessore</option>
                <option <?php if($re[pcity]=='24') echo 'selected';?> value='24'>Jhalokathi</option>
                <option <?php if($re[pcity]=='25') echo 'selected';?> value='25'>Jhenaidah</option>
                <option <?php if($re[pcity]=='26') echo 'selected';?> value='26'>Joypurhat</option>
                <option <?php if($re[pcity]=='27') echo 'selected';?> value='27'>Khagrachari</option>
                <option <?php if($re[pcity]=='28') echo 'selected';?> value='28'>Khulna</option>
                <option <?php if($re[pcity]=='29') echo 'selected';?> value='29'>Kishorgonj</option>
                <option <?php if($re[pcity]=='30') echo 'selected';?> value='30'>Kurigram</option>
                <option <?php if($re[pcity]=='31') echo 'selected';?> value='31'>Kushtia</option>
                <option <?php if($re[pcity]=='32') echo 'selected';?> value='32'>Lalmonirhat</option>
                <option <?php if($re[pcity]=='33') echo 'selected';?> value='33'>Laxmipur</option>
                <option <?php if($re[pcity]=='34') echo 'selected';?> value='34'>Madaripur</option>
                <option <?php if($re[pcity]=='35') echo 'selected';?> value='35'>Magura</option>
                <option <?php if($re[pcity]=='36') echo 'selected';?> value='36'>Manikgonj</option>
                <option <?php if($re[pcity]=='37') echo 'selected';?> value='37'>Meherpur</option>
                <option <?php if($re[pcity]=='38') echo 'selected';?> value='38'>MoulaviBazar</option>
                <option <?php if($re[pcity]=='39') echo 'selected';?> value='39'>Munshigonj</option>
                <option <?php if($re[pcity]=='40') echo 'selected';?> value='40'>Mymensingh</option>
                <option <?php if($re[pcity]=='41') echo 'selected';?> value='41'>Naogaon</option>
                <option <?php if($re[pcity]=='42') echo 'selected';?> value='42'>Narail</option>
                <option <?php if($re[pcity]=='43') echo 'selected';?> value='43'>Narayangonj</option>
                <option <?php if($re[pcity]=='44') echo 'selected';?> value='44'>Narshingdi</option>
                <option <?php if($re[pcity]=='45') echo 'selected';?> value='45'>Natore</option>
                <option <?php if($re[pcity]=='46') echo 'selected';?> value='46'>Netrokona</option>
                <option <?php if($re[pcity]=='47') echo 'selected';?> value='47'>Nilphamari</option>
                <option <?php if($re[pcity]=='48') echo 'selected';?> value='48'>Noakhali</option>
                <option <?php if($re[pcity]=='49') echo 'selected';?> value='49'>Pabna</option>
                <option <?php if($re[pcity]=='50') echo 'selected';?> value='50'>Panchagahr</option>
                <option <?php if($re[pcity]=='51') echo 'selected';?> value='51'>Patuakhali</option>
                <option <?php if($re[pcity]=='52') echo 'selected';?> value='52'>Pirojpur</option>
                <option <?php if($re[pcity]=='53') echo 'selected';?> value='53'>Rajbari</option>
                <option <?php if($re[pcity]=='54') echo 'selected';?> value='54'>Rajshahi</option>
                <option <?php if($re[pcity]=='55') echo 'selected';?> value='55'>Rangamati</option>
                <option <?php if($re[pcity]=='56') echo 'selected';?> value='56'>Rangpur</option>
                <option <?php if($re[pcity]=='57') echo 'selected';?> value='57'>Satkhira</option>
                <option <?php if($re[pcity]=='58') echo 'selected';?> value='58'>Shariatpur</option>
                <option <?php if($re[pcity]=='59') echo 'selected';?> value='59'>Sherpur</option>
                <option <?php if($re[pcity]=='60') echo 'selected';?> value='60'>Sirajgonj</option>
                <option <?php if($re[pcity]=='61') echo 'selected';?> value='61'>Sunamgonj</option>
                <option <?php if($re[pcity]=='62') echo 'selected';?> value='62'>Sylhet</option>
                <option <?php if($re[pcity]=='63') echo 'selected';?> value='63'>Tangail</option>
                <option <?php if($re[pcity]=='64') echo 'selected';?> value='64'>Thakurgaon</option>

            </select><br>
            <label for="inputtext1">Postal Code</label>
            <input id="inputtext1" type="text" name="ppcode" value="<? echo $re[ppcode];?>"  style="width:300px" ><br>
            <label for="inputtext1">Phone</label>
            <input id="inputtext1" type="text" name="pphone" value="<? echo $re[pphone];?>"  style="width:300px" ><br>
            <label for="inputtext1">Fax</label>
            <input id="inputtext1" type="text" name="pfax" value="<? echo $re[pfax];?>"  style="width:300px" ><br>
            <label for="inputtext1">Email</label>
            <input id="inputtext1" type="text" name="pemail" value="<? echo $re[pemail];?>"  style="width:300px" ><br>
            <label for="inputtext1">Url</label>
            <input id="inputtext1" type="text" name="purl" value="<? echo $re[purl];?>"  style="width:300px" ><br>
<!--            <label for="inputtext2">User: </label>
            <select id="inputtext2" name="userId">
            <option value='1' <? //if($re[userId]==1) echo ' selected ';?>>Not Assign</option>
            <?php
//            $sqlp = "SELECT * FROM `user` WHERE id>1";
            //echo $sqlp;
//            $sqlrunp= mysqli_query($db, $sqlp);
//            while($re1=mysqli_fetch_array($sqlrunp)){?>
            <option value='<? //echo $re1[id];?>'
            <? //if($re1[id]==$re[userId]) echo ' selected ';?>><? //echo $re1[uname];?> <? //echo '-'.userProject($re1[id]);?></option>
            <? //}//while ?>
            </select><br />-->
            <label for="inputtext3">Type</label>
            <select id="inputtext3" name="type">
            <?
          echo  $sqlp = "SELECT * FROM `categorie` WHERE cat_type in(1,3,4,5,6,7) $compay_id_sql order by cat_des";
            //echo $sqlp;
            $sqlrunp= mysqli_query($db, $sqlp);
            while($re1=mysqli_fetch_array($sqlrunp)){?>
            <option value='<? echo $re1[cat_id];?>'
            <? if($re[type]==$re1[cat_id]) echo ' selected ';?>><? echo $re1[cat_des];?></option>
            <? }//while ?>
            </select><br />

            <input type="submit" id="inputsubmit1" name="eproject" value="Edit" class="save">
        </div>
    </div>
    </div>
	</td>
	<td width="55%" align="left" valign="top" style="padding-top:45px;">
	<?php if($a_loginDesignation =="Marketing Executive"){  ?>
	
	<?php } ?>
	
	<?php if($a_loginDesignation =="Business Development Manager"){  ?>
	
	</form>
	<?php } ?>
    <? exit;
}













if($p==1){
    if($repid) $sqlp = "SELECT repname.*,project.pname,project.marketingTarget FROM `project`,`repname` WHERE repname.id = '$repid' AND project.id=repname.pid
 and project.company_id='$a_company_id' and repname.company_id='$a_company_id'

    ";
    else $sqlp = "SELECT project.pname FROM `project` WHERE  project.id=$id $compay_id_sql";
    //echo $sqlp;
    $sqlrunp= mysqli_query($db, $sqlp);
    $re=mysqli_fetch_array($sqlrunp);
	
	//root person data collection
	if($linker_person){
		$new_re=find_root_person($re[link_up_other]);
		$re[adpChange]=$new_re[adpChange];
		$re['image']=$new_re['image'];
	}

    ?>
    <form name="createProject" action="./<?= $_SESSION["path"] ?>?keyword=selected_address_enter_activity&p=1&pid=<? echo $id;?>&repid=<? echo $repid;?> "  method="post" enctype="multipart/form-data" <?php if($_GET['activities']==1){echo 'style="display:none;"';} ?>>
    <div style="width:500px; margin:0 auto">
    <div id="fgeneral" class="boxed">
        <h4 class="title"> Person</h4>
        <div class="content">
            <label for="inputtext1">Prospect Name:</label>
            <input id="inputtext1" type="text" name="pname" value="<? echo $re[pname];?>"  style="width:300px" readonly="" ><br>

            <label for="inputtext1">Person Name:</label>
<?php if(!$linker_person){?>
            <input id="inputtext1" type="text" name="repname" value="<? echo $re[repName];?>"  style="width:300px" ><br>
<?php } else{?>
    <input id="inputtext1" type="text" name="new_repname" value="<? echo $new_re[repName];?>"  style="width:300px" ><br>
<?php }?>

            <label for="inputtext1">Designation:</label>
<?php if(!$linker_person){?>
            <input id="inputtext1" type="text" name="repdesignation" value="<? echo $re[repdesignation];?>"  style="width:300px" ><br>
<?php } else{?>
            <input id="inputtext1" type="text" name="new_repdesignation" value="<? echo $new_re[repdesignation];?>"  style="width:300px" ><br>
<?php }?>
			
			
			<input type="hidden" name="linker_person" value="<?php echo $linker_person; ?>" />
			
		   <label for="inputtext1">Buying Role:</label>
			<select name="buyingRole">
				<? 
				//$newdes= "SELECT `designation` FROM `user`" ; 
				//$nsql=mysqli_query($db, $newdes);
				//$nq=mysqli_fetch_array($nsql);
				//while($nq=mysqli_fetch_array($nsql)){
				//echo $nq['designation'];
				//echo "</br>"; }
			
			if($a_loginDesignation =="Marketing Executive")
			{
				//echo 1; 
				?>
				<option value="0" <? if($re[buyingRole]=='0') echo ' selected';?>>Opening Leader</option>
				<option value="1" <? if($re[buyingRole]=='1') echo ' selected';?>>Approver</option>
				<option value="2" <? if($re[buyingRole]=='2') echo ' selected';?>>Decision Maker</option>
				<option value="3" <? if($re[buyingRole]=='3') echo ' selected';?>>Evaluator</option>
				<option value="4" <? if($re[buyingRole]=='4') echo ' selected';?>>User</option>			
				<option value="5" <? if($re[buyingRole]=='5') echo ' selected';?>>Lobbyist</option>				
				
				<?
			}
			else if($a_loginDesignation =="Sales Executive")
			{
				//echo 2;
				?>
				
				
					<option value="1" <? if($re[buyingRole]=='1') echo ' selected';?>>Opinion Leader</option>
					<option value="4" <? if($re[buyingRole]=='5') echo ' selected';?>>Lobbyist</option>				
				
				<?
			}
			else if($a_loginDesignation =="Business Development Manager")
			{
				//echo 3;
				?>
				
				
					<option value="1" <? if($re[buyingRole]=='0') echo ' selected';?>>Opinion Leader</option>
					<option value="4" <? if($re[buyingRole]=='5') echo ' selected';?>>Lobbyist</option>				
				
				<?
			}
			else if($a_loginDesignation =="Director")
			{
				//echo 4;
				?>
				
				
					<option value="1" <? if($re[buyingRole]=='0') echo ' selected';?>>Opinion Leader</option>
					<option value="4" <? if($re[buyingRole]=='5') echo ' selected';?>>Lobbyist</option>				
				
				<?
			}
			else if($a_loginDesignation =="Marketing Manager")
			{
				//echo 5;
				?>
				
				
					<option value="1" <? if($re[buyingRole]=='0') echo ' selected';?>>Opinion Leader</option>
					<option value="4" <? if($re[buyingRole]=='5') echo ' selected';?>>Lobbyist</option>				
				
				<?
			}
			else
			{
				//echo 6;
				?>
				<option value="1" <? if($re[buyingRole]=='0') echo ' selected';?>>Opinion Leader</option>
				<option value="1" <? if($re[buyingRole]=='1') echo ' selected';?>>Approver</option>
				<option value="2" <? if($re[buyingRole]=='2') echo ' selected';?>>Decision Maker</option>
				<option value="3" <? if($re[buyingRole]=='3') echo ' selected';?>>Evaluator</option>
				<option value="4" <? if($re[buyingRole]=='4') echo ' selected';?>>User</option>				
				<option value="4" <? if($re[buyingRole]=='5') echo ' selected';?>>Lobbyist</option>			
				
				<?
			}
			
			?>
			
			</select><br>
			
	
			
			<label for="inputtext1">Personality:</label>
			
	<?php	
	$pp_a="selected";	
if(isPersonalitySelected($re[adpChange],'5') || isPersonalitySelected($re[adpChange],'1') || isPersonalitySelected($re[adpChange],'2') || isPersonalitySelected($re[adpChange],'3') || isPersonalitySelected($re[adpChange],'4') || isPersonalitySelected($re[adpChange],'6') || isPersonalitySelected($re[adpChange],'7'))
$pp_a="";

?>
			
         <table><tr>
		 <td>   
	<?php if(!$linker_person){?>		
			<select name="adpChange[]" size="7" multiple >
			
            <option value="5" <? if(isPersonalitySelected($re[adpChange],'5')) echo ' selected'; echo $pp_a;?>>Laggard</option>
            <option value="1" <? if(isPersonalitySelected($re[adpChange],'1')) echo ' selected';?>>Dynamic</option>		
            <option value="2" <? if(isPersonalitySelected($re[adpChange],'2')) echo ' selected';?>>Manipulative</option>
            <option value="3" <? if(isPersonalitySelected($re[adpChange],'3')) echo ' selected';?>>Conservative</option>
            <option value="4" <? if(isPersonalitySelected($re[adpChange],'4')) echo ' selected';?>>Indecisive</option>
            <option value="6" <? if(isPersonalitySelected($re[adpChange],'6')) echo ' selected';?>>Egoistic</option>
            <option value="7" <? if(isPersonalitySelected($re[adpChange],'7')) echo ' selected';?>>Corrupt</option>
			
          </select>
		<?php } else{?>  
		  
		  <select name="new_adpChange[]" size="7" multiple >
			
            <option value="5" <? if(isPersonalitySelected($re[adpChange],'5')) echo ' selected'; echo $pp_a;?>>Laggard</option>
            <option value="1" <? if(isPersonalitySelected($re[adpChange],'1')) echo ' selected';?>>Dynamic</option>		
            <option value="2" <? if(isPersonalitySelected($re[adpChange],'2')) echo ' selected';?>>Manipulative</option>
            <option value="3" <? if(isPersonalitySelected($re[adpChange],'3')) echo ' selected';?>>Conservative</option>
            <option value="4" <? if(isPersonalitySelected($re[adpChange],'4')) echo ' selected';?>>Indecisive</option>
            <option value="6" <? if(isPersonalitySelected($re[adpChange],'6')) echo ' selected';?>>Egoistic</option>
            <option value="7" <? if(isPersonalitySelected($re[adpChange],'7')) echo ' selected';?>>Corrupt</option>
			
          </select>
		  <?php }?><br>
		  
		  <td style="padding-left:95px"> 
		  <div style="width:110px; height:136px; background:url(images/crm.jpg); margin-bottom:3px;">
<?php echo '<img src="'.$re['image'] .'" width="110"  height="130" style=" border:3px #fff solid;"  />'; ?>
</div></td>
		  </tr>
		  </table>
          
          <br />

			<label for="inputtext1">Political Alignment:</label>
			
			

			
			
			<select name="political">
           <!-- <option value="6" <? if($re[political]=='6') echo ' selected';?>>Outsider to Power Circle</option>-->
            <option value="2" <? if($re[political]=='2') echo ' selected';?>>Member of Power Circle</option>
            
            <option value="3" <? if($re[political]=='3') echo ' selected';?>>Associated to Power Circle</option>
            <option value="4" <? if($re[political]=='4' or $re[political]=='') echo ' selected';?>>Contestant to Power Circle</option>
            <option style="display:none" value="5" <? if($rep[political]=='5') echo ' selected';?>>Outcast by Power Circle</option>
			<!--<option value="1" <? if($re[political]=='1') echo ' selected';?>>Advisor to Power Circle</option>
			<option value="5" <? if($re[political]=='5') echo ' selected';?>>Outcast by Power Circle</option>-->
			
          
		  </select><br>
		  
		   <table width="100%" border="0">
                            <tr>
                              <td width="24%"><strong>
                              
                              </strong></td>
                              <td width="76%" height="35px"><strong><font color="#FF0000"><b style="font-size:12px">Power Circle:</b></font></strong>An official or unofficial (hidden) syndicate of actual decision makers who formalize formal and hidden selection criteria.</td>
                            </tr>
		   
		   
		   </table>
	
		  
			<label for="inputtext1">Relation with us:</label>
			
			

			
	<?php if(!$linker_person){?>		
			<select name="relation">
            <option value="1" <? if($re[relation]=='1') echo ' selected';?>>Enemy</option>
            <option value="2" <? if($re[relation]=='2') echo ' selected';?>>Non-Supporter</option>
            <option style="display:none" value="3" <? //if($rep[relation]=='3') echo ' selected';?>>Neutral</option>
            <option value="4" <? if($re[relation]=='4') echo ' selected';?>>Supporter</option>
            <option value="5" <? if($re[relation]=='5') echo ' selected';?>>Mentor</option>
          </select><br>
		  
		  <?php } else{?>		
			<select name="new_relation">
            <option value="1" <? if($new_re[relation]=='1') echo ' selected';?>>Enemy</option>
            <option value="2" <? if($new_re[relation]=='2') echo ' selected';?>>Non-Supporter</option>
            <option style="display:none" value="3" <? //if($rep[relation]=='3') echo ' selected';?>>Neutral</option>
            <option value="4" <? if($new_re[relation]=='4') echo ' selected';?>>Supporter</option>
            <option value="5" <? if($new_re[relation]=='5') echo ' selected';?>>Mentor</option>
          </select><br>
	
<?php }?>
            
            <!--<label for="inputtext1">Address 1</label>
            <input id="inputtext1" type="text" name="repaddress1" value="<? echo $re[repaddress1];?>"  style="width:300px" ><br>
            <label for="inputtext1">Address 2</label>
            <input id="inputtext1" type="text" name="repaddress2" value="<? echo $re[repaddress2];?>"  style="width:300px" ><br>
            <label for="inputtext1">City</label>
            <select name="repcity">
                <option value='-1'>Select</option>
                <option value='1'>B. Baria</option>
                <option value='2'>Bagerhat</option>
                <option value='3'>Bandarban</option>
                <option value='4'>Barisal</option><option value='5'>Bhola</option>
                <option value='6'>Bogra</option><option value='7'>Borguna</option>
                <option value='8'>Chandpur</option><option value='9'>Chapainawabganj</option>
                <option value='10'>Chittagong</option><option value='11'>Chuadanga</option>
                <option value='12'>Comilla</option><option value='13'>Cox's Bazar</option>
                <option value='14'>Dhaka</option><option value='15'>Dinajpur</option>
                <option value='16'>Faridpur</option><option value='17'>Feni</option>
                <option value='18'>Gaibandha</option><option value='19'>Gazipur</option>
                <option value='20'>Gopalgonj</option><option value='21'>Hobigonj</option>
                <option value='22'>Jamalpur</option><option value='23'>Jessore</option>
                <option value='24'>Jhalokathi</option><option value='25'>Jhenaidah</option>
                <option value='26'>Joypurhat</option><option value='27'>Khagrachari</option>
                <option value='28'>Khulna</option><option value='29'>Kishorgonj</option>
                <option value='30'>Kurigram</option><option value='31'>Kushtia</option>
                <option value='32'>Lalmonirhat</option><option value='33'>Laxmipur</option>
                <option value='34'>Madaripur</option><option value='35'>Magura</option>
                <option value='36'>Manikgonj</option><option value='37'>Meherpur</option>
                <option value='38'>MoulaviBazar</option><option value='39'>Munshigonj</option>
                <option value='40'>Mymensingh</option><option value='41'>Naogaon</option>
                <option value='42'>Narail</option><option value='43'>Narayangonj</option>
                <option value='44'>Narshingdi</option><option value='45'>Natore</option>
                <option value='46'>Netrokona</option><option value='47'>Nilphamari</option>
                <option value='48'>Noakhali</option><option value='49'>Pabna</option>
                <option value='50'>Panchagahr</option><option value='51'>Patuakhali</option>
                <option value='52'>Pirojpur</option><option value='53'>Rajbari</option>
                <option value='54'>Rajshahi</option><option value='55'>Rangamati</option>
                <option value='56'>Rangpur</option><option value='57'>Satkhira</option>
                <option value='58'>Shariatpur</option><option value='59'>Sherpur</option>
                <option value='60'>Sirajgonj</option><option value='61'>Sunamgonj</option>
                <option value='62'>Sylhet</option><option value='63'>Tangail</option>
                <option value='64'>Thakurgaon</option>
            </select><br>
            <label for="inputtext1">Postal Code</label>
            <input id="inputtext1" type="text" name="reppcode" value="<? echo $re[repcode];?>"  style="width:300px" ><br>-->
            <label for="inputtext1">Mobile No.</label>
            <input id="inputtext1" type="text" name="repphone" value="<? echo $re[repphone];?>"  style="width:300px" ><br>
			<label for="inputtext1">Direct Tel No.</label>
            <input id="inputtext1" type="text" name="reptelno" value="<? echo $re[reptelno];?>"  style="width:300px" ><br>
            <!--<label for="inputtext1">Fax</label>
            <input id="inputtext1" type="text" name="repfax" value="<? echo $re[repfax];?>"  style="width:300px" ><br>-->
            <label for="inputtext1">Email</label>
            <input id="inputtext1" type="text" name="repemail" value="<? echo $re[repemail];?>"  style="width:300px" ><br><br />

     
	       
 <label for="inputtext1">National ID NO:</label>
<?php if(!$linker_person){?>					  
            <input id="inputtext1" type="text" name="nationid_no" value="<? echo $re[nationid_no];?>"  style="width:300px" >
<?php } else{?>
            <input id="inputtext1" type="text" name="new_nationid_no" value="<? echo $new_re[nationid_no];?>"  style="width:300px" >
<?php }?><br>
			
			
			
			<label> Date of birth: </label><span>
<?php if(!$linker_person){?>	
			<input type="text" maxlength="10" name="bir_date" value="<? //echo $re[bir_date];?>" >
        	<a id="anchor3" href="#" onClick="
            cal.select(document.forms['createProject'].bir_date,'anchor3',
            'dd-MM-yyyy'); return false;" name="anchor3" > <img src="./images/b_calendar.png" alt="calender" border="0"></a></span>
<?php } else{?>
			<input type="text" maxlength="10" name="new_bir_date" value="<? //echo $new_re[bir_date];?>" >
        	<a id="anchor3" href="#" onClick="
            cal.select(document.forms['createProject'].bir_date,'anchor3',
            'dd-MM-yyyy'); return false;" name="anchor3" > <img src="./images/b_calendar.png" alt="calender" border="0"></a></span>
<?php }?><br />


			<label>Marriage Anniversary Date:</label><span>
<?php if(!$linker_person){?>				
			<input type="text" maxlength="10" name="marriage_date" value="<? //echo $re[marriage_date];?>" >
        	<a id="anchor4" href="#" onClick="
            cal.select(document.forms['createProject'].marriage_date,'anchor4',
            'dd-MM-yyyy'); return false;" name="anchor4" > <img src="./images/b_calendar.png" alt="calender" border="0"></a></span>
<?php } else{?>				
			<input type="text" maxlength="10" name="new_marriage_date" value="<? //echo $new_re[marriage_date];?>" >
        	<a id="anchor4" href="#" onClick="
            cal.select(document.forms['createProject'].marriage_date,'anchor4',
            'dd-MM-yyyy'); return false;" name="anchor4" > <img src="./images/b_calendar.png" alt="calender" border="0"></a></span>
<?php }?><br />
		   
		    
		   
		  <label>  Upload Photo: </label>
		  <input type="file" name="fileToUpload" id="fileToUpload"><br />
<table> 
		 <tr><td style="font-size:9.5px; color:#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N:B: Image Size MAX-5MB</td></tr>
		  
</table><br />



<label for="inputtext1">Additional personal information (desires, hobby, leisure activity, problems, plans etc.):</label>
<?php if(!$linker_person){?>	
            <textarea name="personal_details" cols="4" rows="4" id="inputtext1" style="width:300px"><? echo $re[personal_details];?></textarea><br>
<?php } else{?>
            <textarea name="new_personal_details" cols="4" rows="4" id="inputtext1" style="width:300px"><? echo $new_re[personal_details];?></textarea><br>
<?php }?>
		   
		   
		    <input type="submit" id="inputsubmit1" name="eproject" value="Edit" class="save">
        </div>
    </div>
    </div></form>
	




		
		

<table align="center" width="100%" border="1" bordercolor="#999999" style="border-collapse:collapse;" >
  <tr bgcolor="#0066FF">
    
  </tr>
</table><br><br>
<div style="text-align:center; <?php if(!$_GET['activities']){echo 'display:none;';} ?>">
<form action="<? $PHP_SELF;?>" method="post" name="activities">
  <table width="954" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr bgcolor="#0066FF" align="center">
      <td align="center" colspan="3" height="20"><strong style="color:#FFFFFF">MARKETING ACTIVITIES <font color="#FFFFFF">(<?php echo $re['pname']; echo "; " ; echo $re['project_name'];?>)</font></strong></td>
    </tr>
    <tr height="20">
      <td><strong></strong></td>
      <td><strong>Activity Details </strong></td>
      <td><strong>Amount</strong></td>
    </tr>
    <tr>
      <td valign="top" align="center" style="padding-top:5px;"><div align="left"><br />

       Date: <span><input type="text" maxlength="10" name="edate" >
        <a id="anchor2" href="#" onClick="
            cal.select(document.forms['activities'].edate,'anchor2',
            'dd-MM-yyyy'); return false;" name="anchor2" > <img src="./images/b_calendar.png" alt="calender" border="0"></a></span><br />
<br />

       Person: 
          <?php 
		  
		 
		 
			$q="select * from repname where id='$repid' $compay_id_sql";
			$r=mysqli_query($db, $q);		
			while($row=mysqli_fetch_array($r))
			{
			if($row['link_up_other'])
			{
				$root_info=find_root_person($row['link_up_other']);
				$repName=$root_info['repName'];
			}
			else		{								
				$repName=$row['repName'];
			}
				$repDesig=$row['repdesignation'];
			
			?>
        <span style="color:#0000FF"><?php echo $repName.", ".$repDesig; ?></span><br>
         
          <? } ?>
        <br /><hr color="#666666"><br />
<input type="hidden" name="repname" value=" <? echo $repName; ?>">

        
        Activity: 
        <select name="ptype">
          
          
              <?php
	
	 if($a_loginDesignation == "Marketing Executive"){  ?>
          
          
          <?php if($re[marketingTarget]=="a" or $re[marketingTarget]=="s") { ?>
              <option value="m1">One2one Awareness generation activity</option>
			<?php } ?>
			<?php if($re[marketingTarget]=="i"){ ?>
              <option value="m2">One2one Interest development activity</option>
			<?php } ?>
			<?php if($re[marketingTarget]=="d"){ ?>
              <option value="m3">One2one Desire creation activity</option>
			<?php } ?>
          
          
          
          
          
          
          
          
              <?php }else { ?>
          
          <option value="b1">Business Intelligence (BI) activity</option>
          <option value="b2">Relation establisment activity</option>
          <option value="b3">Bid pre-qualification activity</option>
          <option value="b4">Bidding activity</option>			
          
          
              <?php } ?>
        </select><br />

        <br />
        Agenda: 
  <select name="agenda_type">
    <?php
	$sql="select * from agenda where company_id='$a_company_id'";
	if($a_loginDesignation =="Marketing Executive"){
		$q=unameToAgenda4ME($a_loginUname); // for only me
	}
	else
		$q=unameToAgenda($a_loginUname); //for bdm & others
	while($ag_row=mysqli_fetch_array($q))
	echo "<option value='".$ag_row[name]."'>".$ag_row[name]."</option>";
?>
  </select><br />

      </div><br />
</td>
      <td valign="top" align="center"><textarea name="activity" style="width:400px;" rows="5" cols="600"></textarea></td>
      <td width='20%' valign="top" align="center" style="padding-top:5px;"><input type="text" name="amount" /></td>
    </tr>
    <tr>
      <td colspan='3' align="center"><input type="submit" name="submit" value="Save"></td>
    </tr>
  </table>

</form>


<div id="testdiv1" style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white;
     layer-background-color: white"></div>
	 
	 
<style>
	.short_item{
		margin:0px 5px 0px 0px;
	}

</style>




	
<table width="100%" border="1" bordercolor="#999999" style="border-collapse:collapse; margin-bottom:200px;">
<tr bgcolor="#999999">
<td width="20%" align="center"><strong>Type</strong></td>
<td width="40%" height="30" align="center"><strong>Activity Details</strong></td>
<td width="10%" align="center"><strong>Agenda</strong></td>
<td width="10%" align="center"><strong>Report Date</strong></td>
<td width="15%" align="right"><strong>Amount</strong></td>
</tr>
<?php 

 $q="select * from new_prime_activity where uid='$a_loginUid' and pid='$id' $compay_id_sql";
$r=mysqli_query($db, $q);
while($row=mysqli_fetch_array($r))
{
?>
  <tr>
    <td><?php echo view_ptype($row['ptype']);?></td>
    <td><?php echo $row['activity'];?></td>
    <td><?php echo $row['agenda_type'];?></td>
    <td align="center"><?php echo date("d-m-Y", strtotime($row['edate']));?></td>
    <td align="right"><?php echo $row[amount];?></td>
  </tr>
  <?php } ?>
</table>
</div>
	
    <? exit;
}?>
<!--<a href="./index.php?keyword=manage mail">Manage mail</a>-->
<form action="./project/address.mail.php" method="post" target="_blank">
<!--<div id="mail" >
 Subject <br>
 <select name="mm_subject" onChange="location.href='./index.php?keyword=address&mm_id='+this.options[this.selectedIndex].value">
 <option value="0"> select Subject</option>
 <? 
 $sqlqm=mysqli_query($db, "select mm_id,mm_subject from managemail where mm_status='1'  $compay_id_sql order by mm_subject asc");
 while($rm=mysqli_fetch_array($sqlqm)){
  if($rm[mm_id]==$mm_id)   echo "<option value='$rm[mm_id]' selected>$rm[mm_subject]</option>"; 
  else echo "<option value=$rm[mm_id]>$rm[mm_subject]</option>"; 
 }//while
 ?>
 
 </select>
 <? if($mm_id){
$sqlq=mysqli_query($db, "select * from managemail where mm_id='$mm_id'  $compay_id_sql ");
$re=mysqli_fetch_array($sqlq);
 ?>
  <br><br>
 Body<br>  
 <? echo nl2br($re[mm_body]);?><br><br>
Signature <br>
<? echo $_SESSION[a_loginFullName].'<br>'.$_SESSION[a_loginDesignation];?><br>
<? } //mm_id ?>
</div>-->
<table align="center" width="100%">
    <tr bgcolor="#0066FF" >
        <th height="30" >Prospects Type
            <select id="type2" name="type2" onchange="window.location.href='<?= $_SESSION["path"] ?>?keyword=selected_address_enter_activity&mm_id=<? echo $mm_id;?>&type2='+this.options[this.selectedIndex].value">
                <? if($a_loginDesignation=='Tele-Councelor'){
                        $uptype=userProspecttType($a_loginUid);?>
                   <option value="">Select type</option>
                        <?
                        $sqlp22 = "SELECT * FROM `categorie` WHERE cat_type in(1,3,4,5,6,7) AND cat_id in ($uptype)  $compay_id_sql order by cat_des ASC";
                        //echo $sqlp;
                        $sqlrunp22=mysqli_query($db, $sqlp22);
                        while($re1=mysqli_fetch_array($sqlrunp22)){?>
                        <option value='<? echo $re1[cat_id];?>'
                        <? if($type2==$re1[cat_id]) echo ' selected ';?>><? 
						if(!$a_loginDesignation =="Marketing Executive")
							echo $re1[cat_des].'-'.countprospects($re1[cat_id]);
						else
							echo $re1[cat_des].'-'.countprospects4me($re1[cat_id],$userId);?>
				</option>
                    <? }//while
                   }
                else
				 { ?>
                    <option value="">Select type</option>
                    <?php if(((!($a_loginDesignation =="Marketing Executive") and !($a_loginDesignation =="Sales Manager")) or $a_loginUname=="me999")){ ?>
                    <option value="0">All</option>
                    <?php } ?>
                    <?
                    /*$sqlp22 = "SELECT * FROM `categorie` WHERE cat_type in(1,3,4,5,6,7)  $compay_id_sql order by cat_des ASC";
                    // echo $sqlp22;
                    $sqlrunp22= mysqli_query($db, $sqlp22);*/
                    $all_prospect=get_me_se_prospect_type($userId);
                    foreach($all_prospect as $re1){
                    	if(!$re1)continue;
                    	//print_r($re1);
					/*if( (is_address_accessable($re1[cat_id],$userId) and ($a_loginDesignation =="Marketing Executive"))
					   or (($a_loginDesignation =="Sales Manager") and (is_address_accessable_for_bdm($re1[cat_id],$userId)) )
					   or ($a_loginDesignation =="admin")
					   or ($a_loginDesignation =="Marketing Manager")
					   or ($a_loginDesignation =="Director") ){
					   	*/
					?>
                    <option value='<? echo $re1["cat_id"];?>'
                    <? if($type2==$re1["cat_id"]) echo ' selected ';?>>
					<?
					if($a_loginDesignation !="Marketing Executive")
						echo $re1["cat_des"].'-'.countprospects($re1["cat_id"]);
					else
						echo $re1["cat_des"].'-'.countprospects4me($re1["cat_id"],$userId);?>
					</option>
                    <? //}
                    }//while
                }//else?>
            </select>
			&nbsp;&nbsp; Sort by: <input type="checkbox" class="short_item" id="division" name="division" />&nbsp;<label> Division</label>
            <input type="checkbox" class="short_item" name="district" id="district"/>&nbsp;<label> District</label>
            
            
          &nbsp;&nbsp;<input type="checkbox" class="short_item" value="1" id="pp_code" name="pp_code" <? if($_GET['pp_code']==1) echo "checked";?> />&nbsp;<label>Postal Code</label>
            
           
          &nbsp;&nbsp;<input type="checkbox" class="short_item" value="1" id="org_map" name="org_map" <? if($_GET['org_map']==1) echo "checked";?> />&nbsp;<label>Position Hierarchy</label> 
			
            
            
           

			<!--<input name="w" type="radio" value="1"  onClick="location.href='./index.php?keyword=selected_address&mm_id=<? echo $mm_id;?>&type2=<? echo $_GET['type2']; ?>&w=1'"/>-->
            &nbsp;&nbsp;<input type="checkbox" name="w" <? if($_GET['w']==4) echo "checked1";?> id="Marketing_Activity" value="4" />&nbsp;<label>Marcomm Target</label>
             <br />
            
             
			   &nbsp;&nbsp;<input type="radio" name="short" <? if($_GET['short']=="short") echo "checked1";?> id="short" value="short" />&nbsp;<label>Competition</label>
			  
			   &nbsp;&nbsp;<input type="radio" name="short" <? if($_GET['short']=="short_b") echo "checked1";?> id="short_b" value="short_b" />&nbsp;<label>Behavior</label>
			  
			   &nbsp;&nbsp;<input type="radio" name="short" <? if($_GET['short']=="short_m") echo "checked1";?> id="short_m" value="short_m" />&nbsp;<label>Management</label>
			   
			   &nbsp;&nbsp;<input type="radio" name="short" <? if($_GET['short']=="short_l") echo "checked1";?> id="short_l" value="short_l" />&nbsp;<label>Lifecycle</label>
			   
			   &nbsp;&nbsp;<input type="radio" name="short" <? if($_GET['b2b']=="1")  echo "checked1";?> id="b2b" value="1" />&nbsp;<label>Customer Segment</label>
			  
			
			  
			  <!--<label>
                <input type="radio" name="short" value="Competition " id="short_0" />
                Competition </label>
          
              <label>
                <input type="radio" name="short" value="Behavior  " id="short_1" />
                Behavior </label>
          
              <label>
                <input type="radio" name="short" value="Management " id="short_2" />
                Management </label>
          
              <label>
                <input type="radio" name="short" value="Lifecycle" id="short_3" />
                Lifecycle</label>
            
              <label>
                <input type="radio" name="short" value="Competitor " id="short_0" />
                Competitor</label>-->
          
          

            
            <script>
			
			function get_val(){
			
			w=0;
			if(document.getElementById("Marketing_Activity").checked==true){w=4;document.getElementById("Marketing_Activity").checked=true;}				
			
			org_map=0;
			if(document.getElementById("org_map").checked==true){org_map=1;	document.getElementById("org_map").checked=true;}
			
			division=0;
			if(document.getElementById("division").checked==true){division=1;document.getElementById("division").checked=true;}
						
			district=0;
			if(document.getElementById("district").checked==true){district=1;document.getElementById("district").checked=true;}	
				
			pp_code=0;
			if(document.getElementById("pp_code").checked==true){pp_code=1;document.getElementById("pp_code").checked=true;}
			
			
			if(document.getElementById("short").checked==true){short="short";document.getElementById("short").checked=true;}
			
			
			if(document.getElementById("short_b").checked==true){short="short_b";document.getElementById("short_b").checked=true;}
			
			
			if(document.getElementById("short_m").checked==true){short="short_m";document.getElementById("short_m").checked=true;}
				
			//if(document.getElementById("pp_code").checked==true){short="pp_code";document.getElementById("pp_code").checked=true;}
			
			
			if(document.getElementById("short_l").checked==true){short="short_l";document.getElementById("short_l").checked=true;}
			
			b2b="0";
			if(document.getElementById("b2b").checked==true){b2b="1";document.getElementById("b2b").checked=true;}
			
	
	url="./<?= $_SESSION["path"] ?>?keyword=selected_address_enter_activity&mm_id=&type2=<?php echo $type2; ?>&org_map="+org_map+"&w="+w+"&division="+division+"&district="+district+"&short="+short+"&pp_code="+pp_code+"&b2b="+b2b;

	window.location=url
	}
			<?php if($_GET["w"]){ ?>
				document.getElementById("Marketing_Activity").checked=true;
			<?php } ?><?php if($_GET["org_map"]){ ?>
				document.getElementById("org_map").checked=true;
			<?php } ?><?php if($_GET["division"]){ ?>
				document.getElementById("division").checked=true;
			<?php } ?>	<?php if($_GET["district"]){ ?>		
				document.getElementById("district").checked=true;
			<?php } ?>	<?php if($_GET["pp_code"]){ ?>		
				document.getElementById("pp_code").checked=true;
			<?php } ?>				
				<?php if($_GET["short"]=="short_l"){ ?>		
				document.getElementById("short_l").checked=true;
			<?php } ?>
				
				<?php if($_GET['b2b']=="1"){ ?>		
				document.getElementById("b2b").checked=true;
			<?php } ?>
				
				<?php if($_GET["short"]=="short_m"){ ?>		
				document.getElementById("short_m").checked=true;
			<?php } ?>
				
				<?php if($_GET["short"]=="short_b"){ ?>		
				document.getElementById("short_b").checked=true;
			<?php } ?>
				
				<?php if($_GET["short"]=="short"){ ?>		
				document.getElementById("short").checked=true;
			<?php } ?>
			
</script>
<!--            <input name="w" type="radio" value="2"  onClick="location.href='./index.php?keyword=selected_address_enter_activity&mm_id=<? echo $mm_id;?>&type2=<? echo $_GET['type2']; ?>&w=2'"/>    --><input type="button" value="VIEW" onclick="get_val();" /><input type="reset" value="RESET" onclick='document.getElementById("short_b").checked=false; document.getElementById("short").checked=false; document.getElementById("short_m").checked=false; document.getElementById("short_l").checked=false; document.getElementById("b2b").checked=false;'><br />
        </th>
    </tr>
    <?
 
    $i=1;
    if($type2=='') {exit;}
	
	if($type2){
        $sqltq=mysqli_query($db, "select cat_id,cat_des from categorie where cat_id=$type2  $compay_id_sql");
		}
    elseif($type2==0){
   //     $sqltq=mysqli_query($db, "select cat_id,cat_des from categorie where cat_type=1");
		
		}
    while($rt=mysqli_fetch_array($sqltq)){
        $type2=$rt[cat_id];
        
			echo "<tr bgcolor=#FFFFCC><td > $rt[cat_des]</td></tr>";
	}
	
if($_GET['division']){
	$div_sql="select * from division /*where company_id='$a_company_id'*/ order by div_id asc";
	$div_q=mysqli_query($db, $div_sql);
		while($div_row=mysqli_fetch_array($div_q))
			{
				echo '<tr><td bgcolor=#FFD5D5 style="border:1px #ddd solid; font-size:17px;">Division:'. $div_row["div_des"] .'
						<input type="button" value="PRINT" class="print_btn" rel="'.$dis_row["dist_id"].'" title="District">
				
				</td></tr>';
				
				
				if($_GET['district'])
				{
					$dis_sql="select * from district where div_id='$div_row[div_id]' $compay_id_sql order by dist_id asc";
					$dis_q=mysqli_query($db, $dis_sql);
					while($dis_row=mysqli_fetch_array($dis_q))
						{
							
							echo '<tr><td bgcolor=#92CED3 style="border:1px #ccc solid; font-size:15px;">District:'. $dis_row["dist_des"] .'</td></tr>';
							//include("./project/address_content_for_enter_sales_activity.php"); 
							
							if($_GET['pp_code'])
				{
					$ppcode_sql="select * from ppcode where districtID='$dis_row[dist_id]' $compay_id_sql order by ppcodes asc";
					$ppcode_q=mysqli_query($db, $ppcode_sql);
					while($ppcode_row=mysqli_fetch_array($ppcode_q))
					{
						echo '<tr><td bgcolor=#D1FACF style="border:1px #ccc solid; font-size:15px;">Potal Code:'. $ppcode_row["ppcodes"] .', '.$ppcode_row["suboffice"].'</td></tr>';						
							
													if($_GET['w']==4)
				{
					$marketingTarget_sql=[[marketing_target_level('s'),'s'],[marketing_target_level('i'),'i'],[marketing_target_level('a'),'a'],[marketing_target_level('u'),'u']];
					// $marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';
							if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");		    
									$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							} 
						
												
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
						
						
						
					
					
					
					
					
					
					
					}//end of pp_code while
															
				} //end of pp_code if
				else{
						
													if($_GET['w']==4)
				{
					$marketingTarget_sql=return_marketing_target_arr();
					$marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
					

						
						
						
					
					
					
					
					
					
					}//end of ppcode else
						
						
						
							
							
							
							
						}//end of destrict while
															
					} //end of destrict if
					else{
						
													if($_GET['pp_code'])
				{
					$ppcode_sql="select * from ppcode where districtID in (select dist_id from district where div_id='$div_row[div_id]') order by ppcodes asc";
					$ppcode_q=mysqli_query($db, $ppcode_sql);
					while($ppcode_row=mysqli_fetch_array($ppcode_q))
					{
						echo '<tr><td bgcolor=#D1FACF style="border:1px #ccc solid; font-size:15px;">Potal Code:'. $ppcode_row["ppcodes"] .', '.$ppcode_row["suboffice"].'</td></tr>';						
							
													if($_GET['w']==4)
				{
					$marketingTarget_sql=return_marketing_target_arr();
					$marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
						
						
						
					
					
					
					
					
					
					
					}//end of pp_code while
															
				} //end of pp_code if
				else{
						
													if($_GET['w']==4)
				{
					$marketingTarget_sql=return_marketing_target_arr();
					$marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							}  
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
					

						
						
						
					
					
					
					
					
					
					}//end of ppcode else
						
						
						
					
					
					
					
					
					
					}//end of district else
					
					
	} // end of division while
    
   } //end of division  if
   else{
	   
	   
	   if($_GET['district'])
				{
					$dis_sql="select * from district order by dist_id asc";
					$dis_q=mysqli_query($db, $dis_sql);
					while($dis_row=mysqli_fetch_array($dis_q))
					{
						echo '<tr><td bgcolor=#92CED3 style="border:1px #ccc solid; font-size:15px;">District:'. $dis_row["dist_des"] .'
							<input type="button" value="PRINT" class="print_btn" rel="'.$dis_row["dist_id"].'" title="District">
						</td></tr>';
						
							
													
						
						
						if($_GET['pp_code'])
				{
					$ppcode_sql="select * from ppcode where districtID='$dis_row[dist_id]' order by ppcodes asc";
					$ppcode_q=mysqli_query($db, $ppcode_sql);
					while($ppcode_row=mysqli_fetch_array($ppcode_q))
					{
						echo '<tr><td bgcolor=#D1FACF style="border:1px #ccc solid; font-size:15px;">Potal Code:'. $ppcode_row["ppcodes"] .', '.$ppcode_row["suboffice"].'
						<input type="button" value="PRINT" class="print_btn" rel="'.$ppcode_row["ppcodes"].'" title="Postal Code">
						</td></tr>';						
							
													if($_GET['w']==4)
				{
					$marketingTarget_sql=return_marketing_target_arr();
					$marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
						
						
						
					
					
					
					
					
					
					
					}//end of pp_code while
															
				} //end of pp_code if
				else{
						
													if($_GET['w']==4)
				{
					$marketingTarget_sql=return_marketing_target_arr();
					$marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
					

						
						
						
					
					
					
					
					
					
					}//end of ppcode else
					
					
				
					
					
					
					
					}//end of destrict while
															
				} //end of destrict if
				
	   elseif($_GET['pp_code'])
				{
					$ppcode_sql="select * from ppcode order by ppcodes asc";
					$ppcode_q=mysqli_query($db, $ppcode_sql);
					while($ppcode_row=mysqli_fetch_array($ppcode_q))
					{
						echo '<tr><td bgcolor=#D1FACF style="border:1px #ccc solid; font-size:15px;">Potal Code:'. $ppcode_row["ppcodes"] .', '.$ppcode_row["suboffice"].'
						<input type="button" value="PRINT" class="print_btn" rel="'.$ppcode_row["ppcodes"].'" title="Postal Code">
						</td></tr>';						
							
													
						
						
						
				if($_GET['w']==4)
				{
					$marketingTarget_sql=[["Awareness Level",'a'],["Interest Level",'i'],["Sales Level",'s'],["Desire Level",'d']];
					$marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}  
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							} 					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							} 
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
					

						
						
						
					
					
					
					
					
					
					}//end of Marcomm Target else
					
					
					
					
					
					
					
					}//end of pp_code while
															
				} //end of pp_code if
				elseif($_GET['w']==4)
				{
					$marketingTarget_sql=[[marketing_target_level('s'),'s'],[marketing_target_level('d'),'d'],[marketing_target_level('i'),'i'],[marketing_target_level('a'),'a'],[marketing_target_level('u'),'u']];
					// $marketingTarget_q=mysqli_query($db, $marketingTarget_sql);
					foreach($marketingTarget_sql as $marketingTarget_row)
					{
						echo '<tr><td bgcolor=#EFBB76 style="border:1px #ccc solid; font-size:15px;">Marcomm Target: '. $marketingTarget_row[0].'</td></tr>';						
							
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							} 					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							} 
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if
						
						
						
					
					
					
					
					
					
					
					}//end of Marcomm Target while
															
				} //end of Marcomm Target if
				else{
						
													if($_GET['short']=='short')
							{
                                $all_com=1;
	                            while ($all_com<5) 								
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Competition: '. view_cp($all_com) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_com++;
								}// end of compitition while
	
	                           }// end of compitition if
							   elseif($_GET['short']=='short_b')
							{
								$all_beh=1;
								while($all_beh<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Behavior: '. view_orgbhv($all_beh) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_beh++;
								
								}// end of behavior while
							
							
							} 
						
						
							elseif($_GET['short']=='short_m')
							{
								$all_man=1;
								while($all_man<4)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Management: '. view_maneg($all_man) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_man++;
								
								}// end of management while
							
							
							} 
						
						
							elseif($_GET['short']=='short_l')
							{
								$all_lp=1;
								while($all_lp<5)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Lifecycle Position: '. view_lp($all_lp) .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							}
					
											
							elseif($_GET['b2b']=='1')
							{
								$all_lp=0;
								while($all_lp<=11)
								{
									echo '<tr><td bgcolor=#f9f909 style="border:1px #f9f909 solid; font-size:15px;">Customer Segment: '. view_b2b(2,$all_lp,null)[0] .'</td></tr>';
                                    include("./project/address_content_for_enter_sales_activity.php");								    
								$all_lp++;
								
								}// end of lifecycle position while
							
							
							} 
						
						
							else
							   {
									include("./project/address_content_for_enter_sales_activity.php");
							   }// end of lifecycle position if					
					
					}//end of district else
	 } //end of else division 



     ?>
</table>
<input type="hidden" name="n" value="<? echo $i; ?>">
<input type="hidden" name="mm_id" value="<? echo $mm_id; ?>">
<input type="button" onClick="this.form.submit();" value="GO">
</form>

