<?php

require_once '../inc/db.php';

$retsql = 'SELECT b.bom_id,p.iname,b.bom_name,b.bom_uom
			   FROM bom as b 
			   INNER JOIN products as p ON p.i_id = b.bom_fitem 
			   ORDER BY b.bom_name ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
    die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = $row;
}

$blist = $data;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BOM List</title>
    <link rel="stylesheet" type="text/css" href="../lib/sdt.css">
    <link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
    <div class="w3-container">
        <h3>BOM List</h3>
        <?php require_once '../inc/nav.php'; ?>
        <div class="w3-panel">
            <table id="matbl" class='w3-table w3-striped w3-hoverable'>
                <thead>
                    <tr>
                        <th>BOM Name</th>
                        <th>Product</th>
                        <th>Unit of Manufacture</th>
                    </tr>
                </thead>

                <?php foreach ($blist as $bom) { ?>
                    <tr>
                        <td><?php echo $bom["bom_name"]; ?></td>
                        <td><?php echo $bom["iname"]; ?></td>
                        <td><?php echo $bom["bom_uom"]; ?></td>
                        <td>
                        <td>
                            <button><a href="bomedit.php?bedit=<?php echo $bom["bom_id"]; ?>" style="text-decoration: none;">Edit</a></button>
                            <button disabled class="w3-border-red w3-red"><a href="ajaxdb.php?bdelete=<?php echo $bom["bom_id"]; ?>" style="text-decoration: none;">Delete</a></button>
                        </td>
                        </td>
                    </tr>
                <?php } ?>
            </table>


        </div>

    </div>
    <script src="../lib/sdt.js"></script>
</body>

</html>