<?php

require_once '../inc/db.php';

$bomsql = 'SELECT * FROM bom ORDER BY bom_name ASC';
$bomrs = mysqli_query($conn, $bomsql);
if (!$bomrs) {
	die('Error in query: ' . mysqli_error($conn));
}

$mfsql = 'SELECT * FROM products WHERE icat="Semi-Finished Goods" OR icat="Finished Goods"  ORDER BY icode ASC';
$mfrs = mysqli_query($conn, $mfsql);
if (!$mfrs) {
	die('Error in query: ' . mysqli_error($conn));
}

$locsql = 'SELECT * FROM location ORDER BY loc_code ASC';
$mfloc = mysqli_query($conn, $locsql);
//$rmloc = mysqli_query($conn, $locsql);

?>

<?php

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
		<h3>Manufacture</h3>
		<?php require_once '../inc/nav.php'; ?>

		<!-- <div class="w3-panel w3-left w3-border-right"> -->
		<div class="w3-card-800 w3-border">
			<form action="invoicedb.php" method="post">
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label><b>Date</b></label>
						<input type="date" name="mfdate" class="w3-input">
					</div>
					<div class="w3-container w3-cell">
						<label><b>Process Type</b></label>
						<select name="mftype" id="reft" class="w3-input">
							<option value="">Select Process</option>
							<option value="blending">Blending</option>
							<option value="bagging">Bagging</option>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Ref. #</b></label>
						<input type="text" name="mfno" class="w3-input" autocomplete="off">
					</div>
				</div>
				<div class="w3-cell-row w3-margin-top">
					<div class="w3-container w3-cell">
						<label><b>Product</b></label>
						<select name="mfitem" class="w3-input">
							<option value="">Select Product</option>
							<?php
							while ($row = mysqli_fetch_assoc($mfrs)) {
								echo '<option value="' . $row["i_id"] . '" data-uom="' . $row["ucode"] . '">' . $row["iname"] . '</option>';
							} ?>
							}?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>BOM #</b></label>
						<select id="bom" name="mfbom" class="w3-input">
							<option value="">Select BOM</option>
							<?php
							while ($row = mysqli_fetch_assoc($bomrs)) {
								echo '<option value="' . $row["bom_id"] . '">' . $row["bom_name"] . '</option>';
							} ?>
							}?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Location</b></label>
						<select name="mfloc" class="w3-input">
							<option value="">Select Location</option>
							<?php
							while ($row = mysqli_fetch_assoc($mfloc)) {
								echo '<option value="' . $row["loc_id"] . '">' . $row["loc_name"] . '</option>';
							} ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Qty</b></label>
						<input type="text" name="mfqty" class="w3-input" autocomplete="off">
					</div>
				</div>
				<hr>
				<table id="mftbl" class="w3-table w3-striped">
					<thead class="w3-gray">
						<tr>
							<th>Product</th>
							<th>Location</th>
							<th>Est. Qty</th>
							<th>Act. Qty</th>
						</tr>
					</thead>
					<tbody>
						<!--   -->
					</tbody>

				</table>

				<hr>
				<div class="w3-container w3-cell">
					<label>Note</label>
					<textarea name="mfnote" class="w3-input"></textarea>
				</div>
				<hr>

				<table>
					<tr>
						<!--<td><input type="button" value="Add Row" onclick="addRow('vhrtbl')" /></td> 
					<td><input type="button" value="Delete Row" onclick="deleteRow('vhrtbl')" /></td> -->
						<td><input type="submit" name="mfsubmit" value="Submit" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>


	<script type="text/javascript">
		/*function showDiv(divId1, divId2, element) {
    	 let div1 = document.getElementById(divId1).style;
    	 let div2 = document.getElementById(divId2).style;

    	 switch(element.value) {
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
	} */

		//Shows UoM of Product selected
		document.addEventListener("change", function(event) {
			if (event.target.id.includes("bom")) {
				var ct = event.target.id;
				var tbd = document.querySelector('#mftbl tbody')
				var seltr = document.getElementById(ct);
				var bsel = seltr.options[seltr.selectedIndex].value;
				//console.log(bsel);
				//console.log(tbd);

				let xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						let result = '';
						var drs = JSON.parse(this.responseText);
						drs.forEach(c => {
							result += `<tr>
						<td><input id='rmitem' type='text' class='w3-input' name='rmitem[]' value="${c.iname}" /></td>
						<td><input id="rmloc" type="text" class="w3-input" name="rmloc[]" value="${c.loc_name}" ></td>
						<td><input id="stdqty" type="number" class="w3-input" name="stdqty[]" ></td>
						<td><input id="actqty" type="number" class="w3-input" name="actqty[]" ></td>
						</tr>`;
						});
						tbd.innerHTML = result;
						//console.log(drs);
					}
				};
				xhr.open("GET", "ajaxdb.php?bomi=" + bsel, true);
				xhr.send();
			} //else if(event.target.id.includes("reft")) {}
		});
	</script>
</body>

</html>