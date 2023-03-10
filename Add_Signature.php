<?php include_once 'header.php';?>
<?php  if(empty($_SESSION['user'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
 <script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
  <!--<script language="javascript">
function fncSubmit()
	{
	 if(document.form1.name_dep.value=='')
		{
			alert('กรุณากรอกชื่อฝ่าย/ศูนย์/กลุ่มงาน');
			document.form1.name_dep.focus();		
			return false;
		}else{	
			return true;
			document.form1.submit();
		}
}
</script>-->
 <div class="row">
          <div class="col-lg-12">
            <h1><font color="blue">เพิ่มลายเซ็นต์</font></h1>
            <ol class="breadcrumb alert-success">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> เพิ่มลายเซ็นต์</li>
            </ol>
          </div>
        </div><!-- /.row -->
    <div class="row">
    <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มลายเซ็นต์</h3>
                    </div>
                  <div class="panel-body">
                  <div class='row'>
                       <div class="col-lg-12">       
                           <form name='form2' class="navbar-form navbar-left"  action='prcsign.php' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                    		       <div class="form-group">	
			<label>บุคลากร </label>
                        <select name="empno" id="empno" required  class="form-control select2" style="width: 100%" onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysqli_query($db,"SELECT empno,concat(firstname,' ',lastname) as fullname  FROM emppersonal order by empno ");
				 echo "<option value=''>-เลือกบุคลากร-</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$resultGet['manager']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname']."</option>";
				 } ?>
			 </select>

			 </div><br><br> 
                <div class="form-group">
                <label>ลายเซ็นต์ &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control"/>
                    </div>
			  <br><br>
		<input type='hidden' name='method' value='update_sign'>
                <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>

		</form>
	  </div></div>
    <div class='row'><div class='col-lg-12' id='TB01'> </div></div>
                  </div>
                  </div>
        </div>
    </div>
      <!--  row of columns -->
      <script type="text/javascript">
            $(function () {

              $("#TB01").html('<center><i class="fa fa-spinner fa-pulse" style="font-size:48px"></i></center><br>');
    var column1 = ["เลขที่", "ชื่อ - นามสกุล","ลายเซ็นต์","รูป"];
    $("#TB01").addClass("table-responsive");
    var CTbPL = new createTableAjax();
    CTbPL.GetNewTableAjax('TB01','JsonData/DT_Sign.php?','../back/API/tempSendDataAPI.php',column1
    ,null,null,null,null,false,false,null,false,null,true,'popup/Pis_Sign.php',null,null,null,null,'dynamic-table');

              // var column = ['ลำดับ','ชื่อ - สกุล'];
              // var data = [{no:'1',name:'สมชาย'},{no:'2',name:'สมหญิง'}];
              // var CTbSt = new createTable(column);
              // CTbSt.GetHead();
              // CTbSt.GetTable(data,'TB01');
            });
            </script>
 <?PHP include_once 'footeri.php';  ?>
