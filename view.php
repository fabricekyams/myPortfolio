<?php 
include 'lib/includes.php';



if (isset($_GET['id'])){
	$id = $_GET['id'];
	$select = $db->query("SELECT works.id, works.name, works.slug, works.content, images.name as imgname, categories.name as catname
			FROM works
			LEFT JOIN images
			ON works.img_id = images.id
			LEFT JOIN  categories
			ON works.cat_id = categories.id
			WHERE works.id = $id");
	$works =  $select->fetch();

	$selectimg= $db->query("SELECT id, name FROM images WHERE work_id=$id");
	$imgs = $selectimg->fetchAll();
} else {
	header('HTTP/1.1 301 Moved Permanently');
	header("Location:index.php");
}

 include 'partials/header.php';
 include 'partials/nav.php';?>
 
 <html>
 
 <div class=" row blck head">
 <div class="col-md-11">
 <h2 class=""><?=$works['name']?></h2>
 
 <p> <?=$works['content']?></p>
 <span class="skills" ><?=$works['catname']; ?></span>
 
 
 <?php foreach ($imgs as $img):?>
 <div class=" blck row">
 <div class="">
 <div class=" col-md-6">
	 	
	 		<div class="thumbnail">
		      <img alt="" src="<?=WEBROOT ?>img/works/<?=$img['name']?>">

		    </div>
	 	
 	</div>
 	<div class="col-md-6">
 		<p>NOTHING YET</p>
 	</div>
 	
 	</div>
 	
 	</div>
 <?php endforeach;?>	
 </div>
  
 </div>
 
 </html>

