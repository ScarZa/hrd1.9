<?php

header('Content-type: text/json; charset=utf-8');

include_once 'connect_iJson.php';
include_once '../option/function_date.php';
include_once '../option/funcDateThai.php';

set_time_limit(0);
$rslt = array();
$series = array();
$data = isset($_POST['data'])?$_POST['data']:(isset($_GET['data'])?$_GET['data']:'');
$sql = mysqli_query($db,"SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) fullname
,'ผอ.รพจ.เลยฯ' position
,CASE
    #WHEN m.Status = 'USUSER' THEN 1
		WHEN m.Status = 'SUSER' THEN 1
    WHEN m.Status = 'USER' THEN 2
    ELSE '???'
END class
,dg.dep_name,d.depName,ps.posname,e.photo
FROM emppersonal e
INNER JOIN hospital h on h.manager = e.empno
INNER JOIN pcode p on p.pcode = e.pcode
INNER JOIN member m on m.Name = e.empno
INNER JOIN department d on d.depId = e.depid
INNER JOIN department_group dg on dg.main_dep = d.main_dep
INNER JOIN posid ps on ps.posId = e.posid
UNION
SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) fullname
,CASE
    WHEN m.Status = 'USUSER' THEN 'หัวหน้ากลุ่มภารกิจ'
		WHEN m.Status = 'SUSER' THEN 'หัวหน้า'
    WHEN m.Status = 'USER' THEN 'เจ้าหน้าที่'
    ELSE '???'
END position
,CASE
    WHEN m.Status = 'USUSER' THEN 1
		WHEN m.Status = 'SUSER' THEN 1
    WHEN m.Status = 'USER' THEN 2
    ELSE '???'
END class
,dg.dep_name,d.depName,ps.posname,e.photo
FROM emppersonal e
inner JOIN work_history wh ON wh.empno=e.empno and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
INNER JOIN pcode p on p.pcode = e.pcode
INNER JOIN member m on m.Name = e.empno
INNER JOIN department d on d.depId = wh.depid
INNER JOIN department_group dg on dg.main_dep = d.main_dep
INNER JOIN posid ps on ps.posId = wh.posid
WHERE m.Status != 'ADMIN' AND (d.depId = $data ) and e.status = 1
ORDER BY position asc");

 while( $wt  = mysqli_fetch_assoc( $sql ) ){
    $series['fullname'] = $wt['fullname'];
    $series['position'] = $wt['position'];
    $series['class'] = $wt['class'];
    $series['dep_name'] = $wt['dep_name'];
    $series['depName'] = $wt['depName'];
    $series['posname'] = $wt['posname'];
    $series['photo'] = $wt['photo'];
     array_push($rslt, $series);    
    }
  //print_r($rslt);
print json_encode($rslt);
?>