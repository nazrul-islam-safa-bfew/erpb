<?php
if($_GET["pcodes"]){
  $pcodes=explode(",",$_GET["pcodes"]);
  foreach($pcodes as $pcode)
    echo createSql($pcode);
}elseif($_GET["allPcode"]=="all"){
$allCol="200,201,202,203,204,205,206,207,208,209,210,211,212,002,004,008";
  foreach(explode(",",$allCol) as $col){
    $uid=rand(10000000,9999999999);
    echo $uSql="insert into user values ('$uid','ppo$col','ppo$col','ppo$col','Project Purchase Officer','$col','1',CURDATE());";
  }
  
  foreach(explode(",",$allCol) as $col){
    $uid=rand(10000000,9999999999);
    echo $uSql="insert into user values ('$uid','ae$col','ae$col','ae$col','Accounts Executive','$col','1',CURDATE());";
  }
}else{
  echo "<form action=''><input type='text' name='pcodes' placeholder='208,209'><input type='submit'></form>";
}




function createSql($pcode){
  $data="CREATE TABLE  IF NOT EXISTS  `store$pcode` (
 `rsid` int(11) NOT NULL AUTO_INCREMENT,
 `itemCode` varchar(10) NOT NULL DEFAULT '',
 `receiveQty` double NOT NULL DEFAULT '0',
 `currentQty` double NOT NULL DEFAULT '0',
 `rate` double NOT NULL DEFAULT '0',
 `paymentSL` varchar(100) NOT NULL DEFAULT '',
 `reference` varchar(100) NOT NULL DEFAULT '',
 `remark` varchar(100) NOT NULL DEFAULT '',
 `todat` date NOT NULL DEFAULT '0000-00-00',
 KEY `sid` (`rsid`)
) ENGINE=MyISAM AUTO_INCREMENT=1673 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS  `issue$pcode` (
 `issueSL` int(11) NOT NULL AUTO_INCREMENT,
 `itemCode` varchar(10) NOT NULL DEFAULT '',
 `iowId` int(11) NOT NULL DEFAULT '0',
 `siowId` int(11) NOT NULL DEFAULT '0',
 `issuedQty` double NOT NULL DEFAULT '0',
 `issueRate` double NOT NULL DEFAULT '0',
 `issueDate` date NOT NULL DEFAULT '0000-00-00',
 `reference` varchar(200) NOT NULL DEFAULT '',
 `supervisor` varchar(20) NOT NULL DEFAULT '',
 `issuedQtyTemp` double DEFAULT NULL,
 `eqID` varchar(20) DEFAULT NULL,
 `km_h_qty` varchar(20) DEFAULT NULL,
 `unit` varchar(5) DEFAULT NULL,
 KEY `issueSL` (`issueSL`)
) ENGINE=MyISAM AUTO_INCREMENT=3519 DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS  `storet$pcode` (
 `rsid` int(11) NOT NULL AUTO_INCREMENT,
 `itemCode` varchar(10) NOT NULL DEFAULT '',
 `receiveQty` double NOT NULL DEFAULT '0',
 `currentQty` double NOT NULL DEFAULT '0',
 `rate` double NOT NULL DEFAULT '0',
 `paymentSL` varchar(100) NOT NULL DEFAULT '',
 `reference` varchar(100) NOT NULL DEFAULT '',
 `remark` varchar(100) NOT NULL DEFAULT '',
 `todat` date NOT NULL DEFAULT '0000-00-00',
 KEY `sid` (`rsid`)
) ENGINE=MyISAM AUTO_INCREMENT=947 DEFAULT CHARSET=latin1;";
  return $data;
}
?>