<?php
include("./includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

$sqlp = "SELECT * from `po_force_close_approval` order by posl asc";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp); 
?>

  <table align="left" width="98%" border="1" bordercolor="#000" bgcolor="#fff" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr bgcolor="#FFFFCC">
      <td align="left" width="150"  height="30" >#POSL</td>
      <td align="left">Details</td>
      <td align="right">Action</td>
    </tr>

    
<?php
while($row=mysqli_fetch_array($sqlrunp)){ ?>
    <tr>
      <td align="left" height="30" ><a href='http://win4win.biz/erp/bfew/planningDep/printpurchaseOrder1.php?posl=<?= $row['posl'] ?>' target="_blank"><?= $row['posl'] ?></a>
    <?php
        $posl_arr = explode("_",$row['posl']);
        
$vsqlp = "SELECT vname from `vendor` where vid = '$posl_arr[3]'";
//echo $sqlp;
$vsqlrunp= mysqli_query($db, $vsqlp); 
$vrow=mysqli_fetch_array($vsqlrunp);
echo "<small><br>".$vrow['vname'];
?>
    </td>
      <td align="left"><?= nl2br($row['text']) ?></td>      
      <td align="right"  width="150"><a href="<?= $row['text'] ?>">Approve</a></td>
    </tr>  
<?php
}
?>
</table>
