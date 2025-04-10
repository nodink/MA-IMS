<?php

require_once '../inc/db.php';

$from =isset($_GET['datefrom']) ? ($_GET['datefrom']) : '2023-09-01';
$to =isset($_GET['dateto']) ? ($_GET['dateto']) : date('Y-m-d');

require_once 'logic.php';

$data = stockcals($conn, $from, $to);
// $rnbal = rnbal($conn, $from, $to);
// var_dump($data);
// exit();

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
			<form action="" method="get">
				<div class="w3-row">
					<div class="w3-container w3-quarter">
						<label><b>From</b></label>
						<input type="date" name="datefrom" class="w3-input" value="<?= $from ?>">
					</div>
					<div class="w3-container w3-quarter">
						<label><b>To</b></label>
						<input type="date" name="dateto" class="w3-input" value="<?= $to ?>">
					</div>
					<div class="w3-container w3-quarter">
						<button type="submit" name="submit" class="w3-button">Filter</button>
					</div>
				</div>
			<table id="matbl" class='w3-table w3-striped w3-hoverable'>
				<thead>
					<tr>
						<th>Category</th>
						<th>Product</th>
						<th>UoM</th>
						<th>Opening Bal</th>
						<th>Received</th>
						<th>Available</th>
						<th>Deliveris</th>
						<th>Transfers</th>
						<th>Issues</th>
						<th>Closing Bal</th>
					</tr>
				</thead>

				<?php
				foreach ($data as $sumlist) {
					$tis = $sumlist['dnqty'] + $sumlist['tnqty'];
					$tas = $sumlist["opbqty"] + $sumlist["rnqty"];
				?>
					<tr>
						<td><?= $sumlist['icat'] ?></td>
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