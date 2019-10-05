<?php
//include 'header.php';
include 'db-config.php';
//$error = false;
$data = [];

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

if( is_ajax() ){

	if(empty($_POST['category_id']) || empty($_POST['author']) || empty($_POST['publisher']) || empty($_POST['book_name']) ||
		empty($_POST['year']) || empty($_POST['summary'])){

		//header("Content-type:application/json;charset=utf-8");
		header('HTTP/1.1 422 Unprocessable Entity (Please,fill all fields)');
		$data['message'] = 'Заполните все поля';
		echo json_encode($data);
		//echo $data['message'];
		exit();

	} else {

		$category_id = (int) $_POST['category_id'];
		$author 	 = $db->real_escape_string($_POST['author']);
		$publisher 	 = $db->real_escape_string($_POST['publisher']);
		$book_name 	 = $db->real_escape_string($_POST['book_name']);
		$year 		 = (int) $_POST['year'];
		$summary 	 = $db->real_escape_string($_POST['summary']);

		$duplicate = $db->query("SELECT COUNT(*) as CNT FROM lc_books WHERE lc_books.name='" . $book_name . "'");
	
		if( (int)$duplicate->fetch_assoc()['CNT'] > 0 ){
			$data['message'] = 'Такая книга уже есть в библиотеке';
			
			header("Content-type:application/json;charset=utf-8");
			header('HTTP/1.1 422 Unprocessable Entity (This book is already exist)');
			echo json_encode($data);
			//echo $data['message'];
			exit();

		} else {

			if (!($stmt = $db->multi_query("START
				TRANSACTION;
				INSERT INTO lc_authors (name) VALUES('" . $author . "');
				SET @author_id = LAST_INSERT_ID();
				INSERT INTO lc_publishers (name) VALUES('" . $publisher . "');
				SET @publisher_id = LAST_INSERT_ID();
				INSERT INTO lc_books (category_id, author_id, publisher_id, name, year, summary)
				VALUES (" . $category_id . ", @author_id, @publisher_id, '" . $book_name . "', " . $year . ", '" . $summary . "');
				COMMIT;"))) {

			    $data['message'] = "Не удалось добавить книгу: (" . $db->errno . ") " . $db->error;
				header("Content-type:application/json;charset=utf-8");
				header('HTTP/1.1 422 Unprocessable Entity (We can\'t add this book now in the data base)');
				echo json_encode($data);
				//echo $data['message'];
				exit();
			}
			$data['message'] = 'Ваша книга добавлена';

			header("Content-type:application/json;charset=utf-8");
			header('HTTP/1.1 200 OK (We just saving now your book)');
			echo json_encode($data);
			//echo $data['message'];
		}
	}
} else {
	echo 'Это не ajax запрос';
}