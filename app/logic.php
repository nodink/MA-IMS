<?php

// require_once '../inc/db.php';
function getTransProduct($conn) {
	$retsql = 'SELECT DISTINCT p.i_id, p.iname FROM vhritems as i INNER JOIN products as p WHERE p.i_id = i.vhritem_product ORDER BY p.iname ASC';
	$result = mysqli_query($conn, $retsql);
	if (!$result) {
		die('Error in query: ' . mysqli_error($conn));
	}

	// $data = array();
	// while ($row = mysqli_fetch_assoc($rmrs)) {
	// 	$data[] = $row;         
	// }

	return $result;
}

function getAllCustomer($conn) {
	$isql = 'SELECT * FROM ma_customers';
	$irs = mysqli_query($conn, $isql);
	if (!$irs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_array($irs, MYSQLI_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}

function getCustomer($conn, $edit) {
	$isql = 'SELECT * FROM ma_customers as c WHERE c.cid = "' . $edit . '"';
	$irs = mysqli_query($conn, $isql);
	if (!$irs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_array($irs, MYSQLI_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}

function getAllSupplier($conn) {
	$isql = 'SELECT * FROM ma_suppliers';
	$irs = mysqli_query($conn, $isql);
	if (!$irs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_array($irs, MYSQLI_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}

function getSupplier($conn, $edit) {
	$isql = 'SELECT * FROM ma_suppliers as s WHERE s.sid = "' . $edit . '"';
	$irs = mysqli_query($conn, $isql);
	if (!$irs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_array($irs, MYSQLI_ASSOC)) {
		$data[] = $row;
	}

	return $data;
}

function getUoM($conn) {
	$retsql = 'SELECT * FROM uom ORDER BY ucode ASC';
	$result = mysqli_query($conn, $retsql);
	if (!$result) {
		die('Error in query: ' . mysqli_error($conn));
	}

	return $result;
}

// function getTypeOfbom(){		
// 	$sqlQuery = "SELECT * FROM bom
// 	    INNER JOIN  as d ON d.dept_id = e.dept_name
// 	    WHERE e.dept_name = '".$_POST['dept']."'   
// 		ORDER BY e.emp_name ASC";	
// 	$result = mysqli_query($this->dbConnect, $sqlQuery);	
// 	$dempHTML = '';
// 	while( $demp = mysqli_fetch_assoc($result)) {
// 		$dempHTML .= '<option value="'.$demp["emp_name"].'">'.$demp["emp_name"].'</option>';	
// 	}
// 	echo $dempHTML;
// 	}

function OpeningBal($conn, $date) {
	$sql = "SELECT DISTINCT p.iname, p.icat, i.vhritem_uom,
				SUM(CASE WHEN d.vhrd_reftype='opb' THEN i.vhritem_qty ELSE 0 END) + 
				SUM(CASE WHEN d.vhrd_reftype='rn' THEN i.vhritem_qty ELSE 0 END) - 
				SUM(CASE WHEN d.vhrd_reftype='dn' THEN i.vhritem_qty ELSE 0 END) - 
				SUM(CASE WHEN d.vhrd_reftype='tn' THEN i.vhritem_qty ELSE 0 END) AS opbqty
			FROM vhrdetails as d 
			INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
			INNER JOIN products as p ON p.i_id = i.vhritem_product
			WHERE d.vhrd_date < '".$date."'
			GROUP BY p.iname, p.icat, i.vhritem_uom";

	$rmrs = mysqli_query($conn, $sql);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;         
	}

	return $data;
}

// -- WHERE d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'"

function stockbal($conn, $from, $to) {
	$sqlbal = 'SELECT DISTINCT p.iname, p.icat, i.vhritem_uom,
					SUM(CASE WHEN d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) as opbqty,
					SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) as rnqty,
					SUM(CASE WHEN d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) as dnqty,
					SUM(CASE WHEN d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) as tnqty
					FROM vhrdetails as d 
				    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
				    INNER JOIN products as p ON p.i_id = i.vhritem_product
				    WHERE d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'"
				    GROUP BY p.iname, p.icat, i.vhritem_uom';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;

}

function stockcal($conn, $from, $to) {
	$sqlbal = '
    SELECT p.iname, p.icat, i.vhritem_uom,
        SUM(CASE WHEN d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) as opbqty,
        SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) as rnqty,
        SUM(CASE WHEN d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) as dnqty,
        SUM(CASE WHEN d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) as tnqty
    FROM vhrdetails as d 
    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
    INNER JOIN products as p ON p.i_id = i.vhritem_product
    WHERE d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'"
    GROUP BY p.iname, p.icat, i.vhritem_uom

    UNION 

    SELECT p.iname, p.icat, i.vhritem_uom,
		SUM(CASE WHEN d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) + 
		SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) - 
		SUM(CASE WHEN d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) - 
		SUM(CASE WHEN d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) AS opbqty
    FROM vhrdetails as d 
    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
    INNER JOIN products as p ON p.i_id = i.vhritem_product
    WHERE d.vhrd_date < "'.$from.'"
    GROUP BY p.iname, p.icat, i.vhritem_uom
';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;

}

function rnbal($conn, $from, $to) {
	$sqlbal = 'SELECT DISTINCT p.iname, p.icat, i.vhritem_uom,
					SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty END) as rnqty
					FROM vhrdetails as d 
				    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
				    INNER JOIN products as p ON p.i_id = i.vhritem_product
				    WHERE d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'"
				    GROUP BY p.iname, p.icat, i.vhritem_uom';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;

}

function stockcals($conn, $from, $to) {
	$sqlbal = '
    SELECT 
        p.iname, 
        p.icat, 
        i.vhritem_uom,
        SUM(CASE WHEN d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'" AND d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) as opbqty,
        SUM(CASE WHEN d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'" AND d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) as rnqty,
        SUM(CASE WHEN d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'" AND d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) as dnqty,
        SUM(CASE WHEN d.vhrd_date BETWEEN "'.$from.'" AND "'.$to.'" AND d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) as tnqty,
        SUM(CASE WHEN d.vhrd_date < "'.$from.'" AND d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) +
        SUM(CASE WHEN d.vhrd_date < "'.$from.'" AND d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) -
        SUM(CASE WHEN d.vhrd_date < "'.$from.'" AND d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) -
        SUM(CASE WHEN d.vhrd_date < "'.$from.'" AND d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) AS opbqty
	    FROM 
	        vhrdetails as d 
	    INNER JOIN 
	        vhritems as i ON i.vhrd_id = d.vhrd_id
	    INNER JOIN 
	        products as p ON p.i_id = i.vhritem_product
	    GROUP BY 
	        p.iname, p.icat, i.vhritem_uom
	';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;
}

function groupbal($conn, $group) {
	$sqlbal = 'SELECT p.iname, i.vhritem_uom,
				SUM(CASE WHEN d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) as opbqty,
				SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) as rnqty,
				SUM(CASE WHEN d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) as dnqty,
				SUM(CASE WHEN d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) as tnqty
				FROM vhrdetails as d 
			    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
			    INNER JOIN products as p ON p.i_id = i.vhritem_product
			    WHERE p.icat = "'.$group.'"
			    GROUP BY p.iname, i.vhritem_uom';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;
}

function prodPerTrans($conn, $product) {
	$sqlbal = 'SELECT p.iname, d.vhrd_date, d.vhrd_refno, i.vhritem_uom,
				i.vhritem_qty,l1.loc_name as locin,l2.loc_name as locout
					FROM vhrdetails as d 
				    JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
				    JOIN products as p ON p.i_id = i.vhritem_product
				    JOIN location as l1 ON d.vhrd_locin = l1.loc_id
			   		JOIN location as l2 ON d.vhrd_locout = l2.loc_id
				    WHERE p.iname = "'.$product.'"
				    ORDER BY d.vhrd_date';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;

}

function prodRunningBal($conn, $product) {
	$sqlbal = 'SELECT p.iname, d.vhrd_date, d.vhrd_refno, i.vhritem_uom,
				i.vhritem_qty,l1.loc_name as locin,l2.loc_name as locout,
				(SELECT 
                	SUM(CASE WHEN v2.vhrd_reftype = "opb" THEN i2.vhritem_qty 
                          WHEN v2.vhrd_reftype = "rn" THEN i2.vhritem_qty 
                          WHEN v2.vhrd_reftype = "dn" THEN -i2.vhritem_qty 
                          WHEN v2.vhrd_reftype = "tn" THEN -i2.vhritem_qty 
                    	END) 
			              FROM vhrdetails v2 
			              JOIN vhritems AS i2 ON i2.vhrd_id = v2.vhrd_id
				  		  JOIN products AS p2 ON p2.i_id = i2.vhritem_product
			              WHERE p2.iname = "'.$product.'" AND v2.vhrd_date <= d.vhrd_date
			    ) AS running_balance 
					FROM vhrdetails as d 
				    JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
				    JOIN products as p ON p.i_id = i.vhritem_product
				    JOIN location as l1 ON d.vhrd_locin = l1.loc_id
			   		JOIN location as l2 ON d.vhrd_locout = l2.loc_id
				    WHERE p.iname = "'.$product.'"
				    ORDER BY d.vhrd_date';

	$rmrs = mysqli_query($conn, $sqlbal);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;

}

function getRunningBal($conn, $productId) {
    $query = '
        SELECT 
            v.vhrd_date,
            v.vhrd_refno,
            v.vhrd_reftype,
            i.vhritem_qty,
            (SELECT 
                SUM(CASE WHEN v2.vhrd_reftype = "opb" THEN i2.vhritem_qty 
                          WHEN v2.vhrd_reftype = "rn" THEN i2.vhritem_qty 
                          WHEN v2.vhrd_reftype = "dn" THEN -i2.vhritem_qty 
                          WHEN v2.vhrd_reftype = "tn" THEN -i2.vhritem_qty 
                    END) 
             FROM vhrdetails v2 
             JOIN vhritems AS i2 ON i2.vhrd_id = v2.vhrd_id
	  		 JOIN products AS p2 ON p2.i_id = i2.vhritem_product
             WHERE p2.iname = "'.$productId.'" AND v2.vhrd_date <= v.vhrd_date
            ) AS running_balance
            FROM vhrdetails v
            JOIN vhritems AS i ON i.vhrd_id = v.vhrd_id
	  		JOIN products AS p ON p.i_id = i.vhritem_product
            WHERE p.iname = "'.$productId.'"
            ORDER BY v.vhrd_date
    ';    

    $rmrs = mysqli_query($conn, $query);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	while ($row = mysqli_fetch_assoc($rmrs)) {
		$data[] = $row;          
	}

	return $data;
}

