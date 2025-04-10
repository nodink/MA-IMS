<?php

require_once '../inc/db.php';

// $conn = mysqli_connect("localhost:3318", "root", "root", "invoicedb");

// if(!$conn) {
// 	die("Error Connecting to DB : ".mysqli_connect_error());
// }

//Voucher
if(isset($_POST["submit"])) {
	$reftype = $_POST["reftype"];
	$product = $_POST["product"];
	$uom = $_POST["uom"];
	$qty = $_POST["qty"];
	$vehno = $_POST["vehno"];

	if($reftype == "dn") {
		$sql = 'INSERT INTO vhrdetails(vhrd_date, vhrd_reftype, vhrd_refno, vhrd_locin, vhrd_locout, vhrd_customer, vhrd_note) VALUES("'.$_POST["vdate"].'", "'.$_POST["reftype"].'", "'.$_POST["refno"].'", "'.$_POST["locin"].'", "'.$_POST["locout"].'", "'.$_POST["customer"].'", "'.$_POST["note"].'")';
	} elseif ($reftype == "rn") {
		$sql = 'INSERT INTO vhrdetails(vhrd_date, vhrd_reftype, vhrd_refno, vhrd_locin, vhrd_locout, vhrd_supplier, vhrd_note) VALUES("'.$_POST["vdate"].'", "'.$_POST["reftype"].'", "'.$_POST["refno"].'", "'.$_POST["locin"].'", "'.$_POST["locout"].'", "'.$_POST["supplier"].'", "'.$_POST["note"].'")';
	} else {
		$sql = 'INSERT INTO vhrdetails(vhrd_date, vhrd_reftype, vhrd_refno, vhrd_locin, vhrd_locout, vhrd_note) VALUES("'.$_POST["vdate"].'", "'.$_POST["reftype"].'", "'.$_POST["refno"].'", "'.$_POST["locin"].'", "'.$_POST["locout"].'", "'.$_POST["note"].'")';
	}
	mysqli_query($conn, $sql);
	$lastInsertId = mysqli_insert_id($conn);
	foreach ($product as $key => $value) {
		$sqlprod = 'INSERT INTO vhritems(vhrd_id, vhritem_product,vhritem_uom,vhritem_qty,vhritem_vehno) VALUES("'.$lastInsertId.'", "'.$product[$key].'", "'.$uom[$key].'", "'.$qty[$key].'", "'.$vehno[$key].'")';
	
		$rs = mysqli_query($conn, $sqlprod);
	}
		if($rs) 
		{
			header('location: invoicelist.php');
		} else {
			echo "Error inserting data.........<br>".mysqli_error($conn);
		}
}

if(isset($_POST["vhrid"])) {
	$reftype = $_POST["reftype"];
	$product = $_POST["product"];
	$uom = $_POST["uom"];
	$qty = $_POST["qty"];
	$vehno = $_POST["vehno"];

	if($reftype == "dn") {
		$sql = 'UPDATE vhrdetails 
				SET vhrd_date="'.$_POST["vdate"].'", vhrd_reftype="'.$_POST["reftype"].'", vhrd_refno="'.$_POST["refno"].'", vhrd_locin="'.$_POST["locin"].'", vhrd_locout="'.$_POST["locout"].'", vhrd_customer="'.$_POST["customer"].'", vhrd_note="'.$_POST["note"].'" 
				WHERE vhrd_id="'.$_POST["vhrid"].'"';
	} elseif ($reftype == "rn") {
		$sql = 'UPDATE vhrdetails 
		        SET vhrd_date="'.$_POST["vdate"].'", vhrd_reftype="'.$_POST["reftype"].'", vhrd_refno="'.$_POST["refno"].'", vhrd_locin="'.$_POST["locin"].'", vhrd_locout="'.$_POST["locout"].'", vhrd_supplier="'.$_POST["supplier"].'", vhrd_note="'.$_POST["note"].'" 
				WHERE vhrd_id="'.$_POST["vhrid"].'"';
	} else {
		$sql = 'UPDATE vhrdetails
		        SET vhrd_date="'.$_POST["vdate"].'", vhrd_reftype="'.$_POST["reftype"].'", vhrd_refno="'.$_POST["refno"].'", vhrd_locin="'.$_POST["locin"].'", vhrd_locout="'.$_POST["locout"].'", vhrd_note="'.$_POST["note"].'" 
				WHERE vhrd_id="'.$_POST["vhrid"].'"';
	}
	mysqli_query($conn, $sql);
	$lastInsertId = $_POST["vhrid"];
	$vdsql = 'DELETE FROM vhritems WHERE vhrd_id="'.$_POST["vhrid"].'"';
	mysqli_query($conn, $vdsql);
	foreach ($product as $key => $value) {
		$sqlprod = 'INSERT INTO vhritems(vhrd_id, vhritem_product,vhritem_uom,vhritem_qty,vhritem_vehno) VALUES("'.$lastInsertId.'", "'.$product[$key].'", "'.$uom[$key].'", "'.$qty[$key].'", "'.$vehno[$key].'")';
	
		$rs = mysqli_query($conn, $sqlprod);
	}
		if($rs) 
		{
			header('location: invoicelist.php');
		} else {
			echo "Error updating data.........<br>".mysqli_error($conn);
		}
}

