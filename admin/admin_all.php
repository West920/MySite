<?php
  /** Устанавливаем соединение с базой данных */
  require_once("../config.php");

  /** Проверяем параметр id_news, предотвращая SQL-инъекцию */
  if(!preg_match("|^[\d]+$|",$_POST['id_news'])) exit("Ошибка при обращении к блоку новостей");

  if(isset($_POST['delete']))
  {
    $new = R::load('news', $_POST['id_news']);
    if(!$new) exit("Ошибка запроса к таблице новостей...");
    if(is_file("../".$new->url_pict)) @unlink("../".$row['url_pict']);
    /** Формируем и выполянем SQL-запрос на удаление записи в таблице news  */
    $query = "DELETE FROM news WHERE id_news=".$_POST['id_news'];
    if(query($query)) header("Location: ".constant("Main_url")."index.php");
  }

  if(isset($_POST['hide']))
  {
    $query = "UPDATE news SET hide='hide' 
            WHERE id_news=".$_POST['id_news'];
  if(query($query)) header("Location: ".constant("Main_url")."index.php");

  }

  if(isset($_POST['edit']))
  {
        if(isAdmin() == 0) exit('Недоступный раздел');
        /** Так как для исправления мы будет использовать
        * форму добавления новостей, необходимо соответствующим
        * образом настроить управляющие переменные. */
        $titlepage = "Редактирование новости";
        $button = "Исправить";
        $action = "editnews.php";

        /** Извлекаем из таблицы news запись, соответствующую
        * исправляемой новостной позиции */
        $query = "SELECT * FROM news 
                  WHERE id_news=".$_POST['id_news'];
        $row = one($query);
        if(!$row) links("Ошибка запроса к таблице новостей...");

        /** Берём информацию для оставшихся переменных из базы данных */
        $name = $row['name'];
        $body = $row['body'];
        $url_pict = $row['url_pict'];
        $preview = $row['preview'];
        $date_month = substr($row['putdate'],5,2);
        $date_day = substr($row['putdate'],8,2);
        $date_year = substr($row['putdate'],0,4);
        $date_hour = substr($row['putdate'],11,2);
        $date_minute = substr($row['putdate'],14,2);
        $_POST['id_news'] = $row['id_news'];
        /** Определяем скрыто поле или нет */
        if($row['hide'] == 'show') $showhide = "checked";
        else $showhide = "";

        /** Включаем редактирование */
        define("EDIT",1);
        /** Включаем HTML-форму в полях, которой будут размещены
        * редактируемая информация из таблицы news */
        include "addnewsform.php";
  }

  if(isset($_POST['delete_comm']))
  {
    $comm = R::load('comments', $_POST['id_comm']);
    if(!$comm) exit("Ошибка запроса к таблице новостей...");
    $query = "DELETE FROM comments WHERE id=".$_POST['id_comm'];
    if(query($query)) header("Location: ".constant("Main_url")."news.php?id_news=".$_POST['id_news']);
  }
  
?>