<?php

include_once 'app/controller/controller.php';

class controller_default extends controller {

    public function action($path = null) {
        parent::show("Страница найдена", "app/view/view_" . $path . ".php");
    }

    public function action_restricted($path = null) {
    	header("HTTP/1.0 403 Access forbidden"); 
        $view['path'] = $path;
        parent::show("Нет доступа", "app/view/view_restricted.php", $view);
    }

    public function action_info() {
        $view['message'] = (isset($_SESSION['message']) ? $_SESSION['message'] : "Я что то хотел сказать, да позабыл");
        $view['path'] = (isset($_SESSION['path']) ? $_SESSION['path'] : "/");
        if (isset($_SESSION['btn']))
        {
            $view['btn']=$_SESSION['btn'];
        }
        else
        {
            $btns = array("Ок","Ок","Ок","Ок","Ок", "Ясно-понятно", "Ой здорово то как!", "Ладненько", "Океюшки", "Далее","Понято-принято","Хорошо","Принято к сведению","Замечательно");
        $rand_key = array_rand($btns, 1);
        $view['btn']=$btns[$rand_key];
        }
        unset($_SESSION['message']);
        unset($_SESSION['path']);
        parent::show("Информация", "app/view/view_info.php", $view);
        exit();
    }

    public function action_index() {
        parent::show("Главная-заглавная страница", "app/view/view_index.php");
    }

    public function action_default($path = null) {
    	header("HTTP/1.0 404 Page not found");
        $view['path'] = $path;
        parent::show("Страница " . $path . " не найдена", "app/view/view_default.php", $view);
    }

    public function action_stages() {
        parent::show("Информация", "app/view/view_stages.php");
    }

    public function action_join() {
        parent::show("Поступление", "app/view/view_join.php");
    }

}

?>