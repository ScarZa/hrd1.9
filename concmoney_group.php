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
$sql_per = mysqli_query($db,"select concat(e.firstname,' ',e.lastname) as fullname,po.reg_date,p2.posname as posi
                                                        from plan_out po
                                                        inner join emppersonal e on e.empno=po.empno
                                                        INNER JOIN work_history wh ON wh.empno=e.empno
                                                        inner join posid p2 on wh.posid=p2.posId
                                                        where po.idpo='$project_id' and po.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
    $sql_cost = mysqli_query($db,"SELECT SUM(abode)abode ,SUM(allow)allow,SUM(travel)travel,(SUM(reg)+SUM(other))other,(SUM(abode)+SUM(allow)+SUM(travel)+SUM(reg)+SUM(other))sum
FROM plan_out 
WHERE idpo='$project_id'");
            
    $sql_progroup=  mysqli_query($db,"SELECT CONCAT(e.firstname,' ',e.lastname)fullname,p.posname,po.allow,po.abode,po.travel,(po.other+po.reg)other
,(po.allow+po.abode+po.travel+po.other+po.reg)sum
FROM plan_out po
INNER JOIN emppersonal e on e.empno=po.empno
INNER JOIN department d on e.depid=d.depId
INNER JOIN work_history wh ON wh.empno=e.empno
INNER JOIN posid p on wh.posid=p.posId
WHERE (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)) AND po.idpo='$project_id'");
            $Person_detial = mysqli_fetch_assoc($sql_per);
             $Project_cost = mysqli_fetch_assoc($sql_cost);
         
            
require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
    ?>
    <div class="col-lg-12">
    <table border="0" width="100%">
        <tr>
            <td width="100%" valign="bottom" align="right">แบบ 8708</td>
        </tr>
    </table>
    </div>
    <div align="center"><b>หลักฐานการจ่ายเงินค่าใช้จ่ายในการเดินทางไปราชการ</b> <br>
    ชื่อส่วนส่วนราชการ <?=$hospital['name']?> จังหวัด เลย <br>
        ประกอบใบเบิกค่าใช้จ่ายในการเดินทางของ <?=$Person_detial['fullname']?> ลงวันที่ <?= DateThai2($Person_detial['reg_date'])?></div>
    <table width="100%" border="1" cellspacing="" cellpadding="" frame="below" class="divider">
        <thead>
            <tr>
                <th rowspan="2" width='5%'>ลำดับที่</th>
                <th rowspan="2" width='15%'>ชื่อ</th>
                <th rowspan="2" width='15%'>ตำแหน่ง</th>
                <th colspan="4" width='29%'>ค่าใช้จ่าย</th>
                <th rowspan="2" width='7%'>รวม</th>
                <th rowspan="2" width='10%'>ลายมือชื่อ<br>ผู้รับเงิน</th>
                <th rowspan="2" width='10%'>วัน เดือน ปี<br>ที่รับเงิน</th>
                <th rowspan="2" width='9%'>หมายเหตุ</th>
            </tr>
            <tr>
                <th width='8%'>ค่าเบี้ยเลี้ยง</th>
                <th width='7%'>ค่าเช่าที่พัก</th>
                <th width='7%'>ค่าพาหนะ</th>
                <th width='7%'>ค่าใช้จ่ายอื่นๆ</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($progroup = mysqli_fetch_assoc($sql_progroup)) { ?>
            <tr align='center'>
                <td align='center'><?= $i?></td>
                <td> &nbsp;<?= $progroup['fullname']?></td>
                <td align='center'><?= $progroup['posname']?></td>
                <td align='center'><?= number_format($progroup['allow'])?></td>
                <td align='center'><?= number_format($progroup['abode'])?></td>
                <td align='center'><?= number_format($progroup['travel'])?></td>
                <td align='center'><?= number_format($progroup['other'])?></td>
                <td align='center'><?= number_format($progroup['sum'])?></td>
                <td align='center'>&nbsp;</td>
                <td align='center'>&nbsp;</td>
                <td align='center'>&nbsp;</td>
            </tr>     
               <?php $i++; }?>
        </tbody>
        <tfoot>
            <tr align='center'>
                <td colspan="3" align='center'>รวมเงิน</td>
                <td align='center'><?= number_format($Project_cost['allow'])?></td>
                <td align='center'><?= number_format($Project_cost['abode'])?></td>
                <td align='center'><?= number_format($Project_cost['travel'])?></td>
                <td align='center'><?= number_format($Project_cost['other'])?></td>
                <td align='center'><?= number_format($Project_cost['sum'])?></td>
                <td colspan="3" align='center'>ตามสัญญาเงินเลขที่...................วันที่....................</td>
            </tr>
        </tfoot>
    </table><br><br>
    <table width='100%'>
        <tr>
            <td width='60%' align="center" valign="top">
                จำนวนเงินรวมทั้งสิ้น (ตัวอักษร) <?php if(!empty($Project_cost['sum'])){echo '................'.num2wordsThai($Project_cost['sum']).'บาทถ้วน................';}else{?>.......................................................................................<?php }?><p>
            </td>
            <td width='40%' align="center" valign="top">
                <b>( ลงชื่อ )</b> ............................................ ผู้จ่ายเงิน<br><br>
( <?=$Person_detial['fullname']?> )<br><br>ตำแหน่ง <?=$Person_detial['posi']?><br><br>วันที่ <?= DateThai2($Person_detial['reg_date'])?>
            </td>
        </tr>
    </table><br>
    <table width='100%'>
        <tr>
            <td width='7%' rowspan="3" align="center" valign="top"><u>คำชี้แจง</u></td>
            <td width='93%'>1. ค่าเบี้ยเลี้ยงและค่าเช่าที่พักให้ระบุอัตราวันละและจำนวนวันที่ขอเบิกของแต่ละบุคคลในช่องหมายเหตุ</td>
        </tr>
        <tr>
            <td width='93%'>2. ให้ผู้มีสิทธิแต่ละคนเป็นคนลงลายมือชื่อผู้รับเงินและวันเดือนปีที่ได้รับเงิน กรณีเป็นการรับจากเงินยืม ให้ระบุวันที่ที่ไดีรับจากเงินยืม</td>
        </tr>
        <tr>
            <td width='93%'>3. ผู้จ่ายเงินหมายถึงผู้ที่ของยืมเงินจากทางราชการ และจ่ายเงินยืมนั้นให้แก่ผู้เดินทางแต่ละคน เป็นคนลงลายมือชื่อผู้จ่ายเงิน</td>
        </tr>
    </table>
            <br><div align="right">(แบบแนบฟอร์ม F-FA-009-02)</div>
    <?php 
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('tha2','A4-L','10','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("MyPDF/concmoney_group.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/concmoney_group.pdf' />";
?>
</body>
</html>