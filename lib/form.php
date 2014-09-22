<?php
function input($id,$placeholder,$type = 'text'){
	$value= isset($_POST[$id]) ? $_POST[$id] : '';  
	return "<input name='$id' type='$type'  id='$id' required='required' placeholder='$placeholder' class='form-control' value='$value'>";
}

function textarea($id,$placeholder,$row = 10 ){
	$value= isset($_POST[$id]) ? $_POST[$id] : '';
	return "<textarea name='$id'  id='$id' required='required' placeholder='$placeholder' class='form-control' rows= '$row' value='$value'>$value</textarea>";
}

function selectbox($id, $cats = array()){
	$return = "<select id = '$id' name ='$id' class='form-control'>\n";
	foreach ($cats as $catid => $value){
		$select = '';
		if (isset($_POST['cat_id']) && $catid == $_POST['cat_id']){
			$select = "selected='selected'";
		}
		$return .=  "<option value='$catid' $select >$value</option>\n";
	}
	$return .= "</select>";
	return $return;
}