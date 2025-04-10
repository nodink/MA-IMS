<?php

require_once '../inc/db.php';

if (isset($_GET['medit'])) {
	$medit = $_GET['medit'];
	$mfdata = array();
	$rowlen = '';
	//$vsql = 'SELECT * FROM vhrdetails as d INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id AND d.vhrd_id = "'.$vedit.'"';
	$mfsql = 'SELECT * FROM manufact as m
			  INNER JOIN products as p ON p.i_id = m.mf_fitem
			  INNER JOIN bom as b ON b.bom_id = m.mf_bom
			  INNER JOIN location as l ON l.loc_id = m.mf_loc
			  WHERE m.mf_id = "'.$medit.'"';
	$misql = 'SELECT * FROM manufactitems WHERE mf_id = "'.$medit.'"';
	$mfrs = mysqli_query($conn, $mfsql);
	$mirs = mysqli_query($conn, $misql);
	if (!$mfrs) {
		die('Error in query: ' . mysqli_error($conn));
	} else {
		//$data = mysqli_fetch_assoc($irs)
		while ($row = mysqli_fetch_array($mfrs, MYSQLI_ASSOC)) {
			$mdata['mfid'] = $row['mf_id'];
			$mdata['mfdate'] = $row['mf_date'];
			$mdata['mftype'] = $row['mf_reftype'];
			$mdata['mfno'] = $row['mf_refno'];
			$mdata['mffitem'] = $row['mf_fitem'];
			$mdata['mfbom'] = $row['mf_bom'];
			$mdata['mfloc'] = $row['mf_loc'];
			$mdata['mffqty'] = $row['mf_fqty'];
			$mdata['mfnote'] = $row['mf_note'];
		}
	}

	if (!$mirs) {
		die('Error in query: ' . mysqli_error($conn));
	} else {
		while ($mirow = mysqli_fetch_assoc($mirs)) {
			$mfdata[] = $mirow;
			//$rowlen = count($virow);
		}
	}
}

$bomsql = 'SELECT * FROM bom ORDER BY bom_name ASC';
$bomrs = mysqli_query($conn, $bomsql);
if (!$bomrs) {
	die('Error in query: ' . mysqli_error($conn));
}

$mafsql = 'SELECT * FROM products WHERE icat="Semi-Finished Goods" OR icat="Finished Goods"  ORDER BY icode ASC';
$mafrs = mysqli_query($conn, $mafsql);
if (!$mafrs) {
	die('Error in query: ' . mysqli_error($conn));
}

$locsql = 'SELECT * FROM location ORDER BY loc_code ASC';
$mfloc = mysqli_query($conn, $locsql);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Manufacture</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>

<body>
	<div class="w3-container">
		<h3>Edit Manufacture</h3>
		<?php require_once '../inc/nav.php'; ?>

		<div class="w3-panel w3-left w3-border-right">
			<form action="invoicedb.php" method="post">
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<?php
						$mdate = strftime('%Y-%m-%d', strtotime($mdata["mfdate"]));
						?>
						<label><b>Date</b></label>
						<input type="date" name="mfdate" class="w3-input" value="<?php echo $mdate; ?>">
					</div>
					<div class="w3-container w3-cell">
						<label><b>Process Type</b></label>
						<select name="mftype" id="reft" class="w3-input">
							<option value="">Select Process</option>
							<option value="blending" <?php if ($mdata['mftype'] == "blending") { ?> selected="selected" <?php } ?>>
								Blending</option>
							<option value="bagging" <?php if ($mdata['mftype'] == "bagging") { ?> selected="selected" <?php } ?>>
								Bagging</option>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Ref. #</b></label>
						<input type="text" name="mfno" class="w3-input" autocomplete="off" value="<?php echo $mdata['mfno']; ?>">
					</div>
				</div>
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label><b>Name of Product</b></label>
						<select name="mfitem" class="w3-input">
							<option value="">Select Product</option>
							<?php while ($row = mysqli_fetch_assoc($mafrs)) { ?> <option value="<?php echo $row["i_id"]; ?>" <?php if ($mdata['mffitem'] == $row["i_id"]) { ?> selected="selected" <?php } ?>><?php echo $row["iname"]; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>BOM #</b></label>
						<select name="mfbom" class="w3-input">
							<option value="">Select BOM</option>
							<?php while ($row = mysqli_fetch_assoc($bomrs)) { ?> <option value="<?php echo $row["bom_id"]; ?>" <?php if ($mdata['mfbom'] == $row["bom_id"]) { ?> selected="selected" <?php } ?>><?php echo $row["bom_name"]; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label><b>Location</b></label>
						<select name="mfloc" class="w3-input">
							<option value="">Select Location</option>
							<?php while ($row = mysqli_fetch_assoc($mfloc)) { ?> <option value="<?php echo $row["loc_id"]; ?>" <?php if ($mdata['mfloc'] == $row["loc_id"]) { ?> selected="selected" <?php } ?>><?php echo $row["loc_name"]; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label>Qty</label>
						<input type="text" name="mfqty" class="w3-input" value="<?php echo $mdata['mffqty']; ?>">
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
					<?php
					$count = 0;
					foreach ($mfdata as $mf) {
						$count++
					?>
					<tbody>
						<tr>
							<td>
								<input id='rmitem' type='text' class='w3-input' name='rmitem[]' value="<?php echo $mf['mf_rmitem'] ?>" /> 
							</td> 
							<td>
								<input id="rmloc" type="text" class="w3-input" name="rmloc[]" value="<?php echo $mf['mf_rmloc'] ?>" >
							</td> 
							<td> 
								<input id="stdqty" type="number" class="w3-input" name="stdqty[]" value="<?php echo $mf['mf_stdqty'] ?>">
					     	</td>
							<td> 
								<input id="actqty" type="text" class="w3-input" name="actqty[]" value="<?php echo $mf['mf_actqty'] ?>">
							</td>  
						</tr>
					</tbody>
					<?php  } ?>
				</table>

				<hr>
				<div class="w3-container w3-cell">
					<label>Note</label>
					<textarea name="mfnote" class="w3-input"><?php echo $mdata['mfnote']; ?></textarea>
					<input type="hidden" name="mfid" value="<?php echo $mdata['mfid']; ?>">
				</div>
				<hr>

				<table>
					<tr>
						<!--<td><input type="button" value="Add Row" onclick="addRow('mftbl')" /></td>
						<td><input type="button" value="Delete Row" onclick="deleteRow('mftbl')" /></td>-->
						<td><input type="submit" name="mfupdate" value="Update" /></td>
					</tr>
				</table>

			</form>
		</div>
	</div>

	<script type="text/javascript">
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
			}
		});
	</script>
</body>

</html>