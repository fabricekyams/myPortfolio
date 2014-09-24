<?php  

$auth = 0;
include 'lib/includes.php';
 /**
  * FORMULAIRE
  */
echo flash();
if (isset($_POST['username']) && isset($_POST["password"])){
	$password = sha1($_POST['password']);
	$query = $db->query("SELECT * FROM user WHERE username={$db->quote($_POST['username'])} AND password ='$password'");
	if ($query->rowCount()>0){	
		$_SESSION['Auth'] = $query->fetch();
		setFlash("Vous ête bien connecté");
		header('Location:' . WEBROOT.'admin/index.php');
		die();
	}
	setFlash('Mot de passe ou login incorrecr','danger');
}

/**
 * INCLUSION HEADER
 */

 include 'partials/header.php';
?>
<div class="blck form-signin">
<form class=" " action="#" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?= input('username', "nom utilisateur")?>
        <?= input('password', 'mot de passe','password')?>
        <label class="checkbox">
          <input type="checkbox" name="_remember_me" value="on""> Remember me
        </label>
        <button type="submit" name="_submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
</form>
</div>

<?php include 'partials/footer.php';