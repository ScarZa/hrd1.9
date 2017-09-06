<?php include_once 'header.php';?>
<?php if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<br><br>
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">สร้างบัตรพนักงาน</h3>
                    </div>
                <div class="panel-body">
                    <form class="navbar-form navbar-right" name="frmSearch" role="search" method="post" action="create_card.php">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="form-group">
                    <input type="text" placeholder="ค้นหาชื่อ" name='txtKeyword' class="form-control" value="<?= isset($Search_word)?$Search_word:''?>" >
                    <input type='hidden' name='method'  value='txtKeyword'>
                    <input type='hidden' name='id'  value='<?=$project_id?>'>
                </div> <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Search</button> </td>


        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
                         </form>
                     
                    <?php  
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
        $trainin_id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
	$urlfile="create_card.php"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
		echo "<a  href='$urlfile?id=".$trainin_id."&&s_page=$pPrev".$querystr."' class='naviPN'>Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile?id=".$trainin_id."&&s_page=$i".$querystr."' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile?id=".$trainin_id."&&s_page=$pNext".$querystr."'  class='naviPN'>Next</a>";
	}
}  
$method = isset($_POST['method'])?$_POST['method']:'';
 if($method=='txtKeyword'){
$_SESSION['Keyword_addT']=$_POST['txtKeyword'];
 }
$Search_word= isset($_SESSION['Keyword_addT'])?$_SESSION['Keyword_addT']:'';
 if(!empty($Search_word)){
//คำสั่งค้นหา
     $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname,d.depName as dep from emppersonal e1 
inner JOIN work_history wh ON wh.empno=e1.empno
inner JOIN posid p1 ON p1.posId=wh.posid
inner join pcode p2 on e1.pcode=p2.pcode
inner join department d on d.depId=e1.depid
         WHERE wh.posid=p1.posId and (firstname LIKE '%$Search_word%' or e1.empno LIKE '%$Search_word%' or pid LIKE '%$Search_word%')
             and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w)) and e1.status ='1' order by empno"; 
 }else{
 $q="select e1.empno as empno, e1.pid as pid, concat(p2.pname,e1.firstname,'  ',e1.lastname) as fullname, p1.posname as posname,d.depName as dep from emppersonal e1 
inner JOIN work_history wh ON wh.empno=e1.empno
inner JOIN posid p1 ON p1.posId=wh.posid
inner join pcode p2 on e1.pcode=p2.pcode
inner join department d on d.depId=e1.depid
where wh.posid=p1.posId and e1.status ='1' and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
ORDER BY empno";
 }
$qr=mysqli_query($db,$q);
if($qr==''){exit();}
$total=mysqli_num_rows($qr);
$chk_page=''; 
$e_page=10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
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
                    <form action="card_group.php" method="post" name="form" enctype="multipart/form-data" id="form" target="_blank">
<br>
<div align="center"><input type="submit" name="submit" id="submit" class="btn btn-success" value="ตกลง" ></div>
<br>
                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">
                            <tr align="center" bgcolor="#898888">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="5%">เลือก</th>
                                <th align="center" width="20%">ชื่อ-นามสกุล
                                <th align="center" width="20%">ตำแหน่ง</th>
                                <th align="center" width="20%">หน่วยงาน</th>  
                            </tr>
                            
                            <?php
                             $i=1;
                             $c=0;
while($result=mysqli_fetch_assoc($qr)){?>
    <tr>
                                <td align="center"><?=($chk_page*$e_page)+$i?></td>
                                <td align="center">
                                    <input type="checkbox" name="check_ps[]" id="check_ps[]" value="<?=$c?>" />
                                    <input type="hidden" name="empno[]" id="empno[]" value="<?=$result['empno']?>"
                                </td>
                                <td><?=$result['fullname'];?></td>
                                <td align="center"><?=$result['posname'];?></td>
                                <td align="center"><?=$result['dep'];?></td>
                            </tr>
    <?php $i++;
    $c++; } ?>
                                
                        </table>
<input type="hidden" name="id" value="<?=$Project_detial['tuid']?>">
<input type="hidden" name="method" value="add_pro_trainout">
</form>
<?php if($total>0){
echo mysqli_error($db);

?><BR><BR>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/10)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
                </div>
              </div>
          </div>
</div>
</div>

    <?php include_once 'footeri.php';?>
