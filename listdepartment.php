   
<!-- ค้นหา -->

              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ฝ่าย/ศูยน์/กลุ่มงาน</h3>
                    </div>
                  <div class="panel-body">
  <form class="navbar-form navbar-left" role="search" action='Add_Department.php' method='post'  >
       <div class="form-group">
		<input type='text' name='Search_department' placeholder='ฝ่าย/งาน'  value='' class="form-control"  > 
		<input type='hidden' name='method'  value='search_department'> 
		 </div>
		<button  class="btn btn-warning"><i class="fa fa-search"></i>  ค้นหา</button >
  </form>
 		 
						<!--   <H1>หมายเหตุ รายการที่มีเครื่องหมายดอกจันทร์  (***) จำเป็นต้องระบุให้ครบ</H1> -->
 						

<!------------------------------------------------------------------>

<?php   
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
	$urlfile=""; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
	$per_page=10;
	$num_per_page=floor($chk_page/$per_page);
	$total_end_p=($num_per_page+1)*$per_page;
	$total_start_p=$total_end_p-$per_page;
	$pPrev=$chk_page-1;
	$pPrev=($pPrev>=0)?$pPrev:0;
	$pNext=$chk_page+1;
	$pNext=($pNext>=$total_p)?$total_p-1:$pNext;		
	$lt_page=$total_p-4;
	if($chk_page>0){  
		echo "<a  href='$urlfile?s_page=$pPrev".$querystr."' class='naviPN'>Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile?s_page=$i".$querystr."' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile?s_page=$pNext".$querystr."'  class='naviPN'>Next</a>";
	}
}   
 
if(isset($_POST['method'])?$_POST['method']:''=='search_department'){
     $_SESSION['Search_department']=$_POST['Search_department'];
     $Search_department=trim($_SESSION['Search_department']);
}
 if(!empty($Search_department)){
 
  echo "แสดงคำที่ค้นหา : ".$Search_department;
//คำสั่งค้นหา
     $q="select * from department d1
     LEFT OUTER JOIN department_group d2 on d1.main_dep=d2.main_dep 
 	  Where  d1.depName like '%$Search_department%' or d2.dep_name like '%$Search_department%'  "; 
 }else{
 $q="select * from department d1
     LEFT OUTER JOIN department_group d2 on d1.main_dep=d2.main_dep order by d2.main_dep"; 
 }
	
$qr=mysqli_query($db,$q);
if($qr==''){exit();}
$total=mysqli_num_rows($qr);
$chk_page=''; 
$e_page=20; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
if(!isset($_GET['s_page'])){   
	$_GET['s_page']=0;   
}else{   
	$chk_page=$_GET['s_page'];     
	$_GET['s_page']=$_GET['s_page']*$e_page;   
}   
$q.=" LIMIT ".$_GET['s_page'].",$e_page";
$qr=mysqli_query($db,$q);
if(mysqli_num_rows($qr)>=1){   
	$plus_p=($chk_page*$e_page)+mysqli_num_rows($qr);   
}else{   
	$plus_p=($chk_page*$e_page);       
}   
$total_p=ceil($total/$e_page);   
$before_p=($chk_page*$e_page)+1;  
echo mysqli_error($db);
?>
 </head>
<body>
  

 <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">  
 <TR bgcolor='#898888'>
					<th width='10%'><CENTER>ลำดับ</CENTER></th>
					<th width='30%'><CENTER>หน่วยงาน</CENTER></th>
                                        <th width='30%'><CENTER>ฝ่าย</CENTER></th>
																				<th width='12%'>รายละเอียด</th>
					<th width='18%'><CENTER>แก้ไข | ลบฝ่าย | ลบงาน</CENTER></th>
 </TR>
<?php 
 
$i=1;
while($result=mysqli_fetch_assoc($qr)){?>  
 					<tr >	    
                                        <TD height="20" align="center" ><?=($chk_page*$e_page)+$i?></TD>
					<TD><?=$result['depName']; ?></TD>
                                        <TD><?=$result['dep_name']; ?></TD>
																				<td><CENTER><a href='#' onClick="return popup('WorkTree/WorkTree.html?id=<?= $result['depId'] ?>', popup, 900, 1024);"><i class='fa fa-search'></i></a></CENTER></td>
 					<TD><CENTER>
				    <a href='Add_Department.php?method=update&dep_id=<?=$result['depId']?>&mdep_id=<?=$result['main_dep']?>' ><i class="fa fa-edit"></i></a> 
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='./prcdepartment.php?method=mdelete&mdep_id=<?=$result['main_dep']?>'  title="confirm" onclick="if(confirm('ยืนยันการลบออกจากรายการ ')) return true; else return false;">   
					<i class="fa fa-trash-o"></i></a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href='./prcdepartment.php?method=delete&dep_id=<?=$result['depId']?>'  title="confirm" onclick="if(confirm('ยืนยันการลบออกจากรายการ ')) return true; else return false;">   
					<i class="fa fa-trash-o"></i></a>

					</tr> 
 
  			 
 		 <?php $i++; } ?>
 		 
</CENTER>
</table>

<?php if($total>0){
echo mysqli_error($db);

?><BR><BR>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/20)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
 </div> 
</div></div>