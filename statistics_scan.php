<?php include_once 'header.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<style>
    .number{ text-align : center;}
    .number div{
        background: #f7db04;
        color : #c10000;
    }
    .number2{ text-align : center;}
    .number2 div{
        background: #03992d;
        color : #ffffff;
    }
    #test_report th{ background-color : #21BBD6; color : #ffffff;}
    #test_report{
        border-right : 1px solid #eeeeee;
        border-bottom : 1px solid #eeeeee;
    }
    #test_report td,#test_report th{
        border-top : 1px solid #eeeeee;
        border-left : 1px solid #eeeeee;
        padding : 2px;
    }
    #txt_year{ width : 70px;}
    .fail{ color : red;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  สถิติการลืมลงเวลา </font></h1> 
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> สถิติการลืมลงเวลา</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางสถิติการลืมลงเวลาของบุคลากร</h3>
            </div>
            <div class="panel-body"><div class="col-lg-12">
                    <div class="alert alert-info alert-dismissable row">
                        <?php if ($_SESSION['Status'] == 'ADMIN') { ?>
                            <div class="form-group" align="right"> 
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="navbar-form navbar-right" enctype="multipart/form-data">
                                    <label> ระบุเดือน-ปี : </label>
                                    <div class="form-group">
                                        <select name="txt_month" class="form-control">
                                            <option value=""> เลือกเดือน </option>
                                            <?php
                                            $month = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
                                                '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
                                                '09' => 'กันยายน ', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
                                            $txtMonth = isset($_POST['txt_month']) && $_POST['txt_month'] != '' ? $_POST['txt_month'] : date('m');
                                            foreach ($month as $i => $mName) {
                                                $selected = '';
                                                if ($txtMonth == $i)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $i . '" ' . $selected . '>' . $mName . '</option>' . "\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="txt_year" class="form-control">
                                            <option value=""> เลือกปี </option>
                                            <?php
                                            $txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');

                                            $yearStart = date('Y');
                                            $yearEnd = 2017;

                                            for ($year = ($yearStart+1); $year > $yearEnd; $year--) {
                                                $selected = '';
                                                if ($txtYear == $year)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $year . '" ' . $selected . '>' . ($year + 543) . '</option>' . "\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="submit" class="btn btn-success" value="ตกลง" />
                                </form></div>
                        </div></div>
                    <a class="btn btn-success" download="scan<?= $_POST['txt_month'] . '_' . ($_POST['txt_year'] + 543) ?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', '<?= $_POST['txt_month'] . '/' . ($_POST['txt_year'] + 543) ?>');">Export to Excel</a>
                    <div class='table-responsive'>
                        <table class="table table-responsive"  id="datatable" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php
                        }
                        include_once ('option/funcDateThai.php');

//รับค่าตัวแปรที่ส่งมาจากแบบฟอร์ม HTML
                        $year = isset($_POST['txt_year']) ? mysqli_real_escape_string($db,$_POST['txt_year']) : '';
                        $month = isset($_POST['txt_month']) ? mysqli_real_escape_string($db,$_POST['txt_month']) : '';
                        if (isset($_POST['txt_year']) and isset($_POST['txt_month'])) {
                            if ($year == '' || $month == '')
                                exit('<p class="fail">กรุณาระบุ "เดือน-ปี" ที่ต้องการเรียกรายงาน</p>');

                            $sql = mysqli_query($db,"select month_name from month where month_id='$month'") or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : ' . mysqli_error($db));
                            $month_name = mysqli_fetch_assoc($sql);
//ดึงข้อมูลพนักงานทั้งหมด
                            $allEmpData = array();
                            $strSQL = "SELECT e.empno,CONCAT(p.pname,e.firstname,'  ',e.lastname)as fullname
FROM emppersonal e
INNER JOIN pcode p ON p.pcode=e.pcode
INNER JOIN fingerprint f on f.empno=e.empno and (f.forget_date LIKE '$year-$month%')
ORDER BY e.firstname";
                            $qry = mysqli_query($db,$strSQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : ' . mysqli_error($db));
                            while ($row = mysqli_fetch_assoc($qry)) {
                                $allEmpData[$row['empno']] = $row['fullname'];
                            }echo '<p>';

//เรียกข้อมูลการจองของเดือนที่ต้องการ
                            $allReportData = array();
                            $strSQL = "SELECT f.empno,DAY(f.forget_date)forget_date,if(f.work_scan!='','มม','')work_scan,if(f.finish_work_scan!='','มก','')finish_work_scan,f.exp_status
    FROM fingerprint f 
LEFT JOIN `work` w ON f.empno=w.enpid AND f.forget_date BETWEEN w.begindate AND w.enddate AND w.statusla='Y'
LEFT JOIN plan_out p ON f.empno=p.empno AND f.forget_date BETWEEN p.begin_date AND p.end_date
WHERE ISNULL(w.enpid) AND ISNULL(p.empno) and (f.forget_date LIKE '$year-$month%')
order by f.empno";
                            $qry = mysqli_query($db,$strSQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : ' . mysqli_error($db));
                            while ($row = mysqli_fetch_assoc($qry)) {
                                $allReportData[$row['empno']][$row['forget_date']] = $row['work_scan'] . '/' . $row['finish_work_scan'];
                                $checkReportData[$row['empno']][$row['forget_date']] = $row['exp_status'];
                            }
                            echo "<tr><td align='center'><b> เดือน " . $month_name['month_name'] . " ปี พ.ศ. " . ($year + 543) . "</b></td></tr><tr><td>";
                            echo "<table class='table-responsive' width='100%' border='0' id='test_report' cellpadding='0' cellspacing='0'>";
                            echo '<tr>'; //เปิดแถวใหม่ ตาราง HTML
                            echo '<th>ลำดับ</th>';
                            echo '<th>รายชื่อบุคลากร</th>';

//วันที่สุดท้ายของเดือน
                            $timeDate = strtotime($year . '-' . $month . "-01");  //เปลี่ยนวันที่เป็น timestamp
                            $lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของดือน
                            for ($day = 1; $day <= $lastDay; $day++) {
                                echo '<th>' . substr("0" . $day, -2) . '</th>';
                            }
                            echo "</tr>";$i=1;
                            foreach ($allEmpData as $empCode => $empName) {
                                echo '<tr>'; //เปิดแถวใหม่ ตาราง HTML
                                echo "<td align='center'>$i</td>";
                                echo '<td>&nbsp;&nbsp;' . $empName . '</td>';
                                //เรียกข้อมูลการจองของพนักงานแต่ละคน ในเดือนนี้
                                for ($j = 1; $j <= $lastDay; $j++) {
                                    $numBook = isset($allReportData[$empCode][$j]) ? '<div>' . $allReportData[$empCode][$j] . '</div>' : '_';
                                    $checkReportData[$empCode][$j]= isset($checkReportData[$empCode][$j])?$checkReportData[$empCode][$j]:'';
                                     if($checkReportData[$empCode][$j] == 'W') {$check = "class='number' style='color: red'";}
                                            elseif ($checkReportData[$empCode][$j] == 'A'){$check = "class='number2' style='color: blue'";}
                                            elseif ($checkReportData[$empCode][$j] == 'N'){$check = "align='center' style='color: #b79191'";} 
                                            elseif ($checkReportData[$empCode][$j] == 'Y'){$check = "align='center' style='color: green'";} 
                                            else{$check = "align='center'";}
                                    echo "<td $check>" . $numBook . "</td>";
                                }
                                echo '</tr>'; //ปิดแถวตาราง HTML
                           $i++; }
                            echo "</table>";
                        }
                        ?><br><b style="color: red"> * มม = ไม่ลงเวลามา<br> &nbsp; มก = ไม่ลงเวลากลับ</b><br>
                        &nbsp; <b style="background-color: yellow;color: red">&nbsp;มม&nbsp;</b> = ยังไม่ชี้แจง<br>
                        &nbsp; <b style="background-color: green;color: white">&nbsp;มก&nbsp;</b> = ชี้แจงแล้วแต่ยังไม่อนุมัติ<br>
                        &nbsp; <b style="color: green">&nbsp;มม&nbsp;</b> = อนุมัติ<br>
                        &nbsp; <b style="color: #b79191">&nbsp;มก&nbsp;</b> = ไม่อนุมัติ
                        </td></tr></table></div>
            </div></div></div></div>
<?php include_once 'footeri.php'; ?>
