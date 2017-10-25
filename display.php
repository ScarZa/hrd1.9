<?php
include_once 'head.php';?> 
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Leave Statistics:                 
                            <?php
                            include_once ('option/funcDateThai.php');
                            include 'option/function_date.php';
                            $d_start = 01;
                            $m_start = 01;
                            $d = date("d");
                            if (empty($_POST['year'])) {

                                if ($date >= $bdate and $date <= $edate) {
                                    $y = $Yy;
                                    $Y = date("Y");
                                } else {
                                    $y = date("Y");
                                    $Y = date("Y") - 1;
                                }
                            } else {
                                $y = $_POST['year'] - 543;
                                $Y = $y - 1;
                            }
                            $date_start = "$Y-10-01";
                            $date_end = "$y-09-30";
                            echo $date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                            echo " ถึง ";
                            echo $date_end = DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                            ?>	</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                            <div class="form-group col-lg-9 col-md-9 col-xs-8"> 
                                <select name='year'  class="form-control">
                                    <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                    <?php
                                    for ($i = 2558; $i <= 2565; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-xs-4"><button type="submit" class="btn btn-success">ตกลง</button></div> 						
                        </form>
                        <?php
                        if (empty($_POST['year'])) {

                            if ($date >= $bdate and $date <= $edate) {
                                $year = $Yy;
                                $years = $year + 543;
                            } else {
                                $year = date('Y');
                                $years = $year + 543;
                            }
                        } else {
                            $year = $_POST['year'] - 543;
                            $years = $year + 543;
                        }

                        echo "<center>";



                        echo "รายงานการลา : ทั้งหมด";
                        echo "&nbsp;&nbsp;";
                        echo "ปีงบประมาณ : $years";
                        echo "</center>";

                        $month_start = "$Y-10-01";
                        ;
                        $month_end = "$y-09-30";
                        $I = 10;
                        $name='';
                        for ($i = -2; $i <= 9; $i++) {

                            $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                            $month = mysqli_fetch_assoc($sqlMonth);

                            if ($i <= 0) {
                                $month_start = "$Y-$I-01";
                                $month_end = "$Y-$I-31";
                                /* if(date("Y-m-d")=="$y-$I-$d"){
                                  $month_start = "$y-$I-01";
                                  $month_end = "$y-$I-31";
                                  } */
                            } elseif ($i >= 1 and $i <= 9) {
                                $month_start = "$year-0$i-01";
                                $month_end = "$year-0$i-31";
                            } else {
                                $month_start = "$year-$i-01";
                                $month_end = "$year-$i-31";
                            }

                            $month_start;
                            echo "&nbsp;&nbsp;";
                            $month_end;
                            $countnum[]='';
                            for ($c = 1; $c <= 7; $c++) {
                                $sql = mysqli_query($db,"select count(w.workid) as count from work w   
						 where  w.typela='$c' and    w.begindate between '$month_start' and '$month_end' and statusla='Y' order by count DESC");

                                $rs = mysqli_fetch_assoc($sql);
                                
                                @$countnum[$c].= $rs['count'] . ',';
                            }
                            $name.="'".$month['month_short']."'" . ',';
                            $I++;
                        }
                        echo mysqli_error($db);
                        ?>
                        
                        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function () {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container',
                            type: 'line'
                        },
                        title: {
                            text: 'จำนวนการลาในแต่ละประเภทแยกรายเดือน'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: [<?= $name; ?>
                            ]
                        },
                        yAxis: {
                            title: {
                                text: 'จำนวนครั้ง'
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                        this.x + ': ' + this.y + '';
                            }
                        },
                        plotOptions: {
                            line: {
                                dataLabels: {
                                    enabled: true
                                },
                                enableMouseTracking: true
                            }
                        },
                        series: [{
                                name: 'ลาป่วย',
                                data: [<?= $countnum[1] ?>]
                            }, {
                                name: 'ลากิจ',
                                data: [<?= $countnum[2] ?>]
                            }, {
                                name: 'ลาพักผ่อน',
                                data: [<?= $countnum[3] ?>]
                            }, {
                                name: 'ลาคลอด',
                                data: [<?= $countnum[4] ?>]
                            }, {
                                name: 'ลาบวช',
                                data: [<?= $countnum[5] ?>]
                            }, {
                                name: 'ลาศึกษาต่อ',
                                data: [<?= $countnum[6] ?>]
                            }, {
                                name: 'ลาเลี้ยงดูบุตร',
                                data: [<?= $countnum[7] ?>]
                            }
                        ]
                    });
                });

            });


                        </script>

                        <div class="col-lg-12" id="container" style="margin: 0 auto"></div>
                        <br>
                        <?php
                        $m_start = "$Y-10-01";
                        $m_end = "$y-09-30";
                        for ($c = 1; $c <= 7; $c++) {
                            $sql = mysqli_query($db,"select count(w.workid) as count from work w   
						 where  w.typela='$c' and    w.begindate between '$m_start' and '$m_end' and statusla='Y' order by count DESC");

                            $rs = mysqli_fetch_assoc($sql);

                            $count[$c] = $rs['count'];
                        }
                        ?>
                        
                        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function () {

                    // Radialize the colors
                    Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function (color) {
                        return {
                            radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                            stops: [
                                [0, color],
                                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                            ]
                        };
                    });

                    // Build the chart
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'tainer',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'จำนวนการลาในแต่ละประเภทในปีงบประมาณ <?= $years ?>'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                            percentageDecimals: 1
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    formatter: function () {
                                        return '<b>' + this.point.name + '</b>: ' + this.y + ' ครั้ง';
                                    }
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'ลาไป',
                                data: [
                                    ['ลาป่วย', <?= $count[1] ?>],
                                    ['ลากิจ', <?= $count[2] ?>],
                                    {
                                        name: 'ลาพักผ่อน',
                                        y: <?= $count[3] ?>,
                                        sliced: true,
                                        selected: true
                                    },
                                    ['ลาคลอด', <?= $count[4] ?>],
                                    ['ลาบวช', <?= $count[5] ?>],
                                    ['ลาศึกษาต่อ', <?= $count[6] ?>],
                                    ['ลาเลี้ยงดูบุตร', <?= $count[7] ?>]
                                ]
                            }]
                    });
                });

            });
                        </script>

                        <div class="col-lg-6" id="tainer" style="margin: 0 auto"></div>

                        <?php
                        $sql = mysqli_query($db,"SELECT d.depName as dep_name,
(SELECT round(sum(w.amount)/COUNT(e.empno),2) 
from emppersonal e  
where d.depId=e.depId and w.statusla='Y')count_leave
FROM department d
LEFT OUTER JOIN emppersonal e on e.depid=d.depId
LEFT OUTER JOIN `work` w on e.empno=w.enpid
                                        WHERE w.statusla='Y' and w.begindate between '$m_start' and '$m_end'
                                        GROUP BY d.depId  
order by count_leave DESC limit 10 ");
                        ?>
                        
                        <script type="text/javascript">
            $(function () {
                var chart;
                $(document).ready(function () {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'contain',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                        },
                        title: {
                            text: '10 อันดับการลาแต่ละหน่วยงานในปีงบประมาณ <br>(ค่าเฉลี่ยวันลาต่อคนในหน่วยงาน) <?= $years ?>'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                            percentageDecimals: 1
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    formatter: function () {
                                        return '<b>' + this.point.name + '</b>: ' + this.y + ' วัน';
                                    }
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'ลาไป',
                                data: [<?php
                while ($row = mysqli_fetch_array($sql)) {
                    $depnamex = $row['dep_name'];
                    $countx = $row['count_leave'];
                    $sss = "['" . $depnamex . "'," . $countx . "],";
                    echo $sss;
                }
                ?>
                                ]
                            }]
                    });
                });

            });
                        </script>


                        <div class="col-lg-6" id="contain" style="margin: 0 auto"></div>


                        <SCRIPT language=JavaScript>
                            var OldColor;
                            function popNewWin(strDest, strWidth, strHeight) {
                                newWin = window.open(strDest, "popup", "toolbar=no,scrollbars=yes,resizable=yes,width=" + strWidth + ",height=" + strHeight);
                            }
                            function mOvr(src, clrOver) {
                                if (!src.contains(event.fromElement)) {
                                    src.style.cursor = 'hand';
                                    OldColor = src.bgColor;
                                    src.bgColor = clrOver;
                                }
                            }
                            function mOut(src) {
                                if (!src.contains(event.toElement)) {
                                    src.style.cursor = 'default';
                                    src.bgColor = OldColor;
                                }
                            }
                            function mClk(src) {
                                if (event.srcElement.tagName == 'TD') {
                                    src.children.tags('A')[0].click();
                                }
                            }
                        </SCRIPT>


                    </div>
                </div>
            </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Personal </h3> 
                    </div>
                    <div class="panel-body">
                        <?php
                        $sql_nameperson = mysqli_query($db,"SELECT dg.dep_name as dep_name
FROM  department_group dg 
inner join department d on dg.main_dep = d.main_dep 
inner join emppersonal em on d.depId = em.depid
GROUP BY dg.main_dep
order by dg.main_dep");
                        $sql_person = mysqli_query($db,"SELECT d.main_dep,dg.dep_name as dep_name,COUNT(d.depId) as sum,
COUNT(d1.depId) as d1,
COUNT(d2.depId) as d2,
COUNT(d3.depId) as d3,
COUNT(d4.depId) as d4,
COUNT(d5.depId) as d5,
COUNT(d6.depId) as d6,
COUNT(d7.depId) as d7
FROM emppersonal em
left outer join department d on d.depId = em.depid
left outer join department_group dg on dg.main_dep = d.main_dep
LEFT OUTER JOIN department d1 on d1.depid = em.depid and em.emptype='1'
LEFT OUTER JOIN department d2 on d2.depid = em.depid and em.emptype='2'
LEFT OUTER JOIN department d3 on d3.depid = em.depid and em.emptype='3'
LEFT OUTER JOIN department d4 on d4.depid = em.depid and em.emptype='4'
LEFT OUTER JOIN department d5 on d5.depid = em.depid and em.emptype='5'
LEFT OUTER JOIN department d6 on d6.depid = em.depid and em.emptype='6'
LEFT OUTER JOIN department d7 on d7.depid = em.depid and em.emptype='7'
where em.status='1'
GROUP BY d.main_dep order by dg.main_dep");
                        ?>
                        <script type="text/javascript">
                            $(function () {
                                var chart;
                                $(document).ready(function () {

                                    var colors = Highcharts.getOptions().colors,
                                            categories = [
        <?php
        while ($row1 = mysqli_fetch_array($sql_nameperson)) {
            $dep_name = $row1['dep_name'];
            $show1 = "'" . $dep_name . "',";
            echo $show1;
        }
        ?>],
                                            name = 'Browser brands',
                                            data = [
        <?php
        $i = 0;

        while ($row2 = mysqli_fetch_array($sql_person)) {
            if ($i >= 9) {
                $i = 0;
            }
            $sum = $row2['sum'];
            $d1 = $row2['d1'];
            $d2 = $row2['d2'];
            $d3 = $row2['d3'];
            $d4 = $row2['d4'];
            $d5 = $row2['d5'];
            $d6 = $row2['d6'];
            $d7 = $row2['d7'];
            $show = "{
         y:" . $sum . ",
         color: colors[" . $i . "],
         drilldown: {
         name: '" . $sum . "',
         categories: ['ข้าราชการ', 'ลูกจ้างประจำ', 'พนักงานราชการ', 'พกส.','ลูกจ้างชั่วคราวรายเดือน','ลูกจ้างชั่วคราวรายวัน','นักศึกษาฝึกงาน'],
         data: [" . $d1 . "," . $d2 . "," . $d3 . "," . $d4 . "," . $d5 . "," . $d6 . "," . $d7 . "],
         color: colors[" . $i . "]}},";
            echo $show;
            $i++;
        }
        ?>

                                            ];


                                    // Build the data arrays
                                    var browserData = [];
                                    var versionsData = [];
                                    for (var i = 0; i < data.length; i++) {

                                        // add browser data
                                        browserData.push({
                                            name: categories[i],
                                            y: data[i].y,
                                            color: data[i].color
                                        });

                                        // add version data
                                        for (var j = 0; j < data[i].drilldown.data.length; j++) {
                                            var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5;
                                            versionsData.push({
                                                name: data[i].drilldown.categories[j],
                                                y: data[i].drilldown.data[j],
                                                color: Highcharts.Color(data[i].color).brighten(brightness).get()
                                            });
                                        }
                                    }

                                    // Create the chart
                                    chart = new Highcharts.Chart({
                                        chart: {
                                            renderTo: 'donut',
                                            type: 'pie'
                                        },
                                        title: {
                                            text: 'บุคลากรในโรงพยาบาลจิตเวชเลยราชนครินทร์'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'บุคลากรในโรงพยาบาลจิตเวชเลยราชนครินทร์'
                                            }
                                        },
                                        plotOptions: {
                                            pie: {
                                                shadow: true
                                            }
                                        },
                                        tooltip: {
                                            valueSuffix: 'คน'
                                        },
                                        series: [{
                                                name: 'จำนวน',
                                                data: browserData,
                                                size: '60%',
                                                dataLabels: {
                                                    formatter: function () {
                                                        return this.y > 5 ? this.point.name : null;
                                                    },
                                                    color: 'white',
                                                    distance: -30
                                                }
                                            }, {
                                                name: 'จำนวน',
                                                data: versionsData,
                                                innerSize: '60%',
                                                dataLabels: {
                                                    formatter: function () {
                                                        // display only if larger than 1
                                                        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + 'คน' : null;
                                                    }
                                                }
                                            }]
                                    });
                                });

                            });
                        </script>
                        <div class="col-lg-12" id="donut" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
                    </div></div></div></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Training :
                            <?php
                            $date_start = "$Y-10-01";
                            $date_end = "$y-09-30";
                            echo DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                            echo " ถึง ";
                            echo DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                            ?>
                        </h3> 
                    </div>
                    <div class="panel-body">
                        <center>อบรมภายนอก/ไปราชการในปีงบประมาณ <?= $years ?></center><br>
                        <div class="table-responsive">
                            <?php if($_SESSION['Status']=='ADMIN'){?>
                            <a class="btn btn-success" download="report_Governor.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', '<?= $years ?>');">Export to Excel</a><br><br>
                            <?php } ?>
                            <table class="table table-striped table-responsive tablesorter divider" id="datatable" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" rules="rows" frame="below">
                                <thead>
                                    <tr align="center" bgcolor="#898888">
                                        <TH rowspan="2"><CENTER>เดือน</CENTER> </TH>
                                <TH rowspan="2"><CENTER>
                                  โครงการ
                                </CENTER></TH> 
                                <TH rowspan="2"><CENTER>
                                  คน
                                </CENTER></TH>
                                <TH rowspan="2"><CENTER>
                                  วัน
                                </CENTER></TH>
                                <TH>ประชุม</TH>
                                <TH>อบรม</TH>
                                <TH>สัมมนา</TH>
                                <TH>ดูงาน</TH>
                                <TH>วิทยากร</TH>
                                <TH>อื่นๆ</TH>
                                <TH colspan="5"><CENTER>ค่าใช้จ่าย / เดือน</CENTER></TH>
                                <TH rowspan="2"><CENTER>รวมค่าใช้จ่าย</CENTER></TH>
                                </tr>
                                    <tr align="center" bgcolor="#898888">
                                      <TH colspan="6">คน / ครั้ง</TH>
                                      <TH>ที่พัก</TH>
                                      <TH>ลงทะเบียน</TH>
                                      <TH>เบี่ยเลี้ยง </TH>
                                      <TH>พาหนะเดิน </TH>
                                      <TH>อื่นๆ</TH>
                                    </tr>
                                </thead>
        <?php
        $c = 1;
        $I = 10;
        for ($i = -2; $i <= 9; $i++) {

            $sqlMonth = mysqli_query($db,"select * from month where m_id='$i' order by m_id desc");
            $month = mysqli_fetch_assoc($sqlMonth);

            if ($i <= 0) {
                $month_start = "$Y-$I-01";
                $month_end = "$Y-$I-31";
                /* if(date("Y-m-d")=="$y-$I-$d"){
                  $month_start = "$y-$I-01";
                  $month_end = "$y-$I-31";
                  } */
            } elseif ($i >= 1 and $i <= 9) {
                $month_start = "$year-0$i-01";
                $month_end = "$year-0$i-31";
            } else {
                $month_start = "$year-$i-01";
                $month_end = "$year-$i-31";
            }
            $sql_train = mysqli_query($db,"SELECT COUNT(p.empno) as a2,SUM(p.abode) as a4,
SUM(reg) as a5,SUM(allow) as a6,SUM(p.travel) as a7,SUM(p.other) as a8,
(SELECT COUNT(p.empno) FROM plan_out p, training_out t 
WHERE t.tuid=p.idpo AND t.dt in(1,2) and p.begin_date BETWEEN '$month_start' and '$month_end') pconf,
(SELECT COUNT(t.tuid) FROM training_out t WHERE dt in(1,2) and t.Beginedate BETWEEN '$month_start' and '$month_end') conf,
(SELECT COUNT(p.empno) FROM plan_out p, training_out t 
WHERE t.tuid=p.idpo AND t.dt=3 and p.begin_date BETWEEN '$month_start' and '$month_end') pteach,
(SELECT COUNT(t.tuid) FROM training_out t WHERE dt=3 and t.Beginedate BETWEEN '$month_start' and '$month_end') teach,
(SELECT COUNT(p.empno) FROM plan_out p, training_out t 
WHERE t.tuid=p.idpo AND t.dt=4 and p.begin_date BETWEEN '$month_start' and '$month_end') psee,
(SELECT COUNT(t.tuid) FROM training_out t WHERE dt=4 and t.Beginedate BETWEEN '$month_start' and '$month_end') see,
(SELECT COUNT(p.empno) FROM plan_out p, training_out t 
WHERE t.tuid=p.idpo AND t.dt=5 and p.begin_date BETWEEN '$month_start' and '$month_end') pmeeting,
(SELECT COUNT(t.tuid) FROM training_out t WHERE dt=5 and t.Beginedate BETWEEN '$month_start' and '$month_end') meeting,
(SELECT COUNT(p.empno) FROM plan_out p, training_out t 
WHERE t.tuid=p.idpo AND t.dt in(6,7) and p.begin_date BETWEEN '$month_start' and '$month_end') ptrain,
(SELECT COUNT(t.tuid) FROM training_out t WHERE dt in(6,7) and t.Beginedate BETWEEN '$month_start' and '$month_end') train,
(SELECT COUNT(p.empno) FROM plan_out p, training_out t 
WHERE t.tuid=p.idpo AND t.dt=8 and p.begin_date BETWEEN '$month_start' and '$month_end') pother,
(SELECT COUNT(t.tuid) FROM training_out t WHERE dt=8 and t.Beginedate BETWEEN '$month_start' and '$month_end') other,
(SELECT COUNT(t.tuid) FROM training_out t WHERE t.Beginedate BETWEEN '$month_start' and '$month_end') a1,
(SELECT SUM(t.amount) FROM training_out t WHERE t.Beginedate BETWEEN '$month_start' and '$month_end') a3
FROM plan_out p, training_out t
WHERE t.tuid=p.idpo AND p.begin_date BETWEEN '$month_start' and '$month_end'");
            $rs = mysqli_fetch_assoc($sql_train);
            ?>

                                    <tr>
                                        <td><?php echo $month['month_name']; ?></td>
                                        <td align="center"><?php echo $rs['a1']; ?></td> 
                                        <td align="center"><?php echo $rs['a2']; ?></td> 
                                        <td align="center"><?php echo $rs['a3']; ?></td>
                                        <td align="center"><?= $rs['pconf'].'./'.$rs['conf']?></td>
                                        <td align="center"><?= $rs['ptrain'].'./'.$rs['train']?></td>
                                        <td align="center"><?= $rs['pmeeting'].'./'.$rs['meeting']?></td>
                                        <td align="center"><?= $rs['psee'].'./'.$rs['see']?></td>
                                        <td align="center"><?= $rs['pteach'].'./'.$rs['teach']?></td>
                                        <td align="center"><?= $rs['pother'].'./'.$rs['other']?></td> 
                                        <td align="center"><?php echo $rs['a4']; ?></td> 
                                        <td align="center"><?php echo $rs['a5']; ?></td> 
                                        <td align="center"><?php echo $rs['a6']; ?></td> 
                                        <td align="center"><?php echo $rs['a7']; ?></td> 
                                        <td align="center"><?php echo $rs['a8']; ?></td> 
                                        <td align="center"><?php echo $rs['a4'] + $rs['a5'] + $rs['a6'] + $rs['a7'] + $rs['a8']; ?></td> 
                                    </tr>

            <?php $c++;
            $I++;
        } ?>
                                <tfoot>
                                    <?php
                                    $sql_sum = mysqli_query($db,"SELECT COUNT(p.empno) as b2,SUM(p.abode) as b4,
SUM(reg) as b5,SUM(allow) as b6,SUM(p.travel) as b7,SUM(p.other) as b8,
(SELECT COUNT(t.tuid) FROM training_out t WHERE t.Beginedate BETWEEN '$date_start' and '$date_end') b1,
(SELECT SUM(t.amount) FROM training_out t WHERE t.Beginedate BETWEEN '$date_start' and '$date_end') b3
FROM plan_out p
WHERE p.begin_date BETWEEN '$date_start' and '$date_end'");
                                    $rsum = mysqli_fetch_assoc($sql_sum);
                                    ?>
                                    <tr align="center">
                                        <td align="center" bgcolor="#898888"><b>รวม</b></td>
                                        <td align="center"><?php echo $rsum['b1']; ?></td>
                                        <td align="center"><?php echo $rsum['b2']; ?></td>
                                        <td align="center"><?php echo $rsum['b3']; ?></td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center"><?php echo $rsum['b4']; ?></td>
                                        <td align="center"><?php echo $rsum['b5']; ?></td>
                                        <td align="center"><?php echo $rsum['b6']; ?></td>
                                        <td align="center"><?php echo $rsum['b7']; ?></td>
                                        <td align="center"><?php echo $rsum['b8']; ?></td>
                                        <td align="center"><?php echo $rsum['b4'] + $rsum['b5'] + $rsum['b6'] + $rsum['b7'] + $rsum['b8']; ?></td>
                                    </tr>   
                                </tfoot>
                            </table>
                        </div>
                    </div></div></div></div>
        <?php                                    include_once 'footeri.php';?>