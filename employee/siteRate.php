<style>
  .pending_table td,th{border:1px solid;}
  .pending_table tr:nth-child(odd){background:#eee;}
  .pending_table{font-size:11px;}
</style>	

<?php if($e){ 

    $uSql="SELECT * FROM `siterate` where id=".$e;
    $uQuery=mysqli_query($db,$uSql);
    $result=mysqli_fetch_array($uQuery);

    //update 
    if(isset($saveBtn)){
        $upamount = $_POST['upamount'];
        $up = mysqli_query($db, "update siterate set amount=$upamount where id=$e");
        if($up) echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=index.php?keyword=site+rate\">";
    }
}
?>
<form name="employe" onsubmit="return checkrequired(this);" action="./employee/siteRateSql.php" method="post">
        <table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
            <tr bgcolor="#CC9999">
            <td align="right" valign="top" height="30"><font class='englishhead'>Site Rate Entry Form</font></td>
            </tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr bgcolor="#FFEEEE">
                        <td><LABEL for=name>Item List</LABEL></td>
                        <td >
                            <select name="itemcode">
                                <?php
                                include("config.inc.php");
                                $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);	
                                $Isql="SELECT * from `itemlist` where itemCode >= '82-00-000' AND itemCode < '95-00-000' ORDER BY itemCode ASC";
                                $Iq=mysqli_query($db,$Isql);
                                while($Irow=mysqli_fetch_array($Iq)){
                                    print_r($Irow);
                                    if(!$Irow['itemDes'])continue;
                                    $extra=($eqresult["ccr"]==$Irow['itemCode'] && $eqresult["ccr"]) ? " selected " : "";
                                    echo '<option value="'.$Irow['itemCode'].'" '.$extra.'>'.$Irow['itemCode'] .'-'. $Irow['itemDes'].'</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>			

                    <tr bgcolor="#FFEEEE">
                    <td><LABEL for=salary>Amount/Hour</LABEL></td>
                    <td ><input type="number" name="amount" value=""  alt="req" title="Amount" >
                    <input type="hidden" name="salaryType" value="Amount"> 
                    </td>
                    </tr>
                </td>
            
            <tr><td colspan="2" align="center" ><input type="submit" name="save" value="Save" class="store" ></td></tr>
        </table>
        </table>
        <input type="hidden" name="id" value="<? echo $id;?>">
</form>

<?php if($e){ ?>
    </br></br>
    <form name="updateRate" action="" method="post">
        <table align="center" width="500" border="3"  bordercolor="CC9999" cellpadding="0" cellspacing="0" style="border-collapse:collapse">   
            <tr bgcolor="#FFEEEE">
                <td style="padding:10px;">Amount/Hour</td>
                <td style="padding-left:5px;"><input type="text" name="upamount" value="<?php echo $result['amount']; ?>"> </td>
                <td style="padding-left:5px;"><input type="submit" name="saveBtn" value="Edit Done" class="store"> </td>
            </tr>
        </table>
</form>
<?php } ?>

<table class="pending_table" style="width:  500px; margin: 50px auto; border: 1px solid #999; border-collapse: collapse;">
  <caption><center><h3>
    Site Rate List
    </h3></center></caption>
	<tr>
		<th style="padding: 7px;">Item</th>
		<th>Amount/Hour</th>
        <th>Activity</th>
	</tr>
    <?php 
     $sql="SELECT * FROM `siterate` ORDER BY `id`  DESC";
     $q=mysqli_query($db,$sql);
     while($rs=mysqli_fetch_array($q)){

        $sqln="SELECT * FROM itemlist where itemCode='$rs[itemcode]'";
        $sqlq=mysqli_query($db, $sqln);
        $qr=mysqli_fetch_array($sqlq);

   
         ?>
    <tr>
        <td style="padding:5px;"><?php echo $rs['itemcode']."--".$qr['itemDes'];?></td>
        <td><?php echo $rs['amount'];?></td>
        <td><a href="?keyword=site+rate&e=<?php echo $rs['id'];?>">Edit</a></td>
    </tr>
     <? } ?>
</table>
	
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>