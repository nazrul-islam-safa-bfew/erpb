<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$todat=todat();
$edate=formatDate($edate,'Y-m-j');
$e=date("Y-m-d");
if($_GET[id] && $_GET[action]=="closed"){
	$sql="update iowdaily set closed=1 where id='$_GET[id]'";
	mysqli_query($db,$sql);
	unset($_GET);
	unset($_POST);
}

foreach($_POST as $key=>$val){
	if(stripos($key,"supervisor")===0){
		$supervisor=$val;
		break;
	}
}

foreach($_POST as $key=>$val){
	if(stripos($key,"iowid")===0){
		$iowid=$val;
		break;
	}
}


foreach($_POST as $key=>$val){
	if(stripos($key,"closedOn")===0 && $val){
		$keyVal=explode("_",$key);
		$closedOn=dateFormat($val);
		$upSql=mysqli_query($db,"update troubleTracker set closedOn='$todat' where trID='$keyVal[1]'");		
	}
}

$dateline=dateFormat($_POST[dateline]);
if($_POST[hamperProgress] && $_POST[dateline] && $supervisor && $iowid){
	$sql="insert into troubleTracker (troubleTxt,raisedOn,userID,dateline,iowID) values ('$_POST[hamperProgress]','$todat','$supervisor','$dateline','$iowid')";
	mysqli_query($db,$sql);
}elseif($_POST[hamperProgress]){
	echo "<center>Dateline not found</center>";
}

if($_POST[bilingDoc]){
	$sql="insert into billingDoc (bDes,bParcent,iowID,edate) values ('$_POST[bilingDoc]','$_POST[bilingDocP]','$iowid','$edate')";
	mysqli_query($db,$sql);
}elseif($_POST[bilingDocP] || $_POST[bilingDoc]){
	echo "<center>Parcent or biling text not found</center>";
}

echo "UPDATING....";
echo '<script>
window.close();
</script>';

