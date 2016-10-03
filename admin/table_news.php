<?
            /** Выводим ошибки */
            if (!empty($err)) echo "<div class='panel panel-danger'><div class='panel-heading'>".$err."</div></div>";
            if (!empty($scs)) echo "<div class='panel panel-success'><div class='panel-heading'>".$scs."</div></div>";

            /** Проверяем параметр page, предотвращая SQL-инъекцию */
            if(!preg_match("|^[\d]*$|",$_POST['page'])) links("Ошибка при обращении к блоку новостей");
            /** Проверяем переменную $page, равную порядковому номеру первой новости на странице */
            $page = $_GET['page'];
            if(empty($page)) $page = 1;
            $begin = ($page - 1)*$all_number_news;

            /** Воспроизводим новости, таким образом, как они выглядят на
             * главной странице, но отображаем так же невидимые новости */
            $query = "SELECT id_news,
                   name,
                   body,
                   DATE_FORMAT(putdate,'%d.%m.%Y') as putdate_format,
                   url_pict,
                   hide
            FROM news
            ORDER BY putdate DESC
            LIMIT $begin, $all_number_news";
            $new = all($query);

            if ($new)
            {
            /** Выводим ссылки управления новостями, добавление, удаление и редактирование */
            ?>
            <div class="form-group"><a class="btn btn-default" href="addnewsform.php?start=$start">Добавить новость</a></div>
            <div class="form-group"><a class="btn btn-default" href="/">На главную</a></div>

            <table class="table table-condensed table-striped table-bordered table-hover">
                <tr class=tableheadercat align="center">
                    <td width=120><p class=zagtable>Дата</p></td>
                    <td width=60%><p class=zagtable>Новость</p></td>
                    <td width=40><p class=zagtable><nobr>Избр-е</nobr></p></td>
                    <td colspan=3><p class=zagtable>Действия</p></td>
                </tr>
                <?php
                foreach($new as $news)
                {
                    /** Если новость отмечена как невидимая (hide='hide'), выводим
                     * ссылку "отобразить", если как видимия (hide='show') - "скрыть" */
                    $colorrow = "";
                    if($news['hide']=='show') $showhide = "<p><a href=hide.php?id_news=".$news['id_news']."&start=$start title='Скрыть новость в блоке новостей'>Скрыть</a>";
                    else  {
                        $showhide = "<p><a href=show.php?id_news=".$news['id_news']."&start=$start title='Отобразить новость в блоке новостей'>Отобразить</a>";
                        $colorrow = "class='hiddenrow'";
                    }
                    /** Проверяем наличие изображения */
                    if ($news['url_pict'] != '' && $news['url_pict'] != '-') $url_pict="<b><a href=../".$news['url_pict'].">есть</a></b>";
                    else $url_pict="нет";

                    if (($news['url']!='-') and ($news['url']!='')) $news_url="<br><b>Ссылка:</b> <a href='".$news['url']."'>".$news['url_text']."</a>";
                    else $news_url="";
                    /** Выводим новость */
                    echo "<tr $colorrow >
              <td><p class=help align=center>".$news['putdate_format']."</p></td>
              <td><p><a title='Редактировать текст новости' href=editnewsform.php?id_news=".$news['id_news']."&start=$start>".$news['name']."</a><br>".nl2br($news['body'])." ". $news_url." </td>
              <td><p>".$url_pict."</p></td>
              <td align=center>".$showhide."</td>
              <td align=center><p><a href=delnews.php?start=$start&id_news=".$news['id_news']." title='Удалить новость'>Удалить</a></td>
              <td align=center><p><a href=editnewsform.php?start=$start&id_news=".$news['id_news']." title='Редактировать текст новости'>Исправить</a></td>
            </tr>";
                }
                echo "</table>";
                }
                else $err = "Ошибка при обращении к блоку новостей";

        /** Постраничная навигация */

        $query = "SELECT COUNT(*) as count FROM news WHERE hide='show' AND putdate <= NOW()";
        /** Получаем общее кол-во новостей */
        $total = one($query);
        $total = $total['count'];
        /** Определяем кол-во страниц */
        if($total%$all_number_news>0) $total = (int)($total/$all_number_news)+1;
        else $total = (int)($total/$all_number_news);

        if ($page != 1) $pervpage = '<li><a href='.$_SERVER[PHP_SELF].'?page=1>&laquo;</a></li>';
        /** Проверяем нужны ли стрелки вперед */
        if ($page != $total) $nextpage = '<li><a href='.$_SERVER[PHP_SELF].'?page=' .$total. '>&raquo;</a></li>';
        /** Находим ближайшие станицы с обоих краев, если они есть */
        for($i=3; $i>=1; $i--)
        {
            if($page - $i > 0) $pageleft .= '<li><a href='.$_SERVER[PHP_SELF].'?page='. ($page - $i) .'>'. ($page - $i) .'</a></li>';
        }
        for($i=1; $i<=3; $i++)
        {
            if($page + $i <= $total) $pageright .= '<li><a href='.$_SERVER[PHP_SELF].'?page='. ($page + $i) .'>'. ($page + $i) .'</a></li>';
        }

        /** Вывод меню */
        echo '<ul class="pagination">'.$pervpage.$pageleft.'<li><a href="#"><b>'.$page.'</b></a></li>'.$pageright.$nextpage;
        ?>