<?php

require_once '../inc/db.php';

if (isset($_GET['vedit'])) {
	$vedit = $_GET['vedit'];
	$vhdata = array();
	$rowlen = '';
	//$vsql = 'SELECT * FROM vhrdetails as d INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id AND d.vhrd_id = "'.$vedit.'"';
	$vdsql = 'SELECT * FROM vhrdetails WHERE vhrd_id = "' . $vedit . '"';
	$visql = 'SELECT * FROM vhritems as vi 
		      INNER JOIN products as p WHERE vi.vhritem_product = p.i_id
		      AND vhrd_id = "' . $vedit . '"';
	$vdrs = mysqli_query($conn, $vdsql);
	$virs = mysqli_query($conn, $visql);
	if (!$vdrs) {
		die('Error in query: ' . mysqli_error($conn));
	} else {
		//$data = mysqli_fetch_assoc($irs)
		while ($row = mysqli_fetch_array($vdrs, MYSQLI_ASSOC)) {
			$vdata['vhrid'] = $row['vhrd_id'];
			$vdata['vhrdate'] = $row['vhrd_date'];
			$vdata['vhrtype'] = $row['vhrd_reftype'];
			$vdata['vhrrefno'] = $row['vhrd_refno'];
			$vdata['vhrlocin'] = $row['vhrd_locin'];
			$vdata['vhrlocout'] = $row['vhrd_locout'];
			$vdata['vhrcustomer'] = $row['vhrd_customer'];
			$vdata['vhrsupplier'] = $row['vhrd_supplier'];
			$vdata['vhrnote'] = $row['vhrd_note'];
		}
	}

	if (!$virs) {
		die('Error in query: ' . mysqli_error($conn));
	} else {
		while ($virow = mysqli_fetch_assoc($virs)) {
			$vhdata[] = $virow;
			//$rowlen = count($virow);
		}
	}
}

if ($vhdata) {
	$vhrdata = $vhdata;
}

$retsql = 'SELECT * FROM products as p INNER JOIN uom as u WHERE p.u_id = u.u_id ORDER BY p.icode ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
$itemlist = '';
while ($prow = mysqli_fetch_assoc($result)) {
	//$itemlist .= ''
	$itemlist .= '<option value="' . $prow["i_id"] . '" data-uom="' . $prow["ucode"] . '">' . $prow["iname"] . '</option>';
}

$locsql = 'SELECT * FROM location ORDER BY loc_code ASC';
//$uomsql = 'SELECT * FROM uom ORDER BY ucode ASC';
$locinrs = mysqli_query($conn, $locsql);
$locoutrs = mysqli_query($conn, $locsql);
//$uomrs = mysqli_query($conn, $uomsql);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Voucher</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>

