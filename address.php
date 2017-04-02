<?php //include'connection/connect_i.php';?>
	<script language="JavaScript">

function Check_txt(){
	if(document.getElementById('province').value==""){
		alert("กรุณาระบุ จังหวัด ด้วย");
		document.getElementById('province').focus();
		return false;
	}
	if(document.getElementById('amphur').value=='No'){
		alert("กรุณาระบุ อำเภอ ด้วย");
		document.getElementById('amphur').focus();
		return false;
	}
	
	if(document.getElementById('district').value==""){
		alert("กรุณาระบุ ตำบล ด้วย");
		document.getElementById('district').focus();
		return false;
	}
}
</script>
    <div class="form-group"> 
                    <label>จังหวัด &nbsp;</label>
                    <select class="form-control select2" style="width: 100%" name='province' id='province' onchange="data_show(this.value,'amphur');">
		<option value="">---โปรดเลือกจังหวัด---</option>
		<?php
		$rstTemp=mysqli_query($db,'select * from province Order By PROVINCE_NAME ASC');
		while($arr_2=mysqli_fetch_array($rstTemp)){
                    if($arr_2['PROVINCE_ID']==$edit_person['provice']){$selected='selected';}else{$selected='';}
		
		echo "<option value='".$arr_2['PROVINCE_ID']."' $selected>".$arr_2['PROVINCE_NAME']."</option>";
		}?>
	</select>
    </div>
        <div class="form-group">
        <label>อำเภอ &nbsp;</label>
	<select class="form-control" name='amphur' id='amphur'onchange="data_show(this.value,'district');">
            <?php if(isset($_REQUEST['method'])=='edit'){
                $rstTemp = mysqli_query($db,"select * from amphur where AMPHUR_ID='".$edit_person['empure']."'");
                while ($arr_2 = mysqli_fetch_array($rstTemp)){
                if($arr_2['AMPHUR_ID']==$edit_person['empure']){$selected='selected';}else{$selected='';}
                echo "<option value='".$arr_2['AMPHUR_ID']."' $selected>".$arr_2['AMPHUR_NAME']."</option>";
                
                } }  else {?>
            <option value="">---โปรดเลือกอำเภอ---</option>
            <?php }?>
	</select>
	</div>
        <div class="form-group">
        <label>ตำบล &nbsp;</label>  
	<select class="form-control" name='district' id='district'>
            <?php if($_REQUEST['method']=='edit'){
                $rstTemp = mysqli_query($db,"select * from district where DISTRICT_ID='".$edit_person['tambol']."'");
                while ($arr_2 = mysqli_fetch_array($rstTemp)){
                if($arr_2['DISTRICT_ID']==$edit_person['tambol']){$selected='selected';}else{$selected='';}
                echo "<option value='".$arr_2['DISTRICT_ID']."' $selected>".$arr_2['DISTRICT_NAME']."</option>";
                
                } }  else {?>
		<option value="">---โปรดเลือกตำบล---</option>
                <?php }?>
	</select>
        </div>

<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(select_id,result){
	var url = 'address2.php?select_id='+select_id+'&result='+result;
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	document.getElementById(result).innerHTML =  xmlhttp.responseText;
}
//window.onLoad=data_show(5,'amphur'); 
</script>

