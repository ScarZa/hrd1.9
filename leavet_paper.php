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
<?php
include_once ('option/funcDateThai.php');
    $empno=$_REQUEST['empno'];
    $workid=$_REQUEST['Lno'];
    $sql_hos=  mysqli_query($db,"SELECT CONCAT(p.pname,e.firstname,' ',e.lastname) as fullname,h.name as name 
FROM hospital h
INNER JOIN emppersonal e on e.empno=h.manager
INNER JOIN pcode p on p.pcode=e.pcode");
    $hospital=mysqli_fetch_assoc($sql_hos);
    $sql=  mysqli_query($db,"select t1.*,concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,d2.dep_name as depname,p2.posname as posi 
    ,(SELECT e1.signature FROM emppersonal e1 WHERE e1.empno=t1.idAdmin) writer
    ,(SELECT e1.signature FROM emppersonal e1 WHERE e1.empno=t1.receivert) appr
    ,(SELECT concat(p1.pname,e2.firstname,' ',e2.lastname) FROM emppersonal e2 inner join pcode p1 on e2.pcode=p1.pcode WHERE e2.empno=t1.receivert) appr_name
    ,if(!ISNULL(t1.comfirmert),(SELECT concat(p1.pname,e1.firstname,' ',e1.lastname) FROM emppersonal e1 WHERE e1.empno=t1.comfirmert),'') confirm_name
    ,if(!ISNULL(t1.comfirmert),(SELECT e1.signature FROM emppersonal e1 WHERE e1.empno=t1.comfirmert),'') confirm
            from timela t1 
            inner join emppersonal e1 on t1.empno=e1.empno
            inner join pcode p1 on e1.pcode=p1.pcode
            INNER JOIN work_history wh ON wh.empno=e1.empno
            inner join department d1 on wh.depid=d1.depId
            inner join department_group d2 on d2.main_dep=d1.main_dep
            inner join posid p2 on wh.posid=p2.posId
            where t1.empno='$empno' and t1.id='$workid' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
    $work=  mysqli_fetch_assoc($sql);
    if(!empty($work['comfirmert']) and ($work['authority']=='USER'and ($work['regis_time']=='A' or $work['regis_time']=='Y'))){
      $sql2=  mysqli_query($db,"SELECT concat(p1.pname,e.firstname,' ',e.lastname) fullname ,e.signature
      FROM emppersonal e
      inner join pcode p1 on e.pcode=p1.pcode
      LEFT OUTER JOIN work_history wh ON wh.empno=e.empno and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
      inner join department d1 on wh.depid=d1.depId
      inner join department_group d2 on d2.main_dep=d1.main_dep
      INNER JOIN member m on m.Name = e.empno and m.Status = 'USUSER'
      WHERE d2.main_dep = (SELECT main_dep FROM department WHERE depId = ".$work['depId'].")");

      $head_group =  mysqli_fetch_assoc($sql2);
    }
    if(!empty($work['comfirmert']) and ($work['authority']=='SUSER' and ($work['regis_time']=='A' or $work['regis_time']=='Y'))){
      $sql3=  mysqli_query($db,"SELECT concat(p1.pname,e.firstname,' ',e.lastname) fullname ,e.signature
      FROM emppersonal e
      inner join hospital h on h.manager = e.empno
      inner join pcode p1 on e.pcode=p1.pcode");

      $shead_group =  mysqli_fetch_assoc($sql3);
    }
    $sql_leave=  mysqli_query($db,"select ty.nameLa,w.begindate,w.enddate,w.amount FROM print_leave p
INNER JOIN `work` w on w.workid=p.befor_workid
INNER JOIN typevacation ty on w.typela=ty.idla
where p.empno='$empno' and p.workid='$workid'");
 $leave_data=mysqli_fetch_assoc($sql_leave)                                  
?>
<body>
    <?php
require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
<div class="col-lg-12" align="center">
<table width="35%" border="0" align="right">
  <tr>
    <th scope="col">กลุ่มทรัพยากรบุคคล</th>
  </tr>
  <tr>
    <td align="left">เลขรับ&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $work['idno']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td align="left">วันที่................................................</td>
  </tr>
  <tr>
    <td align="left">เวลา................................................</td>
  </tr>
</table>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ใบขออนุญาตออกนอกสถานที่ราชการในเวลาราชการ</h3>
</div>
<div class="col-lg-12" align="right">
เขียนที่<?=$hospital['name']?><br>
วันที่ <?= DateThai2($work['vstdate'])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br>
<div class="col-lg-12" align="let">
        เรียน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วยข้าพเจ้า <?= $work['fullname']?> ตำแหน่ง <?= $work['posi']?> งาน <?= $work['dep']?> <br>ฝ่าย/กลุ่มงาน <?= $work['depname']?> 
            สังกัดกรมสุขภาพจิต  กระทรวงสาธารณสุข<br>  
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุญาตออกนอกสถานที่ราชการในเวลาราชการ เนื่องจาก<u> <?= $work[comment]?> </u><br>
                        ในวันที่วันที่<u>&nbsp; <?= DateThai2($work['datela'])?>&nbsp; </u>ตั้งแต่เวลา<u>&nbsp; <?= $work['starttime']?>&nbsp; </u>น. ถึงเวลา<u>&nbsp; <?= $work['endtime']?> &nbsp;</u>น.รวม<u> <?=$work['total']?> </u>ชั่วโมง<br>
                         เมื่อครบกำหนดเวลาดังกล่าวแล้ว ข้าพเจ้าจะกลับมาปฏิบัติหน้าที่ตามปกติ <br>
</div>
<div class="col-lg-12" align="center">ขอแสดงความนับถือ<br>
                                          <img src='<?= "signature/".$work['writer']?>' height='35'><br>
                                                     ( <?= $work['fullname']?> )<br>
                                                      <?= DateThai2($work['vstdate'])?></div><br>

                                 <div class="row">
                                 <div class="col-lg-12">
                                     <table width="100%" border="0" cellspacing="0" >
                                         <tr><td width="50%" valign="top">
                                         <u>สถิติการออกนอกสถานที่ราชการ</u><br><br>
                                     <table width="75%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
  <tr>
    <th colspan="2" scope="col">ลามาแล้ว</th>
    <th rowspan="2" scope="col">ลาครั้งนี้</th>
    <th rowspan="2" scope="col">รวมเป็น</th>
  </tr>
  <tr>
    <th scope="col">ครั้ง</th>
    <th scope="col">ชั่วโมง</th>
  </tr>
  <?php
  $sql_leave2=  mysqli_query($db,"select * FROM print_tleave 
where empno='$empno' and tleave_id='$workid' order by printt_id desc limit 1");
  $leave2=mysqli_fetch_assoc($sql_leave2);?>
  <tr>
    <td align="center" scope="row"><?=$leave2['last_tleave']?></td>
    <td align="center" scope="row"><?=$leave2['last_tamount']?></td>
    <td align="center"><?=$work['total']?> ชม.</td>
    <td align="center"><?= $work['total']+$leave2['last_tamount']?> ชม.</td>
   </tr>

</table><br><br>
                                    
                                         <center><?php if(!empty($work['comfirmert'])){?>
                                            (ลงชื่อ) <img src='<?= "signature/".$work['confirm']?>' height='35'> ผู้ตรวจสอบ<br>
                                            ( <?= $work['confirm_name']?> )<br>
                                            <?= DateThai2($work['regis_date'])?><br></center>
                                         <?php }else{ ?>_&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>(ลงชื่อ)..........................................................ผู้ตรวจสอบ<br><br>
                                         ........../............/............<?php }?><br><br></center>
                                         </td>
                                         <td width="50%">
                                     
                                         
                                         <left> เรียน  หัวหน้า <?= $work['depname']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                             - เห็นควรเสนอผู้อำนวยการพิจารณาอนุญาต&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br></left>
                                         <center><?php if($work['authority']=='USER'and ($work['regis_time']=='A' or $work['regis_time']=='Y')){?>
                                            (ลงชื่อ) &nbsp;&nbsp;<img src='<?= "signature/".$work['appr']?>' height='35'>&nbsp;&nbsp; หัวหน้างาน/กลุ่มงาน<br><br>
                                            ( <?= $work['appr_name']?> )<br><br>
                                            <?= DateThai2($work['regis_date'])?><br><p></center>
                                         <?php }else{ ?>_&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>(ลงชื่อ)..........................................หัวหน้างาน/กลุ่มงาน<br><br>
                                             (..........................................................)<br><br>
                                         ........../............/............<br><br></center><?php }?>
                                         <left>เรียน  ผู้อำนวยการ <?=$hospital['name']?>&nbsp;&nbsp;<br>
                                                     - เพื่อพิจารณาอนุญาต&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br></left>
                                         <center><?php if($work['authority']=='SUSER' and ($work['regis_time']=='A' or $work['regis_time']=='Y')){?>
                                            (ลงชื่อ) &nbsp;&nbsp;<img src='<?= "signature/".$work['appr']?>' height='35'>&nbsp;&nbsp; หัวหน้ากลุ่มภารกิจ<br><br>
                                            ( <?= $work['appr_name']?> )<br><br>
                                            <?= DateThai2($work['regis_date'])?><br></center>
                                            <?php }elseif(!empty($work['comfirmert']) and ($work['authority']=='USER'and ($work['regis_time']=='A' or $work['regis_time']=='Y'))){?>
                                            (ลงชื่อ) &nbsp;&nbsp;<img src='<?= "signature/".$head_group['signature']?>' height='35'>&nbsp;&nbsp; หัวหน้ากลุ่มภารกิจ<br><br>
                                            ( <?= $head_group['fullname']?> )<br><br>
                                            <?= DateThai2($work['regis_date'])?><br><br></center>
                                         <?php }else{ ?>_&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>(ลงชื่อ)..........................................หัวหน้ากลุ่มภารกิจ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............<br><br><?php }?>
                                         <?php if($work['authority']=='USUSER' and ($work['regis_time']=='A' or $work['regis_time']=='Y')){?>
                                            <u>คำสั่ง</u>&nbsp; (<img src='images/check.png' height='10'>)&nbsp; อนุญาต &nbsp;    (&nbsp; )&nbsp; ไม่อนุญาต<br><br>
                                            (ลงชื่อ) &nbsp;&nbsp;<img src='<?= "signature/".$work['appr']?>' height='35'>&nbsp;&nbsp; ผู้อำนวยการฯ<br><br>
                                            ( <?= $work['appr_name']?> )<br><br>
                                            <?= DateThai2($work['regis_date'])?><br><br></center>
                                         <?php }elseif(!empty($work['comfirmert']) and ($work['authority']=='SUSER' and ($work['regis_time']=='A' or $work['regis_time']=='Y'))){?>
                                            <u>คำสั่ง</u>&nbsp; (<img src='images/check.png' height='10'>)&nbsp; อนุญาต &nbsp;    (&nbsp; )&nbsp; ไม่อนุญาต<br><br>
                                            (ลงชื่อ) &nbsp;&nbsp;<img src='<?= "signature/".$shead_group['signature']?>' height='35'>&nbsp;&nbsp; ผู้อำนวยการฯ<br><br>
                                            ( <?= $shead_group['fullname']?> )<br><br>
                                            <?= DateThai2($work['regis_date'])?><br><br></center>
                                         <?php }else{ ?>
                                         <u>คำสั่ง</u>&nbsp; (&nbsp; )&nbsp; อนุญาต &nbsp;    (&nbsp; )&nbsp; ไม่อนุญาต<br><br><br>
                                         (ลงชื่อ)..........................................................ผู้อำนวยการฯ<br><br>
                                         (..........................................................)<br><br>
                                         ........../............/............</center>
                                         <?php }?>
                                         <br><div class="col-lg-12" align="right">
                                         
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-HR-012
                                         
                                     </div>
                                                     </td> </tr></table>
                                 </div>
                                     
                                      </div>
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
$pdf->Output("MyPDF/leave.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/leave.pdf' />";
?>
</body>
</html>