<?php
  /** ������������� ���������� � ����� ������ */
  require_once("../config.php");

  /** ��������� �������� id_news, ������������ SQL-�������� */
  if(!preg_match("|^[\d]+$|",$_GET['id_news'])) puterror("������ ��� ��������� � ����� ��������");

  /** ���� ��������� ������� ����� ����������� - ������� ��� */
  $query = "SELECT * FROM news 
            WHERE id_news=".$_GET['id_news'];
  $row = one($query);
  if(!$row) puterror("������ ������� � ������� ��������...");
  if(is_file("../".$row['url_pict'])) @unlink("../".$row['url_pict']);

  /** ��������� � ��������� SQL-������ �� �������� ������ � ������� news  */
  $query = "DELETE FROM news WHERE id_news=".$_GET['id_news'];
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else puterror("������ ��� ��������� � ����� ��������");
?>