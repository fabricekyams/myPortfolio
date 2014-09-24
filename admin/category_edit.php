<?php
include '../lib/includes.php';
include '../lib/auth.php';
/**
 * Verification du Post
 */
var_dump($_POST);
if (isset($_POST['name']) && isset($_POST['slug'])){
	checkCsrf();
	if (preg_match('/^[a-z\-0-9]+$/', $_POST['slug'])){
		
		$catslug = $db->quote($_POST['slug']);
		$catname = $db->quote($_POST['name']);
		if (isset($_GET['id'])){
			$idget = $_GET['id'];
			$db->query("UPDATE categories SET name = $catname , slug = $catslug WHERE id = $idget");	
		}else{
			$db->query("INSERT INTO categories ( name, slug) VALUES ($catname, $catslug)");
		}
		
		header('Location:category.php');
		die();

	}else {
		setFlash('le slug n\'est pas valide', 'danger');
	}
}

if (isset($_GET['id'])){
	$id= $_GET['id'];
	checkCsrf();
	$query= $db->query("SELECT * FROM categories WHERE id=$id");
	if($query->rowCount()==0){
		setFlash("pas de categorie trouvé ", 'danger');
		header('Location:category.php');
		die();
	}
	$_POST =  $query->fetch();
	var_dump($_POST);
			
}

include '../partials/admin_header.php';
include '../partials/admin_nav.php';
?>


<html>
<h1>Editer une Categorie</h1>
<?= flash(); ?>

<form  action="#" method="post">
<div class="form-group">
       <?= input('name', 'nom de la catégorie')?>
       </div>
       <div class="form-group">
        <?= input('slug', 'URL de la catégorie')?>
       </div>  
       <?= csrfInput(); ?>
       <div class="form-group">
        <button type="submit" name="_submit" class="btn btn-primary">Enregistrer</button>
        </div>
</form>

</html>

<?php include '../partials/footer.php';