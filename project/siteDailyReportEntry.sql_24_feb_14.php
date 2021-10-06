<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include("../includes/myFunction.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$todat=todat();
$edate=formatDate($edate,'Y-m-j');

echo "UPDATING....";
for($i=1;$i<$n;$i++){
//echo "<br>I=$i<br>";
	if(${worked.$i}>0 OR ${des.$i} OR ${clientdes.$i}){
//	if(${worked.$i}>0){
	  if(${iowid.$i})
	 { 
	 //echo iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
	 
	    $sqlp = "INSERT INTO iowdaily (id, iowId, edate, qty, todat,des,clientdes,supervisor)".
		" values ('','${iowid.$i}','$edate','${worked.$i}','$todat','${des.$i}','${clientdes.$i}','${supervisor.$i}')";
	 //  echo $sqlp.'<br>';
	  $sqlrunp= mysql_query($sqlp);
     // $sqlrow=mysql_insert_id());
	 // ${deshidden.$i}=iowProgress_preport($edate,${iowid.$i}).iowActualProgress_preport($edate,${iowid.$i},1);
	 // ${des.$i}=${deshidden.$i}.'; '.${des.$i};

	  $updateSql="UPDATE iowdaily set qty='${worked.$i}',clientdes='${clientdes.$i}',des='${des.$i}' where iowId=${iowid.$i} AND edate='$edate'";
	 // echo "<br>$updateSql<br>"; 
	  mysql_query($updateSql);
		
		}else if(${siowid.$i}){
	    $sqlp = "INSERT INTO siowdaily (id, siowId, edate, qty, todat)".
		" values ('','${siowid.$i}','$edate','${worked.$i}','$todat')";
		//echo $sqlp.'<br>';
		$sqlrunp= mysql_query($sqlp);
        $sqlsiowup="UPDATE siowdaily set qty='${worked.$i}' WHERE siowId=${siowid.$i} AND edate='$edate'";
	    mysql_query($sqlsiowup);
		}
	}//if
}//for

$sql="insert into dailyreport(pcode,edate,operation,weather,accident,vcomments,submitted) 
 VALUES ('$loginProject','$edate','$operation','$weather','$accident','$vcomments','$submitted')";
//echo $sql;
mysql_query($sql);
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+daily+report\">";
?>