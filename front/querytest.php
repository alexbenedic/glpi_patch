<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "glpi";
$serial = $_GET["id"];
$hostname = $_GET["hostname"];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT id FROM `glpi_computers` WHERE serial='".$serial."' OR name='". $serial."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
//        echo $id;
       $sql = "SELECT`glpi_computers`.`name`,`glpi_computers`.`serial`,`glpi_computers`.`contact`,`glpi_computers`.`comment`,`glpi_computers`.`date_mod`,`glpi_computers`.`uuid`,`glpi_domains`.`name` AS domain,`glpi_computers`.`date_creation`,`glpi_manufacturers`.`name` AS manufact,`glpi_computermodels`.`name` AS model,`glpi_computertypes`.`name` AS type
FROM `glpi_computers`
INNER JOIN `glpi_manufacturers`
ON `glpi_computers`.`manufacturers_id` = `glpi_manufacturers`.`id`
INNER JOIN `glpi_computermodels`
ON `glpi_computers`.`computermodels_id` = `glpi_computermodels`.`id`
INNER JOIN `glpi_computertypes`
ON `glpi_computers`.`computertypes_id` = `glpi_computertypes`.`id`
INNER JOIN `glpi_domains`
ON `glpi_computers`.`domains_id` = `glpi_domains`.`id`
Where `glpi_computers`.`id`=".$id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $out = array ('Name' => $row["name"],
               'Serial' => $row['serial'], 
               'Contact' => $row['contact'], 
               'Comment' => $row['comment'], 
               'Date Modify' => $row['date_mod'], 
               'UUID' => $row['uuid'], 
               'Domain' => $row['domain'], 
               'Date Create' => $row['date_creation'], 
               'Manufacture' => $row['manufact'], 
               'Model' => $row['model'], 
               'Type' => $row['type'] ) ;
    }
       header('Content-type:application/json;charset=utf-8');
        $toJSON = json_encode($out,JSON_PRETTY_PRINT);
 echo($toJSON);

} else {
    echo "No item";
} 
    }
} else {
    echo "No results";
}

$conn->close();
?>