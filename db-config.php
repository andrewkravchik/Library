<?php
$db = new mysqli("localhost", "lanc-loc", "fOiu2hIha^Ds", "categoryLibrary");
if ($db->connect_errno) {
    echo "Не удалось подключиться к базе данных: " . $db->connect_error;
    exit();
}

/* изменение набора символов на utf8 */
if (!$db->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $db->error);
    exit();
}