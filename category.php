<?php
include 'header.php';
include 'db-config.php';
?>
<p>
	<a href="<?php echo 'http://' . $_SERVER['SERVER_NAME']; ?>" title="Вернуться к выбору категории в библиотеке">
		<button type="button" class="btn btn-lg btn-default">Библиотека</button>
	</a>
</p>
<?php
if(isset($_GET['ncat'])):
	$categoryId = (int) ($_GET['ncat']);

	/* подготавливаемый запрос - подготовка */
	if (!($stmt = $db->prepare("SELECT
		lc_categories.name as 'category_name',
	    lc_books.name as 'book_name',
	    lc_authors.name as 'author_name',
	    lc_publishers.name as 'publisher_name',
	    lc_books.year as 'publish_year',
	    lc_books.summary
	FROM lc_books
	JOIN lc_categories
		ON lc_books.category_id = lc_categories.category_id
	JOIN lc_authors
		ON lc_books.author_id = lc_authors.author_id
	JOIN lc_publishers
		ON lc_books.publisher_id = lc_publishers.publisher_id
	WHERE lc_books.category_id = (?)"))) {
	    echo "Не удалось подготовить запрос: (" . $db->errno . ") " . $db->error;
	    exit();
	}

	/* Привязка и выполнение */
	if (!$stmt->bind_param("i", $categoryId)) {
	    echo "Не удалось привязать параметры: (" . $stmt->errno . ") " . $stmt->error;
	    exit();
	}

	if (!$stmt->execute()) {
	    echo "Не удалось выполнить запрос: (" . $stmt->errno . ") " . $stmt->error;
	    exit();
	}

	$res = $stmt->get_result();

	if($res->num_rows != 0):	
		while($row = $res->fetch_assoc()):
?>
			<div class="panel panel-default">
				<div class="panel-heading">
				  <h3 class="panel-title text-center"><span class="badge">Название</span>:<?php echo $row['book_name'] ?></h3>
				</div>
				<div class="panel-body">
				    

			      <div class="jumbotron">

			      	<div class="row">
			        <div class="col-md-4">
			        	<p><span class="badge">Категория</span>: <?php echo $row['category_name'] ?></p>
			        	<p><span class="badge">Автор</span>: <?php echo $row['author_name'] ?></p>
				        <p><span class="badge">Издательство</span>: <?php echo $row['publisher_name'] ?></p>
				        <p><span class="badge">Год издания</span>: <?php echo $row['publish_year'] ?></p>
			        </div>
			        <div class="col-md-8">
			        	<p><span class="badge">Краткое содержание</span>:<?php echo $row['summary'] ?></p>
			    	</div>
			      	</div>

			        
			      </div> 

				</div>
			</div>
	<?php
		endwhile;
	else:
?>
		<div class="alert alert-info" role="alert">
		    В этой категории еще нет книг
		</div>
<?php
	endif;
	$res->close();

	?>

<?php
endif;
$db->close();
include 'footer.php';
?>