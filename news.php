<?php
require_once("config.php");
include "forms/header.php";
?>

<button class="btn btn-success"><a href="/">На главную</a></button>

<?php
/** Защита от инъекционных запросов */
  if(!preg_match("|^[\d]*$|",$_GET['id_news'])) puterror("Ошибка при обращении к блоку новостей");

  /** Запрашиваем новость id_news (она должна быть видимой hide='show') */
    $query = "SELECT id_news,
                   name,
                   body,
                   DATE_FORMAT(putdate,'%d.%m.%Y %h:%m') as putdate_format,
                   url_pict,
                   hide
                   FROM news WHERE hide='show' AND id_news=".$_GET['id_news'];
    $new = one($query);
  if (!$new) $err = "Ошибка при обращении к блоку новостей";
/** Выводим данные новости */
?>
<div class="new">
        <div class='text-info'>
          <div class="title"><? echo $new['name']; ?></div>
          <div class="datetime"><? echo $new['putdate_format']; ?></div>
        </div>

          <?
            if(trim($new['url_pict']) != "" && trim($new['url_pict']) != "-")
          ?>

          <img class=img src=<? echo $new['url_pict']; ?> ><br>
          <div class='text'><? echo nl2br($new['body']); ?></div> 
</div>

<? include "forms/footer.php"; ?>
