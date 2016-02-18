<?php 
include_once 'app/controller/controller_default.php';
Abstract class Controller{
	//var $view['title'];
	//var $view['content'];
        //Основной абстрактный класс контроллера. Содержит базовые функции отображения + извлечение данных из сессий, которые необходимы в большинстве контроллеров
	abstract function action();

	public function show($title, $path_to_view, $view=null)
	{
			include_once("app/controller/controller_menu.php");
			$controller_menu = new controller_menu();
			$view['title']=$title;
			$view['content'] = $path_to_view ;
			$view['menu'] = $controller_menu->getMenu();
			include "app/view/view_main.php";

	}

	public function notFound($path="")
	{
		$cd = new controller_default();
		$cd->action_default($path);
	}

	public function restricted()
	{
		$cd = new controller_default();
		$cd->action_restricted();
	}
        
        	public function info($message, $backpath)
	{
                $_SESSION['message']=$message;
                $_SESSION['path']=$backpath;
		header('Location: /info');
	}
        
         public function action_info()
	{
		$cd = new controller_default();
		$cd->action_info($_POST['message'], $_POST['backpath']);
	}
        
        	public function adminRequired() //проверяет права из сессии и если нет прав админа, то переадресовывает.
	{
            //print_r($_SESSION);
		if (self::isAdmin())
                {
                    //good. Proceed.
                    //unset($_SESSION['rights']);
                    //echo $_SESSION['rights'];
                    return;
                }
            else    
		{
			self::restricted();
                        exit();
		}
	}

	        	public function teacherRequired() //проверяет права из сессии и если нет прав преподавателя или админа, то переадресовывает.
	{

		if (self::isTeacher())
                {
                    return;
                }
          else      
		{
			self::restricted();
                        exit();
		}
	}

		        public function isAdmin() //проверяет права из сессии и если нет прав преподавателя или админа, то переадресовывает.
	{
            //print_r($_SESSION);
		return (isset($_SESSION['rights']) && ($_SESSION['rights']==0));
	}

			    public function isTeacher() //проверяет права из сессии и если нет прав преподавателя или админа, то переадресовывает.
	{
            //print_r($_SESSION);
		return (isset($_SESSION['rights']) && ($_SESSION['rights']==0 || $_SESSION['rights']==1));
	}
}

?>