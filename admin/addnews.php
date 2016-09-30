<?php

  /** Устнавливаем соединение с базой данных */
  include "../config.php";

/** Проверяем пользователь администратор? */
    if(isAdmin() == 0) links('Недоступный раздел');

  /** Проверим - достаточно ли информации для занесения в базу данных */
  if(empty($_POST['name'])) links("Отсутствует заголовок");
  if(empty($_POST['body'])) links("Содержание не введено");

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
      /** Формируем путь к файлу */
      $path = "files/".date("YmdHis",time());
      /** Если оператор пожелал переименовать файл - переименовываем */
      if($_POST['chk_rename'] == "on")
      {
        /** Проверяем, чтобы не было прямых и обратных слешей */
        $_POST['rename'] = str_replace("\\","",$_POST['rename']);
        $_POST['rename'] = str_replace("/","",$_POST['rename']);
        $_POST['rename'] = stripcslashes($_POST['rename']);
        $path = "files/".substr($_POST['rename'], 0, strrpos($_POST['rename'], ".")); 
      }
        /** Проверяем размеры загружаемого изображения */
        $infimg = getimagesize($_FILES['filename']['tmp_name']);
        if($infimg[0] > 300 or $infimg[1] > 300) links("Большой размер изображения");

      /** Проверяем, не является ли файл скриптом PHP или Perl, html, если это так преобразуем его в формат .txt */
      $extentions = array("#\.php#is",
                          "#\.phtml#is",
                          "#\.php3#is",
                          "#\.html#is",
                          "#\.htm#is",
                          "#\.hta#is",
                          "#\.pl#is",
                          "#\.xml#is",
                          "#\.inc#is",
                          "#\.shtml#is", 
                          "#\.xht#is", 
                          "#\.xhtml#is");
      /** Извлекаем из имени файла расширение */
      $ext = strrchr($_FILES['filename']['name'], "."); 
      $add = $ext;
      foreach($extentions AS $exten) 
      {
        if(preg_match($exten, $ext)) $add = ".txt"; 
      }
      $path .= $add; 
  
      /** Перемещаем файл из временной директории сервера в
      * директорию /files Web-приложения */
      if (copy($_FILES['filename']['tmp_name'], "../".$path))
      {
        /** Уничтожаем файл во временной директории */
        @unlink($_FILES['filename']['tmp_name']);
        /** Изменяем права доступа к файлу */
        @chmod("../".$path, 0644);
      }
    }
    else links("Не указан файл для загрузки");
  } 

  /** Формируем и выполняем SQL-запрос на добавление новости */
  $query = "INSERT INTO news VALUES (0,
                                     '".$_POST['name']."',
                                     '".$_POST['body']."',
                                     '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                                     '$path',
                                     '$showhide');";
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else links("Ошибка при добавлении новостной позиции");
?>