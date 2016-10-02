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
    /** Delete old image*/
    $news = R::findOne('news', 'id_news = ?', [$_POST['id_news']]);
    @unlink($news->url_pict);
    $path_image = "url_pict = '',";
  }

  /** Если требуется загрузить файл - загружаем */
  $path = "";
  if($_POST['chk_filename'] == "on")
  {

      $foo = new Upload($_FILES['filename']); 
        if ($foo->uploaded) 
        {
           $foo->file_new_name_body = '2news';
           $foo->image_resize = true;
           $foo->image_ratio = true;
           $foo->image_ratio_y  = true;
           $foo->image_convert = jpg;
           $foo->image_background_color = "#FFFFFF"; 
           $foo->image_x = 900; 
           $foo->Process('../files/');
           $path = str_replace('\\','/',$foo->file_dst_pathname);
        }

    if(!empty($path)) $path_image = "url_pict = '$path',";
  } 
  /** Формируем и выполняем SQL-запрос на обновление новостной позиции */
  $query = "UPDATE news SET name='".$_POST['name']."',
                            body='".$_POST['body']."',
                            putdate = '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                            $path_image
                            preview ='".$_POST['preview']."', 
                            hide = '$showhide'
            WHERE id_news=".$_POST['id_news'];
  if(query($query)) header("Location: ".constant("Main_url")."index.php");

?>