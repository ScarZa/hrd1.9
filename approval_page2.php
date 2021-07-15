<?php @session_start(); ?>
<?php include 'connection/connect_i.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="images/logo.png">
<!-- Bootstrap core CSS -->
<link href="option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="option/css/stylelist.css">
<script src="option/js/excellentexport.js"></script>
</head>
<body>
    
    <?php
    
    $empno=$_REQUEST['id'];
    $project_id=$_REQUEST['pro_id'];
    $sql_person= mysqli_query($db,"select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname, po.status_out as status_out 
from plan_out po
LEFT OUTER JOIN emppersonal e1 on po.empno=e1.empno
INNER JOIN work_history wh ON wh.empno=e1.empno
inner join posid p1 on wh.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
where e1.status ='1' and po.empno !=$empno and po.idpo='$project_id' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
ORDER BY empno");
   require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
    ?>
    
    <div align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4 align="center">รายชื่อคณะเดินทางไปราชการ</h4></div>
    
    <table border="0" width="100%">
  <?php
                             $i=1;
while($team=  mysqli_fetch_assoc($sql_person)){?>
        <tr>
            <td><b><?= $i?>.</b></td>
            <td><?= $team['fullname']?></td>
            <td><b>ตำแหน่ง</b> &nbsp;&nbsp;<?= $team['posname']?></td>
        </tr>
        <?php $i++; } ?>
    </table>
    <br><br><br>
    <br><br><br>
    <div align="right">F-AD-100-03</div>
    <?php
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('tha2','A4','10','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("MyPDF/approval.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/approval.pdf' />";
?>
</body>
</html>