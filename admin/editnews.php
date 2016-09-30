<?php

  /** Устнавливаем соединение с базой данных */
  include "../config.php";

  /** Проверим - достаточно ли информации для занесения в базу данных */
  if(empty($_POST['name'])) links("Отсутствует заголовок");
  if(empty($_POST['body'])) links("Содержание не введено");

  if(!preg_match("|^[\d]*$|",$_POST['id_news'])) puterror("Ошибка при обращении к блоку новостей");
  /** Определяем, скрыта новоть или нет */
  if($_POST['hide'] == "on") $showhide = "show";
  else $showhide = "hide";

  /** Проверяем параметр id_news, предотвращая SQL-инъекцию */
  if(!preg_match("|^[\d]*$|",$_POST['id_news'])) links("Ошибка при обращении к блоку новостей");
  /** Проверяем время */
  if(!preg_match("|^[\d]+$|",$_POST['date_year'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_month'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_day'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_hour'])) links("Ошибка при обращении к блоку новостей");
  if(!preg_match("|^[\d]+$|",$_POST['date_minute'])) links("Ошибка при обращении к блоку новостей");


  /** Если у данной новости имеется изображение и оператор
  * запрашивает его удаление или вместо этого изображения
  * загружает другое - удаляем старое изображение */
  if($_POST['chk_delete'] == "on" || $_POST['chk_filename'] == "on")
  {
    $query = "SELECT * FROM news WHERE id_news = $_POST[id_news]";
    $row = one($query);
    if(!$row) links("Ошибка при редактировании блока \"Новости\"");
    if(!empty($row['url_pict']))
    {
      if(file_exists("../".$row['url_pict'])) @unlink("../".$row['url_pict']);
    }
    $path_image = "url_pict = '',";
  }

  /** Если требуется загрузить файл - загружаем */
  $path = "";
  if($_POST['chk_filename'] == "on")
  {
    if (!empty($_FILES['filename']['tmp_name']))
    {
      /** Формируем путь к файлу    */
      $path = "files/".date("YmdHis",time());
      /** Если оператор пожелал переименовать файл - переименовываем  */
      if($_POST['chk_rename'] == "on")
      {
        /** Проверяем, чтобы не было прямых и обратных слешей */
        $_POST['rename'] = str_replace("\\","",$_POST['rename']);
        $_POST['rename'] = str_replace("/","",$_POST['rename']);
        $_POST['rename'] = stripcslashes($_POST['rename']);
        $path = "files/".substr($_POST['rename'], 0, strrpos($_POST['rename'], ".")); 
      }
        /** Проверяем размеры изображения */
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
        unlink($_FILES['filename']['tmp_name']);
        /** Изменяем права доступа к файлу */
        chmod("../".$path, 0644);
      }
    }
    else links("Не указан файл для загрузки");
    if(!empty($path)) $path_image = "url_pict = '$path',";
  } 
  /** Формируем и выполняем SQL-запрос на обновление новостной позиции */
  $query = "UPDATE news SET name='".$_POST['name']."',
                            body='".$_POST['body']."',
                            putdate = '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                            $path_image
                            hide = '$showhide'
            WHERE id_news=".$_POST['id_news'];
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else links("Ошибка при редактировании новостей (база данных)");

?>