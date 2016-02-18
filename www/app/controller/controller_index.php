<?php
include_once 'app/controller/controller.php';

class controller_index extends controller
{

	public function action()
	{
		//include_once 'app/model/model_group.php';
		//$mg = new model_group();
		//var_dump($mg->getGroupByID(2));
			parent::show("Главная-заглавная страница","app/view/view_index.php");

	}

}
?>