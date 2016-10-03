<?php
  /** Устанавливаем соединение с базой данных */
  require_once("../config.php");

		$comm = R::load('comments', $_POST['id_comm']);
    if(!$comm) exit("Ошибка запроса к таблице новостей...");
    $query = "DELETE FROM comments WHERE id=".$_POST['id_comm'];
    query($query);