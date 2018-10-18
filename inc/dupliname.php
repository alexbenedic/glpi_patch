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
//echo $merge_id;
$sql = "SELECT   `glpi_computers`.`name` AS `Computer`,
                        `glpi_computers`.`id` AS `Comp_Id`,
                        `glpi_manufacturers`.`name` AS `Manufact`,  `glpi_computers`.`serial` AS `Serial`,  `glpi_computertypes`.`name` AS `Type`,  `glpi_computermodels`.`name` AS `Model`,  `glpi_operatingsystems_9719987b154aaf3b42c3db32aef59090`.`name` AS `OS`,   `glpi_computers`.`date_mod` AS `Mod Date`,   GROUP_CONCAT(DISTINCT CONCAT(IFNULL(`glpi_deviceprocessors_7083fb7d2b7a8b8abd619678acc5b604`.`designation`, '__NULL__'),
                                               '$#$',`glpi_deviceprocessors_7083fb7d2b7a8b8abd619678acc5b604`.`id`) SEPARATOR '$$##$$')
                              AS `Processor`
  FROM `glpi_computers`LEFT JOIN `glpi_states`
                                          ON (`glpi_computers`.`states_id` = `glpi_states`.`id`
                                              )LEFT JOIN `glpi_manufacturers`
                                          ON (`glpi_computers`.`manufacturers_id` = `glpi_manufacturers`.`id`
                                              )LEFT JOIN `glpi_computertypes`
                                          ON (`glpi_computers`.`computertypes_id` = `glpi_computertypes`.`id`
                                              )LEFT JOIN `glpi_computermodels`
                                          ON (`glpi_computers`.`computermodels_id` = `glpi_computermodels`.`id`
                                              ) LEFT JOIN `glpi_items_operatingsystems`
                                          ON (`glpi_computers`.`id` = `glpi_items_operatingsystems`.`items_id`
                                              AND `glpi_items_operatingsystems`.`itemtype` = 'Computer'
                                              ) LEFT JOIN `glpi_operatingsystems`  AS `glpi_operatingsystems_9719987b154aaf3b42c3db32aef59090`
                                          ON (`glpi_items_operatingsystems`.`operatingsystems_id` = `glpi_operatingsystems_9719987b154aaf3b42c3db32aef59090`.`id`
                                              )LEFT JOIN `glpi_locations`
                                          ON (`glpi_computers`.`locations_id` = `glpi_locations`.`id`
                                              ) LEFT JOIN `glpi_items_deviceprocessors`
                                          ON (`glpi_computers`.`id` = `glpi_items_deviceprocessors`.`items_id`
                                              AND `glpi_items_deviceprocessors`.`itemtype` = 'Computer'
                                              ) LEFT JOIN `glpi_deviceprocessors`  AS `glpi_deviceprocessors_7083fb7d2b7a8b8abd619678acc5b604`
                                          ON (`glpi_items_deviceprocessors`.`deviceprocessors_id` = `glpi_deviceprocessors_7083fb7d2b7a8b8abd619678acc5b604`.`id`
                                              ) LEFT JOIN `glpi_items_disks`
                                          ON (`glpi_computers`.`id` = `glpi_items_disks`.`items_id`
                                              AND `glpi_items_disks`.`itemtype` = 'Computer'
                                              )
WHERE  `glpi_computers`.`is_deleted` = 0  
AND `glpi_computers`.`is_template` = 0 
AND `glpi_computers`.`name` = '".$_GET['id']."'
GROUP BY `glpi_computers`.`id` ORDER BY `Mod Date` DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
    ?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Duplicated entry for <?php echo $_GET["id"] ?></h2>
   <h3>Total Duplications <?php echo $id ?> </h3> 
<table>
  <tr>
    <th>Computer</th>
    <th>Computer ID</th>
    <th>Manufacture</th>
    <th>Serial</th>
    <th>Type</th>
    <th>Model</th>
    <th>Operating System</th>
    <th>Modification date</th>
    <th>Processor</th>
  </tr>


<?php
    // output data of each row
    while($row = $result->fetch_assoc()) {
          echo '<tr>
    <td >' . $row["Computer"]. '</td>
    <td >' . $row["Comp_Id"]. '</td>
    <td >' . $row["Manufact"]. '</td>
    <td>' . $row["Serial"]. '</td>
    <td>' . $row["Type"]. '</td>
    <td>'. $row["Model"].'</td>
    <td>'. $row["OS"].'</td>
    <td> '.$row["Mod Date"].'</td>
    <td> '.$row["Processor"].'</td>
  </tr>';
//       $id ++;
    }
    ?>
    </table>

</body>
</html>
    <?php
} else {
//   echo "No Result Found for &nbsp;".$_GET['id'];
}


$conn->close();

?>