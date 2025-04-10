<?php
require_once '../inc/db.php';
require_once 'logic.php';


$data = getAllSupplier($conn);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Suppliers List</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
	<div class="w3-container">
		<h3>Suppliers List</h3>
		<?php require_once '../inc/nav.php'; ?>

		<div class="w3-panel">

			<table id="matbl" class='w3-table w3-striped w3-hoverable itbl'>
				<thead>
					<tr>
						<th>Code</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
				</thead>

				<?php
				foreach ($data as $list) { ?>
					<tr>
						<td><?= $list["scode"] ?></td>
						<td><?= $list["sname"] ?></td>
						<td><?= $list["semail"] ?></td>
						<td><?= $list["sphone"] ?></td>
						<td><?= $list["saddress"] ?></td>
						<td>
							<button><a href="supplier.php?sedit=<?= $list["sid"]; ?>" style="text-decoration: none;">Edit</a></button>
							<button disabled class="w3-border-red w3-red"><a href="ajaxdb.php?sdelete=<?= $list["sid"]; ?>" style="text-decoration: none;">Delete</a></button>
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