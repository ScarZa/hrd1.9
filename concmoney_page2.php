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
$sql_per = mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner join department d1 on e1.depid=d1.depId
                                                        INNER JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join posid p2 on wh.posid=p2.posId
                                                        where e1.empno='$empno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
             $sql_pro = mysqli_query($db,"SELECT t.*,po.abode,po.reg,po.allow,po.travel,po.other, p.PROVINCE_NAME,t2.tName as tname FROM training_out t
						inner join plan_out po on po.idpo=t.tuid and po.empno=$empno
            inner join province p on t.provenID=p.PROVINCE_ID
            inner join trainingtype t2 on t2.tid=t.dt
            WHERE tuid='$project_id'");   
            $Person_detial = mysqli_fetch_assoc($sql_per);
            $Project_detial = mysqli_fetch_assoc($sql_pro);
            $sql_trainout=  mysqli_query($db,"select *,
                    (select count(empno) from plan_out where idpo='$project_id') count_person from plan_out where idpo='$project_id' and empno='$empno'");
            $person_data=mysqli_fetch_assoc($sql_trainout);
            
require_once('option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
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
    จำนวน.........................<?php $total_money=number_format($Project_detial['abode']+$Project_detial['reg']+$Project_detial['allow']+$Project_detial['travel']+$Project_detial['other']); if($total_money==0){echo '...';}else{echo $total_money;}?>.........................บาท<br>
&nbsp;&nbsp;(<?php if(!empty($total_money)){echo '................'.num2wordsThai("$total_money").'บาทถ้วน................';}else{?>.......................................................................................<?php }?>) ไว้เป็นการถูกต้องแล้ว 
 <table width="100%" border="0">
                <tr>
                   
                    <td width="50%" valign="top">
                <br>&nbsp;&nbsp;ลงชื่อ............................................................ผู้รับเงิน<br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <?=$Person_detial['fullname']?> )<br>
<br>&nbsp;&nbsp;ตำแหน่ง <?=$Person_detial['posi']?> <br><br>
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
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('tha2','A4','11','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("MyPDF/concmoney2.pdf");
echo "<meta http-equiv='refresh' content='0;url=MyPDF/concmoney2.pdf' />";
?>
</body>
</html>