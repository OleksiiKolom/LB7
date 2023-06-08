<?php
include("connect.php");
$vendor = $_GET["vendor"];
try {

    $sqlSelect = "SELECT vendors.Name AS vendor, vendors.ID_Vendors, cars.Name AS CarName
    FROM vendors INNER JOIN cars ON vendors.ID_Vendors = cars.FID_Vendors WHERE vendors.Name = :vendor";
    $sth = $dbh->prepare($sqlSelect);

    $sth->bindValue(":vendor", $vendor);

    $sth->execute();

    $res = $sth->fetchAll(PDO::FETCH_NUM);

    header('Content-Type: text/xml');

    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';

    echo '<response>';

    echo '<vendor>';

    foreach($res as $row) {
        echo '<vendor>' . $row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3] . '</vendor>';
    }

    echo '</vendor>';
    
    echo '</response>';

} catch(PDOException $ex) {
    echo $ex->getMessage();
}

$dbh = null;
?>