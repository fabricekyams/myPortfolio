<?php
include '../lib/includes.php';
include '../partials/admin_header.php';
include '../partials/admin_nav.php';

/**
 * VERIFICATION SUPPRESSION
 */

if (isset($_GET['delete'])){
	checkCsrf();
	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM works WHERE id = $id");
}

$query = $db->query('SELECT id, name, slug FROM works');
$works = $query->fetchAll();
$count = 0;
?>
<html>
<h1>Mes Projets</h1>
<?= WEBROOT?>
<table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>id</th>
          <th>name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($works as $work):?>
        	<tr>
	          <td><?= ++$count; ?></td>
	          <td><?= $work['id'];?></td>
	          <td><?= $work['name']?></td>
	          <td>
	          	<a href="work_edit.php?id=<?=$work['id'] ?>&<?=csrf() ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
	          	<a href="?delete=<?= $work['id']?>&<?=csrf() ?>" class="btn btn-danger" onclick="return confirm('ETES VOUS SUR?')"><span class="glyphicon glyphicon-trash"></span></a>
	          	</td>
	        </tr>   
        <?php endforeach;?>
       <tr>
       <td><a href="work_edit.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ajouter un projet</a ></td>
       </tr>
      </tbody>
    </table>
</html>

<?php include '../partials/footer.php';include '../lib/debug.php';?>