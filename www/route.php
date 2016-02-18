<?php

class router {

    public static function takeCare() {
        router::setSessionUp(); //Проверяем валидность сессии
        router::log();
        router::route();
    }

    private static function setSessionUp() { 
        //Метод проверяет валидность текущей сессии и 
        //доопределяет переменные сессии в случае необходимости (логин, права етк)
        //Благодаря этому можно быть уверенным, что в любой части
        //и в любом контроллере обращаясь к $_SESSION мы
        //будем получать только действительные данные о пользователе.
        //В отличие от сессии в базе данных с хэшем и прочим,
        //сессия пользователя (даже анонимного) на стороне сервера существует всегда.
        session_start();
        //Нужно вынести функции сессии в отдельный контроллер
    }

    private static function fixPost() { //Не самый лучший вариант - использование htmlspecialchars, но на данный момент лучше чем ничего.
        foreach ($_POST as &$value) {
            $value = htmlspecialchars($value); 
        }
    }

    private static function log() {
        $name = 'logs/log.txt';

        if (file_exists($name)) {
            $fp = fopen($name, 'a+t');
        } else {
            $fp = fopen($name, 'wt');
        }


        $text = $_SERVER['REMOTE_ADDR'] . "\t";
        session_start();
        $text.=$_SESSION['username'] . "\t";
        $text.=date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "\t";
        $text.=$_SERVER['REQUEST_METHOD'] . "\t";
        $text.=mb_strtolower($_SERVER['REQUEST_URI']) . "\t";
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            $text.=print_r($_POST, true);
        fwrite($fp, $text . "\n");
        fclose($fp);
    }

    private static function route() {

        $controller = null;
        $action = "action";
        $path = explode('/', mb_strtolower($_SERVER['REQUEST_URI']));
        //echo isset($path[1])." ".$path[1]."!";
        if (($path[1])) {
            $name = "controller_" . $path[1];
            $file = "app/controller/" . $name . ".php";
            if (file_exists($file)) {
                include_once $file;
                if (file_exists("app/model/model_" . $path[1] . ".php"))
                    include_once "app/model/model_" . $path[1] . ".php";
                $controller = new $name ();
                if (method_exists($name, "action_" . $path[2])) {
                    if (($_SERVER['REQUEST_METHOD'] == 'POST') && (method_exists($name, "action_post_" . $path[2]))) {
                        //Если метод запроса "ПОСТ", т.е. содержит тело запроса с данными
                        //(и если есть что может обрабатывать эти данные),
                        //то предварительно мы экранируем все небезопасные вещи
                        //Заметка, в таком случае, $_POST может использоваться исключительно в функциях с префиксом post
                        router::fixPost();
                        $action = $action . "_post";
                    }

                    $action = $action . "_" . $path[2];

                    if ($path[4])
                        $controller->$action($path[3], $path[4]);
                    else if ($path[3])
                        $controller->$action($path[3]);
                    else
                        $controller->$action();
                }
                else {
                    if (($_SERVER['REQUEST_METHOD'] == 'POST') && (method_exists($name, "action_post")))
                        $action = $action . "_post";

                    if ($path[3])
                        $controller->$action($path[2], $path[3]);
                    else if ($path[2])
                        $controller->$action($path[2]);
                    else
                        $controller->$action();
                }
            }
            else {
                include_once "app/controller/controller_default.php";
                $controller = new controller_default();
                $name = "controller_default";
                if (method_exists($name, "action_" . $path[1])) {
                    $action = $action . "_" . $path[1];
                    if ($path[3]) {
                        $controller->$action($path[3], $path[3]);
                    } else if ($path[2]) {
                        $controller->$action($path[2]);
                    } else {
                        $controller->$action();
                    }
                }
                else {
                    $action = "action_default";
                    $controller->$action();
                }
            }
        } else {
            include_once "app/controller/controller_default.php";
            $controller = new controller_default();
            $controller->action_index();
        }
    }

}

?>