<?php

require_once '../inc/db.php';

// $conn = mysqli_connect("localhost:3318", "root", "root", "invoicedb");

// if(!$conn) {
// 	die("Error Connecting to DB : ".mysqli_connect_error());
// }

if(isset($_GET["bomi"])) {
$bom = $_GET["bomi"];

$bsql = 'SELECT p.iname, l.loc_name FROM bom as b 
		 INNER JOIN bomitems as bi ON b.bom_id = bi.bom_id  
		 INNER JOIN products as p ON bi.bom_item = p.i_id
		 INNER JOIN location as l ON bi.bom_loc = l.loc_id 
		 AND b.bom_id = "'.$bom.'"';

$brs = mysqli_query($conn, $bsql);
$data = array();
if(mysqli_num_rows($brs) > 0 ){
	while($row = mysqli_fetch_assoc($brs)) {
		$data[] = $row;
		//echo $row['ucode'];
	}
	echo json_encode($data);
  }
}

//Product select UoM show
if(isset($_GET["q"])) {
$q = $_GET["q"];
$hint = "";

$xsql = 'SELECT ucode FROM products as p INNER JOIN uom as u WHERE p.u_id = u.u_id AND p.i_id="'.$q.'" LIMIT 1';

$rs = mysqli_query($conn, $xsql);
if(mysqli_num_rows($rs) > 0 ){
	while($row = mysqli_fetch_array($rs)) {
		echo $row['ucode'];
	}
  }
}

//UoM Edit
$urs = '';
if(isset($_POST["uedit"])) {
	$ue = $_POST["uedit"];
	$uesql = 'SELECT * FROM uom WHERE u_id = "'.$ue.'"';
	$urs = mysqli_query($conn, $uesql);
	$data = array(); 
	if(mysqli_num_rows($urs) > 0 ){
		while($row = mysqli_fetch_assoc($urs)) {
		$data[] = $row;
	}
	echo json_encode($data);
  }
} elseif (isset($_POST["udelete"])) {
	$ud = $_POST["udelete"];
	$udsql = 'DELETE FROM uom WHERE u_id = "'.$ud.'" LIMIT 1';
	$urs = mysqli_query($conn, $udsql);
	echo "Data deleted successfully";
} 


//Location Edit
$lrs = '';
if(isset($_POST["ledit"])) {
	$le = $_POST["ledit"];
	$lesql = 'SELECT * FROM location WHERE loc_id = "'.$le.'"';
	$lrs = mysqli_query($conn, $lesql);
	$data = array(); 
	if(mysqli_num_rows($lrs) > 0 ){
		while($row = mysqli_fetch_assoc($lrs)) {
		$data[] = $row;
	}
	echo json_encode($data);
  }
} elseif (isset($_POST["ldelete"])) {
	$ld = $_POST["ldelete"];
	$ldsql = 'DELETE FROM location WHERE loc_id = "'.$ld.'" LIMIT 1';
	$lrs = mysqli_query($conn, $ldsql);
	echo "Data deleted successfully";
} 