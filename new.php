<?php
include 'header.php';
include 'db-config.php';

?>

<p>
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>" title="Вернуться к выбору категории в библиотеке">
		<button type="button" class="btn btn-lg btn-default">Библиотека</button>
	</a>
</p>

 <form method="post" id="newbook" action="post-new.php">
  <div class="form-group">
  	<label for="genre">Категория:</label>
	<select class="form-control" id="genre" name="category_id">
	<?php if ($result = $db->query("SELECT * FROM `lc_categories`")):
			while($row = $result->fetch_assoc()):
	?>
	  			<option value="<?php echo $row['category_id'] ?>"><?php echo $row['name'];?></option>
	  
	  <?php
	  		endwhile;
		  endif;
	  ?>
	</select>
  </div>
  <div class="form-group">
    <label for="author">Автор:</label>
    <input type="text" class="form-control" id="author" name="author"/>
  </div>
  <div class="form-group">
    <label for="publisher">Издатель:</label>
    <input type="text" class="form-control" id="publisher" name="publisher"/>
  </div>
  <div class="form-group">
    <label for="book_name">Название книги:</label>
    <input type="text" class="form-control" id="book_name" name="book_name"/>
  </div>
  <!-- <div class="form-group">
    <label for="year">Год издания (начиная с 1901):</label>
    <input type="datetime-local" min="1901-01-01T00:00" max="2155-01-01T00:00" id="year" name="year"/>
  </div> -->
  <div class="form-group">
    <label for="year">Год издания (начиная с 1901):</label>
    <input type="text" id="year" name="year"/>
  </div>
  <div class="form-group">
    <label for="summary">Краткое содержание:</label>
    <input type="text" class="form-control" id="summary" name="summary"/>
  </div>
  <div class="form-group">
	<input type="submit" class="btn btn-default" name="submit" value="Создать"/>
  </div>
</form> 

<div id="result" class="alert alert-info invisible" role="alert"></div>


<?php
include 'footer.php';
?>