<?php include_once 'header.php';if(isset($_GET['unset'])){ unset_session();} ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><img src='images/kwrite.ico' width='75'><font color='blue'>  บันทึกทะเบียนรับอบรมภายนอก/ไปราชการ </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกทะเบียนรับอบรมภายนอก/ไปราชการ</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/bookcase.ico' width='25'> บันทึกทะเบียนรับอบรมภายนอก/ไปราชการ</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form name="form1" method="post" action="session.php" class="navbar-form navbar-right">
                            <label> เลือกช่วงเวลา : </label>
                            <div class="form-group">
                                <input type="date"   name='check_date01' class="form-control" value='' > 
                            </div>
                            <div class="form-group">
                                <input type="date"   name='check_date02' class="form-control" value='' >
                            </div>
                            <input type="hidden" name="method" value="check_receive_app">
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form>
                        </div><br><br>
                </div>
               <div class="row">        
                <form name="form2" method="post" action="receive_trainout.php" class="navbar-form navbar-right">
                            <div class="form-group">
                                <select name="select_status" id="select_status" class="form-control">
                                    <option value="">เลือกสถานะการอนุมัติ</option>
                                    <option value="W">รออนุมัติ</option>
                                    <option value="Y">อนุมัติ</option>
                                    <option value="N">ไม่อนุมัติ</option>
                                </select>
                            </div>
                            <input type="hidden" name="method" value="status_app">
                            <button type="submit" class="btn btn-success">ตกลง</button>

                        </form>
                </div>
                <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    $regis= isset($_REQUEST['select_status'])?$_REQUEST['select_status']:'';
                    $urlfile = "receive_trainout.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
                    $per_page = 30;
                    $num_per_page = floor($chk_page / $per_page);
                    $total_end_p = ($num_per_page + 1) * $per_page;
                    $total_start_p = $total_end_p - $per_page;
                    $pPrev = $chk_page - 1;
                    $pPrev = ($pPrev >= 0) ? $pPrev : 0;
                    $pNext = $chk_page + 1;
                    $pNext = ($pNext >= $total_p) ? $total_p - 1 : $pNext;
                    $lt_page = $total_p - 4;
                    if ($chk_page > 0) {
                        echo "<a  href='$urlfile?select_status=$regis&method=status_app&s_page=$pPrev" . $querystr . "' class='naviPN'>Prev</a>";
                    }
                    for ($i = $total_start_p; $i < $total_end_p; $i++) {
                        $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                        if ($e_page * $i <= $total) {
                            echo "<a href='$urlfile?select_status=$regis&method=status_app&s_page=$i" . $querystr . "' $nClass  >" . intval($i + 1) . "</a> ";
                        }
                    }
                    if ($chk_page < $total_p - 1) {
                        echo "<a href='$urlfile?select_status=$regis&method=status_app&s_page=$pNext" . $querystr . "'  class='naviPN'>Next</a>";
                    }
                }
                $method = isset($_REQUEST['method'])?$_REQUEST['method']:'';
                include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
                if ($_SESSION['check_rec'] != "") {
                    $date01=$_SESSION['check_date01'];
                    $date02=$_SESSION['check_date02'];
//คำสั่งค้นหา
                    if($method=='status_app' and $_REQUEST['select_status']!=''){
                        $regis=$_REQUEST['select_status'];
                    $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where (Beginedate between '$date01' and '$date02') and (endDate between '$date01' and '$date02') and hboss='$regis'
GROUP BY t.tuid                                 
order by tuid desc";
                    }elseif(empty ($method) or $method=='status_app' and $_REQUEST['select_status']==''){
                     $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where (Beginedate between '$date01' and '$date02') and (endDate between '$date01' and '$date02')
GROUP BY t.tuid                                 
order by tuid desc";  
                    }
                } else {
                    if($method=='status_app' and $_REQUEST['select_status']!=''){
                        $regis=$_REQUEST['select_status'];
                    $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where hboss='$regis'
GROUP BY t.tuid                                 
order by tuid desc";
                    }elseif(empty ($method) or $method=='status_app' and $_REQUEST['select_status']==''){
                    $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where w.statusla='Y' and Beginedate BETWEEN '$y-10-01' and '$Yy-09-30'
GROUP BY t.tuid                                 
order by tuid desc";
                    }
                    
                }
}else{
                if (!empty($_SESSION['check_rec'])) {
                    $date01=$_SESSION['check_date01'];
                    $date02=$_SESSION['check_date02'];
//คำสั่งค้นหา
                    if($method=='status_app' and $regis=$_REQUEST['select_status']!=''){
                        $regis=$_REQUEST['select_status'];
                    $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where (Beginedate between '$date01' and '$date02') and (endDate between '$date01' and '$date02') and hboss='$regis'
GROUP BY t.tuid                                 
order by tuid desc";
                    }elseif(empty ($method) or $method=='status_app' and $_REQUEST['select_status']==''){
                     $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where (Beginedate between '$date01' and '$date02') and (endDate between '$date01' and '$date02')
GROUP BY t.tuid                                 
order by tuid desc";  
                    }
                } else {
                    if($method=='status_app' and $regis=$_REQUEST['select_status']!=''){
                        $regis=$_REQUEST['select_status'];
                    $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
where hboss='$regis'
GROUP BY t.tuid                                 
order by tuid desc";
                    }elseif(empty ($method) or $method=='status_app' and $_REQUEST['select_status']==''){
                    $q = "SELECT t.*,CONCAT(e1.firstname,'  ',e1.lastname) as fullname,d.depName as depname, p.status_out,COUNT(p.empno) as count, p.status_out as status_out
from training_out t 
LEFT OUTER JOIN plan_out p on t.tuid=p.idpo
LEFT OUTER JOIN emppersonal e1 on e1.empno=p.empno
LEFT OUTER JOIN department d on e1.depid=d.depId
GROUP BY t.tuid                                 
order by tuid desc";
                    }
                    
                }}
                $qr = mysqli_query($db,$q);
                if ($qr == '') {
                    exit();
                }
                $total = mysqli_num_rows($qr);
                $chk_page='';
                $e_page = 30; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                if (!isset($_GET['s_page'])) {
                    $_GET['s_page'] = 0;
                } else {
                    $chk_page = $_GET['s_page'];
                    $_GET['s_page'] = $_GET['s_page'] * $e_page;
                }
                $q.=" LIMIT " . $_GET['s_page'] . ",$e_page";
                $qr = mysqli_query($db,$q);
                if (mysqli_num_rows($qr) >= 1){
                    $plus_p = ($chk_page * $e_page) + mysqli_num_rows($qr);
                } else {
                    $plus_p = ($chk_page * $e_page);
                }
                $total_p = ceil($total / $e_page);
                $before_p = ($chk_page * $e_page) + 1;
                echo mysqli_error($db);
                ?>

                <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_leave.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table id="datatable" align="center" width="100%" border="1">
                    <?php if (isset($_SESSION['check_rec'])?$_SESSION['check_rec']:'' == 'check_receive_app') { ?>
                        <tr>
                            <td colspan="10" align="center">ตั้งแต่วันที่ <?= DateThai1($date01); ?> ถึง <?= DateThai1($date02); ?></td>
                        </tr>
                    <?php } ?>
                    <tr align="center" bgcolor="#898888">
                        <td width="4%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขทะเบียนรับ</b></td>
                        <td width="10%" align="center"><b>ที่</b></td>
                        <td width="7%" align="center"><b>ลงวันที่</b></td>
                        <td width="10%" align="center"><b>จาก</b></td>
                        <td width="5%" align="center"><b>ถึง</b></td>
                        <td width="40%" align="center"><b>เรื่อง</b></td>
                        <td width="12%" align="center"><b>การปฏิบัติ</b></td>
                        <td width="3%" align="center"><b>อนุมัติ</b></td>

                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= $result['memberbook']; ?></td>
                            <td align="center"><?= $result['depname']; ?></a></td>
                            <td align="center"><?= DateThai1($result['datein']); ?></td>
                            <td>&nbsp;&nbsp; <?= $result['fullname']; ?></td>
                            <td align="center"> ผู้อำนวยการ </td>
                            <td align="center"><?= $result['projectName']; ?></td>
                            <td align="center"><?= DateThai1($result['Beginedate']); ?> <b>ถึง</b> <?= DateThai1($result['endDate']); ?></td>
                            <td align="center">
                                <?php if($result['hboss']=='W'){ ?>
                            <i class="fa fa-spinner fa-spin"></i>
                            <?php } elseif ($result['hboss']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['hboss']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>

                </table>
                <?php
                if ($total > 0) {
                    echo mysqli_error($db);
                    ?>
                    <div class="browse_page">

                        <?php
                        // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                        page_navigator($before_p, $plus_p, $total, $total_p, $chk_page);

                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
                        echo $count = ceil($total / 30) . "&nbsp;<B>หน้า</B></font>";
                    }
                    ?> 
             </div>
        </div>
    </div>
</div>
<?php include_once 'footeri.php'; ?>
