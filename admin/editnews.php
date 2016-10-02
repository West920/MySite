<?php

  /** ������������ ���������� � ����� ������ */
  include "../config.php";

  /** �������� - ���������� �� ���������� ��� ��������� � ���� ������ */
  if(empty($_POST['name'])) links("����������� ���������");
  if(empty($_POST['body'])) links("���������� �� �������");

  if(!preg_match("|^[\d]*$|",$_POST['id_news'])) puterror("������ ��� ��������� � ����� ��������");
  /** ����������, ������ ������ ��� ��� */
  if($_POST['hide'] == "on") $showhide = "show";
  else $showhide = "hide";

  /** ��������� �������� id_news, ������������ SQL-�������� */
  if(!preg_match("|^[\d]*$|",$_POST['id_news'])) links("������ ��� ��������� � ����� ��������");
  /** ��������� ����� */
  if(!preg_match("|^[\d]+$|",$_POST['date_year'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_month'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_day'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_hour'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_minute'])) links("������ ��� ��������� � ����� ��������");


  /** ���� � ������ ������� ������� ����������� � ��������
  * ����������� ��� �������� ��� ������ ����� �����������
  * ��������� ������ - ������� ������ ����������� */
  if($_POST['chk_delete'] == "on" || $_POST['chk_filename'] == "on")
  {
    /** Delete old image*/
    $news = R::findOne('news', 'id_news = ?', [$_POST['id_news']]);
    @unlink($news->url_pict);
    $path_image = "url_pict = '',";
  }

  /** ���� ��������� ��������� ���� - ��������� */
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
  /** ��������� � ��������� SQL-������ �� ���������� ��������� ������� */
  $query = "UPDATE news SET name='".$_POST['name']."',
                            body='".$_POST['body']."',
                            putdate = '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                            $path_image
                            preview ='".$_POST['preview']."', 
                            hide = '$showhide'
            WHERE id_news=".$_POST['id_news'];
  if(query($query)) header("Location: ".constant("Main_url")."index.php");

?>