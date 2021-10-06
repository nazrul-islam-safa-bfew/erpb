<?php
class alarming_issue{
  public $db;
  public function __construct(){
    global $db;
    $this->db=$db;
  }
  public function get_it($posl=null){
    $sql="select * from alarming_issue where posl='$posl' order by id desc";
    $q=mysqli_query($this->db,$sql);  
    while($row[]=mysqli_fetch_array($q)){}
    return $row;  
  }
  public function get_all(){
    $sql="select * from alarming_issue order by id desc";
    $q=mysqli_query($this->db,$sql);
    while($row[]=mysqli_fetch_array($q)){}
    return $row;
  }
  public function view_it($rows){
    foreach($rows as $row){
      echo "<tr>
      <td>".date("d/m/Y",$row[timestamp])."</td>
      <td>$row[posl]</td>
      <td>$row[des]</td>
      <td>$row[raised_by]</td>
      <td>$row[status]</td>
      </tr>";
    }
  }
  public function insert_it($posl,$des,$raised_by){
    $timestamp=strtotime(date("Y-m-d"));
    $sql="insert into alarming_issue values ('','$posl','$des','$raised_by','1','$timestamp')";
    mysqli_query($this->db,$sql);
  }
  public function view_form(){
    echo "
    <form action='' method='post' >
      <p>Issue: <textarea name=''></textarea>
    </form>
    ";
  }
    
}
$ai=new alarming_issue;