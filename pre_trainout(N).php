<?php include_once 'header.php'; if(isset($_GET['unset'])){ unset_session();}
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'> ฝึกอบรมภายนอกหน่วยงานที่ยังไม่สรุป </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> ฝึกอบรมภายนอกหน่วยงานที่ยังไม่สรุป</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายนอกหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="pre_trainout(N).php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" placeholder="ค้นหา" name='txtKeyword' class="form-control" value="" >
                                    <input type='hidden' name='method'  value='txtKeyword'>
                                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>


                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="pre_trainout(N).php" enctype="multipart/form-data">
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
                    if(isset($_POST['method'])){ $method =$_POST['method'];}elseif (isset($_GET['method'])) {$method =$_GET['method'];}else{$method ='';}
                    if(isset($_POST['name'])){ $empno =$_POST['name'];}elseif (isset($_GET['name'])) {$empno =$_GET['name'];}else{$empno ='';}
                    $urlfile = "pre_trainout(N).php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
                        echo "<a  href='$urlfile?s_page=$pPrev&method=$method&name=$empno" . $querystr . "' class='naviPN'>Prev</a>";
                    }
                    for ($i = $total_start_p; $i < $total_end_p; $i++) {
                        $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                        if ($e_page * $i <= $total) {
                            echo "<a href='$urlfile?s_page=$i&method=$method&name=$empno" . $querystr . "' $nClass  >" . intval($i + 1) . "</a> ";
                        }
                    }
                    if ($chk_page < $total_p - 1) {
                        echo "<a href='$urlfile?s_page=$pNext&method=$method&name=$empno" . $querystr . "'  class='naviPN'>Next</a>";
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
                    if (!empty($Search_word)) {
//คำสั่งค้นหา
                        $q = "SELECT tro.memberbook, tro.projectName, tro.anProject, tro.Beginedate, tro.endDate, tro.tuid,
(SELECT COUNT(po.empno) FROM plan_out po WHERE po.idpo=tro.tuid and po.status_out='N') count_preson
FROM plan_out po
INNER JOIN training_out tro on po.idpo=tro.tuid
WHERE po.status_out='N' and (tro.memberbook LIKE '%$Search_word%' or tro.projectName LIKE '%$Search_word%')
GROUP BY po.idpo order by tuid desc";
                    }elseif (!empty ($empno)) {
                        $q = "SELECT tro.memberbook, tro.projectName, tro.anProject, tro.Beginedate, tro.endDate, tro.tuid,
(SELECT COUNT(po.empno) FROM plan_out po WHERE po.idpo=tro.tuid and po.status_out='N') count_preson
FROM plan_out po
INNER JOIN training_out tro on po.idpo=tro.tuid
WHERE po.status_out='N' and po.empno = $empno
GROUP BY po.idpo order by tuid desc";
        } else{
                        $q = "SELECT tro.memberbook, tro.projectName, tro.anProject, tro.Beginedate, tro.endDate,  tro.tuid,
(SELECT COUNT(po.empno) FROM plan_out po WHERE po.idpo=tro.tuid and po.status_out='N') count_preson
FROM plan_out po
INNER JOIN training_out tro on po.idpo=tro.tuid
WHERE po.status_out='N'
GROUP BY po.idpo order by tuid desc";
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
                แสดงคำที่ค้นหา : <?= isset($Search_word)?$Search_word:''?><?= isset($fullname)?$fullname['fullname']:''?>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="7%" align="center"><b>เลขที่หนังสือ</b></td>
                        <td width="40%" align="center"><b>โครงการ</b></td>
                        <td width="19%" align="center"><b>หน่วยงานผู้จัด</b></td>
                        <td width="15%" align="center"><b>วันที่จัด</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้เข้าร่วม</b></td>
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('pre_project_out(N).php?id=<?= $result['tuid']; ?>',popup,700,500);"><?= $result['memberbook']; ?></a>
                            </td>
                            <td><a href="#" onclick="return popup('pre_project_out(N).php?id=<?= $result['tuid']; ?>',popup,700,500);"><?= $result['projectName']; ?></a></td>
                            <td align="center"><?= $result['anProject']; ?></td>
                            <td align="center"><?= DateThai1($result['Beginedate']);?> <b>ถึง</b> <?= DateThai1($result['endDate']);?></td>
                            <td align="center"><?= $result['count_preson']; ?></td>
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
