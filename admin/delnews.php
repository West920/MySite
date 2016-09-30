<?php
  /** Устанавливаем соединение с базой данных */
  require_once("../config.php");

  /** Проверяем параметр id_news, предотвращая SQL-инъекцию */
  if(!preg_match("|^[\d]+$|",$_GET['id_news'])) puterror("Ошибка при обращении к блоку новостей");

  /** Если новостная позиция имела изображение - удаляем его */
  $query = "SELECT * FROM news 
            WHERE id_news=".$_GET['id_news'];
  $row = one($query);
  if(!$row) puterror("Ошибка запроса к таблице новостей...");
  if(is_file("../".$row['url_pict'])) @unlink("../".$row['url_pict']);

  /** Формируем и выполянем SQL-запрос на удаление записи в таблице news  */
  $query = "DELETE FROM news WHERE id_news=".$_GET['id_news'];
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else puterror("Ошибка при обращении к блоку новостей");
?>