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
    <body>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายนอกหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    if(isset($_POST['year'])){ $year =$_POST['year'];}elseif (isset($_GET['year'])) {$year =$_GET['year'];}else{$year ='';}
                    if(isset($_POST['method'])){ $method =$_POST['method'];}elseif (isset($_GET['method'])) {$method =$_GET['method'];}else{$method ='';}
                    if(isset($_POST['name'])){ $empno =$_POST['name'];}elseif (isset($_GET['name'])) {$empno =$_GET['name'];}else{$empno ='';}
                    $urlfile = "detail_trainout(N).php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
                        echo "<a  href='$urlfile?s_page=$pPrev&method=$method&name=$empno&year=$year" . $querystr . "' class='naviPN'>Prev</a>";
                    }
                    for ($i = $total_start_p; $i < $total_end_p; $i++) {
                        $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                        if ($e_page * $i <= $total) {
                            echo "<a href='$urlfile?s_page=$i&method=$method&name=$empno&year=$year" . $querystr . "' $nClass  >" . intval($i + 1) . "</a> ";
                        }
                    }
                    if ($chk_page < $total_p - 1) {
                        echo "<a href='$urlfile?s_page=$pNext&method=$method&name=$empno&year=$year" . $querystr . "'  class='naviPN'>Next</a>";
                    }
                }


                        if(isset($_POST['name'])){ $empno =$_POST['name'];}elseif (isset($_GET['name'])) {$empno =$_GET['name'];}else{$empno ='';}
                        if(!empty($empno)){
                        $sqln = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname  FROM emppersonal where empno=$empno ");
                        $fullname = mysqli_fetch_array($sqln);}
        
                    $Search_word = isset($_SESSION['txtKeyword'])?$_SESSION['txtKeyword']:'';
                    
                    $year = isset($_POST['year'])?$_POST['year']:(isset($_GET['year'])?$_GET['year']:'');
                    //$year = $_POST['year'];
if (!empty($empno) and empty($year)) {
                        $q = "SELECT tro.memberbook, tro.projectName, tro.anProject, tro.Beginedate, tro.endDate, tro.tuid
FROM plan_out po
INNER JOIN training_out tro on po.idpo=tro.tuid
INNER JOIN emppersonal e on po.empno=e.empno
INNER JOIN work_history wh ON wh.empno=e.empno
INNER JOIN department d1 on wh.depid=d1.depId
WHERE po.status_out='N' and po.empno = $empno  and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
order by tuid desc";
        }elseif(!empty ($year) and !empty($empno)){
        $y = $year - 543;
        $Y = $y - 1;
           $q = "SELECT tro.memberbook, tro.projectName, tro.anProject, tro.Beginedate, tro.endDate,  tro.tuid
FROM plan_out po
INNER JOIN training_out tro on po.idpo=tro.tuid
INNER JOIN emppersonal e on po.empno=e.empno
INNER JOIN work_history wh ON wh.empno=e.empno
INNER JOIN department d1 on wh.depid=d1.depId
WHERE po.status_out='N' and po.empno = $empno and (tro.Beginedate BETWEEN '$Y-10-01' and '$y-09-30') and (tro.endDate BETWEEN '$Y-10-01' and '$y-09-30')
     and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
order by tuid desc";
        }
        $qr = mysqli_query($db,$q);
                if ($qr == '') {
                    exit();
                }
                $total = mysqli_num_rows($qr);
                $chk_page = '';
                $e_page = 30; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                if (!isset($_GET['s_page'])) {
                    $_GET['s_page'] = 0;
                } else {
                    $chk_page = $_GET['s_page'];
                    $_GET['s_page'] = $_GET['s_page'] * $e_page;
                }
                $q.=" LIMIT " . $_GET['s_page'] . ",$e_page";
                $qr = mysqli_query($db,$q);
                if (mysqli_num_rows($qr) >= 1) {
                    $plus_p = ($chk_page * $e_page) + mysqli_num_rows($qr);
                } else {
                    $plus_p = ($chk_page * $e_page);
                }
                $total_p = ceil($total / $e_page);
                $before_p = ($chk_page * $e_page) + 1;
                echo mysqli_error($db);
                ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_trainout(N)<?= isset($fullname)?$fullname['fullname']:''?><?=$_GET['s_page']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'trainout(N)');">Export to Excel</a><br><br>
                <table align="center" width="100%" border="1" id="datatable">
                    <tr>
                        <td align="center" colspan="5"><b>ชื่อบุคลากร : <?= isset($Search_word)?$Search_word:''?><?= isset($fullname)?$fullname['fullname']:''?><?= isset($_GET['year'])?' ปีงบ '.$year:''?></b></td>
                    </tr>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="7%" align="center"><b>เลขที่หนังสือ</b></td>
                        <td width="40%" align="center"><b>โครงการ</b></td>
                        <td width="19%" align="center"><b>หน่วยงานผู้จัด</b></td>
                        <td width="15%" align="center"><b>วันที่จัด</b></td>
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= $result['memberbook']; ?></td>
                            <td><?= $result['projectName']; ?></td>
                            <td align="center"><?= $result['anProject']; ?></td>
                            <td align="center"><?= DateThai1($result['Beginedate']);?> ถึง <?= DateThai1($result['endDate']);?></td>
                        </tr>
                    <?php $i++;
                }
                ?>

                </table>
<?php
if ($total > 0) {
    echo mysqli_error($db);
    ?><BR><BR>
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
    </div>
<?php include_once 'footeri.php'; ?>
