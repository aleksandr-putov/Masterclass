<?php

include_once 'app/controller/controller.php';
//include_once 'app/controller/controller_cart.php';
include_once 'app/controller/controller_user.php';
include_once 'app/controller/controller_group.php';

//include_once 'app/controller/controller_order.php';


class controller_admin extends controller {

    public function action() {
        parent::adminRequired();
        $cg = new controller_group();
        $groups = $cg->getAllActiveGroups();
        $view['groups'] = $groups;
        parent::show("Панель управления", "app/view/view_admin.php", $view);
    }

    public function action_post_create_user() {
        parent::adminRequired();

        $model_user = new model_user();

        if ($model_user->username_is_free($_POST['username']) && $model_user->username_is_ok($_POST['username']) && $model_user->password_is_ok($_POST['password'])) {
            //echo $_POST['rights'];
            $user = $model_user->create_user($_POST['username'], $_POST['password'], $_POST['fio'], $_POST['rights']);
            $model_user->changeGroupForStudent(0, $_POST['group'], $user['id']);
            $GLOBALS['err'] = "Пользователь успешно создан";
            $this->action_create_user($_POST['group']);
        } else
            $this->action_create_user();
    }
    
    public function action_export($group_id=null)
    {
        parent::adminRequired();
        $cg=new controller_group();
        $group = $cg->getGroupByID($group_id);
        //var_dump($group_id);
        if ($group_id==NULL || !$group)
        {
            parent::info("Группа не найдена...","/admin/");
            exit();
        }

            $cu = new controller_user();
            $students = $cu->getUsersFromGroup($group_id);           

        if (count($students)==0)
        {
             parent::info("Группа пуста. Некого экспортировать...","/group/view/".$group_id);
             exit();
        }
       // print_r($students);
        $list='';
        foreach ($students as $value) {
          $list.=$value['fio'] . ';' . $value['login'] . ';' . $value['pass'] . "\xA";
        }
        if (ob_get_level()) {
      ob_end_clean();
    }
     $list=iconv("UTF-8","CP1251",$list);
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream;');
    header('Content-Disposition: attachment; filename="' .  $group['grade'] . ' ' . $group['year'].'.csv"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($list));
    // читаем файл и отправляем его пользователю
    echo $list;
            exit();
    }
    
    public function action_export_view($group_id=null)
    {
        parent::adminRequired();
        $cg=new controller_group();
        $group = $cg->getGroupByID($group_id);
        //var_dump($group_id);
        if ($group_id==NULL || !$group)
        {
            parent::info("Группа не найдена...","/admin/");
            exit();
        }

            $cu = new controller_user();
            $students = $cu->getUsersFromGroup($group_id);           

        if (count($students)==0)
        {
             parent::info("Группа пуста. Некого экспортировать...","/group/view/".$group_id);
             exit();
        }
       // print_r($students);
        $list='';
        foreach ($students as $value) {
          $list.= '<p>' . $value['fio'] . '  |  ' . $value['login'] . '  |  ' . $value['pass'] . '</p>';
        }
            parent::info("Вот тот самый список участников группы <" . $group['grade'] . ' ' . $group['year'] . ">:<br /><br />" . $list, "/group/view/".$group_id);
            exit();
    }
    public function genPassword() {
        $pass = '';
        $words = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $max_position = strlen($words) - 1;
        for ($i = 0; $i < 10; $i++) {
            $position = floor(mt_rand(0, 10) / 10 * $max_position);
            $pass = $pass . substr($words, $position, 1);
        }
        return $pass;
    }

    public function translit($text) {
        $space = '_';
        $text = mb_strtolower($text, 'utf8'); //А вдруг не UTF-8?!
        //echo ($text . ' ');
        //$text1251 = mb_convert_encoding($text, "UTF-8", "Windows-1251");
        $transl = array(
            0 => 'a', 1 => 'b', 2 => 'v', 3 => 'g', 4 => 'd', 5 => 'e', 32 => 'yo', 6 => 'zh', 7 => 'z', 8 => 'i', 9 => 'y',
            10 => 'k', 11 => 'l', 12 => 'm', 13 => 'n', 14 => 'o', 15 => 'p', 16 => 'r', 17 => 's', 18 => 't', 19 => 'u',
            20 => 'f', 21 => 'h', 22 => 'ts', 23 => 'ch', 24 => 'sh', 25 => 'sch', 27 => 'y', 29 => 'e', 30 => 'yu', 31 => 'ya',
            33 => $space
        );

        $result = '';
        $ind = 0;
        $i = 0;
        trim($text, " \n\r\0");
        while ($i < strlen($text)) {

            if ((ord($text[$i]) == 208 || ord($text[$i]) == 209) && (ord($text[$i + 1]) < 208)) {
                $text = substr_replace($text, '', $i, 1);
            } else {
                //echo(ord($text[$i]) - 176 .' ');
                $i++;
            }
        }
        //echo (' -> ' . $text. ' ### ');
        for ($i = 0; $i < strlen($text); $i++) {
            //$str_ord = strval(ord($text[$i]));
            //$str_ord = mb_substr($str_ord, -2, 2);
            //echo ($str_ord. ', id=' . $i . '; ');
            //echo($text[$i]); //////////////////////				
            $translid = ord($text[$i]) - 176;
            if ($translid == 33 || $translid == -31) {
                $translid = 32;
            }
            if ($translid == -144) {
                $translid = 33;
            }
            if ($translid < 0) {
                $translid += 64;
            }
            //echo('id=' . $translid . ', letter=' .$transl[$translid] . ', i=' .$i.';  ******  ');
            if (isset($transl[$translid])) {// (array_key_exists($text[$i], $transl))
                //echo('HOOORAY!!!');
                if ($translid != 33) {
                    $result = $result . $transl[$translid];
                } else {
                    $result = $result . $transl[$translid];
                    $i++;
                    break;
                }
            }
        }

        //echo ($result);
        $translid = ord($text[$i]) - 176;
        if ($translid == 33) {
            $translid = 32;
        }
        if ($translid == -144) {
            $translid = 33;
        }
        if ($translid < 0) {
            $translid += 64;
        }
        if (isset($transl[$translid])) {
            if ($i++ < strlen($text)) {
                $result = $result . $transl[$translid];
            }
        }


        for ($i; $i < strlen($text); $i++) {
            $translid = ord($text[$i]) - 176;
            if ($translid == -144) {
                $i++;
                break;
            }
        }
        if ($i < strlen($text)) {

            $translid = ord($text[$i]) - 176;
            if ($translid == 33) {
                $translid = 32;
            }
            if ($translid == -144) {
                $translid = 33;
            }
            if ($translid < 0) {
                $translid += 64;
            }
            if (isset($transl[$translid])) {
                $result = $result . $transl[$translid];
            }
        }
        //echo ($result . '; ');
        return $result;
    }

    public function action_create_user($defaultGroupID = null) {

        parent::adminRequired();
        $cg = new controller_group();
        $groups = $cg->getAllActiveGroups();
        $view['groups'] = $groups;
        $view['defaultGroupID'] = $defaultGroupID;
        parent::show("Создание нового пользователя", "app/view/view_create_user.php", $view);
    }

    public function action_post_bulk_create_users() {
        parent::adminRequired();
        $list == '';
        $model_user = new model_user();
        $model_group = new model_group();
        $fios = explode("\n", $_POST['fios']); //А вдруг не \n?!
        //print_r($fios);
        for ($i = 0; $i < count($fios); $i++) {
            $username = $this->translit($fios[$i]);

            $lastUsername = $model_user->getLastSimiliarUsername($username);
            //print_r($lastUsername);
            if (!is_null($lastUsername) && $lastUsername) {
                $j = strlen($lastUsername) - 1;
                $lastNumber = '';
                while ($j > 0 && $lastUsername[$j] != '_') {
                    $lastNumber = $lastUsername[$j--] . $lastNumber;
                }
                if ($j == 0) {
                    $lastNumber = '1';
                }
                $lastNumber = strval($lastNumber) + 1;
                $username = $username . '_' . $lastNumber;
            }
            $password = $this->genPassword();
            //print_r($username);
            $group = $model_group->getGroupByID($_POST['group']);
            $user = $model_user->create_user($username, $password, $fios[$i], 2);
            $model_user->changeGroupForStudent(0, $_POST['group'], $user['id']);
            $list .= '<span>' . $fios[$i] . '  |  ' . $username . '  |  ' . $password . '</span><br /><br />';
        }
        parent::info("Следующие новые пользователи-ученики добавлены в группу <" . $group['grade'] . ' ' . $group['year'] . ">:<br /><br />" . $list, "/admin");

        /*
          if ($model_user->username_is_free($_POST['username']) && $model_user->username_is_ok($_POST['username']) && $model_user->password_is_ok($_POST['password']))
          {
          //echo $_POST['rights'];
          $user = $model_user->create_user($_POST['username'], $_POST['password'], $_POST['fio'],$_POST['rights']);
          $model_user->changeGroupForStudent(0, $_POST['group'], $user['id']);
          $GLOBALS['err']="Пользователь успешно создан";
          $this->action_create_user($_POST['group']);
          }
          else
          $this->action_create_user();
         */
    }

    public function action_bulk_create_users($defaultGroupID = null) {

        parent::adminRequired();
        $model_user = new model_user();

        session_start();
        $cu = new controller_user();
        if (!$cu->session_is_empty() && $cu->is_valid_session() && $cu->isAdmin()) {
            $cg = new controller_group();
            $groups = $cg->getAllActiveGroups();
            $view['groups'] = $groups;
            $view['defaultGroupID'] = $defaultGroupID;
            parent::show("Создание нового пользователя", "app/view/view_create_users.php", $view);
        } else
            header('Location: /user/enter');
    }

    public function action_post_change_group($group_id = null) {
        parent::adminRequired();

        $model_user = new model_user();

        if (true) {
            //echo $_POST['rights'];
            $controller_group = new controller_group();
            $id = $controller_group->addGroup($_POST['grade'], $_POST['year']);
            $controller_group->setTeacherForGroup($_POST['teacher'], $id);
            header('Location: /admin/group/' . $id);
            //$this->action_create_user();
        } else
            $this->action_create_group();
    }

    public function action_change_group($group_id = null) {

        parent::adminRequired();
        //session_start();
        if (!$group_id) {
            header('Location: /admin');
        } else {
            $group = $this->getGroupByID($group_id);
            if (!is_null($group)) {
                $cu = new controller_user();

                $teachers = $cu->getAllTeachers();
                $view['teachers'] = $teachers;
                //parent::show("Сменить преподавателя группе","app/view/view_group_change.php", $view);

                $view['group'] = $group;
                parent::show("Группа " . $group['grade'] . ' ' . $group['year'], "app/view/view_group_change.php", $view);
                //var_dump($user);
            } else {
                parent::notFound($group_id);
                //echo "NO";
                //header('Location: /not_found');
            }
        }
    }

    public function action_post_create_group() {
        parent::adminRequired();

        $model_user = new model_user();

        if (true) {
            //echo $_POST['rights'];
            $controller_group = new controller_group();
            $id = $controller_group->addGroup($_POST['grade'], $_POST['year']);
            $controller_group->setTeacherForGroup($_POST['teacher'], $id);
            header('Location: /admin/group/' . $id);
            //$this->action_create_user();
        } else
            $this->action_create_group();
    }

    public function action_create_group() {

        parent::adminRequired();
        $cu = new controller_user();

        //$cg = new controller_group();
        $teachers = $cu->getAllTeachers();
        $view['teachers'] = $teachers;
        parent::show("Создание новой группы", "app/view/view_create_group.php", $view);
    }

    public function action_group($id) {

        
        parent::adminRequired();
        header("Location: /group/".$id);
        $cg = new controller_group();
        $cu = new controller_user();
        $group = $cg->getGroupByID($id);

        if ($group) {
            //var_dump($cu->getUsersFromGroup($group['id']));
            $view['header'] = $cg->getGroupHeader($group);
            $view['group'] = $group;
            $view['students'] = $cu->getUsersFromGroup($group['id']);
            //var_dump($view['students']);
            parent::show("Редактирование группы", "app/view/view_admin_group.php", $view);
        } else
            header('Location: /');
    }

}

?>