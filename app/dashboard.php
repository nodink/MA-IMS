<?php

require_once '../inc/db.php';

$sqlbal = 'SELECT DISTINCT p.iname, p.icat, i.vhritem_uom,
				SUM(CASE WHEN d.vhrd_reftype="opb" THEN i.vhritem_qty ELSE 0 END) as opbqty,
				SUM(CASE WHEN d.vhrd_reftype="rn" THEN i.vhritem_qty ELSE 0 END) as rnqty,
				SUM(CASE WHEN d.vhrd_reftype="dn" THEN i.vhritem_qty ELSE 0 END) as dnqty,
				SUM(CASE WHEN d.vhrd_reftype="tn" THEN i.vhritem_qty ELSE 0 END) as tnqty
				FROM vhrdetails as d 
			    INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id
			    INNER JOIN products as p ON p.i_id = i.vhritem_product
			    GROUP BY p.iname, p.icat, i.vhritem_uom';

$rmrs = mysqli_query($conn, $sqlbal);
if (!$rmrs) {
	die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_assoc($rmrs)) {
	$data[] = $row;
	//$product = $row['iname'];           
}

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Stock Report</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
	<div class="w3-container">
		<h3>Stock Report</h3>
		<?php require_once '../inc/nav.php'; ?>

		<div class="w3-panel">

			<table id="matbl" class='w3-table w3-striped w3-hoverable'>
				<thead>
					<tr>
						<th>Category</th>
						<th>Product</th>
						<th>UoM</th>
						<th>Opening Bal</th>
						<th>Received</th>
						<th>Available</th>
						<th>Deliveries</th>
						<th>Transfers</th>
						<th>Issues</th>
						<th>Closing Bal</th>
					</tr>
				</thead>

				<?php
				foreach ($data as $sumlist) {
					$tas = $sumlist["opbqty"] + $sumlist["rnqty"];
					$tis = $sumlist["dnqty"] + $sumlist["tnqty"]; ?>
					<tr>
						<td><?= $sumlist["icat"] ?></td>
						<td><?= $sumlist["iname"] ?></td>
						<td><?= $sumlist["vhritem_uom"] ?></td>
						<td><?= $sumlist["opbqty"] ?></td>
						<td><?= $sumlist["rnqty"] ?></td>
						<td><?= $tas ?></td>
						<td><?= $sumlist["dnqty"] ?></td>
						<td><?= $sumlist["tnqty"] ?></td>
						<td><?= $tis ?></td>
						<td><?= $tas - $tis ?></td>
					</tr>
				<?php } ?>
			</table>


		</div>

	</div>
	<script src="../lib/sdt.js"></script>
</body>

</html>