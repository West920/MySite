<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Новости</title>

    
    <link rel='stylesheet' href='/css/bootstrap.min.css' type='text/css' media='all'>
    <link rel="stylesheet" href="/style.css"  type='text/css'>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


    
</head>
<body>
    <div class=" col-md-10 col-md-offset-1">
        <div class="row">
            <nav role="navigation" class="navbar navbar-default">
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
            <div class="col-md-10 col-md-offset-1"><div class="pinfo">
                <?
                $cook = CheckCook();
                if (CheckCook()) echo "Здравствуйте, <span style='color:#1815a2'>".$cook['name']."</span>";
                ?>
            </div></div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1"><div class="border side-left">Сайд бар слева</div></div>
            <div class="col-md-6">
                <div class="border">

                <?
                if (!empty($err)) echo "<div class='panel panel-danger'><div class='panel-heading'>".$err."</div></div>";
                if (!empty($scs)) echo "<div class='panel panel-success'><div class='panel-heading'>".$scs."</div></div>";
                ?>
