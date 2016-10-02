<?php
include "../config.php";

if (function_exists('date_default_timezone_set')) date_default_timezone_set('Europe/Kaliningrad');


if(isset($_POST["ok"]))
{
  $path = '';

  /** Выполняем проверки на пустоту  */
  if(empty($_POST['name'])) $err = "Отсутствует имя пользователя";
  elseif(empty($_POST['email'])) $err = "Отсутствует e-mail";
  else{
        
        $foo = new Upload($_FILES['avatar']); 
        if ($foo->uploaded) 
        {
          
          /** Delete old image*/
          $user = R::findOne('users', 'name = ?', [$_POST['name']]);
          @unlink($user->avatar);
          
           $foo->file_new_name_body   = $user->name;
           $foo->image_resize = true;
           $foo->image_ratio = true;
           $foo->image_ratio_fill  = true;
           $foo->image_convert = jpg;
           $foo->image_x = 100; 
           $foo->image_y = 100; 
           $foo->Process('../files/avatars');

           $path = str_replace('\\','/',$foo->file_dst_pathname);


           $prfsave = R::load('users', $_COOKIE['id']);
            $prfsave->name=$_POST['name'];
            $prfsave->email=$_POST['email'];
            if(!empty($_POST['pass'])) $prfsave->pass=md5(md5(trim($_POST['pass'])));
            if($path!='') $prfsave->avatar=$path;
            if(R::store($prfsave)) $scs = 'Изменения сохранены';
        }

        
    }
}

include "../forms/header.php";
$data = R::load('users', $_COOKIE['id']);
?>


<H1>Аккаунт</H1><br>
<form name=form  method=post role="form" enctype='multipart/form-data' action="profile.php">

  <div class="col-md-6">

    <div class="form-group row">
      <label for="name">Имя пользователя</label>
      <input class=form-control size=70 type=text id="name" name="name" placeholder="Ввдедите логин" value=<? echo $data->name;?>>
    </div>

    <div class="form-group row">
      <label for="email">E-mail</label>
      <input class=form-control size=70 type=email id="email" name="email" placeholder="Ввдедите E-mail" value=<? echo $data->email;?>>
    </div>

    <div class="form-group row">
      <label for="pass">Пароль</label>
      <input class=form-control size=70 type=password id="pass" name="pass" placeholder="Ввдедите пароль">
    </div>

    <div class="form-group row">
            
            <label for="avatar">Аватар</label>
            <input type=file id="avatar" name="avatar">
    </div>

    <button class="btn btn-success" size=70 type=submit name="ok">Сохранить</button>
  </div>

<div class="col-md-3 col-md-offset-3">
    <div class="form-group row">
        <img src=<? echo '../'.$data->avatar; ?>>
    </div>
</div>

</form>
</div>

<?php
include "../forms/footer.php";
?>