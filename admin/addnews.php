<?php

  /** ������������ ���������� � ����� ������ */
  include "../config.php";

/** ��������� ������������ �������������? */
    if(isAdmin() == 0) links('����������� ������');

  /** �������� - ���������� �� ���������� ��� ��������� � ���� ������ */
  if(empty($_POST['name'])) links("����������� ���������");
  if(empty($_POST['body'])) links("���������� �� �������");

  /** ����������, ������ ������ ��� ��� */
  if($_POST['hide'] == "on") $showhide = "show";
  else $showhide = "hide";

  /** ��������� ����� */
  if(!preg_match("|^[\d]+$|",$_POST['date_year'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_month'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_day'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_hour'])) links("������ ��� ��������� � ����� ��������");
  if(!preg_match("|^[\d]+$|",$_POST['date_minute'])) links("������ ��� ��������� � ����� ��������");


  /** ���� ���� ������ �������� �� ������ - ���������� � �� ������ */
  $path = "";
  /** ���� ��������� ��������� ���� - ��������� */
  if($_POST['chk_filename'] == "on")
  {
    if (!empty($_FILES['filename']['tmp_name']))
    {
      /** ��������� ���� � ����� */
      $path = "files/".date("YmdHis",time());
      /** ���� �������� ������� ������������� ���� - ��������������� */
      if($_POST['chk_rename'] == "on")
      {
        /** ���������, ����� �� ���� ������ � �������� ������ */
        $_POST['rename'] = str_replace("\\","",$_POST['rename']);
        $_POST['rename'] = str_replace("/","",$_POST['rename']);
        $_POST['rename'] = stripcslashes($_POST['rename']);
        $path = "files/".substr($_POST['rename'], 0, strrpos($_POST['rename'], ".")); 
      }
        /** ��������� ������� ������������ ����������� */
        $infimg = getimagesize($_FILES['filename']['tmp_name']);
        if($infimg[0] > 300 or $infimg[1] > 300) links("������� ������ �����������");

      /** ���������, �� �������� �� ���� �������� PHP ��� Perl, html, ���� ��� ��� ����������� ��� � ������ .txt */
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
      /** ��������� �� ����� ����� ���������� */
      $ext = strrchr($_FILES['filename']['name'], "."); 
      $add = $ext;
      foreach($extentions AS $exten) 
      {
        if(preg_match($exten, $ext)) $add = ".txt"; 
      }
      $path .= $add; 
  
      /** ���������� ���� �� ��������� ���������� ������� �
      * ���������� /files Web-���������� */
      if (copy($_FILES['filename']['tmp_name'], "../".$path))
      {
        /** ���������� ���� �� ��������� ���������� */
        @unlink($_FILES['filename']['tmp_name']);
        /** �������� ����� ������� � ����� */
        @chmod("../".$path, 0644);
      }
    }
    else links("�� ������ ���� ��� ��������");
  } 

  /** ��������� � ��������� SQL-������ �� ���������� ������� */
  $query = "INSERT INTO news VALUES (0,
                                     '".$_POST['name']."',
                                     '".$_POST['body']."',
                                     '".$_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']." ".sprintf("%02d",$_POST['date_hour']).":".sprintf("%02d",$_POST['date_minute']).":00',
                                     '$path',
                                     '$showhide');";
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else links("������ ��� ���������� ��������� �������");
?>