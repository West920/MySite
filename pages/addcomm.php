<?php
include '../config.php';

	if(isset($_POST["comment"]))
	{
	  /** Выполняем проверки на пустоту  */
	  if(!empty($_POST['textcomm']))
	  {
	  		/**add comment  */
	  		$save = R::dispense('comments');
        $save->id_user=$_COOKIE['id'];
        $save->id_news=$_POST['id_news'];
        $save->put_time=date("Y-m-d H:i:s");
        $save->text=$_POST['textcomm'];
        if(R::store($save)) header( 'Location: ../news.php?id_news='.$_POST['id_news'] , true, 303 );
        
	  }
	}
?>