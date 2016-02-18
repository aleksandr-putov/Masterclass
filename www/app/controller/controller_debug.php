<?php
include_once 'app/controller/controller.php';

class controller_debug extends controller
{

	public function action($arg1=null,$arg2=null)
	{
		include_once 'app/model/model_group.php';
		$mg = new model_group();
		print_r($mg->getGroupByID($arg1));
		var_dump($mg->getGroupByID($arg1));
			//parent::show("Главная-заглавная страница","app/view/view_index.php");

	}
        public function action_json()
        {
            $json='[{"id_t":"13","id_s":"16","score":"4"},{"id_t":"15","id_s":"16","score":"3"},{"id_t":"14","id_s":"19","score":"1"},{"id_t":"21","id_s":"19","score":"10"}]';
            $rate=json_decode($json, true);
        var_dump($rate);
        echo  json_last_error();
        }
	public function action_admin($username)
	{
		include_once 'app/controller/controller_user.php';
		$mu = new controller_user();
		$usr = $mu->getCurrentUser();
		if($mu->isAdmin($usr))
			echo "YIS, ADMIN";
		if ($usr['login']==$username)
			echo "YIS, ".$username;
	}

	public function action_session(){
		print_r($_SESSION);
		echo 1;
	}
        	public function action_info($msg='Default debug message'){
                    parent::info($msg, '/debug/info/'.  rand(0, 100));
	}
        
        	public function action_tasks($group)
	{
		include_once 'app/controller/controller_task.php';
		$ct = new controller_task();
                echo "<pre>\n";
                print_r($ct->groupTasks($ct->getTasksForGroup($group)));
                echo"\n</pre>";
	}
        


}
?>