//Add Manufacture
if(isset($_POST["mfsubmit"])) {
	$rmitem = $_POST["rmitem"];
	$rmloc = $_POST["rmloc"];
	$stdqty = $_POST["stdqty"];
	$actqty = $_POST["actqty"];
	
	$mfsql = 'INSERT INTO manufact(mf_date, mf_reftype, mf_refno, mf_fitem, mf_bom, mf_loc, mf_fqty, mf_note) VALUES("'.$_POST["mfdate"].'", "'.$_POST["mftype"].'", "'.$_POST["mfno"].'", "'.$_POST["mfitem"].'", "'.$_POST["mfbom"].'", "'.$_POST["mfloc"].'", "'.$_POST["mfqty"].'", "'.$_POST["mfnote"].'")';
	
	mysqli_query($conn, $mfsql);
	$lastInsertId = mysqli_insert_id($conn);
	foreach ($rmitem as $key => $value) {
		$sqlmf = 'INSERT INTO manufactitems(mf_id, mf_rmitem,mf_rmloc,mf_stdqty,mf_actqty) VALUES("'.$lastInsertId.'", "'.$rmitem[$key].'", "'.$rmloc[$key].'", "'.$stdqty[$key].'", "'.$actqty[$key].'")';
	
		$mfrs = mysqli_query($conn, $sqlmf);
	}
		if($mfrs) 
		{
			header('location: manufacture.php');
		} else {
			echo "Error inserting data.........<br>".mysqli_error($conn);
		}
} 

//Add Items/Products
if(isset($_POST["isubmit"])) {
	$isql = 'INSERT INTO products(u_id, icode, iname, icat) VALUES("'.$_POST["iuom"].'", "'.$_POST["icode"].'", "'.$_POST["iname"].'", "'.$_POST["icat"].'")';

	if(mysqli_query($conn, $isql)) {
		header('location: itemlist.php');
	} else {
		echo "Error in saving data........ ".mysqli_error($conn);
	}
}

if(isset($_POST["itemid"])){
	$isql = 'UPDATE products SET u_id="'.$_POST["iuom"].'", icode="'.$_POST["icode"].'", iname="'.$_POST["iname"].'", icat="'.$_POST["icat"].'" WHERE i_id="'.$_POST["itemid"].'"';
	if(mysqli_query($conn, $isql)) {
		header('location: itemlist.php');
	} else {
		echo "Error in updating data........ ".mysqli_error($conn);
	}
}

