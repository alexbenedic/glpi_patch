<?php
include('login/db_configs.php');
 date_default_timezone_set('Asia/Kuala_Lumpur');
 $last30days = date("Y-m-d",strtotime('-30 days'));
$mnum = date("m");
$sql = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
                           where `glpi_computers`.`is_deleted` = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $total = $result->num_rows;
//    echo "total asset &nbsp;".$total."<br>" ;
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//       if ($row["name"] )
//    }

} 
else {
    echo "0 results";
}

$sql1 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where `glpi_computers`.`is_deleted` = '0'and (`glpi_operatingsystems`.`name` LIKE '%server%' OR  `glpi_operatingsystems`.`name` LIKE '%RedHat%' 
OR  `glpi_operatingsystems`.`name` LIKE '%VMware%' OR  `glpi_operatingsystems`.`name` LIKE '%AIX%' OR  `glpi_operatingsystems`.`name` LIKE '%Linux%' 
 OR  `glpi_operatingsystems`.`name` LIKE '%SunOS %' OR  `glpi_operatingsystems`.`name` LIKE '%CentOS%' )";
$result = $conn->query($sql1);

if ($result->num_rows > 0) {
    $server = $result->num_rows;
//    echo "total server &nbsp;".$server."<br>" ;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('server.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
    $server = '0';
    $data = "";
   $csv_handler = fopen ('server.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}
$sql11 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where `glpi_computers`.`is_deleted` = '1'and (`glpi_operatingsystems`.`name` LIKE '%server%' OR  `glpi_operatingsystems`.`name` LIKE '%RedHat%' 
OR  `glpi_operatingsystems`.`name` LIKE '%VMware%' OR  `glpi_operatingsystems`.`name` LIKE '%AIX%' OR  `glpi_operatingsystems`.`name` LIKE '%Linux%' 
 OR  `glpi_operatingsystems`.`name` LIKE '%SunOS %' OR  `glpi_operatingsystems`.`name` LIKE '%CentOS%' )";
$result = $conn->query($sql11);

if ($result->num_rows > 0) {
    $server_decom = $result->num_rows;
//    echo "total server &nbsp;".$server."<br>" ;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('server_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
     $server_decom = '0';
     $data = "";
    $csv_handler = fopen ('server_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}
$sql12 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`date_mod` as date,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where `glpi_computers`.`is_deleted` = '0'and (`glpi_operatingsystems`.`name` LIKE '%server%' OR  `glpi_operatingsystems`.`name` LIKE '%RedHat%' 
OR  `glpi_operatingsystems`.`name` LIKE '%VMware%' OR  `glpi_operatingsystems`.`name` LIKE '%AIX%' OR  `glpi_operatingsystems`.`name` LIKE '%Linux%' 
 OR  `glpi_operatingsystems`.`name` LIKE '%SunOS %' OR  `glpi_operatingsystems`.`name` LIKE '%CentOS%' )and (`glpi_computers`.`date_mod`) <= DATE('".$last30days."')";
$result = $conn->query($sql12);

if ($result->num_rows > 0) {
    $server_notupd = $result->num_rows;
//    echo "total server &nbsp;".$server."<br>" ;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['date']."\n";
//    echo $data;
}
$csv_handler = fopen ('server_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
    $server_notupd = '0';
     $data = "";
   $csv_handler = fopen ('server_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql13 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where `glpi_computers`.`is_deleted` = '1'and (`glpi_operatingsystems`.`name` LIKE '%server%' OR  `glpi_operatingsystems`.`name` LIKE '%RedHat%' 
OR  `glpi_operatingsystems`.`name` LIKE '%VMware%' OR  `glpi_operatingsystems`.`name` LIKE '%AIX%' OR  `glpi_operatingsystems`.`name` LIKE '%Linux%' 
 OR  `glpi_operatingsystems`.`name` LIKE '%SunOS %' OR  `glpi_operatingsystems`.`name` LIKE '%CentOS%' ) and   MONTH(`glpi_computers`.`date_mod`) ='".$mnum."'";
$result = $conn->query($sql13);

if ($result->num_rows > 0) {
    $server_decom_month = $result->num_rows;
//    echo "total server &nbsp;".$server."<br>" ;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('server_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
     $server_decom_month = '0';
     $data = "";
    $csv_handler = fopen ('server_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql2 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 0 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%'
 and (`glpi_computertypes`.`name` LIKE '%desktop%' or `glpi_computertypes`.`name` LIKE '%tower%'or `glpi_computertypes`.`name` LIKE '%Space-saving%');";
$result = $conn->query($sql2);

if ($result->num_rows > 0) {
    $comp = $result->num_rows;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('desktop.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
//    echo "total Desktop &nbsp;".$comp."<br>" ;
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//       if ($row["name"] )
//    }

} 
else {
    $comp = '0';
    $data = "";
   $csv_handler = fopen ('desktop.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}
$sql21 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 1 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%'
 and (`glpi_computertypes`.`name` LIKE '%desktop%' or `glpi_computertypes`.`name` LIKE '%tower%'or `glpi_computertypes`.`name` LIKE '%Space-saving%');";
$result = $conn->query($sql21);

if ($result->num_rows > 0) {
    $comp_decom = $result->num_rows;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('desktop_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
//    echo "total Desktop &nbsp;".$comp."<br>" ;
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//       if ($row["name"] )
//    }

} 
else {
    $comp_decom = '0';
    $data = "";
   $csv_handler = fopen ('desktop_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}
$sql22 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`date_mod` as date,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 0 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%'
 and (`glpi_computertypes`.`name` LIKE '%desktop%' or `glpi_computertypes`.`name` LIKE '%tower%'or `glpi_computertypes`.`name` LIKE '%Space-saving%')
and (`glpi_computers`.`date_mod`) <= DATE('".$last30days."');";
$result = $conn->query($sql22);

if ($result->num_rows > 0) {
    $comp_notupd = $result->num_rows;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['date']."\n";
//    echo $data;
}
$csv_handler = fopen ('desktop_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
//    echo "total Desktop &nbsp;".$comp."<br>" ;
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//       if ($row["name"] )
//    }

} 
else {
    $comp_notupd = '0' ;
    $data = "";
 $csv_handler = fopen ('desktop_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql23 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 1 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%'
 and (`glpi_computertypes`.`name` LIKE '%desktop%' or `glpi_computertypes`.`name` LIKE '%tower%'or `glpi_computertypes`.`name` LIKE '%Space-saving%') and   MONTH(`glpi_computers`.`date_mod`) ='".$mnum."'";
$result = $conn->query($sql23);

if ($result->num_rows > 0) {
    $comp_decom_month = $result->num_rows;
    $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('desktop_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
//    echo "total Desktop &nbsp;".$comp."<br>" ;
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//       if ($row["name"] )
//    }

} 
else {
    $comp_decom_month = '0';
    $data = "";
   $csv_handler = fopen ('desktop_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql3 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 0 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%' 
and (`glpi_computertypes`.`name` LIKE '%notebook%' or `glpi_computertypes`.`name` LIKE '%laptop%' )";
$result = $conn->query($sql3);

if ($result->num_rows > 0) {
    $lappy = $result->num_rows;
//    echo "total Laptop &nbsp;".$lappy."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('laptop.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
$lappy = '0';
  $data = "";
$csv_handler = fopen ('laptop.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}
$sql31 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 1 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%' 
and (`glpi_computertypes`.`name` LIKE '%notebook%' or `glpi_computertypes`.`name` LIKE '%laptop%' )";
$result = $conn->query($sql31);

if ($result->num_rows > 0) {
    $lappy_decom = $result->num_rows;
//    echo "total Laptop &nbsp;".$lappy."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('laptop_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
       $lappy_decom = '0';
  $data = "";
$csv_handler = fopen ('laptop_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql32 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`date_mod` as date,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 0 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%' 
and (`glpi_computertypes`.`name` LIKE '%notebook%' or `glpi_computertypes`.`name` LIKE '%laptop%' ) and (`glpi_computers`.`date_mod`) <= DATE('".$last30days."');";
$result = $conn->query($sql32);

if ($result->num_rows > 0) {
    $lappy_notupd = $result->num_rows;
//    echo "total Laptop &nbsp;".$lappy."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['date']."\n";
//    echo $data;
}
$csv_handler = fopen ('laptop_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
   $lappy_notupd = '0';
  $data = "";
  $csv_handler = fopen ('laptop_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql33 = "SELECT `glpi_computers`.`name` as desktop,`glpi_computers`.`is_deleted` as deleted,`glpi_computers`.`serial`,`glpi_computers`.`contact` as username, `glpi_operatingsystems`.`name`,`glpi_computertypes`.`name` as cat
FROM `glpi_computers`
                LEFT JOIN `glpi_items_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`items_id`=`glpi_computers`.`id`)
LEFT JOIN `glpi_operatingsystems`
                           ON (`glpi_items_operatingsystems`.`operatingsystems_id`=`glpi_operatingsystems`.`id`)
LEFT JOIN `glpi_computertypes`
                           ON (`glpi_computertypes`.`id`=`glpi_computers`.`computertypes_id`)
where  `glpi_computers`.`is_deleted` = 1 and `glpi_operatingsystems`.`name` LIKE '%Windows 7%' 
and (`glpi_computertypes`.`name` LIKE '%notebook%' or `glpi_computertypes`.`name` LIKE '%laptop%' ) and   MONTH(`glpi_computers`.`date_mod`) ='".$mnum."'";
$result = $conn->query($sql33);

if ($result->num_rows > 0) {
    $lappy_decom_month = $result->num_rows;
//    echo "total Laptop &nbsp;".$lappy."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
  $data .= $row['desktop'].",".$row['serial'].",".$row['username'].",".$row['name'].",".$row['cat']."\n";
//    echo $data;
}
$csv_handler = fopen ('laptop_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
       $lappy_decom_month = '0';
  $data = "";
$csv_handler = fopen ('laptop_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql4 = "SELECT * FROM `glpi_printers` where is_deleted = 0";
$result = $conn->query($sql4);

if ($result->num_rows > 0) {
    $printer = $result->num_rows;
//    echo "total Laptop &nbsp;".$printer."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
if ($row['have_serial'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Serial\n";

    } 
    else if ($row['have_parallel'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Parallel\n";

    } 
    else if ($row['have_usb'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",USB\n";

    }
    else if ($row['have_wifi'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",WiFi\n";

    }
    else if ($row['have_ethernet'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Ethernet\n";

    } 
    else
    {
          $data .= $row['name'].",".$row['serial'].",Null\n";

    }
//    echo $data;
}
$csv_handler = fopen ('printer.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
    $data = "";
  $csv_handler = fopen ('printer.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql41 = "SELECT *
FROM `glpi_printers`
where is_deleted = 1";
$result = $conn->query($sql41);

if ($result->num_rows > 0) {
    $printer_decom = $result->num_rows;
//    echo "total Laptop &nbsp;".$printer."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
    if ($row['have_serial'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Serial\n";

    } 
    else if ($row['have_parallel'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Parallel\n";

    } 
    else if ($row['have_usb'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",USB\n";

    }
    else if ($row['have_wifi'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",WiFi\n";

    }
    else if ($row['have_ethernet'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Ethernet\n";

    } 
    else
    {
          $data .= $row['name'].",".$row['serial'].",Null\n";

    }
}
$csv_handler = fopen ('printer_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
     $data = "";
    $csv_handler = fopen ('printer_decom.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql42 = "SELECT *
FROM `glpi_printers`
where is_deleted = 0 and (`glpi_printers`.`date_mod`) <= DATE('".$last30days."');";
$result = $conn->query($sql42);

if ($result->num_rows > 0) {
    $printer_notupd = $result->num_rows;
//    echo "total Laptop &nbsp;".$printer."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
if ($row['have_serial'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Serial\n";

    } 
    else if ($row['have_parallel'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Parallel\n";

    } 
    else if ($row['have_usb'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",USB\n";

    }
    else if ($row['have_wifi'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",WiFi\n";

    }
    else if ($row['have_ethernet'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Ethernet\n";

    } 
    else
    {
          $data .= $row['name'].",".$row['serial'].",Null\n";

    }
}
$csv_handler = fopen ('printer_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
    $data = "";
   $csv_handler = fopen ('printer_not_update.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

$sql43 = "SELECT *
FROM `glpi_printers`
where is_deleted = 1
and   MONTH(`glpi_printers`.`date_mod`) ='".$mnum."'";


$result = $conn->query($sql43);

if ($result->num_rows > 0) {
    $printer_decom_month = $result->num_rows;
//    echo "total Laptop &nbsp;".$printer."<br>" ;
  $data = "";
while($row = $result->fetch_assoc()) {
    if ($row['have_serial'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Serial\n";

    } 
    else if ($row['have_parallel'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Parallel\n";

    } 
    else if ($row['have_usb'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",USB\n";

    }
    else if ($row['have_wifi'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",WiFi\n";

    }
    else if ($row['have_ethernet'] === '1')
    {
          $data .= $row['name'].",".$row['serial'].",Ethernet\n";

    } 
    else
    {
          $data .= $row['name'].",".$row['serial'].",Null\n";

    }
}
$csv_handler = fopen ('printer_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);

} 
else {
     $data = "";
    $printer_decom_month = '0';
    $csv_handler = fopen ('printer_decom_month.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}


//all asset'

$sqlAA = "SELECT `glpi_computers`.`name`,`glpi_computers`.`id`,`glpi_computers`.`serial`,`glpi_computers`.`tag_id`,`glpi_manufacturers`.`name` AS manufact,`glpi_computermodels`.`name` AS model,`glpi_computertypes`.`name` AS type  
FROM `glpi_computers`
INNER JOIN `glpi_manufacturers`
ON `glpi_computers`.`manufacturers_id` = `glpi_manufacturers`.`id`
INNER JOIN `glpi_computermodels`
ON `glpi_computers`.`computermodels_id` = `glpi_computermodels`.`id`
INNER JOIN `glpi_computertypes`
ON `glpi_computers`.`computertypes_id` = `glpi_computertypes`.`id`
INNER JOIN `glpi_domains`
ON `glpi_computers`.`domains_id` = `glpi_domains`.`id`
INNER JOIN `glpi_items_operatingsystems`
ON `glpi_items_operatingsystems`.`items_id` = `glpi_computers`.`id`
INNER JOIN `glpi_operatingsystems`
ON `glpi_operatingsystems`.`id` = `glpi_items_operatingsystems`.`operatingsystems_id`
WHERE `glpi_computers`.`is_deleted` = 0 order by `glpi_computers`.`id` ASC ;";


$result = $conn->query($sqlAA);

if ($result->num_rows > 0) {
  
  $data = "";
$data1 = "";
$data1 .= "Hostname, Serial Number, MBB Tag, Model, Type\n";
while($row = $result->fetch_assoc()) {
     $data .= $row['name'].";".$row['serial'].";".$row['tag_id'].";".$row['model'].";".$row['type']."\n";
 $data1 .= $row['name'].",".$row['serial'].",".$row['tag_id'].",".$row['model'].",".$row['type']."\n";

}
$csv_handler = fopen ('allasset.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
$csv_handler = fopen ('AllActiveITAsset.csv','w');
fwrite ($csv_handler,$data1);
fclose ($csv_handler);
} 
else {
     $data = "";
 
    $csv_handler = fopen ('allasset.csv','w');
fwrite ($csv_handler,$data);
fclose ($csv_handler);
}

    $time = date("Y-m-d H:i:s");

$sql = "INSERT INTO glpi_active_chart (desktop, laptop, server, printer,network,storage,dateime)
VALUES ('".$comp."', '".$lappy."', '".$server."','".$printer."','250','332','".$time."')";

if ($conn->query($sql) === TRUE) {
//    echo "Success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "INSERT INTO glpi_noupdate_chart (desktop, laptop, server, printer,network,storage,dateime)
VALUES ('".$comp_notupd."', '".$lappy_notupd."', '".$server_notupd."','".$printer_notupd."','250','332','".$time."')";

if ($conn->query($sql) === TRUE) {
//    echo "Success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "INSERT INTO glpi_decom_chart (desktop, laptop, server, printer,network,storage,dateime)
VALUES ('".$comp_decom."', '".$lappy_decom."', '".$server_decom."','".$printer_decom."','250','332','".$time."')";

if ($conn->query($sql) === TRUE) {
//header('Location: newasset.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "INSERT INTO glpi_decom_chart_month (desktop, laptop, server, printer,network,storage,dateime)
VALUES ('".$comp_decom_month."', '".$lappy_decom_month."', '".$server_decom_month."','".$printer_decom_month."','250','332','".$time."')";

if ($conn->query($sql) === TRUE) {
header('Location: newasset.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//include('newasset.php');

$conn->close();

//echo "Balance : ". ($total-$comp-$server-$lappy)
?>