<?php

if (function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/Kaliningrad');;

  if($titlepage == "") $titlepage = "Добавление новости";

  include "../util/topadmin.php";

  /** Если не определена константа EDIT,
  * Устанавливаем параметры HTML-формы
  * на редактирование */
  if(!defined("EDIT"))
  {
    $button = "Добавить";
    $action = "addnews.php";
    $showhide = "checked";
    $chk_filename = "";
    $chk_rename   = "";
    $name = "";
    $body = "";
    $url = "";
    $url_text = "";
    $url_pict = "";
    $date_month = date("m");
    $date_day = date("d");
    $date_year = date("Y");
    $date_hour = date("H");
    $date_minute = date("i");
  }
?>
<table><tr><td>
<p class=boxmenu><a class=menu href="index.php">Вернуться в администрирование новоcтей</a></p>
</td></tr></table>
<form name=form enctype='multipart/form-data' action=<?php echo $action; ?> method=post>
<table cellpadding="0" cellspacing="6">
<tr>
  <td><p class=zag2>Название</td>
  <td></td>
  <td><input class=input size=70 type=text name=name value='<?php echo htmlspecialchars($name); ?>' required></td>
</tr>
<tr>
  <td><p class=zag2>Содержание</td>
  <td></td>
  <td><textarea class=input name=body rows=10 cols=60 required><?php echo htmlspecialchars($body); ?></textarea></td>
</tr>
<tr>
  <td><p class=zag2>Дата новости</td>
  <td></td>
  <td>
   <?php
     /** Выпадающий список для дня */
     echo "<select title='День' class=input type=text name='date_day'>";
     for($i = 1; $i <= 31; $i++)
     {
       if($date_day == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d", $i);
     }
     echo "</select>";
     /** Выпадающий список для месяца */
     echo "<select class=input type=text name='date_month'>";
     for($i = 1; $i <= 12; $i++)
     {
       if($date_month == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d", $i);
     }
     echo "</select>";
     /** Выпадающий список для года */
     echo "<select class=input type=text name='date_year'>";
     for($i = 2004; $i <= 2017; $i++)
     {
       if($date_year == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>$i";
     }
     echo "</select>";
     /** Выпадающий список для часа */
     echo "&nbsp;&nbsp;<select class=input type=text name='date_hour'>";
     for($i = 0; $i <= 23; $i++)
     {
       if($date_hour == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d",$i);
     }
     echo "</select>";
     /** Выпадающий список для минут */
     echo "<select class=input type=text name='date_minute'>";
     for($i = 0; $i <= 59; $i++)
     {
       if($date_minute == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>".sprintf("%02d",$i);
     }
     echo "</select>";
   ?>
</tr>
<tr>
  <td><p class=zag2>Изображение</td>
  <td><input type="checkbox" name="chk_filename" onclick="freeze_filename(this.form)" <?php echo htmlspecialchars($chk_filename); ?>></td>
  <td><input class=input size=70 type=file name=filename></td>
</tr>
<tr>
  <td><p class=zag2>Переименовать</td>
  <td><input type="checkbox" name="chk_rename" onclick="freeze_rename(this.form)" <?php echo htmlspecialchars($chk_rename); ?>></td>
  <td><input class=input1 size=70 type=text name=rename ></td>
</tr>
<?php
  if(defined("EDIT") && !empty($url_pict))
  {
  ?>
<tr>
  <td><p class=zag2>Удалить изображение</td>
  <td><input type="checkbox" name="chk_delete"></td>
  <td></td>
  <?php
  }
?>
</tr>
<tr>
  <td><p class=zag2>Отображать</td>
  <td><input type=checkbox name=hide <?php echo htmlspecialchars($showhide); ?>></td>
  <td><p class=help>если флажок не отмечен, новостная позиция не отображается на страницах сайта</p></td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td><input class=button type=submit value=<?php echo htmlspecialchars($button); ?>></td>
</tr>
<input type=hidden name=id_news value=<?php echo htmlspecialchars($_GET['id_news']); ?>>
<input type=hidden name=start value=<?php echo htmlspecialchars($_GET['start']); ?>>
</table>
</form>


<script language="JavaScript"> 
<!-- 
  function freeze_filename(form) 
  { 
    form.filename.disabled = !form.chk_filename.checked; 
  } 
  function freeze_rename(form) 
  { 
    form.rename.disabled = !form.chk_rename.checked; 
  } 

  if('<?= $chk_filename; ?>' == 'checked') document.form.filename.disabled = false; 
  else document.form.filename.disabled = true;
  if('<?= $chk_rename; ?>' == 'checked') document.form.rename.disabled = false; 
  else document.form.rename.disabled = true;
//--> 
</script>