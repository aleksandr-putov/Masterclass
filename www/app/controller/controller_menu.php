<?php

include_once 'app/controller/controller.php';
include_once 'app/controller/controller_user.php';
include_once 'app/controller/controller_group.php';

class controller_menu extends controller {

    public function action() {
        $view['title'] = "Нет такого :(";
        $view['content'] = "app/view/view_default.php";
        include "app/view/view_main.php";
    }

    public function getMenu() {
        session_start();
        $rights = array("Администратор", "Преподаватель", "Участник");
        //$cats=[];
        $cats[] = array("/", "Главная");
        
        $cats[] = array("/stages", "Информация");
        //$cats[] = array("/join", "Поступление");
        $cg = new controller_group();
        $groups = $cg->getAllActiveGroups();
        $glist;
        foreach ($groups as $group) {
            $glist[] = array("/" . $group['id'], $group['grade'] . " " . $group['year']);
        }
        $glist[] = array("/archive", "Архив");
        $cats[] = array("/group", 'Группы', $glist);
       // $cats[] = array("/schedule", "Расписание");
        $cu = new controller_user();
        //$cats[]=array("/","checko".$cu->getSessionUsername());
        //var_dump($_SESSION);
        $user = $cu->getCurrentUser();
        if ($user) {
            $array[] = array("/view/" . $user['login'], "Личный кабинет");
            if ($cu->isAdmin($user)) {
                $array[] = array("/admin", "Панель управления");
            }
            $array[] = array("/logout", "Выйти");
            $cats[] = array("/user", $rights[$user['rights']] . " " . $cu->getSessionUsername(), $array);
            //$cats[6]=array("/user/logout","Выйти");
        } else {
            $cats[] = array("/user/enter", "Войти");
        }
        //var_dump($cats);
        $path = $_SERVER['REQUEST_URI'];
        $menu = $menu . '<ul class="nav">';

        foreach ($cats as $category) { //Хотелось бы сделать этот код менее громоздким и ужасным
            $menu = $menu . "<li";
            if ($path == $category[0])
                $menu = $menu . ' class="active"';
            if (isset($category[2]))
                $menu = $menu . ' class="dropdown"';
            $menu = $menu . '><a href="' . $category[0] . '"';
            if (isset($category[2]))
                $menu = $menu . 'class="dropdown-toggle" data-toggle="dropdown"';
            $menu = $menu . '>' . $category[1];
            if (isset($category[2])) {
                $menu = $menu . ' <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>';
                $menu = $menu . '<ul class="dropdown-menu">';
                foreach ($category[2] as $key) {
                    $menu = $menu . "<li><a href=" . $category[0] . $key[0] . '>' . $key[1] . "</li>";
                }
                $menu = $menu . '</ul>';
            }
            $menu = $menu . '</a></li>';
        }
        $menu = $menu . '</ul>';

        return $menu;
    }

}

?>