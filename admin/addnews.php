<?php

  /** Устнавливаем соединение с базой данных */
  include "../config.php";

/** Проверяем пользователь администратор? */
    if(isAdmin() == 0) links('Недоступный раздел');

  /** Проверим - достаточно ли информации для занесения в базу данных */
  if(empty($_POST['name'])) links("Отсутствует заголовок");
  if(empty($_POST['body'])) links("Содержание не введено");
  if(empty($_POST['preview'])) links("Содержание не введено");

  /** Определяем, скрыта новоть или нет */
  if($_POST['hide'] == "on") $showhide = "show";
  else $showhide = "hide";

  /** Проверяем время */
  if(!preg_match("|^[\d]+$|",$_POST['date_year'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_month'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_day'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_hour'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_minute'])) links("Ошибка при обращении к блоку новостей");


  /** Если поле выбора картинки не пустое - закачиваем её на сервер */
  $path = "";
  /** Если требуется загрузить файл - загружаем */
  if($_POST['chk_filename'] == "on")
  {
    if (!empty($_FILES['filename']['tmp_name']))
    {
      $foo = new Upload($_FILES['filename']); 
        if ($foo->uploaded) 
        {
           $foo->file_new_name_body = '2news';
           $foo->image_resize = true;
           $foo->image_ratio = true;
           $foo->image_ratio_x  = true;
           $foo->image_convert = jpg;
           $foo->image_y = 300; 
           $foo->Process('../files/');
           $path = str_replace('\\','/',$foo->file_dst_pathname);
        }
    }
  } 

  /** Формируем и выполняем SQL-запрос на добавление новости */
  $query = "INSERT INTO news VALUES (0,
                                     '".$_POST['name']."',
                                     '".$_POST['preview']."',
                                     '".$_POST['body']."',
                                     '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                                     '$path',
                                     '$showhide');";
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else links("Ошибка при добавлении новостной позиции");
?>