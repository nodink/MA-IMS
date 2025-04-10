<?php

require_once '../inc/db.php';

$icode = $iname = $icat = "";

$retsql = 'SELECT * FROM products as p INNER JOIN uom as u WHERE p.u_id = u.u_id ORDER BY p.icode ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
	die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$data[] = $row;
}

$ilist = $data;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Item List</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
	<div class="w3-container">
		<h3>Item List</h3>
		<?php require_once '../inc/nav.php'; ?>

		<div class="w3-panel">

			<table id="matbl" class='w3-table w3-striped w3-hoverable itbl'>
				<thead>
					<tr>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>UoM</th>
						<th>Item Category</th>
						<th>Action</th>
					</tr>
				</thead>

				<?php
				foreach ($ilist as $list) { ?>
					<tr>
						<td><?php echo $list["icode"]; ?></td>
						<td><?php echo $list["iname"]; ?></td>
						<td><?php echo $list["ucode"] ?></td>
						<td><?php echo $list["icat"]; ?></td>
						<td>
							<button><a href="item.php?iedit=<?php echo $list["i_id"]; ?>" style="text-decoration: none;">Edit</a></button>
							<button disabled class="w3-border-red w3-red"><a href="ajaxdb.php?idelete=<?php echo $list["i_id"]; ?>" style="text-decoration: none;">Delete</a></button>
							<!--<input type="button" name="iedit" value="Edit" id="<?php //echo $list["i_id"];?>" class="i_edit"/>
	                        <input type="button" name="idelete" value="Delete" id="<?php //echo $list["i_id"]; ?>" class="i_delete w3-border-red w3-red"  /> -->
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>

	</div>
	<script src="../lib/sdt.js"></script>
</body>

</html>