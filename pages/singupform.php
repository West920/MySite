<?php
include "../config.php";

$err = "";
$scs = "";

/** Нажата кнопка регистрации */
if(isset($_POST["ok"]))
{
    /** Выполняем проверки на пустоту  */
    if(empty($_POST['name'])) $err = "Отсутствует имя пользователя";
    elseif(empty($_POST['email'])) $err = "Отсутствует e-mail";
    elseif(empty($_POST['pass'])) $err = "Отсутствует пароль";
    else{
        /** Выполняем проверки лсуществования логина и пароля  */
        $stmt = prepare('SELECT * FROM users WHERE name = :name');
        $stmt->execute(array(':name' => $_POST['name']));
        if($stmt->fetch()) $err = "Пользователь с таким логином уже существует";
        else{
            $stmt = prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(array(':email' => $_POST['email']));
            if($stmt->fetch()) $err = "Пользователь с таким e-mail уже существует";
            else{
                /** Шифрование пароля и реристрация пользователя  */
                $pass = md5(md5(trim($_POST['pass'])));
                $stmt = prepare('insert into users (name, email, pass) values (:name, :email, :pass)');
                $stmt->execute(array(':name' => $_POST['name'], ':email' => $_POST['email'], ':pass' => $pass));
                if($stmt){
                    $scs = "Пользователь зарегистрирован";
                }
            }
        }
    }
}

include "../forms/header.php";
?>

<H1>Регистрация пользователя</H1><br>
<form name=form  method=post role="form" action="singupform.php">

    <div class="form-group row">
        <div class="col-md-5">
            <label for="name">Имя пользователя</label>
            <input class=form-control size=70 type=text id="name" name="name" placeholder="Ввдедите логин">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-5">
            <label for="email">E-mail</label>
            <input class=form-control size=70 type=email id="email" name="email" placeholder="Ввдедите E-mail">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-5">
            <label for="pass">Пароль</label>
            <input class=form-control size=70 type=password id="pass" name="pass" placeholder="Ввдедите пароль">
        </div>
    </div>

    <div class="row col-md-2">
        <button class="btn btn-success" size=70 type=submit name="ok">Зарегистрироваться</button>
    </div>

</form>

<?php
include "../forms/footer.php";
?>