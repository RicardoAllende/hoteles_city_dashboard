<?php
## Database configuration
// include 'config.php';
include(__DIR__ . '/../../config.php');

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$rowperpage = 1000;
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
// $sel = mysqli_query($con,"select count(*) as allcount from {user}");
// $records = mysqli_fetch_assoc($sel);
// $totalRecords = $records['allcount'];
$totalRecords = $DB->count_records('user');//($table, $conditions_array);

## Total number of record with filtering
// $sel = mysqli_query($con,"select count(*) as allcount from {user} WHERE  ".$searchQuery);
// $records = mysqli_fetch_assoc($sel);
// $totalRecordwithFilter = $records['allcount'];
$totalRecordwithFilter = $DB->count_records_sql("select count(*) from {user} {$searchQuery}", $queryParams);

## Fetch records
// $empQuery = "select * from employee  ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// $empRecords = mysqli_query($con, $empQuery);
$records = $DB->get_records_sql("select email, concat(firstname, ' ', lastname) as name, id from {user} {$searchQuery} order by email {$columnSortOrder} LIMIT {$row}, {$rowperpage}", $queryParams);

$data = array();

// while ($row = mysqli_fetch_assoc($empRecords)) {
//     $data[] = array( 
//         "email"=>$row['email'],
//         "name"=>$row['emp_name'],
//         "id"=>$row['gender'],
//         "salary"=>$row['salary'],
//         "city"=>$row['city']
//     );
// }

foreach ($records as $key => $record) {
    $data[] = array(
        'email' => $record->email,
        'name'  => $record->name,
        'id'    => $record->id,
        'reg'   => '<a href="https://www.google.com.mx">Elemento</a>',
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data
);
$json_response = json_encode($response);
// _log($response);
echo $json_response;