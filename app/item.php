<?php

require_once '../inc/db.php';

$icode = $iname = $icat = "";

if (isset($_GET['iedit'])) {
	$iedit = $_GET['iedit'];
	$isql = 'SELECT * FROM products as p INNER JOIN uom as u WHERE p.u_id = u.u_id AND p.i_id = "' . $iedit . '"';
	$irs = mysqli_query($conn, $isql);
	if (!$irs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$data = array();
	//$data = mysqli_fetch_assoc($irs)
	while ($row = mysqli_fetch_array($irs, MYSQLI_ASSOC)) {
		$data[] = $row;
	}

	//$idata = $data;
	# code...
}

$retsql = 'SELECT * FROM uom ORDER BY ucode ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Item</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>

<body>
	<div class="w3-container">
		<h3>Item</h3>
		<?php require_once '../inc/nav.php'; ?>

		<!-- <div class="w3-panel w3-left w3-border-right"> -->
		<div class="w3-card-600 w3-border">
			<form action="invoicedb.php" method="post">
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label>Item Code</label>
						<input type="text" name="icode" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['icode']; } ?>">
					</div>
					<div class="w3-container w3-cell">
						<label>Item Name</label>
						<input type="text" name="iname" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['iname']; } ?>">
					</div>
				</div>
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label>Item UoM</label>
						<select name="iuom" id="iuom" class="w3-input">
							<option value=""><i>Select UoM</i></option>
							<?php while ($row = mysqli_fetch_assoc($result)) { ?>
								<option value="<?php echo $row["u_id"]; ?>" 
									<?php if (isset($data)) {
											if ($data[0]['u_id'] == $row["u_id"]) { ?> selected="selected" <?php } } ?>>
											<?php echo $row["ucode"]; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="w3-container w3-cell">
						<label>Item Category</label>
						<select name="icat" id="icat" class="w3-input">
							<option value=""><i>Select Category</i></option>
							<option value="Raw Material" 
								<?php if (isset($data)) {
									if ($data[0]['icat'] == "Raw Material") { ?> selected="selected" <?php } } ?>>Raw Material</option>
							<option value="Semi-Finished Goods" 
								<?php if (isset($data)) {
										if ($data[0]['icat'] == "Semi-Finished Goods") { ?> selected="selected" <?php } } ?>>Semi-Finished Goods</option>
							<option value="Finished Goods" 
								<?php if (isset($data)) {
										if ($data[0]['icat'] == "Finished Goods") { ?> selected="selected" <?php } } ?>>Finished Goods</option>
							<option value="Packaging Materials" 
								<?php if (isset($data)) {
										if ($data[0]['icat'] == "Packaging Materials") { ?> selected="selected" <?php } } ?>>Packaging Materials</option>
						</select>
					</div>
				</div><br>
				<div class="w3-container w3-cell">
					<?php if (isset($data)) { ?>
						<input type="hidden" name="itemid" value="<?php echo $data[0]['i_id']; ?>">
						<input type="submit" name="iupdate" value="Update" />
					<?php } else { ?>
						<input type="submit" name="isubmit" value="Submit" />
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
</body>

</html>