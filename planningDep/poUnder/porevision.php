<?php
class poRevision{
  public $db;
  public function __construct(){
    global $db;
    $this->db=$db;
  }
  public function getAllRevision($posl){
    $sql="select * from porevision where posl='$posl' order by id desc";
    $q=mysqli_query($this->db,$sql);
    while($row[]=mysqli_fetch_array($q)){}
    return $row;
  }
  public function insertRevision($posl,$edate,$designation,$revisionTxt){
    if($designation=="Procurement Executive")$designation="PO";
    elseif($designation=='Chairman & Managing Director')$designation="MD";
    
    $sql="insert into porevision (posl,edate,designation,revisionTxt) values ('$posl','$edate','$designation','$revisionTxt')";
//     echo $sql;
    mysqli_query($this->db,$sql);
    if(mysqli_affected_rows($this->db)>0)return true;
    return false;
  }
  public function print_revision($posl){
    $getAllRevision=$this->getAllRevision($posl);
    echo "<table width=50% style='border: 1px solid #999;
    margin: auto;
    border-collapse: collapse;'>
    <tr style='background:#fff; border-bottom:1px solid'><th colspan=2>Revision History</th><tr>
    ";
    foreach($getAllRevision as $revision){
      if(!$revision["id"])continue;
      if($revision[designation]=="MD")$revision[designation]="<span style='padding: 2px;
    background: #00f;
    color: #fff;
    border-radius: 5px;'>$revision[designation]</span>";
      $edate=date("d/m/Y",strtotime($revision[edate]));
      echo "<tr style='border-bottom:1px solid #999;'><td align=left width=110><b>$revision[designation]</b>:$edate</td><td align=left><i>$revision[revisionTxt]</i></td></tr>";
    }
    echo "</table>";
  }
}
$poRevision=new poRevision;
?>