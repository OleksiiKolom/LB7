<?php
include("connect.php");
$costRent = $_GET["costRent"];

try {
    $sqlSelect = "SELECT Date_start, Date_end, Cost FROM rent WHERE Date_end = :costRent";
    $sth = $dbh->prepare($sqlSelect);
    $sth->bindValue(":costRent", $costRent);
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    $data = array();
    
    foreach($res as $row) {
       array_push($data, $row['Cost']);
    }
    
    $json_data = json_encode($data);
    echo $json_data;
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

$dbh = null;
?>