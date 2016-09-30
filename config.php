<?
session_start();
define("Main_url", 'http://kurs/');
include '/libs/rb.php';

R::setup( 'mysql:host=localhost;dbname=worksolution', 'root', '' ); 




  if (function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/Kaliningrad');

/**
 * Создаем переменные для подключения к БД
 */
  $dblocation = "127.0.0.1";
  $dbname = "WorkSolution";
  $dbuser = "root";
  $dbpasswd = "";
  /** Количество новостей, выводимых на странице */
  $all_number_news = 5;


/** Для подключения к БД используем PDO
 *  @return array[] $db одиночный результат запроса
 */
function db(){
  static $db = null;
  if(is_null($db)){
    $db = new PDO("mysql:host=127.0.0.1;dbname=WorkSolution", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->query("SET NAMES 'utf8'");
  }
  return $db;
}
/** Удобное выполнение запроса
 * @param string $q Текст запроса
 * @return object PDOStatement или FALSE, если запрос выполнить не удалось.
 */
function query($q){
  return db()->query($q);
}
function prepare($t){
  return db()->prepare($t);
}
/** Получение одной записи
 * @param string $q Текст запроса
 * @return object PDOStatement или FALSE, если запрос выполнить не удалось.
 */
function one($q){
  return query($q)->fetch();
}
/** Получение более 1 записи
 * @param string $q Текст запроса
 * @return object PDOStatement или FALSE, если запрос выполнить не удалось.
 */
function all($q){
  return query($q)->fetchAll();
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

/** Вывод текста ошибок
 * @param string Текст при появлении ошибки
 * @return void
 */
function links($msg)
{
  echo "<div class='panel panel-danger'><div class='panel-heading'>".$msg."</div></div>";
  exit;
}
/** Проверка на администратора
 * @return boolean Результат проверки
 */
function isAdmin()
{
  $cook = CheckCook();
  if($cook['isAdmin']==1)return true;
}
/** Проверка корректности кук
 * @return array[] Данные о вошедшем пользователе
 */
function CheckCook()
{
  $m = $_COOKIE['id'];
  $s = $_COOKIE['hash'];

  if (isset($m) and isset($s)) {
    $stmt = prepare('SELECT * FROM users WHERE id = :id and hash = :hash');
    $stmt->execute(array(':id' => $m, ':hash' => $s));
    $res = $stmt->fetch();
    if (!$res)
    {
      $err = "Что то не так. Проверь куки";
      unset($_COOKIE['id']);
      unset($_COOKIE['hash']);
    } 
    else {

      return $res;
    }
  }
}


?>