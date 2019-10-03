<?php
## Database configuration
// include 'config.php';
include(__DIR__ . '/../../config.php');
include(__DIR__ . '/lib.php');
die(local_hoteles_city_dashboard_get_paginated_users($_POST));
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = " ";
$queryParams = array();
if($searchValue != ''){
    $searchValue = "%{$searchValue}%";
    $searchQuery = " WHERE email like ? or concat(firstname, ' ', lastname) like ? ";
    array_push($queryParams, $searchValue);
    array_push($queryParams, $searchValue);
}

## Total number of records without filtering
$totalRecords = $DB->count_records('user');//($table, $conditions_array);

## Total number of record with filtering
$totalRecordwithFilter = $DB->count_records_sql("select count(*) from {user} {$searchQuery}", $queryParams);

$default_fields = local_hoteles_city_dashboard_get_default_report_fields();
$custom_fields  = local_hoteles_city_dashboard_get_custom_report_fields();

$orderBy = " order by {$columnName} {$columnSortOrder} ";
if($columnName == 'fullname'){
    $orderBy = " ORDER BY fullname {$columnSortOrder}";
}

// _log('$default_fields', $default_fields);
$select_default = "";
if(!empty($default_fields)){
    $select_default = ', ' . implode(',', $default_fields);
}
// _log('$custom_fields', $custom_fields);
if(!empty($custom_fields)){
    implode(',', $custom_fields);
}

## Fetch records
// $records = $DB->get_records_sql("select concat(firstname, ' ', lastname) as name {$select_default} from {user} {$searchQuery} order by name {$columnSortOrder}
//                                  LIMIT {$row}, {$rowperpage}", $queryParams);
$records = $DB->get_records_sql("select email, concat(firstname, ' ', lastname) as name, id, '<a href=\"https://www.google.com.mx\">Elemento</a>' AS reg from {user} {$searchQuery} order by email {$columnSortOrder} LIMIT {$row}, {$rowperpage}", $queryParams);

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => array_values($records)
);
$json_response = json_encode($response);
_log('Desde función', local_hoteles_city_dashboard_get_paginated_users($_POST));//$json_response;
_log('Similar', $json_response);
echo $json_response;