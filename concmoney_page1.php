<?php @session_start(); ?>
<?php include 'connection/connect_i.php';
      include 'function/Convert_num_text.php';?>
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
    include_once ('option/funcDateThai.php');
        $empno=$_REQUEST['id'];
        $project_id=$_REQUEST['pro_id'];
 $sql_hos=  mysqli_query($db,"SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysqli_fetch_assoc($sql_hos);       
$sql_per = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        INNER JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join posid p2 on wh.posid=p2.posId
                                                        where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
    $sql_pro = mysqli_query($db,"SELECT t.*,p.PROVINCE_NAME,t2.tName as tname FROM training_out t
            inner join province p on t.provenID=p.PROVINCE_ID
            inner join trainingtype t2 on t2.tid=t.dt
            WHERE tuid='$project_id'");
    $sql_cost = mysqli_query($db,"SELECT SUM(abode)abode ,SUM(reg)reg,SUM(allow)allow,SUM(travel)travel,SUM(other)other
FROM plan_out 
WHERE idpo='$project_id'");
    $sql_pjoin = mysqli_query($db,"SELECT CONCAT(e.firstname,' ',e.lastname) as fullname
from plan_out p
INNER JOIN emppersonal e on e.empno = p.empno
WHERE p.idpo= $project_id and p.empno != $empno");
            
//    $sql_join=  mysqli_query($db,"select COUNT(empno)join_plan from plan_out where idpo='$project_id'");
//            $person_join=mysqli_fetch_assoc($sql_join);
//            $p_join_plan = $person_join['join_plan'];
    
            $Person_detial = mysqli_fetch_assoc($sql_per);
            $Project_detial = mysqli_fetch_assoc($sql_pro);
            $Project_cost = mysqli_fetch_assoc($sql_cost);
         
            $sql_trainout=  mysqli_query($db,"select *,
                    (select count(empno) from plan_out where idpo='$project_id') count_person from plan_out where idpo='$project_id' and empno='$empno'");
            $person_data=mysqli_fetch_assoc($sql_trainout);
            
require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
    ?>
    <div class="col-lg-12">
    <table border="0" width="100%">
        <tr>
            <td width="80%" valign="top">สัญญายืมเงินเลขที่............................................วันที่..............................................</td>
            <td width="20%" valign="bottom" align="right">ส่วนที่ 1</td>
        </tr>
        <tr>
            <td valign="top">ชื่อผู้ยืม.......<?=$Person_detial['fullname']?>.........จำนวนเงิน........<?php $total_money=number_format($Project_detial['m1']+$Project_detial['m2']+$Project_detial['m3']+$Project_detial['m4']+$Project_detial['m5']); if($total_money==0){echo '.......';}else{echo $total_money;}?>.........บาท</td>
            <td valign="bottom" align="right">แบบ 8708</td>
        </tr>
    </table>
    </div><h4 align="center">ใบเบิกค่าใช้จ่ายในการเดินทางไปราชการ</h4>
    <div align="right">ที่ทำการ <?=$hospital['name']?><br> วันที่ <?= DateThai2($person_data['reg_date'])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div class="col-lg-12" align="left">
    <b>เรื่อง</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุมัติเบิกค่าใช้จ่ายในเดินทางไปราชการ<br>
    <b>เรียน</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ตามคำสั่ง / บันทึก ที่ <?= $Project_detial['memberbook'] ?> ลงวันที่ <?= DateThai2($Project_detial['datein']) ?> ได้อนุมัติให้
<?=$Person_detial['fullname']?> <br>ตำแหน่ง <?=$Person_detial['posi']?> สังกัด <?=$hospital['name']?> พร้อมด้วย 
                    <?php while ($Person_join = mysqli_fetch_array($sql_pjoin)) {
                        echo $Person_join['fullname'].", ";
}?>
เดินทางไปปฏิบัติราชการ <?=$Project_detial['projectName']?> 
ณ. <?= $Project_detial['stantee'] ?> จ. <?= $Project_detial['PROVINCE_NAME'] ?> โดยออกเดินทางจาก<br>
(&nbsp;&nbsp;) บ้านพัก (&nbsp;&nbsp;) สำนักงาน (&nbsp;&nbsp;) ประเทศไทย ตั้งแต่วันที่...........เดือน ......................พ.ศ................เวลา...............น.<br>
และกลับถึง (&nbsp;&nbsp;) บ้านพัก (&nbsp;&nbsp;) สำนักงาน (&nbsp;&nbsp;) ประเทศไทย วันที่.........เดือน ...................พ.ศ..............เวลา.............น.<br>
    รวมเวลาไปราชการครั้งนี้.................วัน.................ชั่วโมง<br>    
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ข้าพเจ้าขอเบิกค่าใช้จ่ายในการเดินทางไปราชการสำหรับ (&nbsp;&nbsp;) ข้าพเจ้า (&nbsp;&nbsp;) คณะดังนี้<br>
<table width="100%" border="0">
    <tr>
        <td width="70%" height="30">ค่าเบี้ยเลี้ยงเดินทางประเภท..................................จำนวน<?php if(!empty($Project_detial['m3'])){echo "..........".number_format($Project_detial['amount'])."..........";}else{?>.........................<?php }?>วัน</td>
        <td width="30%" height="30">รวม <?php if(!empty($Project_cost['allow'])){echo "..........".number_format($Project_cost['allow'])."..........";}else{?>...............................<?php }?> บาท</td>
    </tr>
    <tr>
        <td height="30">ค่าเช่าที่พักปะเภท................................................จำนวน<?php if(!empty($Project_detial['m1'])){echo "..........".number_format($Project_detial['amount'])."..........";}else{?>.........................<?php }?>วัน</td>
        <td height="30">รวม <?php if(!empty($Project_cost['abode'])){echo "..........".number_format($Project_cost['abode'])."..........";}else{?>...............................<?php }?> บาท</td>
    </tr>
    <tr>
        <td height="30">ค่าพาหนะ............................................................................................. </td>
        <td height="30">รวม <?php if(!empty($Project_cost['travel'])){echo "..........".number_format($Project_cost['travel'])."..........";}else{?>...............................<?php }?> บาท</td>
    </tr>
    <tr>
        <td height="30">ค่าใช้จ่ายอื่น.......................................................................................... </td>
        <td height="30">รวม <?php if(!empty($Project_cost['other']) or !empty($Project_cost['reg'])){echo "..........".number_format($Project_cost['other']+$Project_cost['reg'])."..........";}else{?>...............................<?php }?> บาท</td>
    </tr>
    <tr>
        <td align="right" colspan="2" height="30">รวมเงินทั้งสิ้น .....<?php $total_money=number_format($Project_cost['abode']+$Project_cost['reg']+$Project_cost['allow']+$Project_cost['travel']+$Project_cost['other']); if($total_money==0){echo '...';}else{echo $total_money;}?>......บาท</td>
    </tr>
</table>
จำนวนเงิน (ตัวอักษร) <?php if(!empty($total_money)){echo '................'.num2wordsThai("$total_money").'บาทถ้วน................';}else{?>.......................................................................................<?php }?><p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            ข้าพเจ้าขอรับรองว่ารายการที่กล่าวมาข้างต้นเป็นความจริง และหลักฐานการจ่าที่ส่งมาด้วย<br>จำนวน ........................ฉบับ รวมทั้งจำนวนเงินที่ขอเบิกถูกต้องตามกฎหมายทุกประการ
            <br>
            <table width="100%" border="0">
                <tr>
                    <td width="30%" align="center" valign="top">&nbsp;</td>
                    <td width="40%" align="center" valign="top"><br><b>( ลงชื่อ )</b> ............................................ <br><br>
(
  <?=$Person_detial['fullname']?>
)<br><br>
ตำแหน่ง
<?=$Person_detial['posi']?></td>
                </tr>
                </table>
                    
                
            <br><br><div align="right">F-FA-009-02</div>
<?php
$html = ob_get_contents();
ob_clean();

ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
 
     <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
                <tr>
                   
                    <td width="50%" valign="top"><br>&nbsp;&nbsp;&nbsp;ได้ตรวจสอบหลักฐานการเบิกจ่ายเงินที่แนบถูกต้อง&nbsp;&nbsp;&nbsp;แล้วเห็นควรอนุมัติให้เบิกจ่ายได้<br>
                <br>&nbsp;&nbsp;ลงชื่อ.............................................................</br><br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(.........................................................)</br><br>
<br>&nbsp;&nbsp;ตำแหน่ง........................................................</br><br>
<br>&nbsp;&nbsp;วันที่..............................................................</br><br>
</td>
<td width="50%" valign="top"><br>&nbsp;&nbsp;&nbsp;อนุมัติให้จ่ายได้<br><br>
<br>&nbsp;&nbsp;ลงชื่อ.............................................................</br><br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...........................................................)</br><br>
<br>&nbsp;&nbsp;ตำแหน่ง.........................................................</br><br>
<br>&nbsp;&nbsp;วันที่...............................................................</br><br>
</td>
                </tr>
                </table>
    
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ได้รับเงินค่าใช้จ่ายในการทางไปราชการ  
    จำนวน.........................<?php $total_money=number_format($Project_cost['abode']+$Project_cost['reg']+$Project_cost['allow']+$Project_cost['travel']+$Project_cost['other']); if($total_money==0){echo '...';}else{echo $total_money;}?>.........................บาท<br>
&nbsp;&nbsp;(<?php if(!empty($total_money)){echo '................'.num2wordsThai("$total_money").'บาทถ้วน................';}else{?>.......................................................................................<?php }?>) ไว้เป็นการถูกต้องแล้ว 
 <table width="100%" border="0">
                <tr>
                   
                    <td width="50%" valign="top">
                <br>&nbsp;&nbsp;ลงชื่อ............................................................ผู้รับเงิน<br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <?=$Person_detial['fullname']?> )<br>
<br>&nbsp;&nbsp;ตำแหน่ง <?=$Person_detial['posi']?> <br>
<br>&nbsp;&nbsp;วันที่...............................................................</br><br>
</td>
                    <td width="50%" valign="top">
<br>&nbsp;&nbsp;ลงชื่อ.........................................................ผู้จ่ายเงิน</br><br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(.......................................................)</br><br>
<br>&nbsp;&nbsp;ตำแหน่ง............................................................</br><br>
<br>&nbsp;&nbsp;วันที่...............................................................</br><br>
</td>   
                </tr>
                </table>
 &nbsp;&nbsp;&nbsp;จากเงินยืมตามสัญญาเลขที่.................................................วันที่............................................................
 <hr>
 &nbsp;&nbsp;หมายเหตุ.................................................................................................................................................<p>
 &nbsp;&nbsp;...........................................................................................................................................................<br><br> 
 &nbsp;&nbsp;...........................................................................................................................................................<br><br>
 &nbsp;&nbsp;...........................................................................................................................................................<br><br>
 &nbsp;&nbsp;...........................................................................................................................................................
 <hr>
 <u>คำชี้แจง</u>&nbsp;&nbsp;&nbsp;1. กรณีเดินทางเป็นหมู่คณะและจัดทำใบเบิกค่าใช้จ่ายรวมฉบับเดียวกัน หากระยะเวลาในการเริ่มต้น<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;และ สิ้นสุดการเดินทางของแต่ละบุคคลแตกต่างกัน ให้แสดงรายละเอียดของวันเวลาที่แตกต่างกัน<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ของบุคคลนั้นในช่องหมายเหตุ<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. กรณียื่นขอเบิกค่าใช้จ่ายรายบุคคล ให้ผู้ขอรับเงินและวันเดือนปีที่ได้รับเงินกรณีที่มีการยืมเงิน<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ให้ระบุวันที่ที่ได้รับเงินยืม เลขที่สัญญายืมและวันที่อนุมัติเงินยืมด้วย<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. กรณีที่ยืนขอเบิกค่าใช้จ่ายรวมเป็นหมู่คณะ ผู้ขอรับเงินมิต้องลงลายมือชื่อในช่องผู้รับเงิน ทั้งนี้ ให้<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้มีสิทธิแต่ละคนลงลายมือชื่อผู้รับเงินในหลักฐานการจ่ายเงิน (ส่วนที่ 2)<br>

            <div align="right">F-FA-009-02</div>            
    <?php 
$html2 = ob_get_contents();
ob_clean();    
$pdf = new mPDF('tha2','A4','11','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->AddPage();
$pdf->WriteHTML($html2,2);
$pdf->Output("MyPDF/concmoney1.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/concmoney1.pdf' />";
?>
</body>
</html>