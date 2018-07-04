<?php @session_start(); ?>
<?php include_once 'connection/connect_i.php'; 
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}?>
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
        <?php $method = isset($_POST['method'])?$_POST['method']:isset($_GET['method']);
        if($method=='edit_event'){
        $event_id=$_REQUEST['event_id'];
        $sql_event=  mysqli_query($db,"select * from tbl_event where event_id='$event_id'");
        $event=  mysqli_fetch_assoc($sql_event);
        if($event['event_allDay']=='true'){
        $event_end=date('Y-m-d', strtotime($event['event_end']."-1 days "));
        }  else {
            $event_end=$event['event_end'];
        }
        }
        ?>
    <div class="col-lg-12">
        <h3><font color='blue'>  เพิ่มรายการวันหยุดนักขัตฤกษ์ </font></h3> 
<!--        <ol class="breadcrumb alert-success">
            <li><a href="fullcalendar/fullcalendar4.php"><i class="fa fa-home"></i> ปฏิทินกิจกรรม</a></li>
            <li class="active"><i class="fa fa-edit"></i> เพิ่มรายการกิจกรรม</li>
        </ol>-->
    </div>
<div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  align="center">
                <h3 class="panel-title">เพิ่มรายการวันหยุดนักขัตฤกษ์</h3>
            </div>
            <div class="panel-body">
                <div class="well well-sm">
               <form class="navbar" role="form" action='prcevent.php' enctype="multipart/form-data" method='post'> 
               <div class="form-group">
                <label for="massege"> วันหยุดนักขัตฤกษ์</label>
                <div class="col-lg-12">
                    <textarea class="form-control" type="text" name="massege" id="massege" placeholder="วันหยุดนักขัตฤกษ์ที่ต้องการให้แสดง" rows="1"><?= isset($event['event_title'])?$event['event_title']:''?></textarea>
                </div></div> 
                <label for="massege"> วันที่</label>
                <div class="form-group">              
                    <div class="col-lg-6 col-xs-6"><input class="form-control" type="date" name="event_start_date" id="event_start_date" value="<?= substr($event['event_start'], 0, 10)?>" required></div>                
                </div><br><br> 
                <?php if(!$method){?>
                <input type="hidden" name="method" value="add_holidayevent">
                <center>
                <input type="submit" class="btn btn-success" value="ตกลง">
                </center>
                <?php }else {?>
                <input type="hidden" name="event_id" value="<?= $event_id?>">
                <input type="hidden" name="method" value="edit_holidayevent">
                <center>
                <input type="submit" class="btn btn-warning" value="แก้ไข">
                </center>
                <?php }?>
               </form>
                </div> 
 <?php

// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
                function page_navigator($before_p, $plus_p, $total, $total_p, $chk_page) {
                    global $e_page;
                    global $querystr;
                    //$empno = isset($_GET['name'])?$_GET['name']:'';
                    $urlfile = "add_holiday_calendra.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
                        echo "<a  href='$urlfile?s_page=$pPrev" . $querystr . "' class='naviPN'>Prev</a>";
                    }
                    for ($i = $total_start_p; $i < $total_end_p; $i++) {
                        $nClass = ($chk_page == $i) ? "class='selectPage'" : "";
                        if ($e_page * $i <= $total) {
                            echo "<a href='$urlfile?s_page=$i" . $querystr . "' $nClass  >" . intval($i + 1) . "</a> ";
                        }
                    }
                    if ($chk_page < $total_p - 1) {
                        echo "<a href='$urlfile?s_page=$pNext" . $querystr . "'  class='naviPN'>Next</a>";
                    }
                }
                
                $Search_word = isset($_POST['txtKeyword'])?$_POST['txtKeyword']:'';
                    if (!empty($Search_word)) {
//คำสั่งค้นหา
                        $q = "SELECT * FROM tbl_event WHERE process='7' and (event_title LIKE '%$Search_word%') ORDER by event_id DESC";
                    }else{
                $q = "SELECT * FROM tbl_event WHERE process='7' ORDER by event_id DESC";
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
                <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="add_holiday_calendra.php" enctype="multipart/form-data">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <input type="text" placeholder="ชื่อวัน" name='txtKeyword' class="form-control" value="" >
                                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>
                        </tr>
                    </table>
                </form>

                <?php include_once ('option/funcDateThai.php'); ?>
                แสดงคำที่ค้นหา : <?= isset($Search_word)?$Search_word:''?>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="20%" align="center"><b>วันที่</b></td>
                        <td width="30%" align="center"><b>ชื่อวันหยุด</b></td>
                        <td width="6%" align="center"><b>แก้ไข</b></td>
                        <td width="6%" align="center"><b>ลบ</b></td>
                     </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= DateThai1($result['event_start']);?></td>
                            <td align="center"><?= $result['event_title']; ?></td>
                            <td align="center"><a href="add_holiday_calendra.php?method=edit_holidayevent&&event_id=<?=$result['event_id'];?>"><img src='images/tool.png' width='30'></a></td>
                            <td align="center"><a href="prcevent.php?method=delete_holidayevent&&event_id=<?=$result['event_id'];?>"><img src='images/button_cancel.ico' width='30'></a></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </table>
<?php if ($total > 0) {
    echo mysqli_error($db); ?><br>
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
