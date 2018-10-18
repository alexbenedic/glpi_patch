<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "glpi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
   
$sql = "SELECT   `glpi_computers`.`date_mod` AS `Mod Date`
  FROM `glpi_computers`
WHERE  `glpi_computers`.`is_deleted` = 0  
AND `glpi_computers`.`is_template` = 0 
AND `glpi_computers`.`name` = '".$_GET['id']."'
GROUP BY `glpi_computers`.`id` ORDER BY `Mod Date` asc";
$result = $conn->query($sql);
$id = $result->num_rows;
$limit_id = $id-1;
//echo $limit_id;

$sql = "UPDATE `glpi_computers` SET `glpi_computers`.`is_deleted`='1' WHERE `glpi_computers`.`name` = '".$_GET['id']."'
 ORDER BY `glpi_computers`.`date_mod` asc limit ".$limit_id;
if ($conn->query($sql) === TRUE) {
    ?>
    <meta http-equiv="refresh" content="0;url=/glpi/front/duplicheck.php?type=serial"/>
<?php
} else {
    echo "Error updating record: " . $conn->error;
}
$conn->close();

?>