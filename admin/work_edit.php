<?php
include '../lib/includes.php';

/**
 * Verification du Post
 */

$imgs= array();
if (isset($_POST['name']) && isset($_POST['slug'])){
	/**echo 'POST: ';
	var_dump($_POST);
	echo  'FILES';
	var_dump($_FILES);*/
	
	checkCsrf();
	
	
	if (preg_match('/^[a-z\-0-9]+$/', $_POST['slug'])){
		
		$workslug = $db->quote($_POST['slug']);
		$workname = $db->quote($_POST['name']);
		$workcontent = $db->quote($_POST['content']);
		$workcatid = $db->quote($_POST['cat_id']);
		
		/**
		 * SAVE WORK
		 */	
		if (isset($_GET['id'])){
			$idget = $_GET['id'];
			$db->query("UPDATE works SET name = $workname , slug = $workslug, content = $workcontent, cat_id=$workcatid   WHERE id = $idget");	
			$_POST['workid'] = $idget;
		}else{
			$db->query("INSERT INTO works ( name, slug , content, cat_id) VALUES ($workname, $workslug, $workcontent, $workcatid)");
			$_POST['workid'] = $db->lastInsertId();
			var_dump($_POST['workid']);
		}
		
		$workid = $_POST['workid'];
		var_dump($workid);

		/**
		 * SEND IMAGES
		 */
		$imageFile = $_FILES['image'];
		$images = array();
		foreach ($imageFile['tmp_name'] as $k =>$v){
			if (!empty($v)){
				$images= array(
						'name'=> $imageFile['name'][$k],
						'tmp_name' => $imageFile['tmp_name'][$k]
				);
				
				$extension = pathinfo($images['name'],PATHINFO_EXTENSION);
				$imgname = $images['name'];
				if (in_array($extension, array('jpg','png'))){
					$db->query("INSERT INTO images (name, work_id) VALUES ('none', $workid)");
					$imageid = $db->lastInsertId();
					move_uploaded_file($images['tmp_name'], IMAGE . 'works/'.$imageid.'.'.$extension);
					$imgname = $imageid.'.'.$extension;
					$db->query("UPDATE images SET name='$imgname' WHERE id = $imageid ");
				}
				
				//
				//die();
					
			}
		} 
		header('Location:work.php');
		die();
	}else {
		setFlash('le slug n\'est pas valide', 'danger');
	}
}

if (isset($_GET['id'])  ){
	
	$id= ($_GET['id']);
	
	checkCsrf();
	$query= $db->query("SELECT * FROM works WHERE id=$id");
	if($query->rowCount()==0){
		setFlash("pas de projets trouvé ", 'danger');
		header('Location:work.php');
		die();
	}
	$_POST =  $query->fetch();
	
	$selectimg= $db->query("SELECT id, name FROM images WHERE work_id=$id");
	$imgs = $selectimg->fetchAll();
			
}
if (isset($_GET['del_image'])){
	checkCsrf();
	unlink(IMAGE.'/works/'.$_GET['imgname']);
	$id = $db->quote($_GET['del_image']);
	$imgworkid = $db->query("SELECT work_id FROM images WHERE id = $id")->fetch();
	$db->query("DELETE FROM images WHERE id = $id");
	header('Location:work_edit.php?id='.$imgworkid['work_id'].'&'.csrf());
	die();

}

$selects = $db->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll();
$cats = array();
foreach ($selects as $select){
	$cats[$select['id']]=$select['name'];
} 



include '../partials/admin_header.php';
include '../partials/admin_nav.php';
?>


<html>
<h1>Editer un Projets</h1>
<?= flash(); ?>
<div class="row">
	<div class="col-md-8">
		<form  action="#" method="post" enctype="multipart/form-data">
				<div class="form-group">
		      		 <?= input('name', 'nom du projet')?>
		       </div>
		       <div class="form-group">
		       		 <?= input('slug', 'URL du projet')?>
		       </div>
		       <div class="form-group">
		        		<?= textarea('content', 'Description projet'); ?>
		       </div>  
		        <div class="form-group">
		        	<?= selectbox('cat_id', $cats); ?>
		       </div>   
		       	<?= csrfInput(); ?>
		       <div class="form-group">
		              
			       <input type="file" name="image[]"  >
			       <input type="file" name="image[]" class="hidden" id="duplicate">
			       <a href="#" class="btn btn-info" id="duplicate-btn">Ajouter une image</a>
		       </div>   
		       <div class="form-group">
		        	<button type="submit" name="_submit" class="btn btn-primary">Enregistrer</button>
		        </div>
		</form>
	</div>
	<div class="col-md-4">
		<?php foreach ($imgs as $img):?>
			<a href="?del_image=<?= $img['id']?>&<?=csrf()?>&imgname=<?=$img['name']?>" onclick="return confirm('DELETE: SUR?')"><img src="<?= WEBROOT;?>img/works/<?=$img['name']?>" alt="" class="img-thumbnail" /></a>	
		<?php endforeach;?>
	</div>
</div>


</html>

<?php 
ob_start();?>
<script type="text/javascript">
(function($){
	$("#duplicate-btn").click(function(e){
		e.preventDefault();
		var clone = $('#duplicate').clone().attr('id','').removeClass('hidden');
		console.log(clone);
		$('#duplicate').before(clone);
		})
})(jQuery);
</script>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<!--<script type="text/javascript">

tinymce.init({
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});//
</script>-->
<?php $script = ob_get_clean()?>


<?php include '../partials/footer.php';
include '../lib/debug.php';?>