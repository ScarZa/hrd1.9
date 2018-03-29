<?php include_once 'header.php'; if(isset($_GET['unset'])){ unset_session();}
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'> บุคลากรที่ยังไม่สรุปฝึกอบรมภายนอกหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บุคลากรที่ยังไม่สรุปฝึกอบรมภายนอกหน่วยงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบุคลากรที่ยังไม่สรุปฝึกอบรมภายนอกหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2558; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <button type="submit" class="btn btn-success">ตกลง</button>
                    </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="pre_persontrainout(N).php" enctype="multipart/form-data">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <select name="name" id="name" class="form-control select2" style="width: 100%"> 
				<?php	$sql = mysqli_query($db,"SELECT empno,concat(firstname,' ',lastname) as fullname  FROM emppersonal order by empno ");
				 echo "<option value=''> - ค้นหาด้วยชื่อบุคลากร - </option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$_POST['name']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname']."</option>";
				 } ?>
			 </select>
                                    <input type='hidden' name='method'  value='empno_search'>
                                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
                <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    if(isset($_POST['year'])){ $year =$_POST['year'];}elseif (isset($_GET['year'])) {$year =$_GET['year'];}else{$year ='';}
                    if(isset($_POST['method'])){ $method =$_POST['method'];}elseif (isset($_GET['method'])) {$method =$_GET['method'];}else{$method ='';}
                    if(isset($_POST['name'])){ $empno =$_POST['name'];}elseif (isset($_GET['name'])) {$empno =$_GET['name'];}else{$empno ='';}
                    $urlfile = "pre_persontrainout(N).php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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

                if(isset($_POST['method'])){ $method =$_POST['method'];}elseif (isset($_GET['method'])) {$method =$_GET['method'];}else{$method ='';}
                    if ($method == 'txtKeyword') {
                        $_SESSION['txtKeyword'] = $_POST['txtKeyword'];
                    }elseif ($method == 'empno_search') {
                        if(isset($_POST['name'])){ $empno =$_POST['name'];}elseif (isset($_GET['name'])) {$empno =$_GET['name'];}else{$empno ='';}
                        if(!empty($empno)){
                        $sqln = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname  FROM emppersonal where empno=$empno ");
                        $fullname = mysqli_fetch_array($sqln);}
        }
                    $Search_word = isset($_SESSION['txtKeyword'])?$_SESSION['txtKeyword']:'';
                    
                    $year = isset($_POST['year'])?$_POST['year']:(isset($_GET['year'])?$_GET['year']:'');
                    //$year = $_POST['year'];
                    if (!empty ($empno)) {
                        $q = "SELECT e.empno, CONCAT(e.firstname,' ',e.lastname)fullname,d1.depName,COUNT(po.id_plan)not_conclude
FROM plan_out po
INNER JOIN training_out tro on tro.tuid=po.idpo
INNER JOIN emppersonal e on po.empno=e.empno
INNER JOIN work_history wh ON wh.empno=e.empno
INNER JOIN department d1 on wh.depid=d1.depId
WHERE po.status_out='N' and po.empno = $empno and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
GROUP BY po.empno";
        }elseif(!empty ($year)){
        $y = $year - 543;
        $Y = $y - 1;
            $q = "SELECT e.empno, CONCAT(e.firstname,' ',e.lastname)fullname,d1.depName,COUNT(po.idpo)not_conclude
FROM plan_out po
INNER JOIN training_out tro on tro.tuid=po.idpo
INNER JOIN emppersonal e on po.empno=e.empno
INNER JOIN work_history wh ON wh.empno=e.empno
INNER JOIN department d1 on wh.depid=d1.depId
WHERE po.status_out='N' and (tro.Beginedate BETWEEN '$Y-10-01' and '$y-09-30') and (tro.endDate BETWEEN '$Y-10-01' and '$y-09-30')
     and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
GROUP BY po.empno ORDER BY not_conclude DESC";
        }else{
            $q = "SELECT e.empno, CONCAT(e.firstname,' ',e.lastname)fullname,d1.depName,COUNT(po.idpo)not_conclude
FROM plan_out po
INNER JOIN training_out tro on tro.tuid=po.idpo
INNER JOIN emppersonal e on po.empno=e.empno
INNER JOIN work_history wh ON wh.empno=e.empno
INNER JOIN department d1 on wh.depid=d1.depId
WHERE po.status_out='N' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
GROUP BY po.empno ORDER BY not_conclude DESC";
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
                แสดงคำที่ค้นหา : <?= isset($Search_word)?$Search_word:''?><?= isset($fullname)?$fullname['fullname']:''?><?= isset($year)?$year:''?>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="10%" align="center"><b>ลำดับ</b></td>
                        <td width="40%" align="center"><b>ชื่อ - นามสกุล</b></td>
                        <td width="35%" align="center"><b>หน่วยงาน</b></td>
                        <td width="15%" align="center"><b>จำนวนเรื่องที่ยังไม่สรุป</b></td>
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('detail_trainout(N).php?name=<?= $result['empno']?>&year=<?=$year?>',popup,1000,500);"><?= $result['fullname']; ?></a></td>
                            <td align="center"><?= $result['depName']; ?></td>
                            <td align="center"><a href="#" onclick="return popup('detail_trainout(N).php?name=<?= $result['empno']?>&year=<?=$year?>',popup,1000,500);"><?= $result['not_conclude']; ?></a></td>
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

<?php include_once 'footeri.php'; ?>
