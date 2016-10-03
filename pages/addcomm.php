<?php
include '../config.php';

	  /** Выполняем проверки на пустоту  */
	  if(!empty($_POST['textcomm']))
	  {
	  		$res = array();
	  		/**add comment  */
	  		$save = R::dispense('comments');
        $save->id_user=$_COOKIE['id'];
        $save->id_news=$_POST['id_news'];
        $save->put_time=date("Y-m-d H:i:s");
        $save->text=$_POST['textcomm'];
        R::store($save);
        
	  }

?>