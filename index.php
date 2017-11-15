<?php
include_once 'header.php';
if (isset($_GET['unset'])) {
    unset_session();
}
?>
<?php
if (!$db) {
    $check = md5(trim(check));
    ?>
    <center>
        <h3>ยังไม่ได้ตั้งค่า Config <br>กรุณาตั้งค่า Config เพื่อเชื่อมต่อฐานข้อมูล</h3>
        <a href="#" class="btn btn-danger" onClick="return popup('set_conn_db.php?method=<?= $check ?>', popup, 400, 515);" title="Config Database">Config Database</a>

    </center>
    <?php
} else {
    $sql = mysqli_query($db, "select * from  hospital");
    $resultHos = mysqli_fetch_assoc($sql);


    if ($resultHos['logo'] != '') {
        $pic = $resultHos['logo'];
        $fol = "logo/";
    } else {
        $pic = 'agency.ico';
        $fol = "images/";
    }
    ?><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info">
                <div class="col-lg-1 col-md-2 col-xs-3" align="center"><img src='<?= $fol . $pic; ?>' width="80"></div>
                <div class="col-lg-11 col-md-10 col-xs-9" valign="top">
                    <h2><b>ระบบข้อมูลบุคลากร </b><small><br><b><font color="green">
                                <?php echo $resultHos['name']; ?></font></b></small></h2>
                    ยินดีต้อนรับสู่ <a class="alert-link" href="http://startbootstrap.com" target="_blank"> ระบบข้อมูลบุคลากร</a>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>
    <ol class="breadcrumb alert-success">
        <li class="active"><i class="fa fa-home"></i> หน้าหลัก</li>
    </ol>
    <?php if (isset($_SESSION['user'])) { ?>
<!--    <div class="row">-->
    <div class="row col-lg-12">
        <div class="row col-lg-4">
            <a href="<?= $resultHos['url'] ?>service&support1.2/process/from_hrd.php?fullname=<?= $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?>
               &id=<?= $_SESSION['user'] ?>&dep=<?= $_SESSION['dep'] ?>" class="btn btn-warning" target="_blank">โปรมแกรมสนับสนุน</a>      
            <a href="#" class="btn btn-success" onClick="return popup('display.php', popup, 1248, 800);" title="แสดงกราฟ">กราฟ</a>
        </div>
        <div class="row" align="right">
            <a href="#" class="btn btn-success" onClick="return popup('total_regularity.php', popup, 650, 600);" title="ดูระเบียบ/ข้อบังคับ">ระเบียบ</a>
            <a href="mainpost_page.php" class="btn btn-info" title="ประกาศข่าว/ประชาสัมพันธ์">ประชาสัมพันธ์</a>
            <a href="#" class="btn btn-primary" onClick="return popup('fullcalendar/fullcalendar3.php', popup, 820, 650);" title="ดูวันลาไปราชการ">ปฏิทินไปราชการ</a>
            <a href="#" class="btn btn-info" onClick="return popup('fullcalendar/fullcalendar5.php', popup, 820, 650);" title="ดูวันลาไปราชการ">ปฏิทินอบรมภายใน</a>
            <a href="#" class="btn btn-warning" onClick="return popup('fullcalendar/fullcalendar2.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">ปฏิทินการลา</a>
            <?php if ($_SESSION['Status'] == 'ADMIN') { ?>
                <a href="#" class="btn btn-danger" onClick="return popup('fullcalendar/fullcalendar1.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">ปฏิทินการลา</a><?php } ?>
        </div>
<!--    </div>-->
    </div><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-calendar"></i> ปฏิทินการใช้ห้องประชุมและรถยนต์ </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12"><iframe src="<?= $resultHos['url']?>service&support1.2/fullcalendar1_2(hrd).php" width="100%" height="900" style="border:none;" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    <?php
    } else {
        $sql = "select tp.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from topic_post tp
        inner join emppersonal em on em.empno=tp.empno_post
        where empno_status='ADMIN' order by topic_id desc limit 5";
        $qr = mysqli_query($db, $sql);

        $sql2 = "select re.*,CONCAT(em.firstname,' ',em.lastname) as fullname,em.photo as photo from regularity re
        inner join emppersonal em on em.empno=re.empno_regu
        order by regu_id desc limit 5";
        $qr2 = mysqli_query($db, $sql2);

        $Manual = "manualHRD.pdf";
        $folder_manual = "manual/";
        ?>
        <div class="row">
            <div class="col-lg-2 col-xs-6">
                <a href="<?= $resultHos['url'] ?>service&support" class="btn btn-warning" target="_blank">โปรมแกรมสนับสนุน</a>       
            </div>
            <div class="col-lg-8"></div>
            <div class="col-lg-2 col-xs-6" align="right">
                <!--<a href="#" class="btn btn-success" onClick="return popup('<?= $folder_manual . $Manual ?>', popup, 820, 1000);" title="คู่มือการใช้โปรแกรม">คู่มือการใช้งาน</a>-->
                <a href="#" class="btn btn-success" onclick="window.open('<?= $folder_manual . $Manual ?>', '', 'width=820,height=1000');
                        return false;" title="คู่มือการใช้โปรแกรม">คู่มือการใช้งาน</a>
            </div>
            <p><br><br>
            <div class="col-lg-5">
                <div class="row">      
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><center><u><h3><b>ระเบียบ/คำสั่ง</b></h3></u></center></h3>
                            </div>
                            <div class="panel-body">

                                <?php
                                include 'option/funcDateThai.php';
                                while ($topic_regu = mysqli_fetch_assoc($qr2)) {
                                    if ($topic_regu['regu_file'] != '') {
                                        $regu_file = $topic_regu['regu_file'];
                                        $folder_file = "regu_file/";
                                    }
                                    ?>
                                    <p><h4><b><font color='red'>ระเบียบที่ <?= $topic_regu['regu_id'] ?></font></b></h4><b>ผู้ประกาศ</b> คุณ<?= $topic_regu['fullname'] ?>  <b>ประกาศเมื่อ</b> <?= DateThai1($topic_regu['regu_date']) ?>
                                    <a href="<?= $folder_file . $regu_file ?>" target="_blank"><font color='blue'><h5><li><?= $topic_regu['topic_regu'] ?></li></h5></font></a>                           
        <?php } ?>
                                <center><a href="#" onClick="return popup('total_regularity.php', popup, 820, 650);" title="ดูระเบียบทั้งหมด">อ่านทั้งหมด</a>
                                </center>
                            </div>
                        </div></div></div></div>
            <div class="col-lg-7">
                <div class="row">   
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><center><u><h3><b>ประกาศ/ข่าวประชาสัมพันธ์</b></h3></u></center></h3>
                            </div>
                            <div class="panel-body">
                                <?php
                                while ($topic_post = mysqli_fetch_assoc($qr)) {
                                    if (!empty($topic_post)) {
                                        if (!empty($topic_post['photo_post'])) {
                                            $photo_post = $topic_post['photo_post'];
                                            $folder_post = "post/";
                                        } else {
                                            $photo_post = '';
                                            $folder_post = '';
                                        }
                                        $sql_comm = mysqli_query($db, "select count(topic_id) as comm from comment where topic_id='" . $topic_post['topic_id'] . "'");
                                        $comm = mysqli_fetch_assoc($sql_comm);
                                        ?>
                                        <p><h4><b><font color='red'>ประกาศที่ <?= $topic_post['topic_id'] ?></font></b></h4>
                                        <b>ผู้ประกาศ</b> คุณ<?= $topic_post['fullname'] ?>  <b>ประกาศเมื่อ</b> <?= DateThai1($topic_post['post_date']) ?> <b>มีผู้สอบถาม <font color='red'><?= $comm['comm'] ?></font> คน</b><p>
                                            <a href="comm_page.php?post=<?= $topic_post['topic_id'] ?>"><h4><li><?= $topic_post['post'] ?></li></h4></a>
                                            <?php
                                            if (!empty($topic_post['link'])) {
                                                echo "<a href='" . $topic_post['link'] . "' target='_blank'> <i class='fa fa-link'></i> รายละเอียด </a><br><br>";
                                            }
                                            if (!empty($photo_post)) {
                                                $file_name = $photo_post;
                                                $info = pathinfo($file_name, PATHINFO_EXTENSION);
                                                if ($info == 'jpg' or $info == 'JPG' or $info == 'bmp' or $info == 'BMP' or $info == 'png' or $info == 'PNG') {
                                                    ?>
                                                    <a href="comm_page.php?post=<?= $topic_post['topic_id'] ?>"><center>
                                                            <embed src='<?= $folder_post . $photo_post ?>' mce_src='<?= $folder_post . $photo_post ?>' width='100%' height=''>
                                                        </center></a>
                                                <?php } else { ?>
                                                    <a href="<?= $folder_post . $photo_post ?>"  target="_blank"><i class="fa fa-download"></i> ดาวน์โหลดเอกสาร</a>
                                                <?php
                                                }
                                            }
                                        }
                                        echo "<hr>";
                                    }
                                    ?>
                            </div>
                        </div></div></div>
            </div>
        </div>
    <?php
    }
}
?>
<?php include_once 'footeri.php'; ?>