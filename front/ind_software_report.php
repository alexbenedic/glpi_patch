<?php
$id = $_GET["id"];
$name = $_GET["softname"];
include 'report_config.php';


$filename = $name.".csv";

 
  header('Content-Type: text/csv; charset=utf-8');

  header('Content-Disposition: attachment; filename='.$filename);
  $output = fopen("php://output","w");
  fputcsv($output, array('Desktop','Serial','Version','Software Name','Entity'));
//  $date_today = date("Y-m-d");
//  $date_today_plus=date("Y-m-d",strtotime('+30 days',strtotime(date("Y-m-d"))));
//  $date_month = date("Y-m-d",strtotime('-1 month',strtotime(date("Y-m-d"))));
  $query = "  SELECT DISTINCT 
                       `glpi_computers`.`name` AS compname,
                    
                       `glpi_computers`.`serial`,
                   
                       `glpi_softwareversions`.`name` AS version,
                     
                       `glpi_entities`.`completename` AS entity
                  
                FROM `glpi_computers_softwareversions`
                INNER JOIN `glpi_softwareversions`
                     ON (`glpi_computers_softwareversions`.`softwareversions_id`
                           = `glpi_softwareversions`.`id`)
                INNER JOIN `glpi_computers`
                     ON (`glpi_computers_softwareversions`.`computers_id` = `glpi_computers`.`id`)
                LEFT JOIN `glpi_entities` ON (`glpi_computers`.`entities_id` = `glpi_entities`.`id`)
                LEFT JOIN `glpi_locations`  ON (`glpi_computers`.`locations_id` = `glpi_locations`.`id`                                                                                                 )
                LEFT JOIN `glpi_states` ON (`glpi_computers`.`states_id` = `glpi_states`.`id`)
                LEFT JOIN `glpi_groups` ON (`glpi_computers`.`groups_id` = `glpi_groups`.`id`)
                LEFT JOIN `glpi_users` ON (`glpi_computers`.`users_id` = `glpi_users`.`id`)
                WHERE (`glpi_softwareversions`.`softwares_id` = ".$id.")
                       AND `glpi_computers`.`is_deleted` = 0
                       AND `glpi_computers`.`is_template` = 0
                       AND `glpi_computers_softwareversions`.`is_deleted` = 0
                ORDER BY `entity` ASC, `version`, `compname` ASC
;";
  
  $result = mysqli_query($conn,$query);
$x=1;
  while($row = mysqli_fetch_assoc($result)){
      $x++;
    fputcsv($output,  array($row['compname'],$row['serial'],$row['version'],$name,$row['entity']));
        }
  fclose($output);
$conn->close();

?>