<?php @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
    <link rel="stylesheet" href="js/fullcalendar-2.1.1/fullcalendar.min.css">
    <script type="text/javascript">
            $(function() {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'month,agendaWeek,agendaDay',
                        center: 'title',
                        right: 'prev,next today'
                    },
                    editable: true,
                    theme: true,
                    events: "data_events3.php?gData=1",
                    loading: function(bool) {
                        if (bool)
                            $('#loading').show();
                        else
                            $('#loading').hide();
                    },
                    eventLimit:true,  
                    lang:'th'// put your options and callbacks here  
                });

            });
        </script>
    <style type="text/css">
    html,body{
        maring:0;padding:0;
        font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;   
        font-size:12px;
    }
	#calendar{
		max-width: 700px;
		margin: 0 auto;
        font-size:13px;
	}        
    </style>
</head>
<body>

<br><br>
<div style="margin:auto;width:800px;">
 <div id='calendar'></div>
 </div>
<br>
<div align="center">
<?php
include '../connection/connect_calendra.php';
$train=  mysqli_query($db,"SELECT tid,tName FROM trainingtype ORDER BY tid ASC") or die(mysqli_error($db));
$code_color=array("1"=>"orange","2"=>"violet","3"=>"green","4"=>"red","5"=>"yellowgreen","6"=>"blue","7"=>"brown","8"=>"purple","9"=>"#977dd1","10"=>"#6a6a6a","11"=>"#361203");

while ($row = mysqli_fetch_array($train)) {  $i=$row['tid'];?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $row['tName']?></a> 
<?php  }?>
</div>
    
<script src="js/fullcalendar-2.1.1/lib/jquery.min.js"></script>    
<script type="text/javascript" src="js/fullcalendar-2.1.1/lib/moment.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/lang/th.js"></script>
<script type="text/javascript" src="script3.js"></script>            
</body>
</html>