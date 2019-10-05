<?php
include 'header.php';
include 'db-config.php';

if ($result = $db->query("SELECT * FROM `lc_categories`")):

?>

<ul class="list-group">

<?php
	while($row = $result->fetch_assoc()):
?>
		<li class="list-group-item"><a href="category.php?ncat=<?php echo $row['category_id'];?>"><?php echo $row['name'];?></a></li>
<?php
	endwhile;

	$result->close();

endif;
?>
<div class="add_botton_block">
    <a href="new.php" title="Добавить новую книгу в библиотеку">
        <button type="button" class="btn btn-lg btn-default">Добавить книгу</button>
    </a>
    <a href="edit.php" title="Добавить новую книгу в библиотеку">
        <button type="button" class="btn btn-lg btn-default">Редактировать книгу</button>
    </a>
</div>
<?php
	$db->close();
    include 'footer.php';
?>