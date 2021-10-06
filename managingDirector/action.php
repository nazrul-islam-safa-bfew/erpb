<form name="check" action="./index.php?keyword=view+dma&selectedPcode=<? echo $dmaPcode;?>&iow=<? echo $dmaiow;?>" method="post">
<table width="400" border="1" bordercolor="#9999CC" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<tr bgcolor="#9999CC"><td> Action</td></tr>
<tr><td><input type="radio" name="check" checked value="Approved by Mngr P&C">Checked and Approved</td></tr>
<tr><td><input type="radio" name="check" value="Forward to MD">Rejected [Unable to take decisition because]<br>
      <textarea cols="50" rows="5" name="checkMesg"></textarea></td></tr>
<tr><td align="center"><input type="submit" name="Save" value="Save"></td></tr>
</table>

</form>