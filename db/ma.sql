CREATE TABLE `bom` (
  `bom_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bom_name` varchar(25) DEFAULT NULL,
  `bom_fitem` varchar(25) DEFAULT NULL,
  `bom_uom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bomitems` (
  `bomi_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bom_id` int(11) NOT NULL,
  `bom_item` varchar(25) NOT NULL,
  `bom_loc` varchar(25) NOT NULL,
  `bom_type` varchar(25) NOT NULL,
  `bom_qty` decimal(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `location` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `loc_code` varchar(25) DEFAULT NULL,
  `loc_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `manufact` (
  `mf_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mf_date` timestamp NULL DEFAULT NULL,
  `mf_reftype` varchar(25) DEFAULT NULL,
  `mf_refno` varchar(12) DEFAULT NULL,
  `mf_fitem` varchar(25) DEFAULT NULL,
  `mf_bom` varchar(25) DEFAULT NULL,
  `mf_loc` varchar(25) DEFAULT NULL,
  `mf_fqty` varchar(25) DEFAULT NULL,
  `mf_note` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `manufactitems` (
  `mfi_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `mf_id` int(11) NOT NULL,
  `mf_rmitem` varchar(25) DEFAULT NULL,
  `mf_rmloc` varchar(25) DEFAULT NULL,
  `mf_stdqty` decimal(10,4) DEFAULT NULL,
  `mf_actqty` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `products` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `u_id` int(11) NOT NULL,
  `icode` varchar(25) NOT NULL,
  `iname` varchar(25) NOT NULL,
  `icat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `uom` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ucode` varchar(25) NOT NULL,
  `uname` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `vhrdetails` (
  `vhrd_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vhrd_date` timestamp NULL DEFAULT NULL,
  `vhrd_reftype` varchar(25) DEFAULT NULL,
  `vhrd_refno` varchar(12) DEFAULT NULL,
  `vhrd_locin` varchar(25) NOT NULL,
  `vhrd_locout` varchar(25) NOT NULL,
  `vhrd_supplier` varchar(25) DEFAULT NULL,
  `vhrd_customer` varchar(25) DEFAULT NULL,
  `vhrd_note` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `vhritems` (
  `vhritem_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vhrd_id` int(11) NOT NULL,
  `vhritem_product` varchar(25) DEFAULT NULL,
  `vhritem_uom` varchar(12) DEFAULT NULL,
  `vhritem_qty` int(11) DEFAULT NULL,
  `vhritem_vehno` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE ma_customers (
  cid INT(11) AUTO_INCREMENT PRIMARY KEY,
  ccode VARCHAR(55) NOT NULL,
  cname VARCHAR(55) NOT NULL,
  cemail VARCHAR(55) NOT NULL UNIQUE,
  cphone VARCHAR(50) DEFAULT NULL,
  caddress TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE ma_suppliers (
  sid INT(11) AUTO_INCREMENT PRIMARY KEY,
  scode VARCHAR(55) NOT NULL,
  sname VARCHAR(55) NOT NULL,
  semail VARCHAR(55) NOT NULL UNIQUE,
  sphone VARCHAR(50) DEFAULT NULL,
  saddress TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
