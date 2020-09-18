<?php @session_start(); ?>
<?php include_once 'connection/connect_i.php';
if(!$db){
     die ('Connect Failed! :'.mysqli_error ($db));
     exit;
}?>
<?php if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
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
$query=mysqli_query($db,"select * from hospital");
$hospital=  mysqli_fetch_assoc($query);
if (!empty($hospital['logo'])) {
                                    $pic = $hospital['logo'];
                                    $fol = "logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }
$empno=$_REQUEST['id'];
$sql = $db->prepare("SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,p1.posname as posion,e1.photo as photo FROM emppersonal e1
inner JOIN work_history wh ON wh.empno=e1.empno
inner JOIN posid p1 ON p1.posId=wh.posid
WHERE e1.empno= ?  and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
$sql->bind_param("i",$empno);
$sql->execute();
$sql->bind_result($name,$posion,$photo);
$sql->fetch();

if (!empty($photo)) {
                                    $photo = $photo;
                                    $folder = "photo/";
                                } else {
                                    $photo = 'person.png';
                                    $folder = "images/";
                                }

?>
<style type="text/css">
    body{
  -webkit-print-color-adjust:exact;
}
p.small {line-height: 90%}
p.big {line-height: 200%}
table {
  border-collapse: separate;
  border-spacing: 0px;
}
</style>
    <?php
require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<table border="1" name="card" style="background-image: url('images/card.jpg');">
    <tr>
    <td align="center" width="190" height="295" >
            <img src='<?= $fol . $pic; ?>' width="35"><br>
            <font size="2" color="blue"><p><b><?= $hospital['name']?><br>
                    กรมสุขภาพจิต กระทรวงสาธารณสุข</b></p></font><br>
            <img src='<?= $folder . $photo ?>' height="110"><br><br>
            <p class="small"><b><font size="3" color="black"><?= $name?></font><br>
            <font size="2" color="black"><?= $posion?></font></b></p>
            <p><img src='images/logogrom.png' width="25"> <img src='images/URS.png' width="45">&nbsp;</p>
        </td>
    </tr>
</table>
<?php
$time_re=  date('Y_m_d');
$reg_date=$work['reg_date'];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('tha2','A4','11','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("card/card$empno$Code.pdf");
echo "<meta http-equiv='refresh' content='0;url=card/card$empno$Code.pdf' />";

?>
<?php include 'footeri.php';?>