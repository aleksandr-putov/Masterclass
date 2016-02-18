<?php
include_once 'app/controller/controller.php';
include_once 'app/model/model_user.php';


class controller_banana extends controller
{
	var $error;
	public function action()
	{
		$view['title']="Админ-Панель";
		include_once 'app/model/model_user.php';
		//echo new model_user->user_exists('logg')?'true':'false';
		$view['content']= "app/view/view_Banana.php";
		include "app/view/view_main.php";
	}

	public function catalog(){
		//echo "Wow, is it working?";
		//echo "ALLO, ".$_POST['username'].", ETO TI?";
		//$this->registration();
		unset($GLOBALS['err']);
		if ($SERVER['REQUEST_METHOD']=='POST')
		{
		
					
			//header( 'Location: /user/register');
		}
		//else
		//{
			$view['title']="Регистрация нового пользователя";
			$view['content']= "app/view/view_user_registration.php";
			//$error=$this->error;
			include "app/view/view_main.php";
		//}	

	}

	public function auth(){
		if ($_POST['action']=="auth")
		{
			//$err;
			unset($GLOBALS['err']);
			$model_user = new model_user();
			if ($model_user->user_exists($_POST['username']) && $model_user->password_matches($_POST['username'], $_POST['password']))
					{
						session_start();
						$_SESSION['session_hash']=$model_user->make_session($_POST['username']);
						$_SESSION['username']=$_POST['username'];			
						header('Location: /index');
						return;
					}
					//else
					//	echo "1";
			//echo "2".$GLOBALS['err'];
			//header('Location: /user/auth');
		}
		//else
		{
			$view['title']="Авторизация";
			$view['content']= "app/view/view_user_authorization.php";
			include "app/view/view_main.php";
		}
	}
	public function is_valid_session()
	{
		session_start();
		$model_user = new model_user();
		return $model_user->is_valid_session($_SESSION['username'], $_SESSION['session_hash']);
	}
	public function forceLog()
	{
			session_start();
			echo $_SESSION['username']." ".$_SESSION['session_hash'];
			$model_user = new model_user();
			$model_user->delete_session($_SESSION['session_hash']);
			unset($_SESSION['session_hash']);
			unset($_SESSION['username']);
	}
	public function logout()
	{
		//echo "I said - log fuckin outta here!";
		
		if ($this->is_valid_session())
		{
			session_start();
			$model_user = new model_user();
			$model_user->delete_session($_SESSION['session_hash']);
			unset($_SESSION['session_hash']);
			unset($_SESSION['username']);
		}
		header('Location: /index');
	}

}
?>