<?php

require_once '../inc/db.php';
require_once 'logic.php';

if (isset($_GET['cedit'])) {
	$cedit = $_GET['cedit'];
	$data = getCustomer($conn, $cedit);
}

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Customer</title>
	<link rel="stylesheet" type="text/css" href="../lib/w3.css">
	<!-- <script src="../lib/addrow.js"></script> -->
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
						<label for="ccode">Customer Code</label>
						<input type="text" name="ccode" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['ccode']; } ?>">
					</div>
					<div class="w3-container w3-cell">
						<label for="cname">Customer Name</label>
						<input type="text" name="cname" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['cname']; } ?>">
					</div>
					<div class="w3-container w3-cell">
						<label for="email">Email</label>
						<input type="email" name="cemail" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['cemail']; } ?>">
					</div>
				</div><br>
				<div class="w3-cell-row">
					<div class="w3-container w3-cell">
						<label for="cphone">Phone</label>
						<input type="text" name="cphone" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['cphone']; } ?>">
					</div>
					<div class="w3-container w3-cell">
						<label for="caddress">Address</label>
						<input type="text" name="caddress" class="w3-input" autocomplete="off" 
						value="<?php if (isset($data)) { echo $data[0]['caddress']; } ?>">
					</div>
				</div><br>
				<div class="w3-container w3-cell">
					<?php if (isset($data)) { ?>
						<input type="hidden" name="custid" value="<?php echo $data[0]['cid']; ?>">
						<input type="submit" name="cupdate" value="Update" />
					<?php } else { ?>
						<input type="submit" name="csubmit" value="Submit" />
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
</body>
</html>