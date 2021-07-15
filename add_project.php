<?php include_once 'header.php';?>
<?php if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} 
$method = isset($_POST['method'])?$_POST['method']:isset($_GET['method'])?$_GET['method']:''; 
?>
<script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
        <div class="row">
          <div class="col-lg-12">
              <?php if($method=='edit'){?>
            <h1><font color='blue'>  แก้ไขข้อมูลโครงการ </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_trainin.php"><i class="fa fa-edit"></i> บันทึกการฝึกอบรมภายในหน่วยงาน</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขข้อมูลโครงการ</li>
              <?php }else{?>
            <h1><font color='blue'>  เพิ่มข้อมูลโครงการ </font></h1> 
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มข้อมูลโครงการ</li>
              <?php }?>
            </ol>
          </div>
      </div>
<?php
    if($method=='edit'){
        $edit_id=$_REQUEST['id'];
        $edit_per=  mysqli_query($db,"select * from trainingin t1 
            where t1.idpi='$edit_id'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
    }
?>
<form class="navbar-form navbar-left" role="form" action='prctraining.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">บันทึกประวัติการฝึกอบรมภายในหน่วยงาน</h3>
                    </div>
                <div class="panel-body">
                    <div class="form-group"> 
                        <?php if(!empty($method)){
 			$take_date1=$edit_person['reg_date'];
                        $take_date2=$edit_person['dateBegin'];
                        $take_date3=$edit_person['dateEnd'];
                        }else{
                        $take_date1=date('Y-m-d');     
                        $take_date2=date('Y-m-d'); 
                        $take_date3=date('Y-m-d');
                        }
 		?>
                <script type="text/javascript">
                $(function() {
                $( "#datepicker" ).datepicker("setDate", new Date('<?=$take_date1?>')); //Set ค่าวัน
                $( "#datepicker1" ).datepicker("setDate", new Date('<?=$take_date2?>')); //Set ค่าวัน
                $( "#datepicker2" ).datepicker("setDate", new Date('<?=$take_date3?>')); //Set ค่าวัน
                 });
                </script>
                <label>วันที่เขียนโครงการ &nbsp;</label>
                <input placeholder="รูปแบบ 31/01/2559" type="text" class="form-control" name="reg_date" id="datepicker" onkeydown="return nextbox(event, 'address')" required>
             	</div>
                    <?php if($method=='edit'){?>
                    <div class="form-group"> 
                <label>เลขที่โครงการ &nbsp;</label>
                <input value='<?= isset($edit_person['in1'])?$edit_person['in1']:''?>' type="text" class="form-control" name="project_no" id="project_no" placeholder="เลขที่โครงการ" onkeydown="return nextbox(event, 'cidid')">
                    </div><br><?php }?> 
                    <div class="form-group"> 
                    <label>ชื่อโครงการ &nbsp;</label>
                <input value='<?= isset($edit_person['in2'])?$edit_person['in2']:''?>' type="text" class="form-control" size="100" name="project_name" id="project_name" placeholder="ชื่อโครงการ" onkeydown="return nextbox(event, 'pname')" required>
             	</div><br>
                <div class="form-group"> 
                    <label>หน่วยงานที่จัด &nbsp;</label>
                <input value='<?= isset($edit_person['in3'])?$edit_person['in3']:''?>' type="text" class="form-control"  size="98" name="project_dep" id="project_dep" placeholder="หน่วยงานที่จัด" onkeydown="return nextbox(event, 'pname')" required>
             	</div><br> 
                <div class="form-group">
                <label>วัตถุประสงค์ของโครงการ &nbsp;</label>
             	<TEXTAREA value='' NAME="project_obj" id="project_obj"  cols="50" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?= isset($edit_person['in4'])?$edit_person['in4']:''?></TEXTAREA>
                    </div><br>
                <div class="form-group"> 
                <label>สถานที่จัด &nbsp;</label>
                <input value='<?= isset($edit_person['in5'])?$edit_person['in5']:''?>' type="text" class="form-control" name="project_place" id="project_place" placeholder="สถานที่จัด" onkeydown="return nextbox(event, 'lname')" required>
             	</div>
                    <div class="form-group">
         			<label>จังหวัด &nbsp;</label>
                                <select name="province" id="province" required  class="form-control select2" style="width: 100%" onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM province order by PROVINCE_NAME  ");
				 echo "<option value=''>--เลือกจังหวัด--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['PROVINCE_ID']==$edit_person['in6']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['PROVINCE_ID']."' $selected>".$result['PROVINCE_NAME']." </option>";
				 } ?>
			 </select>
			 </div>
                <div class="form-group">
                    <div class="form-group">
                    <label>ระหว่างวันที่ &nbsp;</label>
                    <input placeholder="รูปแบบ 31/01/2559" type="text" name="Pdates" id="datepicker1" class="form-control" required>
                       </div>                 
                    <div class="form-group">
                        <label>ถึงวันที่ &nbsp;</label>
                        <input placeholder="รูปแบบ 31/01/2559" type="text" name="Pdatee" id="datepicker2" class="form-control" required>
                    </div>
                         </div><br>
                    <div class="form-group"> 
                <label>จำนวนวันที่จัด &nbsp;</label>
                <input value='<?= isset($edit_person['in8'])?$edit_person['in8']:''?>' type="text" class="form-control" name="amountd" id="amountd" placeholder="จำนวนวันที่จัด" onkeydown="return nextbox(event, 'lname')" onKeyUp="javascript:inputDigits(this);" required>
             	</div>
                    <div class="form-group"> 
                <label>จำนวนชั่วโมง &nbsp;</label>
                <input value='<?= isset($edit_person['in9'])?$edit_person['in9']:''?>' type="text" class="form-control" name="amounth" id="amounth" placeholder="จำนวนชั่วโมง" onkeydown="return nextbox(event, 'sex')" onKeyUp="javascript:inputDigits(this);" required>
             	</div>
                <div class="form-group">
         			<label>รูปแบบ &nbsp;</label>
 				<select name="format" id="format" required  class="form-control"  onkeydown="return nextbox(event, 'bday');">
                                    <?php	$sql = mysqli_query($db,"SELECT *  FROM trainingtype order by tName  ");
				 echo "<option value=''>--เลือกรูปแบบ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['tid']==$edit_person['in10']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['tid']."' $selected>".$result['tName']." </option>";
				 } ?>
				 </select>
			 </div>
                    <div class="form-group"> 
                <label>ความพึงพอใจ &nbsp;</label>
                <input value='<?= isset($edit_person['in11'])?$edit_person['in11']:''?>' type="text" class="form-control" name="persen" id="persen" placeholder="ความพึงพอใจ" onkeydown="return nextbox(event, 'address')">
             	</div><br>
                <div class="form-group"> 
                <label>ปัญหาและอุปสรรค &nbsp;</label>
             	<TEXTAREA value='' NAME="barrier" id="barrier"  cols="57" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?= isset($edit_person['in12'])?$edit_person['in12']:''?></TEXTAREA>
             	</div><br>
                <div class="form-group"> 
                <label>แนวทางการขยายผล &nbsp;</label>
             	<TEXTAREA value='' NAME="further" id="further"  cols="55" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?= isset($edit_person['in13'])?$edit_person['in13']:''?></TEXTAREA>
                </div><br>
                <div class="form-group"> 
                <label>ข้อคิดเห็น &nbsp;</label>
             	<TEXTAREA value='' NAME="comment" id="comment"  cols="65" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?= isset($edit_person['in14'])?$edit_person['in14']:''?></TEXTAREA>
                </div><br>
                <?php if($method=='edit'){?>
                <div class="form-group"><label>แนบเอกสาร &nbsp;</label><input type="file" name="image"  id="image" class="form-control"/></div>
                <?php } ?>
                </div>
                </div>


          </div>
