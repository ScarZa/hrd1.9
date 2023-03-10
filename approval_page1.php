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
    $sql_pro = mysqli_query($db,"SELECT t.*, p.PROVINCE_NAME,t2.tName as tname FROM training_out t
    inner join province p on t.provenID=p.PROVINCE_ID
    inner join trainingtype t2 on t2.tid=t.dt
    WHERE tuid='$project_id'");
$Project_detial = mysqli_fetch_assoc($sql_pro);
$sql_per = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        INNER JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join posid p2 on wh.posid=p2.posId
                                                        where e1.empno='".$Project_detial['traveler']."' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
            $Person_detial = mysqli_fetch_assoc($sql_per);
            
         
            $sql_trainout=  mysqli_query($db,"select *,
                    (select count(empno) from plan_out where idpo='$project_id') count_person from plan_out where idpo='$project_id' and empno='$empno'");
            $person_data=mysqli_fetch_assoc($sql_trainout);
            
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
    <b>ที่</b> &nbsp;&nbsp;&nbsp;สธ ๐๘๓๘.๑.๒/<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Project_detial['memberbook']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    วันที่ <b><?= DateThai2($Project_detial['datein'])?></b><br>
    <b>เรื่อง</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุมัติเดินทางไปราชการ
</div>
<div class="col-lg-12" align="let">
    <b>เรียน</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?>&nbsp;&nbsp;(ผ่านหัวหน้าฝ่ายทรัพยากรบุคคล)</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยข้าพเจ้า <?=$Person_detial['fullname']?> ตำแหน่ง <?=$Person_detial['posi']?> พร้อมคณะจำนวน <?= $person_data['count_person']-1?> คน
(รายละเอียดแนบท้าย) มีความประสงค์เดินทางไปราชการเรื่อง <?=$Project_detial['projectName']?> (<b><?php if($Project_detial['dt']=='10' or $Project_detial['dt']=='11'){echo $Project_detial['tname'];}?></b>) ระหว่างวันที่</b> <?= DateThai2($Project_detial['Beginedate']) ?>&nbsp; ถึงวันที่ &nbsp; <?= DateThai2($Project_detial['endDate']) ?>
ณ. <?= $Project_detial['stantee'] ?> จ. <?= $Project_detial['PROVINCE_NAME'] ?><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในการนี้ ข้าพเจ้าขออนุมัติเดินทางไปราชการตั้งแต่วันที่&nbsp; <?= DateThai2($Project_detial['stdate'])?>&nbsp; ถึงวันที่&nbsp; <?= DateThai2($Project_detial['etdate'])?>&nbsp;
            โดยไม่ถือเป็นวันลา และขออนุมัติเดินทางโดย<br>
                <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
                    <tr>
                        <td width="40%" align="center">&nbsp;</td>
                        <td width="30%" align="center">ไป</td>
                        <td width="30%" align="center">กลับ</td>
                    </tr>
                    <tr>
                        <td height="30">&nbsp;[ ] รถโดยสารประจำทาง</td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                    </tr>
                    <tr>
                        <td height="30">&nbsp;[ ] รถไฟ</td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                    </tr>
                    <tr>
                        <td height="30">&nbsp;[ ] รถยนต์ส่วนตัว ทะเบียน.....................</td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                    </tr>
                    <tr>
                        <td height="30">&nbsp;[ ] รถยนต์ส่วนกลาง ทะเบียน.................. พร้อมพนักงานขับรถ</td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                    </tr>
                    <tr>
                        <td height="30">&nbsp;[ ] เครื่องบิน</td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                        <td>&nbsp;จาก................. ถึง................. </td>
                    </tr>
                </table><br>                                                                                          
                โดยมีเหตุความจำเป็นในกรณีที่ขอเดินทางโดยเครื่องบินดังนี้................................................................................................<p>
                ...................................................................................................................................................................​.​.​.​.​.​.​.​.​.​.​.​.​.​.​.​<br>
                
                ในการเดินทางไปราชการครั้งนี้ข้าพเจ้าประมาณการค่าใช้จ่าย จาก<?=$hospital['name']?> ดังต่อไปนี้
                <table width="100%" border="0">
                    <tr>
                        <td height="25" width="17%"><?php if(!empty($Project_detial['m3'])){?>[<img src="images/check.png" width="10">]<?php }else{?>[ ]<?php }?> ค่าเบี้ยเลี้ยง</td>
                        <td width="33%" align="left">เป็นจำนวนเงิน <?php if(!empty($Project_detial['m3'])){echo number_format($Project_detial['m3']);}else{?>.........................<?php }?> บาท</td>
                        <td width="16%"><?php if(!empty($Project_detial['m2'])){?>[<img src="images/check.png" width="10">]<?php }else{?>[ ]<?php }?> ค่าลงทะเบียน</td>
                        <td width="35%" align="right">เป็นจำนวนเงิน <?php if(!empty($Project_detial['m2'])){echo number_format($Project_detial['m2']);}else{?>.........................<?php }?> บาท</td>
                    </tr>
                    <tr>
                        <td height="25"><?php if(!empty($Project_detial['m1'])){?>[<img src="images/check.png" width="10">]<?php }else{?>[ ]<?php }?> ค่าที่พัก</td>
                        <td align="left">เป็นจำนวนเงิน <?php if(!empty($Project_detial['m1'])){echo number_format($Project_detial['m1']);}else{?>.........................<?php }?> บาท</td>
                        <td><?php if(!empty($Project_detial['m5'])){?>[<img src="images/check.png" width="10">]<?php }else{?>[ ]<?php }?> ค่าใช้จ่ายอื่นๆ</td>
                        <td align="right">เป็นจำนวนเงิน <?php if(!empty($Project_detial['m5'])){echo number_format($Project_detial['m5']);}else{?>.........................<?php }?> บาท</td>
                    </tr>
                    <tr>
                        <td height="25"><?php if(!empty($Project_detial['m4'])){?>[<img src="images/check.png" width="10">]<?php }else{?>[ ]<?php }?> ค่าพาหนะ</td>
                        <td align="left">เป็นจำนวนเงิน <?php if(!empty($Project_detial['m4'])){echo number_format($Project_detial['m4']);}else{?>.........................<?php }?> บาท</td>
                        <td colspan="2">[ ] ไม่ขอเบิกค่าใช้จ่าย</td>
                    </tr>
                    <tr>
                      <td height="25">รวมค่าใช้จ่ายทั้งสิ้น</td>
                      <td align="left">เป็นจำนวนเงิน........<?php $total_money=number_format($Project_detial['m1']+$Project_detial['m2']+$Project_detial['m3']+$Project_detial['m4']+$Project_detial['m5']); if($total_money==0){echo '...';}else{echo $total_money;}?>...........บาท</td>
                      <td colspan="2">(<?php if(!empty($total_money)){echo '................'.num2wordsThai("$total_money").'บาทถ้วน................';}else{?>.......................................................................................<?php }?>)</td>
                    </tr>
                </table>
                และได้แนบเอกสารมาพร้อมนี้ [ ] หนังสือเชิญ &nbsp;&nbsp;&nbsp;&nbsp;[ ] &nbsp;&nbsp; เอกสารโครงการ<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ
            <br>
            <table width="100%" border="0">
                <tr>
                    <td width="30%" align="center" valign="top">&nbsp;</td>
                    <td width="40%" align="center" valign="top"><br><b>( ลงชื่อ )</b> ............................................ <br>
(
  <?=$Person_detial['fullname']?>
)<br>
ตำแหน่ง
<?=$Person_detial['posi']?></td>
                    <td width="30%"><br>
                      <table border="1" cellspacing="" cellpadding="" frame="below" class="divider">
                        <tr>
                            <td valign="top">
                                <br>
                                &nbsp;ฝ่ายการเงิน ............................<br><br>
                            &nbsp;ฝ่าย HRM .............................</td>
                        </tr>
                    </table>   
                    </td>
                </tr>
                </table>
                    
                
            <br><div align="right">F-AD-100-03</div>
    <?php
    $html = ob_get_contents();
ob_clean();
    $sql_person= mysqli_query($db,"select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname, po.status_out as status_out 
from plan_out po
LEFT OUTER JOIN emppersonal e1 on po.empno=e1.empno
INNER JOIN work_history wh ON wh.empno=e1.empno
inner join posid p1 on wh.posid=p1.posId
inner join pcode p2 on e1.pcode=p2.pcode
where e1.status ='1' and po.empno !=".$Project_detial['traveler']." and po.idpo='$project_id' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
group by e1.empno
ORDER BY po.empno asc");
ob_start();
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
$html2 = ob_get_contents();
ob_clean();    
$pdf = new mPDF('tha2','A4','10','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->AddPage();
$pdf->WriteHTML($html2,2);
$pdf->Output("MyPDF/approval.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/approval.pdf' />";
?>
</body>
</html>