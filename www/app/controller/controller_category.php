<?php
include_once 'app/controller/controller.php';
include_once 'app/model/model_category.php';
include_once 'app/model/model_user.php';


class controller_category extends controller
{
	var $error;

	public function action(){}
	public function getCategoryTree()
	{
		$model_category = new model_category();
		return $model_category->makeCategoryTree();
		//var_dump($array);
	}

}
?>