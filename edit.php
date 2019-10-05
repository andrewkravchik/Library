<?php
include 'header.php';
include 'db-config.php';

?>

<p>
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>" title="Вернуться к выбору категории в библиотеке">
		<button type="button" class="btn btn-lg btn-default">Библиотека</button>
	</a>
</p>

 <form method="post" id="newbook" action="get-new.php">
  <div class="form-group">
  	<label for="genre">Выберите категорию</label>
	<select class="form-control" id="genre" name="category_id">
	<?php if ($result = $db->query("SELECT * FROM `lc_categories`")):?>
				<option selected="selected">--Выберите категорию книг--</option>
			<?php while($row = $result->fetch_assoc()):
	?>
	  			<option value="<?php echo $row['category_id'] ?>"><?php echo $row['name'];?></option>
	  
	  <?php
	  		endwhile;
		  endif;
	  ?>
	</select>
  </div>
</form> 

<div id="result" class="alert alert-info invisible" role="alert"></div>


<?php
include 'footer.php';
?>