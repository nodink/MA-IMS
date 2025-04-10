<?php

require_once '../inc/db.php';
// $conn = mysqli_connect("localhost:3318", "root", "root", "invoicedb");

// if (!$conn) {
// 	die("Error Connecting to DB : " . mysqli_connect_error());
// }

$fgsql = 'SELECT * FROM products WHERE icat="Semi-Finished Goods" OR icat="Finished Goods"  ORDER BY icode ASC';
$result = mysqli_query($conn, $fgsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}

$rmsql = 'SELECT * FROM products WHERE icat="Raw Material" OR icat="Semi-Finished Goods" OR icat="Packaging Materials" ORDER BY icode ASC';
$rmresult = mysqli_query($conn, $rmsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}

$locsql = 'SELECT * FROM location ORDER BY loc_code ASC';
$locresult = mysqli_query($conn, $locsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bill of Material</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>

<body>
	<div class="w3-container">
		<h3>Bill of Material</h3>
		<?php require_once '../inc/nav.php'; ?>

		<!-- <div class="w3-panel w3-left w3-border-right"> -->
		<div class="w3-card-800 w3-border">
			<form action="invoicedb.php" method="post">
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label>BOM Name</label>
						<input type="text" name="bomname" class="w3-input">
					</div>
					<div class="w3-container w3-cell">
						<label>Components of</label>
						<select name="fg" class="w3-input">
							<option value="" readonly>Select Item</option>
							<?php
							while ($row = mysqli_fetch_assoc($result)) {
								echo '<option value="' . $row["i_id"] . '">' . $row["iname"] . '</option>';
							} ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label>Unit of Manufacture</label>
						<input type="number" name="bomuom" class="w3-input">
					</div>
				</div>
				<table id="bomtbl" class="w3-table w3-striped w3-margin-top">
					<tr>
						<th>Item</th>
						<th>Location</th>
						<th>Type of Item</th>
						<th>Qty</th>
					</tr>
					<tr>
						<td>
							<select name="bomrm[]" class="w3-input">
								<option value="">Select Item</option>
								<?php
								while ($row = mysqli_fetch_assoc($rmresult)) {
									echo '<option value="' . $row["i_id"] . '">' . $row["iname"] . '</option>';
								} ?>
							</select>
						</td>
						<td>
							<select name="bomloc[]" class="w3-input">
								<option value="">Select Location</option>
								<?php
								while ($row = mysqli_fetch_assoc($locresult)) {
									echo '<option value="' . $row["loc_id"] . '">' . $row["loc_name"] . '</option>';
								} ?>
							</select>
						</td>
						<td>
							<select name="bomtype[]" class="w3-input">
								<option value="">Select Type</option>
								<option value="component">Component</option>
								<option value="co-product">Co-product</option>
								<option value="by-product">By-product</option>
								<option value="scrap">Scrap</option>
							</select>
						</td>
						<td>
							<input type="text" name="bomqty[]" class="w3-input">
						</td>
					</tr>
				</table>

				<hr>

				<table>
					<tr>
						<td><input type="button" value="Add Row" onclick="addRow('bomtbl')" /></td>
						<td><input type="button" value="Delete Row" onclick="deleteRow('bomtbl')" /></td>
						<td><input type="submit" name="bomsubmit" value="Submit" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>

</html>