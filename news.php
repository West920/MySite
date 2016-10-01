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
</div>

<? 
/** Show commentaries */
$data = R::find('comments', 'id_news=:id_news', array(':id_news'=>$_GET['id_news']));
  if($data!=array())
  {
    foreach($data as $com)
    {
      echo "<div class='border border-comment'>";
      $user = R::load('users', $com->id_user);
      ?>


      <div class="col-md-2 nopad-left">
          <span id='commname'><? echo $user->name;?></span>
          <img src=<? echo $user->avatar; ?> class="img-thumbnail"><br>
          
      </div>

      <br>
      <?
        echo '<div class="text">'.nl2br($com->text).'</div>';


        
        echo '</div>';
      
    }
  }
?>






<? if(isset($_COOKIE['id'])) {
$data = R::load('users', $_COOKIE['id']);
?>
    <div class="border border-comment">
      <H3>Добавить коментарий</H3><br>

        <div class="col-md-3 nopad-left">
          <img src=<? echo $data->avatar; ?> class="img-thumbnail"><br>
          <span id='commname'><? echo $data->name;?></span>

        </div>
          
        <div class="col-md-9">
            <form name=form  method=post role="form" action="pages/addcomm.php">
            <input type="hidden" name="id_news" value=<?echo $_GET['id_news']; ?>>
              <div class="form-group row">
                <label for="textcomm">Содержание комментария</label>
                <textarea class=form-control rows="5" cols="45" id="textcomm" name="textcomm" ></textarea>
              </div>
              <div class="form-group row">
                <button class="btn btn-success" type=submit name="comment">Добавить</button>
              </div>
            </form>
        </div>

    </div>

<? 
}
include "forms/footer.php"; 
?>
