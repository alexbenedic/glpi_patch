<?php
$id = $_GET["id"];
 include 'report_config.php';

//$sql = "SELECT name
//FROM `glpi_computers`
//WHERE `id` =".$id;
//$result = $conn->query($sql);
//
//if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//        $name = $row["name"];
//    }
//} else {
//    echo "0 results";
//}

$filename = $id.".csv";

 
  header('Content-Type: text/csv; charset=utf-8');
   
  header('Content-Disposition: attachment; filename='.$filename);
  $output = fopen("php://output","w");
  fputcsv($output, array('Name','Serial','Username','Comment','Date Mod','UUID','Domain','Date Create','Manufacturer','Model','Type'));
//  $date_today = date("Y-m-d");
//  $date_today_plus=date("Y-m-d",strtotime('+30 days',strtotime(date("Y-m-d"))));
//  $date_month = date("Y-m-d",strtotime('-1 month',strtotime(date("Y-m-d"))));
$query = "SELECT `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where `glpi_operatingsystems`.`name` LIKE '%server%' OR  `glpi_operatingsystems`.`name` LIKE '%RedHat%' 
OR  `glpi_operatingsystems`.`name` LIKE '%VMware%' OR  `glpi_operatingsystems`.`name` LIKE '%AIX%' OR  `glpi_operatingsystems`.`name` LIKE '%Linux%' 
 OR  `glpi_operatingsystems`.`name` LIKE '%SunOS %' OR  `glpi_operatingsystems`.`name` LIKE '%CentOS%'
";
  //$query = "select * from employee_activity where datetime_in >= DATE('".$frm."') and  datetime_out <= DATE('".$to."') order by datetime_in asc";
  $result = mysqli_query($conn,$query);
  while($row = mysqli_fetch_assoc($result)){
    fputcsv($output,$row);
        }
  fclose($output);
$conn->close();
?>