for($i=1;$i<$n;$i++){ echo ${iowid.$i};
//echo "<br>I=$i<br>";
	if(${worked.$i}>0 OR ${des.$i}){
//	if(${worked.$i}>0){
	  if(${iowid.$i} and ${des.$i})
	 {
	 //echo iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
		 
	    $sqlp = "INSERT INTO iowdaily (id, iowId, edate, qty, todat,des,clientdes,supervisor,type,auto_save_info) ".
		" values ('','${iowid.$i}','$edate','${worked.$i}','$todat','${des.$i}','','${supervisor.$i}','','$hidden_code')";
	  echo $sqlp.'<br>';
	  $sqlrunp= mysqli_query($db, $sqlp);
     // $sqlrow=mysql_insert_id());
	 // ${deshidden.$i}=iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
	 // ${des.$i}=${deshidden.$i}.'; '.${des.$i};

	  $updateSql="UPDATE iowdaily set qty='${worked.$i}',clientdes='',des='${des.$i}',supervisor='${supervisor.$i}',auto_save_info='$hidden_code' where iowId=${iowid.$i} AND edate='$edate' and type='' and closed=0";
	 echo "<br>$updateSql<br>"; 
	  mysqli_query($db, $updateSql);
	}else if(${siowid.$i}){
	    $sqlp = "INSERT INTO siowdaily (id, siowId, edate, qty, todat,type)".
		" values ('','${siowid.$i}','$edate','${worked.$i}','$todat','')";
		//echo $sqlp.'<br>';
		$sqlrunp= mysqli_query($db, $sqlp);
        $sqlsiowup="UPDATE siowdaily set qty='${worked.$i}' WHERE siowId=${siowid.$i} AND edate='$edate' and  type='' and closed=0";
	    mysqli_query($db, $sqlsiowup);
		}
	}//if
										 
$c_iow_id=${iowid.$i};
				if($c_iow_id>0){						 
		    $sqlp = "INSERT INTO change_order (iowId, edate, text,supervisor) ".
		" values ('${iowid.$i}','$edate','${des.$i}','${supervisor.$i}')";
				$q=mysqli_query($db,$sqlp);
// echo $sqlp;
	  $updateSql="UPDATE change_order set text='${wi.$i}' where iowId=${iowid.$i} AND edate='$edate'";
// 	 echo "<br>$updateSql<br>"; 
	  mysqli_query($db, $updateSql);
				}
				

	
//echo "<br>I=$i<br>";
	if(${worked.$i}>0 OR ${wi.$i} and 1==2){ /*stoped*/
//	if(${worked.$i}>0){
		$type=${wi.$i} ? "wi" : "";
	  if(${iowid.$i} and (${wi.$i}))
	 { 
	 //echo iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
		 
	    $sqlp = "INSERT INTO iowdaily (id, iowId, edate, qty, todat,des,clientdes,supervisor,type) ".
		" values ('','${iowid.$i}','$edate','${worked.$i}','$todat','${des.$i}','${wi.$i}','${supervisor.$i}','$type')";
// 	  echo $sqlp.'<br>';
	  $sqlrunp= mysqli_query($db, $sqlp);
   // $sqlrow=mysql_insert_id());
	 // ${deshidden.$i}=iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
	 // ${des.$i}=${deshidden.$i}.'; '.${des.$i};

	  $updateSql="UPDATE iowdaily set qty='${worked.$i}',clientdes='${wi.$i}',des='${des.$i}',supervisor='${supervisor.$i}' where iowId=${iowid.$i} AND edate='$edate' and type='$type' and closed=0";
// 	 echo "<br>$updateSql<br>"; 
	  mysqli_query($db, $updateSql);
	}else if(${siowid.$i}){
	    $sqlp = "INSERT INTO siowdaily (id, siowId, edate, qty, todat,type)".
		" values ('','${siowid.$i}','$edate','${worked.$i}','$todat','wi')";
		//echo $sqlp.'<br>';
		$sqlrunp= mysqli_query($db, $sqlp);
        $sqlsiowup="UPDATE siowdaily set qty='${worked.$i}' WHERE siowId=${siowid.$i} AND edate='$edate' and  type='wi' and closed=0";
	    mysqli_query($db, $sqlsiowup);
		}
	}//if
//echo "<br>I=$i<br>";
	if(${worked.$i}>0 OR ${co.$i} and 1==2){ /*stoped*/
//	if(${worked.$i}>0){
	  if(${iowid.$i} or ${co.$i})
	 { 
	 //echo iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
	 
	    $sqlp = "INSERT INTO iowdaily (id, iowId, edate, qty, todat,des,clientdes,supervisor,type) ".
		" values ('','${iowid.$i}','$edate','${worked.$i}','$todat','${des.$i}','${co.$i}','${supervisor.$i}','co')";
// 	  echo $sqlp.'<br>';
	  $sqlrunp= mysqli_query($db, $sqlp);
			
			
     // $sqlrow=mysql_insert_id());
	 // ${deshidden.$i}=iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
	 // ${des.$i}=${deshidden.$i}.'; '.${des.$i};

	  $updateSql="UPDATE iowdaily set qty='${worked.$i}',clientdes='${co.$i}',des='${des.$i}',supervisor='${supervisor.$i}' where iowId=${iowid.$i} AND edate='$edate' and type='co' and closed=0";
	 // echo "<br>$updateSql<br>"; 
	  mysqli_query($db, $updateSql);
		
		}else if(${siowid.$i}){
	    $sqlp = "INSERT INTO siowdaily (id, siowId, edate, qty, todat, type)".
		" values ('','${siowid.$i}','$edate','${worked.$i}','$todat','co')";
		//echo $sqlp.'<br>';
		$sqlrunp= mysqli_query($db, $sqlp);
        $sqlsiowup="UPDATE siowdaily set qty='${worked.$i}' WHERE siowId=${siowid.$i} AND edate='$edate' and type='co' and closed=0";
	    mysqli_query($db, $sqlsiowup);
		}
	}//if
}//for
$weather= $_POST['weather'];
$accident= $_POST['accident'];
$vcomments= $_POST['vcomments'];

if($weather || $accident || $vcomments){
	$sql="insert into dailyreport(pcode,edate,operation,weather,accident,vcomments,submitted) 
	 VALUES ('$loginProject','$e','$operation','$weather','$accident','$vcomments','$submitted')";
	mysqli_query($db, $sql);
// 	echo $sql;
	$sql="update dailyreport set operation='$operation',weather='$weather',accident='$accident',vcomments='$vcomments',submitted='$submitted' where pcode='$loginProject' and edate='$e'";
	mysqli_query($db, $sql);
// 	echo $sql;
}
if($_POST['taskDailyReport'])
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=task+daily+report\">";
else
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+daily+report\">";
?>