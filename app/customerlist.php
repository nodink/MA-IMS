<?php
require_once '../inc/db.php';
require_once 'logic.php';


$data = getAllCustomer($conn);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customer List</title>
	<link rel="stylesheet" type="text/css" href="../lib/sdt.css">
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
	<div class="w3-container">
		<h3>Customer List</h3>
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
						<td><?= $list["ccode"] ?></td>
						<td><?= $list["cname"] ?></td>
						<td><?= $list["cemail"] ?></td>
						<td><?= $list["cphone"] ?></td>
						<td><?= $list["caddress"] ?></td>
						<td>
							<button><a href="customer.php?cedit=<?= $list["cid"]; ?>" style="text-decoration: none;">Edit</a></button>
							<button disabled class="w3-border-red w3-red"><a href="ajaxdb.php?cdelete=<?= $list["cid"]; ?>" style="text-decoration: none;">Delete</a></button>
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