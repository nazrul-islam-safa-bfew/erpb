<?php
class Privilege{
  private $defaultResponsibility=10;
  //department Classification
  private $allDep=null;
  public function __construct($dep=null){
    if($dep)$this->allDep=$dep;
    echo $this->allDep;
  }
  
  public function depClass(){
    $department=array(
      "md"=>array("dep"=>"Director"),
      "hr"=>array("dep"=>"Human Resource"),
      "project"=>array("dep"=>"Construction Manager")
    );
    return $department;
  }
  
  public function responsiblityWoner(){
    $allDep=$this->depClass();
    foreach($allDep as $dep){
      print_r($dep);
    }
  }
}

$Privilege=new Privilege;

$Privilege->responsiblityWoner();






