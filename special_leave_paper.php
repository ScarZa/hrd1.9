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
<style type="text/css">
body {
	margin-top: 50px;
}
</style>
</head>
<?php
include_once ('option/funcDateThai.php');
include 'option/function_date.php';

    $empno=$_REQUEST['empno'];
    $workid=$_REQUEST['work_id'];
    $sql_hos=  mysqli_query($db,"SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysqli_fetch_assoc($sql_hos);
    $sql=  mysqli_query($db,"select w.*,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,d2.dep_name as depname,p2.posname as posi ,
ty.nameLa as namela,w.tel as telephone
            from work w 
            inner join emppersonal e1 on w.enpid=e1.empno
            inner join pcode p1 on e1.pcode=p1.pcode
            inner join department d1 on e1.depid=d1.depId
            inner join department_group d2 on d2.main_dep=d1.main_dep
            inner join posid p2 on e1.posid=p2.posId
						INNER JOIN typevacation ty on ty.idla=w.typela
            where w.enpid='$empno' and w.workid='$workid'");
    $work=  mysqli_fetch_assoc($sql);
    
?>
<body>
    <?php
require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12">
    <table border="0" width="100%">
        <tr>
            <td width="5%" valign="top"><img src="images/garuda02.png" width="60"></td>
            <td width="95%" valign="bottom" align="center"><h1>บันทึกข้อความ</h1></td>
        </tr>
    </table>
</div><br>
<div class="col-lg-12">
    <b>ส่วนราชการ</b> &nbsp;&nbsp;&nbsp;<?=$hospital['name']?> &nbsp;&nbsp;&nbsp;ฝ่ายทรัพยากรบุคคล โทร.๐-๔๒๘๐-๘๑๔๔ <br>
    <b>ที่</b> &nbsp;&nbsp;&nbsp;สธ ๐๘๓๘.๑.๒/<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    วันที่ <b><?= DateThai2($work['reg_date'])?></b><br>
    <b>เรื่อง</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุญาตลาเป็นกรณีพิเศษ 
</div>
<div class="col-lg-12" align="let">
    <b>เรียน</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามระเบียบ <?=$hospital['name']?> ว่าด้วยการลาและการมาปฏิบัติราชการของบุคลากร <?=$hospital['name']?> 
            พ.ศ.2546 ข้อ 1 (5) การลากิจ ให้ยื่นใบลาล่วงหน้าต่อหัวหน้างาน/ฝ่าย และส่งฝ่ายทรัพยากรบุคคล ไม่น้อยกว่า 2 วันทำการ ยกเว้นกรณีเร่งด่วน ให้บ้นทึกชี้แจ้งของการลาเป็นกรณีพิเศษ และข้อ 13 (1) - (2) ไม่อนุญาตให้ข้าราชการ
            ลูกจ้างประจำ และลูกจ้างชั่วคราว ใช้สิทธิการลาก่อน-หลัง วันหยุดราชการ วันหยุดชดเชย และวันหยุดราชการประจำปี ถ้ามีเหตุผล ความจำเป็นให้บันทึกขออนุญาตเสนอผู้อำนวยการโรงพยาบาลเป็น กรณีพิเศษ นั้น<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในการนี้ ข้าพเจ้ามีความประสงค์ขออนุญาตลา เป็นกรณีพิเศษ<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;) 
            &nbsp;ลากิจ<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;) 
            &nbsp;ลาพักผ่อน<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;) 
            &nbsp;ลาก่อน-หลัง วันหยุดราชการ<br>
            ตั้งแต่วันที่<b>&nbsp; <?= DateThai2($work['begindate'])?>&nbsp; </b>ถึงวันที่<b>&nbsp; <?= DateThai2($work['enddate'])?>&nbsp; </b>เป็นระยะเวลา<b>&nbsp; <?= $work['amount']?> &nbsp;</b>วัน<br>
            เนื่องจาก<b> <?= $work['abnote']?> </b><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาอนุญาต
            
                                    
</div><br> 
                                 <div class="row">
                                 <div class="col-lg-12">
                                     <table border="0" width="100%">
                                         <tr>
                                             <td width="50%" align="center">
                                                 ความคิดเห็นของหัวหน้าฝ่าย/งาน .............................................<br><br>
                                     ..............................................................................................<br><br>
                                     ..............................................................................................<br><br><br><br><br>
                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     ........................................หัวหน้าฝ่าย/งาน<br><br>
                                     (..........................................)<br><br>
                                     ........../............/............ 
                                             </td>
                                             <td width="50%" align="center">
                                                 .............................................<br><br>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         ( <?= $work['fullname']?> ) ผู้ขออนุญาต<br><br>
                                     <?= DateThai2($work['reg_date'])?><br><br>
                                     (&nbsp;&nbsp;&nbsp;) &nbsp;อนุญาต &nbsp;&nbsp; (&nbsp;&nbsp;&nbsp;) &nbsp;ไม่อนุญาต<br><br><br>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     ...............................................ผู้อำนวยการฯ<br><br>
                                     (..........................................)<br><br>
                                         ........../............/............
                                             </td>
                                         </tr>
                                     </table>
                                 </div>
                                     
                                 </div><br><br><br><br><br>
<div class="col-lg-12" align="right">F-HR-008</div>
<?php
$time_re=  date('Y_m_d');
$reg_date=$work['reg_date'];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('tha2','A4','10','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("MyPDF/spec_leave.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/spec_leave.pdf' />";
?>
</body>
</html>