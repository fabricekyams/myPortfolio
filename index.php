<?php include 'lib/includes.php';?>
<?php include 'partials/header.php';?>
<?php include 'partials/nav.php';

flash(); 


$slect = $db->query("
		SELECT works.id, works.name, works.slug, images.name as imgname, categories.name as catname
		FROM works 
		LEFT JOIN images
		ON works.img_id = images.id 
		LEFT JOIN  categories 
		ON works.cat_id = categories.id");
$works =  $slect->fetchAll();
?>

<html>
 <h1>Mon Portfolio</h1>
 
 <div class="row">
 <?php foreach ($works as $work ):?>
  <div class=" col-sm-6 col-md-4">
    <div class="thumbnail">
     <a href="view.php?id=<?=$work['id'];?>&<?=csrf(); ?>"> 
      <img src="<?=WEBROOT?>img/works/<?=$work['imgname']?>"  data-src="holder.js/100%x200" alt="..." style="height: 200px; width: 100%; display: block;">
      <div class="caption">
      <span class="skills" ><?=$work['catname']; ?></span>
        <h3><?=$work['name']; ?></h3>       
      </div>
      </a>
    </div>
  </div>
  <?php endforeach;?>
</div>

</html>

<?php include 'partials/footer.php';?>