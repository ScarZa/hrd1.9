<?php include_once 'header.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
$screen = isset($_REQUEST['screen']) ? $_REQUEST['screen'] : '';
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'><img src='images/kchart.ico' width='75'>  รายงานแสดงการลืมแสกน/มาสายบุคลากรแยกหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลืมแสกน/มาสายของบุคลากรหน่วยงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/kchart.ico' width='25'> ตารางสถิติการลืมแสกน/มาสายของบุคลากรหน่วยงาน</h3>
            </div>
            <div class="panel-body">
<!--                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form name="form1" method="post" action="Lperson_report_sum.php" enctype="multipart/form-data" class="navbar-form navbar-right">
                            <div class="form-group">
                                <select name="month" id="month"  class="form-control" required=""> 
                                    <?php
                                    $sql = mysqli_query($db, "SELECT month_id, month_name FROM month order by m_id");
                                    echo "<option value=''>--เลือกเดือน--</option>";
                                    while ($result = mysqli_fetch_assoc($sql)) {
                                        echo "<option value='" . $result['month_id'] . "' $selected>" . $result['month_name'] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <select name="dep" id="dep"  class="form-control select2" style="width: 200px" required=""> 
                                    <?php
                                    if ($screen == '1') {
                                        $sql = mysqli_query($db, "SELECT *  FROM department order by depId");
                                        echo "<option value=''>--เลือกฝ่ายงาน--</option>";
                                        while ($result = mysqli_fetch_assoc($sql)) {
                                            echo "<option value='" . $result['depId'] . "' $selected>" . $result['depName'] . " </option>";
                                        }
                                    } else {
                                        $sql = mysqli_query($db, "SELECT *  FROM emptype order by EmpType");
                                        echo "<option value=''>--เลือกประเภทบุคลากร--</option>";
                                        while ($result = mysqli_fetch_assoc($sql)) {
                                            echo "<option value='" . $result['EmpType'] . "' $selected>" . $result['TypeName'] . " </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div> 
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
                            
                            <input type="hidden"   name='screen' class="form-control" value='<?= $screen ?>' >
                            <button type="submit" class="btn btn-success">ตกลง</button>


                        </form></div> <br><br></div>-->
                <?php// if ($screen == '2') {?>
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form name="form2" method="post" action="lateforget_report.php" enctype="multipart/form-data" class="navbar-form navbar-right">
                            <div class="form-group">
                                <select name="posi" id="posi"  class="form-control select2" style="width: 200px" required="">
                                <?php
                                         $sql = mysqli_query($db, "SELECT *  FROM emptype order by EmpType");
                                        echo "<option value=''>--เลือกประเภทบุคลากร--</option>";
                                        while ($result = mysqli_fetch_assoc($sql)) {
                                            echo "<option value='" . $result['EmpType'] . "'>" . $result['TypeName'] . " </option>";
                                        }
                                    
                                    ?>
                                    </select></div>
                                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=date('Y-m-d')?>')); //Set ค่าวัน
                $( "#datepicker2" ).datepicker("setDate", new Date('<?=date('Y-m-d')?>')); //Set ค่าวัน
                 });
                </script>
                <div class="form-group">
                <input name="str" type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                </div>
                <div class="form-group">
                <input name="end" type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                </div>
                            <input type="hidden"   name='method' class="form-control" value='range_date' >
                            <input type="hidden"   name='screen' class="form-control" value='<?= $screen ?>' >
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form></div> <br><br></div>
                <?php //}
                if(isset($_POST['method'])){
                    include 'option/funcDateThai.php';
                    $method = $_POST['method'];
                    $posi = $_POST['posi'];
                    $str = insert_date($_POST['str']);
                    $end = insert_date($_POST['end']);
                $sql = mysqli_query($db, "SELECT CONCAT(e.firstname,' ',e.lastname)as fullname
,(SELECT COUNT(f.finger_id) FROM fingerprint f LEFT JOIN `work` w ON f.empno=w.enpid AND f.forget_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y' LEFT JOIN plan_out p ON f.empno=p.empno AND f.forget_date BETWEEN p.begin_date AND p.end_date WHERE f.empno=e.empno and f.work_scan='N' AND ISNULL(w.enpid) AND ISNULL(p.empno) and 
f.forget_date BETWEEN '$str' and '$end')as ws
,(SELECT COUNT(f.finger_id) FROM fingerprint f LEFT JOIN `work` w ON f.empno=w.enpid AND f.forget_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y' LEFT JOIN plan_out p ON f.empno=p.empno AND f.forget_date BETWEEN p.begin_date AND p.end_date WHERE f.empno=e.empno and f.finish_work_scan='N' AND ISNULL(w.enpid) AND ISNULL(p.empno) and 
f.forget_date BETWEEN '$str' and '$end')as fws
,(SELECT COUNT(l.late_id) FROM late l LEFT JOIN `work` w ON l.empno=w.enpid AND l.late_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y' LEFT JOIN plan_out p ON l.empno=p.empno AND l.late_date BETWEEN p.begin_date AND p.end_date WHERE l.empno=e.empno AND ISNULL(w.enpid) AND ISNULL(p.empno) and ((l.late_date BETWEEN '$str' and '$end')))total_late
FROM emppersonal e 
LEFT JOIN late l on l.empno=e.empno
LEFT JOIN fingerprint f on f.empno=e.empno
WHERE e.emptype=$posi
and ((l.late_date BETWEEN '$str' and '$end')or(f.forget_date BETWEEN '$str' and '$end'))
GROUP BY e.empno ORDER BY fullname");

                
                $type = mysqli_query($db,"select TypeName as name from emptype where EmpType='$posi'");
                $type_name = mysqli_fetch_assoc($type);
                }
                ?>

                <!-- <H1>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H1> -->

                <div class="table-responsive">
                    <a class="btn btn-success" download="report_dep_leave_total.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                    <table  id="datatable" align="center" width="100%" border="1">
                        <tr>
                            <th colspan="7" align="center">สรุปการมาสาย/ลืมแสกนลายนิ้วมือ ของข้าราชการ ลูกจ้างประจำ พนักงานราชการ พนักงานกระทรวงฯ ลูกจ้างรายวัน</th>
                        </tr>
                        <tr>
                            <th colspan="7" align="center">ประเภท : <?php if (!empty($method)) { echo $type_name['name']." ( ".DateThai2($str) . " ถึง " . DateThai2($end)." )";}?> </th>
                        </tr>
                        <tr>
                            <td width="5%" align="center"><b>ลำดับ</b></td>
                            <td width="15%" align="center"><b>ชื่อ-นามสกล</b></td>
                            <th width="10%"  align="center">ลืมลงเวลามา</th>
                            <th width="10%" align="center">ลืมลงเวลากลับ</th>
                            <th width="10%" align="center">รวมลืมลงเวลา</th>
                            <th width="10%" align="center">มาสาย</th>
                            <th width="10%" align="center">รวมทั้งหมด</th>
                        </tr>
                         <?php
                        $i = 1;
                        while ($result = mysqli_fetch_assoc($sql)) {
                            //$sum_total=$result['L3']+$result['leave_total'];
                            ?>
                            <tr>
                                <td align="center"><?= $i ?></td>
                                <td><?= $result['fullname']; ?></td>
                                <td align="center"><?= $result['ws']; ?></td>
                                <td align="center"><?= $result['fws']; ?></td>
                                <td align="center"><?= $total_wf = $result['ws']+$result['fws']; ?></td>
                                <td align="center"><?= $result['total_late']; ?></td>
                                <td align="center"><?= $total_wf+$result['total_late']; ?></td>
                            </tr>
    <?php
    $i++;
}
?>
                    </TABLE>
                </div>
            </div>	
        </div>	
    </div>	
<?PHP include_once 'footeri.php'; ?>
 						