<?php @session_start(); ?>
<?php include_once 'connection/connect_i.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
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
    <script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
<?php
    $empno=$_REQUEST['id'];
    $Lno=$_REQUEST['Lno'];
?>
<body>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">รายละเอียดใบลาของบุคลากร</h3>
                    </div>
                <div class="panel-body" align="center">
                    <div class="form-group" align="center">
                        <?php include_once ('option/funcDateThai.php');
                            $select_det=  mysqli_query($db,"select concat(p1.pname,e1.firstname,' ',e1.lastname) as fullname,d1.depName as dep,p2.posname as posi,e1.empno as empno,w.*,c.*
                                                        from emppersonal e1 
                                                        inner join pcode p1 on e1.pcode=p1.pcode
                                                        inner JOIN work_history wh ON wh.empno=e1.empno
                                                        inner join department d1 on wh.depid=d1.depId
                                                        inner join posid p2 on e1.posid=p2.posId
                                                        inner join work w on e1.empno=w.enpid
                                                        inner join cancle c on w.workid=c.workid
                                                        where e1.empno='$empno' and w.workid='$Lno' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
                            $detial_l= mysqli_fetch_assoc($select_det);
                        ?>
                        <table align="center" width='100%'>
                        <thead>
              <tr>
                  <td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : </b></td>
                  <td>&nbsp;&nbsp;<?=$detial_l['fullname'];?></td>
              </tr>
              <tr>
                  <td align="right"><b>ฝ่าย-งาน : </b></td>
                  <td>&nbsp;&nbsp; <?=$detial_l['dep'];?></td></tr>
              <tr>
                  <td align="right"><b>ตำแหน่ง : </b></td>
                  <td>&nbsp;&nbsp; <?=$detial_l['posi'];?></td></tr>
              <tr>
                <td align="right"><b>เลขที่ใบลา : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['leave_no'];?></td>
              </tr>
              <tr><td align="right"><b>วันที่เขียนใบลา : </b></td>
                  <td>&nbsp;&nbsp; <?=DateThai1($detial_l['reg_date']);?></td>
              </tr>
              <tr>
                  <td align="right"><b>ประเภทการลา : </b></td>
                  <td>&nbsp;&nbsp; <?php	$sql = mysqli_query($db,"SELECT *  FROM typevacation where idla='".$detial_l['typela']."'");
				 $result = mysqli_fetch_assoc( $sql );
                                echo $result['nameLa'];
				 ?>
                  </td>
              </tr>
              <tr><td align="right"><b>วันที่ลา : </b></td>
                  <td>&nbsp;&nbsp; <?=DateThai1($detial_l['begindate']);?>                    <b> ถึง</b>                    <?=DateThai1($detial_l['enddate']);?></td>
                </tr>
              <tr>
                <td align="right"><b>รวมจำนวน : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['amount'];?>&nbsp; <b>วัน</b></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เหตุผลการลา : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['abnote'];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>สถานที่ติดต่อ : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['address'];?></td>
              </tr>
              <tr>
                <td align="right"><B>เบอร์ทรศัพท์ : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['tel'];?></td>
              </tr>
              <tr>
                <td align="right"><b>ใบรับรองแพทย์ : </b></td>
                <td>&nbsp;&nbsp; <?php 
                    if($detial_l['check_comment']==1){
                        echo '-';
                    }elseif ($detial_l['check_comment']==2) {
                        echo 'มี';  
                      }elseif ($detial_l['check_comment']==3) {
                        echo 'ไม่มี';
                      }
?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>หมายเหตุ : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['comment'];?></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>วันที่ยกเลิก : </b></td>
                <td>&nbsp;&nbsp; <?=DateThai1($detial_l['cancledate']);?></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>เหตุผลการยกเลิก : </b></td>
                <td>&nbsp;&nbsp; <?=$detial_l['cancle_comment'];?></td>
              </tr>
              <?php
                $sqladmin=  mysqli_query($db,"select e.firstname as name from emppersonal e inner join cancle c on e.empno=c.admin_cancle where c.workid='".$Lno."'");
                $SqlAdmin=  mysqli_fetch_assoc($sqladmin);
              ?>
              <tr>
                <td align="right" valign="top"><b>ผู้ยกเลิก : </b></td>
                <td>&nbsp;&nbsp; <?=$SqlAdmin['name'];?></td>
              </tr>
                        </thead>
              </table>
                    </div>
                                        <div class="form-group">
   <center><a href="#" class="btn btn-warning" onclick="javascript:window.close();">ปิดหน้าต่าง</a></center> 
                                         
                    </div>
                     </div>
                  </div>
              </div>
    </div>
</form>

<?php include_once 'footeri.php';?>