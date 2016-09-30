<?php
require_once "../config.php";
/** Выполняем проверки на пустоту  */
if(empty($_POST['name'])) links("Отсутствует имя пользователя");
if(empty($_POST['pass'])) links("Отсутствует пароль");
$id = 0;

/** Шифруем пароль для проверки (двойное шифрование)*/
$pass = md5(md5(trim($_POST['pass'])));
/** Проверка логина и пароля*/
$stmt = prepare('SELECT * FROM users WHERE name = :name and pass = :pass');
$stmt->execute(array(':name' => $_POST['name'], ':pass' => $pass));
$res = $stmt->fetch();
if(!$res) links("Неверно введены данные");
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
        header( 'Location: ../index.php', true, 303 );
    }
}

/** Функция для генерации случайной строки
 * @param integer длина кода
 * @return integer Случайное число
 */
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
?>

