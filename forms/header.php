<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Новости</title>

    
    <link rel='stylesheet' href='/css/bootstrap.min.css' type='text/css' media='all'>
    <link rel="stylesheet" href="/style.css"  type='text/css'>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="js/news.js"></script>

    
</head>
<body>
    <div class=" col-md-10 col-md-offset-1">
        <div class="row">
            <nav role="navigation" class="navbar navbar-inverse">
                <div class="container-fluid">

                    <div class="navbar-header">
                        <a href="#" class="navbar-brand">By West920</a>
                    </div>

                    <ul class="nav navbar-nav">
                        <li class="active tag_li"><a href="/">Главная</a></li>
                        <?php

                        if (!CheckCook())
                        {
                            echo '<li><a href='.constant("Main_url").'pages/loginform.php>Вход</a></li> <li><a href='.constant("Main_url").'pages/singupform.php>Регистрация</a></li>';
                        }
                        else
                        {
                            if(isAdmin()) echo '<li><a href="/admin">Администрирование новостей</a></li>';
                            echo '<li><a href='.constant("Main_url").'pages/profile.php>Аккаунт</a></li>';
                            echo '</ul><ul class="nav navbar-nav navbar-right">
                            <li><a href="'.constant("Main_url").'pages/logout.php">Выход</a></li>
                        </ul>';
                    }
                    ?>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

            <div class="carousel">
                    <div class="slider">
                        <ul>
                            <li><img class="img-responsive" src="http://umor-midle1.esy.es/wp-content/themes/artdevil/images/slides/1.jpg" alt=""></li>
                            <li><img class="img-responsive" src="https://image.jimcdn.com/app/cms/image/transf/dimension=1920x400:format=jpg/path/s32007c35ebd7c299/image/ib585422e62df23f3/version/1438334272/image.jpg" alt=""></li>
                            <li><img class="img-responsive" src="http://s.om1.ru/localStorage/news/40/02/de/0c/4002de0c_resizedScaled_1000to400.jpg" alt=""></li>
                            <li><img class="img-responsive" src="http://galaxy-science.ru/media/k2/items/cache/thumbs/d26f2d3a8ff5583681ac68eec63fdc44_XL_1000x400.jpg" alt=""></li>
                            <li><img class="img-responsive" src="http://cs5.pikabu.ru/images/big_size_comm/2015-11_4/144776261713148841.jpg" alt=""></li>
                        </ul>
                    </div>
                </div>





            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1"><div class="pinfo">
                <?
                $cook = CheckCook();
                if (CheckCook()) echo "Здравствуйте, <span style='color:#1815a2'>".$cook['name']."</span>";
                ?>
            </div></div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="border">

                <?
                if (!empty($err)) echo "<div class='panel panel-danger'><div class='panel-heading'>".$err."</div></div>";
                if (!empty($scs)) echo "<div class='panel panel-success'><div class='panel-heading'>".$scs."</div></div>";
                ?>
