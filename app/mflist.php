<?php

require_once '../inc/db.php';

$retsql = 'SELECT m.mf_id,m.mf_date,m.mf_reftype,m.mf_refno,p.iname,b.bom_name,m.mf_fqty,m.mf_note
			   FROM manufact as m  
			   INNER JOIN products as p ON p.i_id = m.mf_fitem
			   INNER JOIN bom as b ON b.bom_id = m.mf_bom  
			   ORDER BY m.mf_date ASC';
$result = mysqli_query($conn, $retsql);
if (!$result) {
    die('Error in query: ' . mysqli_error($conn));
}
$data = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = $row;
}

$mflist = $data;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manufactured List</title>
    <link rel="stylesheet" type="text/css" href="../lib/sdt.css">
    <link rel="stylesheet" type="text/css" href="../lib/w3.css">
</head>

<body>
    <div class="w3-container">
        <h3>Manufactured List</h3>
        <?php require_once '../inc/nav.php'; ?>

        <div class="w3-panel">

            <table id="matbl" class='w3-table w3-striped w3-hoverable'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Ref. #</th>
                        <th>Ref. Type</th>
                        <th>BOM Code</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Note</th>
                    </tr>
                </thead>

                <?php
                foreach ($mflist as $mf) {
                    $mdate = date("d-M-y", strtotime($mf["mf_date"])); ?>
                    <tr>
                        <td><?php echo $mdate; ?></td>
                        <td><?php echo $mf["mf_refno"]; ?></td>
                        <td><?php echo $mf["mf_reftype"]; ?></td>
                        <td><?php echo $mf["bom_name"]; ?></td>
                        <td><?php echo $mf["iname"]; ?></td>
                        <td><?php echo $mf["mf_fqty"]; ?></td>
                        <td><?php echo $mf["mf_note"]; ?></td>
                        <td>
                        <td>
                            <button><a href="mfedit.php?medit=<?php echo $mf["mf_id"]; ?>" style="text-decoration: none;">Edit</a></button>
                            <button disabled class="w3-border-red w3-red"><a href="ajaxdb.php?mdelete=<?php echo $mf["mf_id"]; ?>" style="text-decoration: none;">Delete</a></button>
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