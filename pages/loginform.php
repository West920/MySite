<?php
include "../config.php";

if(isset($_POST["enter"]))
{
    /** Выполняем проверки на пустоту  */
    if(empty($_POST['name'])) $err = "Отсутствует имя пользователя";
    if(empty($_POST['pass'])) $err = "Отсутствует пароль";
    $id = 0;

    /** Шифруем пароль для проверки (двойное шифрование)*/
    $pass = md5(md5(trim($_POST['pass'])));
    /** Проверка логина и пароля*/
    $stmt = prepare('SELECT * FROM users WHERE name = :name and pass = :pass');
    $stmt->execute(array(':name' => $_POST['name'], ':pass' => $pass));
    $res = $stmt->fetch();
    if(!$res) $err = "Неверно введены данные";
    else {
        $id = $res['id'];
        /** Генерируем случайный hash-код */
        $hash = md5(generateCode(10));
        $pass = md5(md5(trim($_POST['pass'])));
        /** Заносим данные в БД */
        $stmt = prepare('update users set hash=:hash WHERE name = :name and pass = :pass');
        $stmt->execute(array(':name' => $_POST['name'], ':hash' => $hash, ':pass' => $pass));
        if($stmt){
            /** Записываем куки */
            setcookie("id", $id, time()+60*60*24*30, "/");
            setcookie("hash", $hash, time()+60*60*24*30, "/");
            header( 'Location: '.constant('Main_url'), true, 303 );
        }
    }
}

include "../forms/header.php";
?>
<H1>Вход на сайт</H1><br>
    <form name=form  method=post role="form" action="loginform.php">

        <div class="form-group row">
            <div class="col-md-5">
                <label for="name">Имя пользователя</label>
                <input class=form-control size=70 type=text id="name" name="name" placeholder="Ввдедите логин">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-5">
                <label for="pass">Пароль</label>
                <input class=form-control size=70 type=password id="pass" name="pass" placeholder="Ввдедите пароль">
            </div>
        </div>


            <button class="btn btn-success" size=70 type=submit name="enter">Войти</button>


    </form>

    </div>
<?php
include "../forms/footer.php";
?>