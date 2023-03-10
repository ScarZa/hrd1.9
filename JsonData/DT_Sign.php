<?php
header('Content-type: text/json; charset=utf-8');

include_once 'connect_iJson.php';
include_once '../option/function_date.php';
include_once '../option/funcDateThai.php';

set_time_limit(0);
$rslt = array();
$series = array();
//$data = isset($_POST['data1'])?$_POST['data1']:(isset($_GET['data1'])?$_GET['data1']:'');
$sql = mysqli_query($db,"SELECT empno,concat(firstname,' ',lastname) as fullname 
,if(signature != '','มีลายเซ็นต์แล้ว','ไม่มี') chk_sign
FROM emppersonal order by empno");

 while( $num_risk  = mysqli_fetch_assoc( $sql ) ){
    $series['empno'] = $num_risk['empno'];
    $series['fullname'] = $num_risk['fullname'];
    $series['chk_sign'] = $num_risk['chk_sign'];
     array_push($rslt, $series);    
    }
  
print json_encode($rslt);
