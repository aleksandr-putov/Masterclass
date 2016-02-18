<?php
include_once 'app/controller/controller.php';
include_once 'app/controller/controller_user.php';
include_once 'app/model/model_catalog.php';
include_once 'app/model/model_category.php';
include_once 'app/model/model_user.php';


class controller_catalog extends controller
{
	var $error;

	public function action_item($item_id)
	{
		$controller_user = new controller_user();
		$buying = $controller_user->is_valid_session();
		$un = $controller_user->getUsername();
		$sh = $controller_user->getSessionHash();
		$model_catalog = new model_catalog();
		$view['item']=$model_catalog->getItem($item_id);
		parent::show($view['item']['name'],"app/view/view_itemnew.php", $view);
	}
	public function action()
	{
 		$this->action_cat(0, 1);
	}

	//public function cat()
	//{
	//	$this->cat(0);
	//}

	public function action_cat($num, $page=1)
	{

		$controller_user = new controller_user();
		$buying = $controller_user->is_valid_session();
		$un = $controller_user->getUsername();
		$sh = $controller_user->getSessionHash();
		$model_category = new model_category();
		$model_catalog = new model_catalog();
		$c=$model_category->getCategory($num);
		if ($c['id']==null)
		{
			include_once 'app/controller/controller_default.php';
			$cs= new controller_default();
			$cs->action();
		}
		else
		{
			$view['cat']=$num;
			$view['page']=$page;
			$view['cats']=$model_category->getChildCategories($num);
			$view['items'] = $model_catalog->getCatalog($num, $page);
			$view['pages'] = $model_catalog->getPagesCount($num);

			parent::show($c['name'],"app/view/view_catalog.php", $view);

		}
	}

}
?>