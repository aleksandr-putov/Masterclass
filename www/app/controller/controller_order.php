<?php
include_once 'app/controller/controller.php';
include_once 'app/controller/controller_user.php';
include_once 'app/model/model_db.php';

class controller_order extends controller {

	public function action()
	{
		//$this->showCart();
	}
	public function action_view($id)
	{
		$view['order_i'] = model_db::get_instance()->DB->query('SELECT *, price*amount as cost from `order_item` JOIN `item` ON order_item.item_id=item.id where order_id ="'.$id.'"')->fetchAll();
		$view['order'] = model_db::get_instance()->DB->query('SELECT * from `order` where id="'.$id.'"')->fetch();
		$view['content'] = "app/view/view_order.php";
		$view['menu'] = $this->menu();
		include "app/view/view_main.php";
	}

	public function listUser($user_id)
	{
		$statement = model_db::get_instance()->DB->query('SELECT * from `order` where user_id = "'.$user_id.'"')->fetchAll();
		return $statement;
	}
	public function listAll()
	{
		$statement = model_db::get_instance()->DB->query('SELECT * from `order`')->fetchAll();
		return $statement;
	}
}
?>