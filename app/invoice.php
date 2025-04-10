<?php

require_once '../inc/db.php';
require_once 'logic.php';

$retsql = 'SELECT * FROM products as p INNER JOIN uom as u WHERE p.u_id = u.u_id ORDER BY p.icode ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}

$locsql = 'SELECT * FROM location ORDER BY loc_code ASC';
$locinrs = mysqli_query($conn, $locsql);
$locoutrs = mysqli_query($conn, $locsql);

$supp = getAllSupplier($conn);
$cust = getAllCustomer($conn);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Voucher</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<!--<script src="../lib/addrow.js"></script>-->
</head>

<body>
	<div class="w3-container">
		<h3>My Voucher</h3>
		<?php require_once '../inc/nav.php'; ?>

		<!-- <div class="w3-panel w3-left w3-border-right"> -->
		<div class="w3-card-800 w3-border">
			<form action="invoicedb.php" method="post">
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label><b>Date</b></label>
						<input type="date" name="vdate" class="w3-input">
					</div>
					<div class="w3-container w3-cell">
						<label><b>Ref. Type</b></label>
						<select name="reftype" id="reft" class="w3-input" onchange="showDiv('id01','id02', this)">
							<option value="">Select Voucher</option>
							<option value="dn">Delivery Note</option>
							<option value="rn">Receipt Note</option>
							<option value="tn">Transfer Note</option>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Ref. #</b></label>
						<input type="text" name="refno" class="w3-input" autocomplete="off">
					</div>
				</div>
				<div class="w3-cell-row w3-margin-top">
					<div class="w3-container w3-cell">
						<label><b>Location In</b></label>
						<select name="locin" class="w3-input">
							<option value="">Select Location</option>
							<?php
							while ($row = mysqli_fetch_assoc($locinrs)) {
								echo '<option value="' . $row["loc_id"] . '">' . $row["loc_name"] . '</option>';
							} ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Location Out</b></label>
						<select name="locout" class="w3-input">
							<option value="">Select Location</option>
							<?php
							while ($row = mysqli_fetch_assoc($locoutrs)) {
								echo '<option value="' . $row["loc_id"] . '">' . $row["loc_name"] . '</option>';
							} ?>
						</select>
					</div>
					<div id="id01" class="w3-container w3-cell" style="display: none;">
						<label><b>Supplier</b></label>
						<select name="supplier" class="w3-input">
							<option value="">Select Supplier</option>
							<?php
							foreach ($supp as $row) {
								echo '<option value="' . $row["sid"] . '">' . $row["sname"] . '</option>';
							} ?>
						</select>
					</div>
					<div id="id02" class="w3-container w3-cell" style="display: none;">
						<label><b>Customer</b></label>
						<select name="supplier" class="w3-input">
							<option value="">Select Supplier</option>
							<?php
							foreach ($cust as $row) {
								echo '<option value="' . $row["cid"] . '">' . $row["cname"] . '</option>';
							} ?>
						</select>
					</div>
				</div>
				<hr>
				<table id="vhrtbl" class="w3-table w3-striped">
					<tr>
						<th style="width: 40px">Product</th>
						<th style="width: 20px">UoM</th>
						<th style="width: 20px">Qty</th>
						<th style="width: 20px">Veh. #</th>
					</tr>
					<tr class="rw0">
						<td id="col0">
							<select id="product_1" name="product[]" class="w3-input">
								<option value="" readonly>Select Item</option>
								<?php
								while ($row = mysqli_fetch_assoc($result)) {
									echo '<option value="' . $row["i_id"] . '" data-uom="' . $row["ucode"] . '">' . $row["iname"] . '</option>';
								} ?>
							</select>
						</td>
						<td id="col1">
							<input id="uom_1" type="text" class="w3-input" name="uom[]" value="">
						</td>
						<td id="col2">
							<input id="qty_1" type="number" class="w3-input" name="qty[]">
						</td>
						<td id="col3">
							<input id="vehno_1" type="text" class="w3-input" name="vehno[]">
						</td>
					</tr>
				</table>

				<hr>
				<div class="w3-container w3-cell">
					<label>Note</label>
					<textarea name="note" class="w3-input"></textarea>
				</div>
				<hr>

				<table>
					<tr>
						<td><input type="button" value="Add Row" onclick="addRow('vhrtbl')" /></td>
						<td><input type="button" value="Delete Row" onclick="deleteRow('vhrtbl')" /></td>
						<td><input type="submit" name="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

	<script src="../lib/addrow.js"></script>
	<script type="text/javascript">
		function showDiv(divId1, divId2, element) {
			let div1 = document.getElementById(divId1).style;
			let div2 = document.getElementById(divId2).style;
			//.display = element.value == "compound" ? 'block' : 'none';

			//if (element.value = 'rn') {
			//	div.display = 'block';
			//} else if(element.value = 'dn') { 
			//	div.display = 'block';
			//}

			switch (element.value) {
				case 'rn':
					div1.display = 'block';
					div2.display = 'none';
					break;
				case 'dn':
					div2.display = 'block';
					div1.display = 'none';
					break;
				default:
					div1.display = 'none';
					div2.display = 'none';
			}
		}

		//Shows UoM of Product selected
		document.addEventListener("change", function(event) {
			//var ett = event.target.id;
			//console.log(ett);
			if (event.target.id.includes("product")) {
				var ct = event.target.id;
				var seltr = document.getElementById(ct);
				var inp = seltr.parentNode.nextElementSibling.firstElementChild.getAttribute("id");
				//console.log(ct);
				//console.log(inp);
				var selected = seltr.options[seltr.selectedIndex];
				var extra = selected.getAttribute('data-uom');
				var priceInput = document.getElementById(inp);
				//priceInput.disabled = false;
				priceInput.value = extra;
			}
		});
		
	</script>
</body>

</html>