</div>
    <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ค่าใช้จ่าย</h3>
                    </div>
                <div class="panel-body">
                    <div class="form-group"> 
                <label>ประมาณการค่าใช้จ่าย &nbsp;</label>
                <input value='<?= isset($edit_person['mp'])?$edit_person['mp']:''?>' type="text" class="form-control" name="cost" id="cost" placeholder="ประมาณการค่าใช้จ่าย" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าอาหาร/อาหารว่างเครื่องดื่ม &nbsp;</label>
                <input value='<?= isset($edit_person['m1'])?$edit_person['m1']:''?>' type="text" class="form-control" name="meals" id="meals" placeholder="ค่าอาหาร/อาหารว่างเครื่องดื่ม" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าวิทยากร &nbsp;</label>
                <input value='<?= isset($edit_person['m2'])?$edit_person['m2']:''?>' type="text" class="form-control" name="expert" id="expert" placeholder="ค่าวิทยากร" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าเดินทาง &nbsp;</label>
                <input value='<?= isset($edit_person['m3'])?$edit_person['m3']:''?>' type="text" class="form-control" name="travel" id="travel" placeholder="ค่าเดินทาง" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                    <div class="form-group"> 
                <label>ค่าวัสดุ &nbsp;</label>
                <input value='<?= isset($edit_person['m4'])?$edit_person['m4']:''?>' type="text" class="form-control" name="material" id="material" placeholder="ค่าวัสดุ" onkeydown="return nextbox(event, 'position')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                  <div class="form-group">
         			<label>แหล่งงบประมาณ &nbsp;</label>
 				<select name="source" id="source" required  class="form-control"  onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM trainingmoney order by id");
				 echo "<option value=''>--เลือกงบประมาณ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['id']==$edit_person['in15']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['id']."' $selected>".$result['name']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group">
         			<label>ประเภทเนื้อหา &nbsp;</label>
 				<select name="type_know" id="type_know" required  class="form-control"  onkeydown="return nextbox(event, 'line');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM traininglevel order by lid");
				 echo "<option value=''>--เลือกเนื้อหา--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['lid']==$edit_person['in16']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['lid']."' $selected>".$result['lname']." </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group">
         			<label>ผู้รับผิดชอบโครงการ &nbsp;</label>
                                <select name="respon" id="respon" required  class="form-control select2" style="width: 100%" onkeydown="return nextbox(event, 'pertype');"> 
				<?php	$sql = mysqli_query($db,"select concat(firstname,' ',lastname) as fullname,empno  FROM emppersonal order by firstname");
				 echo "<option value=''>--เลือกรายชื่อ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$edit_person['adminadd']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname']." </option>";
				 } ?>
			 </select>
			 </div><br>
                 <div class="form-group"> 
                <label>หมายเหตุ &nbsp;</label>
             	<TEXTAREA value='' NAME="note" id="note"  cols="65" rows="" class="form-control" onkeydown="return nextbox(event, 'movedate')"><?= isset($edit_person['in18'])?$edit_person['in18']:''?></TEXTAREA>
                </div>
                    
                </div>
              </div>
          </div>
</div>
    <?php if($method=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person['idpi'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="add_trainin">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }?>
</form>
<?php include_once 'footeri.php';?>         