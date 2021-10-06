$pcode=[208,209];
CREATE TABLE `store$pcode` (
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

CREATE TABLE `issue$pcode` (
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


CREATE TABLE `storet$pcode` (
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
) ENGINE=MyISAM AUTO_INCREMENT=947 DEFAULT CHARSET=latin1
