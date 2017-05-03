<?php require "db.php";
$query = mysqli_query($conn, 'SELECT level, shelf_no, bin_id FROM location_bin ORDER BY shelf_no asc, level asc ');

echo "<table border='1'>";
echo "<tr>";
$i=0;

while($res = mysqli_fetch_assoc($query)) {
    $row=$res['shelf_no'];
    if ($i < $row){
            $i=$row;
        echo "</tr><tr>";

    }

    echo "<td>".$res['bin_id']."</td>";



    }


echo "</table>";

?>