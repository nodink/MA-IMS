<?php

require_once '../inc/db.php';

	if (isset($_GET['bedit'])) {
		$bedit = $_GET['bedit'];
		$bidata= array();
		$rowlen='';
		//$vsql = 'SELECT * FROM vhrdetails as d INNER JOIN vhritems as i ON i.vhrd_id = d.vhrd_id AND d.vhrd_id = "'.$vedit.'"';
		$bsql = 'SELECT * FROM bom as b
				 INNER JOIN products as p WHERE b.bom_fitem = p.i_id
		         AND b.bom_id = "'.$bedit.'"';
		$bisql = 'SELECT * FROM bomitems as bi 
		          INNER JOIN products as p ON bi.bom_item = p.i_id
		          INNER JOIN location as l ON bi.bom_loc = l.loc_id
		          WHERE bom_id = "'.$bedit.'"';
		$brs = mysqli_query($conn, $bsql);
		$birs = mysqli_query($conn, $bisql);
		if(!$brs){
			die('Error in query: '. mysqli_error($conn));
		} else {
			//$data = mysqli_fetch_assoc($irs)
			while ($row = mysqli_fetch_array($brs, MYSQLI_ASSOC)) {
				$bdata['bomid']=$row['bom_id'];
				$bdata['bomname']=$row['bom_name'];
				$bdata['bomfitem']=$row['bom_fitem'];
				$bdata['bomuom']=$row['bom_uom'];
			}
		}

		if(!$birs){
			die('Error in query: '. mysqli_error($conn));
		} else {
			while($birow = mysqli_fetch_assoc($birs)) {
				$bidata[]=$birow;
				//$rowlen = count($virow);
			} 
		}
	}


	$fgsql = 'SELECT * FROM products WHERE icat="Semi-Finished Goods" OR icat="Finished Goods"  ORDER BY icode ASC';
	$fgrs = mysqli_query($conn, $fgsql);
	if (!$fgrs) {
		die('Error in query: ' . mysqli_error($conn));
	}

	$rmsql = 'SELECT * FROM products WHERE icat="Raw Material" OR icat="Semi-Finished Goods" OR icat="Packaging Materials" ORDER BY icode ASC';
	$rmrs = mysqli_query($conn, $rmsql);
	if (!$rmrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$rmlist = '';
	while ($rmrow = mysqli_fetch_assoc($rmrs)) {
	//$itemlist .= ''
	$rmlist .= '<option value="'.$rmrow["i_id"].'">'.$rmrow["iname"].'</option>'; 
	} 

	$locsql = 'SELECT * FROM location ORDER BY loc_code ASC';
	$locrs = mysqli_query($conn, $locsql);
	if (!$locrs) {
		die('Error in query: ' . mysqli_error($conn));
	}
	$loclist = '';
	while ($locrow = mysqli_fetch_assoc($locrs)) {
	//$itemlist .= ''
	$loclist .= '<option value="'.$locrow["loc_id"].'">'.$locrow["loc_name"].'</option>'; 
	} 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit BOM</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<script src="../lib/addrow.js"></script>
</head>
<body>
	<div class="w3-container">
		<h3>Edit BOM</h3>
		<?php require_once '../inc/nav.php'; ?>
	
	<div class="w3-panel w3-left ">
		<form action="invoicedb.php" method="post">
			<div class="w3-cell-row">
				<div class="w3-container w3-cell">
					<label>BOM Name</label>
					<input type="text" name="bomname" class="w3-input" autocomplete="off" value="<?php echo $bdata['bomname']; ?>" >
				</div>
				<div class="w3-container w3-cell">
					<label>Components of</label>
					<select name="fg" class="w3-input">
						<option value="" readonly>Select Item</option>
						<?php
						while ($row = mysqli_fetch_assoc($fgrs)) { ?>
						<option value="<?php echo $row["i_id"]; ?>"
						<?php if($bdata['bomfitem'] == $row["i_id"]){?>
						selected="selected"<?php } ?> ><?php echo $row["iname"]; ?>
					    </option> 
					<?php } ?>
					</select>
				</div>
				<div class="w3-container w3-cell">
					<label>Unit of Manufacture</label>
					<input type="number" name="bomuom" class="w3-input" autocomplete="off" value="<?php echo $bdata['bomuom']; ?>" >
				</div>
			</div><hr>
		<table id="bomtbl" class="w3-table w3-striped">
				<tr>
					<th>Item</th>
					<th>Location</th>
					<th>Type of Item</th>
					<th>Qty</th>
				</tr>
				<?php  
					$count = 0;
					foreach ($bidata as $bi) {
					$count++	
				?>
				<tr> 
					<td>
						<select id="product_<?php echo $count; ?>" name="bomrm[]" class="w3-input">
							<option value="<?php echo $bi["bom_item"]; ?>" selected="selected"><?php echo $bi["iname"]; ?></option>
							<?php echo $rmlist; ?>
						</select>
					</td> 
					<td>
						<select id="loc_<?php echo $count; ?>" name="bomloc[]" class="w3-input">
							<option value="<?php echo $bi["bom_loc"]; ?>" selected="selected"><?php echo $bi["loc_name"]; ?></option>
							<?php echo $loclist; ?>
						</select>
					</td> 
					<td> 
						<select id="bt_<?php echo $count; ?>" name="bomtype[]" class="w3-input">
							<option value="">Select Type</option>
							<option value="component" <?php if ($bi['bom_type'] == "component") { ?> selected="selected" <?php } ?>>Component</option>
							<option value="co-product" <?php if ($bi['bom_type'] == "co-product") { ?> selected="selected" <?php } ?>>Co-product</option>
							<option value="by-product" <?php if ($bi['bom_type'] == "by-product") { ?> selected="selected" <?php } ?>>By-product</option>
							<option value="scrap" <?php if ($bi['bom_type'] == "scrap") { ?> selected="selected" <?php } ?>>Scrap</option>
						</select>
			     	</td>
					<td> 
						<input id="bq_<?php echo $count; ?>" type="text" name="bomqty[]" class="w3-input" value="<?php echo $bi['bom_qty'] ?>">
					</td>  
				</tr> 
				<?php  } ?> 
			</table> 
			
			<hr>
			<div class="w3-container w3-cell">
				<input type="hidden" name="bomid" value="<?php echo $bdata['bomid']; ?>">
			</div>
			<hr>

			<table> 
				<tr> 
					<td><input type="button" value="Add Row" onclick="addRow('bomtbl')" /></td> 
					<td><input type="button" value="Delete Row" onclick="deleteRow('bomtbl')" /></td> 
					<td><input type="submit" name="bupdate" value="Update" /></td> 
				</tr>  
			</table>

		</form> 	
	</div>
	</div>
</body>
</html>