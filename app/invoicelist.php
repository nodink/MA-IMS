<?php

require_once '../inc/db.php';

$vdate = $reftype = $refno = $prod = $uom = $qty = "";

//$retsql = 'SELECT * FROM vhrdetails as d INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id ORDER BY d.vhrd_date ASC';
$retsql = 'SELECT d.vhrd_id,d.vhrd_date,d.vhrd_refno,d.vhrd_note,l1.loc_name as locin,l2.loc_name as locout,p.iname,i.vhritem_uom,i.vhritem_qty 
			   FROM vhrdetails as d 
			   INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id 
			   INNER JOIN products as p ON p.i_id = i.vhritem_product
			   INNER JOIN location as l1 ON d.vhrd_locin = l1.loc_id
			   INNER JOIN location as l2 ON d.vhrd_locout = l2.loc_id  
			   ORDER BY d.vhrd_date ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$data[] = $row;
}

$vhrlist = $data;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Voucher List</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
	<div class="w3-container">
		<h3>Voucher List</h3>
		<?php require_once '../inc/nav.php'; ?>

		<div class="w3-panel">

			<table id="matbl" class='w3-table w3-striped w3-hoverable'>
				<thead>
					<tr>
						<th>Date</th>
						<th>Ref. #</th>
						<th>Loc. In</th>
						<th>Loc. Out</th>
						<th>Product</th>
						<th>UoM</th>
						<th>Quantity</th>
						<th>Note</th>
					</tr>
				</thead>

				<?php
				foreach ($vhrlist as $vhr) {
					$vdate = date("d-M-y", strtotime($vhr["vhrd_date"])); ?>
					<tr>
						<td><?php echo $vdate; ?></td>
						<td><?php echo $vhr["vhrd_refno"]; ?></td>
						<td><?php echo $vhr["locin"]; ?></td>
						<td><?php echo $vhr["locout"]; ?></td>
						<td><?php echo $vhr["iname"]; ?></td>
						<td><?php echo $vhr["vhritem_uom"]; ?></td>
						<td><?php echo $vhr["vhritem_qty"]; ?></td>
						<td><?php echo $vhr["vhrd_note"]; ?></td>
						<td>
						<td>
							<button><a href="vhredit.php?vedit=<?php echo $vhr["vhrd_id"]; ?>" style="text-decoration: none;">Edit</a></button>
							<button disabled class="w3-border-red w3-red"><a href="ajaxdb.php?vdelete=<?php echo $vhr["vhrd_id"]; ?>" style="text-decoration: none;">Delete</a></button>
						</td>
						</td>
					</tr>
				<?php } ?>
			</table>


		</div>

	</div>
	<script src="../lib/sdt.js"></script>
</body>

</html>