//Add Customer
if(isset($_POST["csubmit"])) {
	$csql = 'INSERT INTO ma_customers(ccode, cname, cemail, cphone, caddress) VALUES("'.$_POST["ccode"].'", "'.$_POST["cname"].'", "'.$_POST["cemail"].'", "'.$_POST["cphone"].'", "'.$_POST["caddress"].'")';

	if(mysqli_query($conn, $csql)) {
		header('location: customerlist.php');
	} else {
		echo "Error in saving data........ ".mysqli_error($conn);
	}
}

if(isset($_POST["custid"])){
	$isql = 'UPDATE ma_customers SET ccode="'.$_POST["ccode"].'", cname="'.$_POST["cname"].'", cemail="'.$_POST["cemail"].'", cphone="'.$_POST["cphone"].'", caddress="'.$_POST["caddress"].'" WHERE cid="'.$_POST["custid"].'"';
	if(mysqli_query($conn, $isql)) {
		header('location: customerlist.php');
	} else {
		echo "Error in updating data........ ".mysqli_error($conn);
	}
}

//Add Spplier
if(isset($_POST["ssubmit"])) {
	$csql = 'INSERT INTO ma_suppliers(scode, sname, semail, sphone, saddress) VALUES("'.$_POST["scode"].'", "'.$_POST["sname"].'", "'.$_POST["semail"].'", "'.$_POST["sphone"].'", "'.$_POST["saddress"].'")';

	if(mysqli_query($conn, $csql)) {
		header('location: supplierlist.php');
	} else {
		echo "Error in saving data........ ".mysqli_error($conn);
	}
}

if(isset($_POST["suppid"])){
	$isql = 'UPDATE ma_suppliers SET scode="'.$_POST["scode"].'", sname="'.$_POST["sname"].'", semail="'.$_POST["semail"].'", sphone="'.$_POST["sphone"].'", saddress="'.$_POST["saddress"].'" WHERE sid="'.$_POST["suppid"].'"';
	if(mysqli_query($conn, $isql)) {
		header('location: supplierlist.php');
	} else {
		echo "Error in updating data........ ".mysqli_error($conn);
	}
}

//UoM
if(isset($_POST["usubmit"])) {
	$usql = 'INSERT INTO uom(ucode, uname) VALUES("'.$_POST["ucode"].'", "'.$_POST["uname"].'")';

	if(mysqli_query($conn, $usql)) {
		header('location: uom.php');
	} else {
		echo "Error in data entry........ ".mysqli_error($conn);
	}
}

if(isset($_POST["uomid"])){
	$usql = 'UPDATE uom SET ucode="'.$_POST["ucode"].'", uname="'.$_POST["uname"].'" WHERE u_id="'.$_POST["uomid"].'"';
	if(mysqli_query($conn, $usql)) {
		header('location: uom.php');
	} else {
		echo "Error in data entry........ ".mysqli_error($conn);
	}
}

//Location
if(isset($_POST["locsubmit"])) {
	$lsql = 'INSERT INTO location(loc_code, loc_name) VALUES("'.$_POST["loccode"].'", "'.$_POST["locname"].'")';

	if(mysqli_query($conn, $lsql)) {
		header('location: loc.php');
	} else {
		echo "Error in data entry........ ".mysqli_error($conn);
	}
}

if(isset($_POST["locid"])){
   $lsql = 'UPDATE location SET loc_code="'.$_POST["loccode"].'", loc_name="'.$_POST["locname"].'" WHERE loc_id="'.$_POST["locid"].'"';
    if(mysqli_query($conn, $lsql)) {
		header('location: loc.php');
	} else {
		echo "Error in data entry........ ".mysqli_error($conn);
	}
}


