<?php 
header('Content-type: text/json; charset=utf-8');
include 'connection/connect_i.php';
//$rslt=array();
$result=array();
$series = array();
//$data = isset($_GET['data'])?$_GET['data']:$_POST['data'];
$sql=mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,
d1.depName as dep,p2.posname as posi,e1.empno as empno
from emppersonal e1 
inner join pcode p1 on e1.pcode=p1.pcode
inner join department d1 on e1.depid=d1.depId
INNER JOIN work_history wh ON wh.empno=e1.empno
inner join posid p2 on wh.posid=p2.posId
where (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)) order by dep desc");
//$result = mysqli_fetch_array($sql);
while ($empperson = mysqli_fetch_assoc($sql)) {
  $series['fullname'] = $empperson['fullname'];
  $series['dep'] = $empperson['dep'];
  $series['posi'] = $empperson['posi'];
  $series['empno'] = $empperson['empno'];
array_push($result, $series); 
}
//$execute=array(':pd_id' => $data);
//$result=$conn_DB->select();
// if(isset($_GET['data2'])){
//     $result['count'] = $_GET['data2'];    
// }
//print_r($result);
print json_encode($result);
?>