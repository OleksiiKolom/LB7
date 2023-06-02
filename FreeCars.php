<?php
include("connect.php");
$date = $_GET["FreeCars"];

try {
    $sqlSelect = "SELECT * FROM cars WHERE ID_Cars NOT IN (SELECT FID_Car FROM rent WHERE Date_start <= :date AND Date_end >= :date)";
    $sth = $dbh->prepare($sqlSelect);
    $sth->bindValue(":date", $date);
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    
    foreach($res as $row) {
        echo "<tr><td>{$row['ID_Cars']}</td><td>{$row['Name']}</td></tr>";
    }

} catch(PDOException $ex) {
    echo $ex->getMessage();
}

$dbh = null;
?>