<body>
	<div class="w3-container">
		<h3>My Voucher</h3>
		<?php require_once '../inc/nav.php'; ?>

		<div class="w3-panel w3-left w3-border-right">
			<form action="invoicedb.php" method="post">
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<?php
						$vrdate = strftime('%Y-%m-%d', strtotime($vdata["vhrdate"]));
						?>
						<label><b>Date</b></label>
						<input type="date" name="vdate" class="w3-input" value="<?php echo $vrdate; ?>">
					</div>
					<div class="w3-container w3-cell">
						<label><b>Ref. Type</b></label>
						<select name="reftype" id="reft" class="w3-input" onchange="showDiv('id01','id02', this)">
							<option value="">Select Voucher</option>
							<option value="dn" <?php if ($vdata['vhrtype'] == "dn") { ?> selected="selected" <?php } ?>>
								Delivery Note</option>
							<option value="rn" <?php if ($vdata['vhrtype'] == "rn") { ?> selected="selected" <?php } ?>>
								Receipt Note</option>
							<option value="tn" <?php if ($vdata['vhrtype'] == "tn") { ?> selected="selected" <?php } ?>>
								Transfer Note</option>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Ref. #</b></label>
						<input type="text" name="refno" class="w3-input" autocomplete="off" value="<?php echo $vdata['vhrrefno']; ?>">
					</div>
				</div>
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label><b>Location In</b></label>
						<select name="locin" class="w3-input">
							<option value="">Select Location</option>
							<?php while ($row = mysqli_fetch_assoc($locinrs)) { ?> <option value="<?php echo $row["loc_id"]; ?>" <?php if ($vdata['vhrlocin'] == $row["loc_id"]) { ?> selected="selected" <?php } ?>><?php echo $row["loc_name"]; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Location Out</b></label>
						<select name="locout" class="w3-input">
							<option value="">Select Location</option>
							<?php while ($row = mysqli_fetch_assoc($locoutrs)) { ?> <option value="<?php echo $row["loc_id"]; ?>" <?php if ($vdata['vhrlocout'] == $row["loc_id"]) { ?> selected="selected" <?php } ?>><?php echo $row["loc_name"]; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div id="id01" class="w3-container w3-cell" style="display: none;">
						<label>Supplier</label>
						<input type="text" name="supplier" class="w3-input" autocomplete="off" value="<?php if ($vdata['vhrsupplier'] != "NULL") { echo $vdata['vhrsupplier']; } ?>">
					</div>
					<div id="id02" class="w3-container w3-cell" style="display: none;">
						<label>Customer</label>
						<input type="text" name="customer" class="w3-input" autocomplete="off" value="<?php if ($vdata['vhrcustomer'] != "NULL") { echo $vdata['vhrcustomer']; } ?>">
					</div>
				</div>
				<hr>
				<table id="vhrtbl" class="w3-table w3-striped">
					<tr>
						<th>Product</th>
						<th>UoM</th>
						<th>Qty</th>
						<th>Veh. #</th>
					</tr>
					<?php
					$count = 0;
					foreach ($vhrdata as $vd) {
						$count++
					?>
						<tr class="rw0">
							<td id="col0">
								<select id="product_<?php echo $count; ?>" name="product[]" class="w3-input">
									<option value="<?php echo $vd["vhritem_product"]; ?>" data-uom="<?php $vd["vhritem_uom"]; ?>" selected="selected"><?php echo $vd["iname"]; ?></option>
									<?php echo $itemlist; ?>
								</select>
								<!--<input type="text" name="product[]" value="" />-->
							</td>
							<td id="col1">
								<input id="uom_<?php echo $count; ?>" type="text" class="w3-input" name="uom[]" value="<?php echo $vd['vhritem_uom'] ?>">
							</td>
							<td id="col2">
								<input type="number" id="qty_<?php echo $count; ?>" class="w3-input" name="qty[]" value="<?php echo $vd['vhritem_qty'] ?>">
							</td>
							<td id="col3">
								<input id="vehno_<?php echo $count; ?>" type="text" class="w3-input" name="vehno[]" value="<?php echo $vd['vhritem_vehno'] ?>">
							</td>
						</tr>
					<?php  } ?>
				</table>

				<hr>
				<div class="w3-container w3-cell">
					<label>Note</label>
					<textarea name="note" class="w3-input"><?php echo $vdata['vhrnote']; ?></textarea>
					<input type="hidden" name="vhrid" value="<?php echo $vdata['vhrid']; ?>">
				</div>
				<hr>

				<table>
					<tr>
						<td><input type="button" value="Add Row" onclick="addRow('vhrtbl')" /></td>
						<td><input type="button" value="Delete Row" onclick="deleteRow('vhrtbl')" /></td>
						<td><input type="submit" name="vupdate" value="Update" /></td>
					</tr>
				</table>

			</form>
		</div>
	</div>

	<script type="text/javascript">
		function showDiv(divId1, divId2, element) {
			let div1 = document.getElementById(divId1).style;
			let div2 = document.getElementById(divId2).style;

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
			if (event.target.id.includes("product")) {
				var ct = event.target.id;
				var seltr = document.getElementById(ct);
				var inp = seltr.parentNode.nextElementSibling.firstElementChild.getAttribute("id");
				var selected = seltr.options[seltr.selectedIndex];
				var extra = selected.getAttribute('data-uom');
				var uomInput = document.getElementById(inp);
				uomInput.value = extra;
			}
		});


		document.addEventListener("DOMContentLoaded", () => {
			var reft = document.querySelector('#reft');
			var supp = document.querySelector('#id01');
			var cust = document.querySelector('#id02');

			var reftval = reft.options[reft.selectedIndex];
			//var refttext = "Loaded";
			//console.log(refttext);
			//console.log(reftval.value);

			if (reftval.value == 'dn') {
				cust.style.display = 'block';
			} else if (reftval.value == 'rn') {
				supp.style.display = 'block';
			} else {

			}
		});


		//reft.onload = function(){

		//}
	</script>
</body>

</html>