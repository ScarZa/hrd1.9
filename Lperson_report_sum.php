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
        <h1><font color='blue'><img src='images/kchart.ico' width='75'>  รายงานแสดงการลาของบุคลากรแยกหน่วยงาน </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลาของของของบุคลากรหน่วยงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='images/kchart.ico' width='25'> ตารางสถิติการลาของของบุคลากรหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info alert-dismissable">
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


                        </form></div> <br><br></div>
                <?php
                                    if ($screen == '2') {?>
                <div class="alert alert-info alert-dismissable">
                    <div class="form-group" align="right"> 
                        <form name="form2" method="post" action="Lperson_report_sum.php" enctype="multipart/form-data" class="navbar-form navbar-right">
                            <div class="form-group">
                                <select name="dep" id="dep"  class="form-control select2" style="width: 200px" required="">
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
                <input name="year" type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                </div>
                <div class="form-group">
                <input name="eyear" type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" required>
                </div>
                            <input type="hidden"   name='method' class="form-control" value='range_date' >
                            <input type="hidden"   name='screen' class="form-control" value='<?= $screen ?>' >
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </form></div> <br><br></div>
                <?php }
                if (!empty($_REQUEST['year'])) {
                    $year = $_POST['year'] - 543;
                }
                $year_now = date("Y");
                include 'option/funcDateThai.php';
                
                if (!empty($_POST['year']) or ! empty($_GET['year'])) {
                    $method = isset($_POST['method'])?$_POST['method']:'';
                        if($method != 'range_date'){
                            include 'option/function_date.php';
                    if ($date >= $bdate and $date <= $edate) {//ถ้าช่วงที่ใช้งานอยู่ปัจจุบันอยู่ในช่วงเดือน ตุลาคม - ธันวาคม
                        $year = date('Y') - 1;
                        $take_month = isset($_POST['month']) ? $_POST['month'] : '';
                        $depno = isset($_POST['dep']) ? $_POST['dep'] : '';

                        if ($take_month == '1' or $take_month == '2' or $take_month == '3' or $take_month == '4' or $take_month == '5' or $take_month == '6' or $take_month == '7' or $take_month == '8' or $take_month == '9') {
                            $take_month1 = "$y-$take_month-01";
                            if ($take_month == '4' or $take_month == '6' or $take_month == '9') {
                                $take_month2 = "$y-$take_month-30";
                            } elseif ($take_month == '2') {
                                $take_month2 = "$y-$take_month-29";
                            } else {
                                $take_month2 = "$y-$take_month-31";
                            }
                            $take_date1 = "$Y-10-01";
                            $take_date2 = "$y-09-30";
                        } elseif ($take_month == '10' or $take_month == '11' or $take_month == '12') {
                            $take_month1 = "$Y-$take_month-01";
                            if ($take_month == '11') {
                                $take_month2 = "$Y-$take_month-30";
                            } else {
                                $take_month2 = "$Y-$take_month-31";
                            }
                            $take_date1 = "$Y-10-01";
                            $take_date2 = "$y-09-30";
                        }
                        $yen = date("Y") + 1;
                        $Yst = date("Y");
                    } else {//ถ้าช่วงที่ใช้งานอยู่ปัจจุบันอยู่ในช่วงเดือน มกราคม - กันยายน
                        $year = date('Y');
                        $yen = date("Y") + 1;
                        $Yst = date("Y");

                        $take_month = isset($_POST['month']) ? $_POST['month'] : '';
                        $depno = isset($_POST['dep']) ? $_POST['dep'] : '';

                        if ($take_month == '1' or $take_month == '2' or $take_month == '3' or $take_month == '4' or $take_month == '5' or $take_month == '6' or $take_month == '7' or $take_month == '8' or $take_month == '9') {
                            $this_year = $y;
                            $ago_year = $Y;
                            $take_month1 = "$this_year-$take_month-01";
                            if ($take_month == '4' or $take_month == '6' or $take_month == '9') {
                                $take_month2 = "$this_year-$take_month-30";
                            } elseif ($take_month == '2') {
                                $take_month2 = "$this_year-$take_month-29";
                            } else {
                                $take_month2 = "$this_year-$take_month-31";
                            }
                            $take_date1 = "$ago_year-10-01";
                            $take_date2 = "$this_year-09-30";
                        } elseif ($take_month == '10' or $take_month == '11' or $take_month == '12') {
                            $this_year = $y;
                            $ago_year = $Y;
                            $next_year = $Yy;
                            $take_month1 = "$ago_year-$take_month-01";
                            if ($take_month == '11') {
                                $take_month2 = "$ago_year-$take_month-30";
                            } else {
                                $take_month2 = "$ago_year-$take_month-31";
                            }
                            $take_date1 = "$ago_year-10-01";
                            $take_date2 = "$this_year-09-30";
                        } else {
                            $this_year = $y;
                            $ago_year = $Y;
                        }
                    }
                        }else{
                            if(empty($year)){
                                 $y=  date("Y");
                            } else {
                                $y=date("Y");
                            }
                                 $Y=$y-1;
                                 $Yy=$y+1;
                            $this_year = $y;
                            $ago_year = date('Y')-1;
                            $next_year = $Yy;
                    $year = date('Y');
                    $depno = isset($_POST['dep']) ? $_POST['dep'] : '';
                    $take_month1 = insert_date($_POST['year']);
                    $take_month2 = insert_date($_POST['eyear']);
                    $take_date1 = "$ago_year-10-01";
                    $take_date2 = "$this_year-09-30";
                    $date_start = '';
                    $date_end = ''; 
                        }
//                    $date_start = "$Yst-10-01";
//                    $date_end = "$yen-09-30" . "<br>";
                } else {
                    $year = '';
                    $depno = '';
                    $take_month1 = '';
                    $take_month2 = '';
                    $take_date1 = '';
                    $take_date2 = '';
                    $date_start = '';
                    $date_end = '';
                }
                if ($screen == '1') {
                    $code1 = "wh.depid='$depno'";
                    $code2 = "LEFT OUTER JOIN department d on w.depId=d.depId";
                    $code3 = "t.depId='$depno'";
                    $code4 = "select depName as name from department where depId='$depno'";
                } else {
                    $code1 = "wh.emptype='$depno'";
                    $code2 = "LEFT OUTER JOIN emptype e2 on e1.emptype=e2.EmpType";
                    $code3 = "e1.emptype='$depno'";
                    $code4 = "select TypeName as name from emptype where EmpType='$depno'";
                }
                $sql = mysqli_query($db, "SELECT CONCAT(e1.firstname,' ',e1.lastname) as fullname,e1.empno as empno, e1.emptype,CONCAT(TIMESTAMPDIFF(year,e1.regis_date,NOW()))AS age,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1'and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_sick,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_sick,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_leave,
(select SUM(w.amount) from `work`w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_leave,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_vacation,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_vacation,
(SELECT COUNT(w.amount)  from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_maternity,
(select SUM(w.amount) from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_month1' and '$take_month2') or  (w.enddate between '$take_month1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_maternity,
(SELECT COUNT(w.amount)  from `work` w where w.typela='1'and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_sick_total,
(select SUM(w.amount) from `work` w where w.typela='1' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_sick_total,
(SELECT COUNT(w.amount)  from `work` w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_leave_total,
(select SUM(w.amount) from `work`w where w.typela='2' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_leave_total,
(SELECT COUNT(w.amount)  from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_vacation_total,
(select SUM(w.amount) from `work` w where w.typela='3' and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_vacation_total,
(SELECT COUNT(w.amount)  from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') amonut_maternity_total,
(select SUM(w.amount) from `work` w where (w.typela='4' or w.typela='5') and e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1') sum_maternity_total,
(SELECT COUNT(t.total)  from timela t WHERE t.`status`='N' and e1.empno=t.empno and $code3 and t.datela between '$take_date1' and '$take_month2' and e1.status ='1') amonut_t,
(select SUM(t.total) from timela t WHERE t.`status`='N' and e1.empno=t.empno and $code3 and t.datela between '$take_date1' and '$take_month2' and e1.status ='1') sum_t,
(SELECT SUM(w.amount) FROM `work` w WHERE $code1 and e1.empno=w.enpid and w.typela='3' and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and w.regis_leave!='N') now_leave ,
(select ld.L3 from leave_day ld where $code1 and e1.empno=ld.empno and fiscal_year='" . ($year - 1) . "') befor_leave,
(select ld.L3 from leave_day ld where $code1 and e1.empno=ld.empno and fiscal_year='$year') total_leave
from `work` w
LEFT OUTER JOIN emppersonal e1 on w.depId=e1.depid
LEFT OUTER JOIN work_history wh ON wh.empno=e1.empno
LEFT OUTER JOIN leave_day ld ON e1.empno=ld.empno
$code2
where e1.empno=w.enpid and $code1 and ((w.begindate between '$take_date1' and '$take_month2') or  (w.enddate between '$take_date1' and '$take_month2')) and w.statusla='Y' and e1.status ='1'
GROUP BY e1.empno
order by e1.empno");

                $sql_dep = mysqli_query($db, $code4);
                $depname = mysqli_fetch_assoc($sql_dep);
                ?>

                <!-- <H1>จำนวนการรายงานความเสี่ยงของหน่วยงาน</H1> -->

                <div class="table-responsive">
                    <a class="btn btn-success" download="report_dep_leave_total.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                    <table  id="datatable" align="center" width="100%" border="1">
                        <tr>
                            <th colspan="23" align="center">สรุปวันลาของข้าราชการ ลูกจ้างประจำ พนักงานราชการ พนักงานกระทรวงฯ ลูกจ้างรายวัน</th>
                        </tr>
                        <tr>
                            <th colspan="23" align="center"><?= $depname['name']; ?></th>
                        </tr>
                        <tr>
                            <td width="3%" rowspan="3" align="center"><b>ลำดับ</b></td>
                            <td width="9%" rowspan="3" align="center"><b>ชื่อ-นามสกล</b></td>
                            <th colspan="8" align="center">เดือนนี้ ( <?php if (!empty($take_month)) {
                    echo DateThai2($take_month1) . " ถึง " . DateThai2($take_month2);
                }else{ echo DateThai2($take_month1) . " ถึง " . DateThai2($take_month2);} ?> )</th>
                            <th colspan="8" align="center">ตั้งแต่ต้นปี ( <?= DateThai2($take_date1); ?> ถึง <?= DateThai2($take_date2); ?> )</th>
                            <th width="4%" rowspan="3" align="center">พักผ่อนสะสม</th>
                            <th width="4%" rowspan="3" align="center">พักผ่อนปีนี้</th>
                            <th width="4%" rowspan="3" align="center">รวม</th>
                            <th width="4%" rowspan="3" align="center">เหลือ</th>
                            <th width="4%" rowspan="3" align="center">ลาชั่วโมง</th>
                        </tr>
                        <tr align="center">
                            <td colspan="2" align="center"><b>ลาป่วย</b></td>
                            <td colspan="2" align="center"><b>ลากิจ</b></td>
                            <td colspan="2" align="center"><b>ลาพักผ่อน</b></td>
                            <td colspan="2" align="center"><b>ลาคลอด/บวช</b></td>
                            <td colspan="2" align="center"><b>ลาป่วย</b></td>
                            <td colspan="2" align="center"><b>ลากิจ</b></td>
                            <td colspan="2" align="center"><b>ลาพักผ่อน</b></td>
                            <td colspan="2" align="center"><b>ลาคลอด/บวช</b></td>
                        </tr>
                        <tr align="center">
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                            <td width="4%" align="center">ครั้ง</td>
                            <td width="4%" align="center">วัน</td>
                        </tr>



                        <?php
                        $i = 1;
                        while ($result = mysqli_fetch_assoc($sql)) {
                            //$sum_total=$result['L3']+$result['leave_total'];
                            ?>
                            <tr>
                                <td align="center"><?= $i ?></td>
                                <td><?= $result['fullname']; ?></td>
                                <td align="center"><?= $result['amonut_sick']; ?></td>
                                <td align="center"><?= $result['sum_sick']; ?></td>
                                <td align="center"><?= $result['amonut_leave']; ?></td>
                                <td align="center"><?= $result['sum_leave']; ?></td>
                                <td align="center"><?= $result['amonut_vacation']; ?></td>
                                <td align="center"><?= $result['sum_vacation']; ?></td>
                                <td align="center"><?= $result['amonut_maternity']; ?></td>
                                <td align="center"><?= $result['sum_maternity']; ?></td>
                                <td align="center"><?= $result['amonut_sick_total']; ?></td>
                                <td align="center"><?= $result['sum_sick_total']; ?></td>
                                <td align="center"><?= $result['amonut_leave_total']; ?></td>
                                <td align="center"><?= $result['sum_leave_total']; ?></td>
                                <td align="center"><?= $result['amonut_vacation_total']; ?></td>
                                <td align="center"><?= $result['sum_vacation_total'] ?></td>
                                <td align="center"><?= $result['amonut_maternity_total']; ?></td>
                                <td align="center"><?= $result['sum_maternity_total']; ?></td>
                                <?php
                                if ($result['emptype'] == '1' or $result['emptype'] == '2') {
                                    $befor_leave = $result['befor_leave'];
                                    if ($result['age'] < 10 and $befor_leave + 10 > 20) {
                                        $total = 20;
                                    } elseif ($result['age'] >= 10 and $befor_leave + 10 > 30) {
                                        $total = 30;
                                    } else {
                                        $total = $befor_leave + 10;
                                    }
                                } else {
                                    $befor_leave = 0;
                                    $total = 10;
                                }
                                $now_leave = $total - $result['now_leave'];
                                ?>
                                <td align="center"><?= $befor_leave ?></td>
                                <td align="center">10</td>
                                <td align="center"><?= $total ?></td>
                                <td align="center"><?= $now_leave ?></td>
                                <td align="center"><?= $result['sum_t']; ?></td>
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
 						