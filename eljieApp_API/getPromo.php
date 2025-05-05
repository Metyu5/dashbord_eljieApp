<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_eljie"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM tb_promo";
$result = $conn->query($sql);


$promos = array();


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $promos[] = $row; 
    }
}

$conn->close();


header('Content-Type: application/json');
echo json_encode($promos);
?>