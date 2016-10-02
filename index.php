<?php
include "config.php";
include "forms/header.php";



if(!preg_match("|^[\d]*$|",$_GET['page'])) links("Îøèáêà ïðè îáðàùåíèè ê áëîêó íîâîñòåé");

$page = $_GET['page'];
if(empty($page)) $page = 1;

$begin = ($page - 1)*$all_number_news;



$query = "SELECT id_news,
                   name,
                   preview,
                   body,
                   DATE_FORMAT(putdate,'%d.%m.%Y %h:%m') as putdate_format,
                   url_pict,
                   hide
              FROM news
              WHERE hide='show' AND putdate <= NOW()
              ORDER BY putdate DESC
              LIMIT $begin, $all_number_news";
$new = all($query);
if (!$new) links("Îøèáêà ïðè îáðàùåíèè ê áëîêó íîâîñòåé");

foreach($new as $news)
{
        ?>

        <div class="new">
          <div class='text-info'>
            <div class="title">
              <a href=news.php?id_news=<? echo $news['id_news']; ?>><? echo $news['name']; ?></a>
            </div>
            <div class="datetime"><? echo $news['putdate_format']; ?></div>
          </div>

          <?
          if(trim($news['url_pict']) != "" && trim($news['url_pict']) != "-")
            ?>

          <img class="img-responsive" src=<? echo $news['url_pict']; ?> ><br>
          <div class='text'><? echo nl2br($news['preview']); ?></div> 
        </div>

    <?
}

/** Пагинация */

$query = "SELECT COUNT(*) as count FROM news WHERE hide='show' AND putdate <= NOW()";

$total = one($query);
$total = $total['count'];

if($total%$all_number_news>0) $total = (int)($total/$all_number_news)+1;
else $total = (int)($total/$all_number_news);

if ($page != 1) $pervpage = '<li><a href='.$_SERVER[PHP_SELF].'?page=1>&laquo;</a></li>';

if ($page != $total) $nextpage = '<li><a href='.$_SERVER[PHP_SELF].'?page=' .$total. '>&raquo;</a></li>';

for($i=3; $i>=1; $i--)
{
    if($page - $i > 0) $pageleft .= '<li><a href='.$_SERVER[PHP_SELF].'?page='. ($page - $i) .'>'. ($page - $i) .'</a></li>';
}
for($i=1; $i<=3; $i++)
{
    if($page + $i <= $total) $pageright .= '<li><a href='.$_SERVER[PHP_SELF].'?page='. ($page + $i) .'>'. ($page + $i) .'</a></li>';
}
echo '<ul class="pagination">'.$pervpage.$pageleft.'<li><a href="#"><b>'.$page.'</b></a></li>'.$pageright.$nextpage."</ul></div>";


include "forms/footer.php";
?>
