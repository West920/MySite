<?php
  // ������������� ���������� � ����� ������
  require_once("../config.php");

  /** ��������� �������� id_news, ������������ SQL-�������� */
  if(!preg_match("|^[\d]+$|",$_GET['id_news'])) puterror("������ ��� ��������� � ����� ��������");
  /** �������� ������� */
  $query = "UPDATE news SET hide='hide' 
            WHERE id_news=".$_GET['id_news'];
  if(query($query)) header("Location: index.php?page=".$_GET['page']);
  else puterror("������ ��� ��������� � ����� ��������");
?>