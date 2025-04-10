<?php

require_once '../inc/db.php';

$from =isset($_GET['datefrom']) ? ($_GET['datefrom']) : '';
$to =isset($_GET['dateto']) ? ($_GET['dateto']) : '';
$item =isset($_GET['item']) ? ($_GET['item']) : '';

require_once 'logic.php';

$data = prodRunningBal($conn, $item);
$product = getTransProduct($conn);
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
						<label for="item"><b>Product</b></label>
						<select name="item" class="w3-input">
							<option value="" readonly>Select Item</option>
							<?php
								while ($row = mysqli_fetch_assoc($product)) { ?>
									<option value="<?= $row["iname"] ?>"
									  <?= $row["iname"] == $item ? 'selected' : 'Select Item' ?>>
									  <?= $row["iname"] ?>
									</option>
								<?php } ?>
						</select>
						<!-- <input type="text" name="item" class="w3-input" value="<?= $item ?>"> -->
					</div>
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
			</form>
			<div class="w3-card-2 w3-margin" style="width:25%">
				<header class="w3-container w3-light-grey">
					<h3 class="w3-center"><b><?= $item ?></b></h3>
				</header>
			</div>	
			<table id="matbl" class='w3-table w3-striped w3-hoverable'>
				<thead>
					<tr>
						<th>Date</th>
						<th>Ref. #</th>
						<th>Source</th>
						<th>Destination</th>
						<th>UoM</th>
						<th>Quantity</th>
						<th>Balance</th>
					</tr>
				</thead>

				<?php
				foreach ($data as $sumlist) {
					$vdate = date("d-M-y", strtotime($sumlist["vhrd_date"]));
					// $tis = $sumlist['dnqty'] + $sumlist['tnqty'];
					// $tas = $sumlist["opbqty"] + $sumlist["rnqty"];
				?>
					<tr>
						<td><?= $vdate ?></td>
						<td><?= $sumlist["vhrd_refno"] ?></td>
						<td><?= $sumlist["locout"] ?></td>
						<td><?= $sumlist["locin"] ?></td>
						<td><?= $sumlist["vhritem_uom"] ?></td> 
						<td><?= $sumlist["vhritem_qty"] ?></td>
						<td><?= $sumlist["running_balance"] ?></td>
					</tr>
				<?php } ?>
			</table>


		</div>

	</div>
	<script src="../lib/sdt.js"></script>
</body>

</html>