//BOM 
if(isset($_POST["bomsubmit"])) {
	$bomrm = $_POST["bomrm"];
	$bomloc = $_POST["bomloc"];
	$bomtype = $_POST["bomtype"];
	$bomqty = $_POST["bomqty"];

	$sql = 'INSERT INTO bom(bom_name, bom_fitem, bom_uom) VALUES("'.$_POST["bomname"].'", "'.$_POST["fg"].'", "'.$_POST["bomuom"].'")';
	
	mysqli_query($conn, $sql);
	$lastInsertId = mysqli_insert_id($conn);
	foreach ($bomrm as $key => $value) {
		$sqlbom = 'INSERT INTO bomitems(bom_id, bom_item, bom_loc, bom_type, bom_qty) VALUES("'.$lastInsertId.'", "'.$bomrm[$key].'", "'.$bomloc[$key].'", "'.$bomtype[$key].'", "'.$bomqty[$key].'")';
	
		$bomrs = mysqli_query($conn, $sqlbom);
	}
		if($bomrs) 
		{
			header('location: bom.php');
		} else {
			echo "Error inserting data.........<br>".mysqli_error($conn);
		}
}

//Edit BOM
if(isset($_POST["bomid"])) {
	$bomtype = $_POST["bomtype"];
	$bomrm = $_POST["bomrm"];
	$bomloc = $_POST["bomloc"];
	$bomqty = $_POST["bomqty"];

	$besql ='UPDATE bom 
			 SET bom_name="'.$_POST["bomname"].'", bom_fitem="'.$_POST["bomfitem"].'", bom_uom="'.$_POST["bomuom"].'" 
				WHERE bom_id="'.$_POST["bomid"].'"';
	mysqli_query($conn, $besql);
	$lastInsertId = $_POST["bomid"];
	$bisql = 'DELETE FROM bomitems WHERE bom_id="'.$_POST["bomid"].'"';
	mysqli_query($conn, $bisql);
	foreach ($bomrm as $key => $value) {
		$sqlbi = 'INSERT INTO bomitems(bom_id, bom_item, bom_loc, bom_type, bom_qty) VALUES("'.$lastInsertId.'", "'.$bomrm[$key].'", "'.$bomloc[$key].'", "'.$bomtype[$key].'", "'.$bomqty[$key].'")';
	
		$rs = mysqli_query($conn, $sqlbi);
	}
		if($rs) 
		{
			header('location: invoicelist.php');
		} else {
			echo "Error updating data.........<br>".mysqli_error($conn);
		}
}





///////////////////////////////////////////////////////////////////////////
/*
$array = array(10, 25, 7, 89, 100) ; // This is your array of IDs

$sql = $db->prepare("INSERT INTO selected (selected_customer) VALUES (:param_id)") ; // Prepare the INSERT

foreach($array as $id) {   // Iterate through the array
    $sql->execute([':param_id' => $id]) ;   // Execute for each ID
}

$sqlQuery = "
		SELECT * FROM ".$this->attdtbl." as a
		INNER JOIN ".$this->emptbl." as e ON e.emp_id = a.attd_emp
		INNER JOIN ".$this->dsttbl." as d ON d.dst_id = a.attd_dst
		INNER JOIN ".$this->shifttbl." as s ON s.shift_id = a.attd_shift
		ORDER BY a.attd_date DESC";
		return  $this->getData($sqlQuery);

////////////////////////////////////////////////////////////////////////////
function save(){
    include ('connect.php');

        if (isset($_POST['submit'])) {
            $name=$_POST['name'];
            $quantity=$_POST['amount'];
            $wholesale=$_POST['wholesale'];
            $retail=$_POST['retail'];
            $username=$_POST['username'];

$select_data="select * from drugs where name='$name'";
                $run_data=mysql_query($select_data);
         $row=mysql_fetch_array($run_data);
            $newname=$row['name'];

            $select_username="select * from pharmacist where username='$username'";
    $run_username=mysql_query($select_username);
    $row=mysql_fetch_array($run_username);
    $servedby=$row['username'];

        $insert="insert into amount_required (name,quantity,wholesale,retail,tarehe,servedby)
 values('$newname','$quantity','$wholesale','$retail','$username',NOW(),'$servedby')";
        $run_insert=mysql_query($insert);

        if ($run_insert) {
            echo "<script>alert('Item Entered Successful')</script>";
            echo "<script>window.open('submit.php','_self')</script>";
}
}
*/