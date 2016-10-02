<?php

  // Устанавливаем соединение с базой данных
  include "../config.php";
/** Проверка пользователя на администратора */
if(isAdmin() == 0) links('Недоступный раздел');
  /** Так как для исправления мы будет использовать
  * форму добавления новостей, необходимо соответствующим
  * образом настроить управляющие переменные. */
  $titlepage = "Редактирование новости";
  $button = "Исправить";
  $action = "editnews.php";

  /** Извлекаем из таблицы news запись, соответствующую
  * исправляемой новостной позиции */
  $query = "SELECT * FROM news 
            WHERE id_news=".$_GET['id_news'];
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
  $_GET['id_news'] = $row['id_news'];
  /** Определяем скрыто поле или нет */
  if($row['hide'] == 'show') $showhide = "checked";
  else $showhide = "";

  /** Включаем редактирование */
  define("EDIT",1);
  /** Включаем HTML-форму в полях, которой будут размещены
  * редактируемая информация из таблицы news */
  include "addnewsform.php";
?>