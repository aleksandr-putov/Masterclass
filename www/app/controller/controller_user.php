<?php

include_once 'app/controller/controller.php';

include_once 'app/model/model_user.php';
include_once 'app/libraries/lib_dates.php';
//C сессиями сейчас творится полный адъ. Нужно исправлять и исправлять.
class controller_user extends controller {

    var $error;
    var $usertype;

    public function action() {
        //Здесь идет проверка авторизации и либо адресует на /enter либо показывает профиль
        if (!$this->session_is_empty() && $this->is_valid_session()) {
            header('Location: /user/view');
        } else {
            header('Location: /user/enter');
        }
    }

    public function getSessionUsername() { //Возвращает имя из сессии
        session_start();
        return $_SESSION['username'];
    }

//    public function getCurrentUsername() { //Возвращает имя из текущей ВАЛИДНОЙ сессии.
//        $usr = $this->getCurrentUser();
//        return $usr['login'];
//    }

    public function deleteAllUsernameSessions($username)
    {
        $model_user = new model_user();
        return $model_user->deleteAllUsernameSessions($username);
    }

    public function getCurrentUser() { //Если есть сессия и она валидна и юзер не удалён случайно, то возвращает запись текущего пользователя. Иначе - пустоту. 
        if (!$this->session_is_empty() && $this->is_valid_session() && $this->user_exists($this->getSessionUsername())) {

            $username = $this->getSessionUsername();
            $user = $this->getUser($username);
            return $user;
        } else {
            return null;
        }
    }
    public function getCurrentGroupID($student_id) {
        $model_user = new model_user();
        $grp = $model_user->getCurrentGroupID($student_id);
        return $grp['group_id'];
    }
    public function getUsersFromGroup($group_id) {
        $model_user = new model_user();
        return $model_user->getUsersFromGroup($group_id);
    }
    
    public function getOldUsersFromGroup($group_id) {
        $model_user = new model_user();
        return $model_user->getOldUsersFromGroup($group_id);
    }
    
        public function getDeadSouls() {
        $model_user = new model_user();
        return $model_user->getDeadSouls();
    }
    public function getUserID() {
        $model_user = new model_user();
        return $model_user->getUserID($this->getSessionUsername());
    }

    public function getUserByID($id) {
        $model_user = new model_user();
        return $model_user->getUserByID($id);
    }

    public function getAllTeachers() {
        $model_user = new model_user();
        return $model_user->getAllTeachers();
    }

    public function getSessionHash() {
        session_start();
        return $_SESSION['session_hash'];
    }

    public function session_is_empty() {
        session_start();
        return(!isset($_SESSION['username']));
    }

    public function getUser($username) {
        $model_user = new model_user();
        return $model_user->getUser($username);
    }

    public function setupSession() { //Данный метод настраивает сессию.
        //Берёт имя пользователя из сессии и дописывает информацию о сессии.
        //Записывает всю информацию о пользователе (логин, айди, права доступа) если сессия валидна.
        $user = $this->getCurrentUser();
        if ($user) {
            $_SESSION['rights'] = $user['rights'];
        } else {
            
        }
    }

    public function is_valid_session() {
        session_start();
        $model_user = new model_user();
        $a = $model_user->is_valid_session($_SESSION['username'], $_SESSION['session_hash']);
        if (!$a) {
            $this->forceLog();
        }
        return $a;
    }

    public function forceLog() { //Безоговорочное разлогивание (удаление сессии из базы и из, кхм, сессии.
        session_start();
        //echo $_SESSION['username']." ".$_SESSION['session_hash'];
        $model_user = new model_user();
        $model_user->delete_session($_SESSION['session_hash']);
        unset($_SESSION['rights']);
        unset($_SESSION['session_hash']);
        unset($_SESSION['username']);
    }

    public function action_logout() { //Разлогинивание, вызываемое пользователем.
        //echo "I said - log fuckin outta here!";
        if ($this->is_valid_session()) {
            session_start();
            $model_user = new model_user();
            $model_user->delete_session($_SESSION['session_hash']);
        }
        unset($_SESSION['rights']);
        unset($_SESSION['session_hash']);
        unset($_SESSION['username']);

        header('Location: /');
    }

    public function setUserPassword($username, $password) {
        $model_user = new model_user();
        $model_user->updUserPassword($username, $password);
    }

    public function isAdmin($usr = null) { //Проверяет права либо у текущего пользователя, либо у указанного (чтобы по 100 раз не вызывать getCurrentUser)
        if (!$usr) {
            $usr = $this->getCurrentUser();
        }
        return ($usr['rights'] == '0');
    }

    public function isTeacher($usr = null) { //Проверяет права либо у текущего пользователя, либо у указанного (чтобы по 100 раз не вызывать getCurrentUser)
        if (!$usr) {
            $usr = $this->getCurrentUser();
        }
        return ($usr['rights'] == '1');
    }

    public function user_exists($username) {
        $model_user = new model_user();
        return $model_user->user_exists($username);
    }

    public function action_post_enter() {
        //echo "Working on this";
        unset($GLOBALS['err']);

        $model_user = new model_user();
        if ($this->user_exists($_POST['username']) && $model_user->password_matches($_POST['username'], $_POST['password'])) {
            session_start();
            //echo "tryin";
            $_SESSION['session_hash'] = $model_user->make_session($_POST['username']);
            $_SESSION['username'] = $_POST['username'];
            $this->setupSession();
            header('Location: /');
            //return;
        } else {
            //echo "not tryin";
            $this->action_enter();
        }
    }

    public function action_enter() {
        if (isset($_SESSION['username'])) {
//  if (!$this->session_is_empty() && $this->is_valid_session()) {
            header('Location: /user/view');
        } else {
            parent::show("Вход в профиль", "app/view/view_user_enter.php");
        }
    }

    public function action_view($username = null) {
        session_start();
        if (!$username) {
            if (!$this->session_is_empty() && $this->is_valid_session()) {
                header('Location: /user/view/' . $_SESSION['username']);
            } else {
                header('Location: /user/enter');
            }
        } else {
            if ($this->user_exists($username)) {
                $targetUser = $this->getUser($username);
                $currentUser = $this->getCurrentUser();
                //echo $this->user_exists('admin');
                $view['canEdit'] = false;
                $view['canViewPrivate'] = false;
                
                if ($this->isAdmin($currentUser) || ($currentUser['login'] == $username)) {
                    $view['canEdit'] = true;
                }

                if ($this->isTeacher($currentUser) || $this->isAdmin($currentUser) || ($currentUser['login'] == $username)) {
                    $view['canViewPrivate'] = true;
                }
                
                //var_dump($user);
                $view['user'] = $targetUser;
                if ($targetUser['rights']==2)
                {
                    $view['user']['birthdate']=dateConverter::sqlToDate($view['user']['birthdate']);
                    $group_id = $this->getCurrentGroupID($targetUser['id']);
                    
                    if ($group_id)
                    {

                        include_once 'app/controller/controller_group.php';
                        $cg = new controller_group();
                        $group = $cg->getGroupByID($group_id);
                       // print_r($group);
                        // var_dump($group);
                        $view['group_id']=$group_id;
                        $view['group_name']=$group['grade'] . " " . $group['year'];
                    }
                }
                parent::show("Профиль " . $targetUser['login'], "app/view/view_profile.php", $view);
            } else {
                parent::notFound($username);
                //echo "NO";
                header('Location: /not_found');
            }
        }
    }

    public function action_post_change($username) {
        //print_r($_POST);
        //Добавить проверку доступа!!!!1111 (Эта строка была скопирована тысячи раз в разные места (уже удалено), но вроде проверка здесь пристуствует.
        if ($this->user_exists($username)) {
            $usr = $this->getCurrentUser();
            if ($this->isAdmin($usr) || (($usr['login']) == $username)) {
                //Эта строка сомнительна. потом поправить. Мы как то должны брать ФИО. Или мы его менять не можем? Или убрать смену у модели, либо продумать здесьы
                if ($usr['login'] == $username) {
                    $_POST['fio'] = $usr['fio'];
                }
                $model_user = new model_user();
                $_POST['birthdate']=dateConverter::dateToSql($_POST['birthdate']);
                $model_user->updStudent($username, $_POST);
                header("Location: /user/view/" . $username);
            } else
                parent::restricted();
        }
        else {
            parent::notFound($username);
            //echo "NO";
            //header('Location: /not_found');
        }
    }

    public function action_change($username = null) {
        session_start();
        if (!$username) {
            if (!$this->session_is_empty() && $this->is_valid_session()) {
                header('Location: /user/change/' . $_SESSION['username']);
            } else
                header('Location: /user/enter');
        }
        else {
            if ($this->user_exists($username)) {
                //echo $this->user_exists('admin');
                $usr = $this->getCurrentUser();
                if ($this->isAdmin($usr) || (($usr['login']) == $username)) {
                    $user = $this->getUser($username);
                    if ($user['rights'] != 2)
                        header('Location: /user/view/' . $username); //Менять можем только участников, поэтому если вдруг ктото перешел на изменение препода или админа, кидаем обратно
                    $view['canEdit'] = true;
                    $view['user'] = $user;
                    $view['user']['birthdate']=dateConverter::sqlToDate($view['user']['birthdate']);
                    parent::show("Профиль " . $user['login'], "app/view/view_profile_change.php", $view);
                }
                //var_dump($user);
                else
                    parent::restricted();
            }
            else {
                parent::notFound($username);
                //echo "NO";
                //header('Location: /not_found');
            }
        }
    }


    public function action_post_changepwd($username) {
        unset($GLOBALS['err']);
        if ($this->user_exists($username)) {
            $usr = $this->getCurrentUser();
            if ($this->isAdmin($usr) || (($usr['login']) == $username)) { //если админ ИЛИ меняет себе
                if ($usr['login'] == $username) { //если таки меняет себе то нужно проверить правильный ли старый пароль и НАВСЯКИЙСЛУЧАЙ, написал ли он правильно новые
                    //то нужно убедиться что пароли совпадают!
                    if ($usr['pass'] != $_POST['oldpass']) {
                        $GLOBALS['err'] = "Ошибка! Неправильный пароль!";
                        $this->action_changepwd($username);
                        return;
                    }
                }

                $this->setUserPassword($username, $_POST['newpass']);
                $this->deleteAllUsernameSessions($username);
                //$GLOBALS['err'] = "Пароль успешно изменён";
                //$this->action_view($username);
                parent::info("Пароль успешно изменён!", "/user/view/" . $username);
//header("Location: /user/view/" . $username); //Если б разобраться как просто добавлять в такой переход данные типа уведомлений, это было бы замечательно
            } else
                parent::restricted();
        }
        else {
            parent::notFound($username);
            //echo "NO";
            //header('Location: /not_found');
        }
    }

    public function action_changepwd($username) {
        session_start();

        if ($this->user_exists($username)) {
            //echo $this->user_exists('admin');
            $usr = $this->getCurrentUser();
            if ($this->isAdmin($usr) || (($usr['login']) == $username)) {
                $user = $this->getUser($username);
                if ($usr['rights'] == 0 && $username != $usr['login'])
                    $view['needConfirmation'] = false;
                else
                    $view['needConfirmation'] = true;
                $view['user'] = $user;
                parent::show("Смена пароля " . $user['login'], "app/view/view_profile_changepwd.php", $view);
            }
            //var_dump($user);
            else
                parent::restricted();
        }
        else {
            parent::notFound($username);
            //echo "NO";
            //header('Location: /not_found');
        }
    }

    public function action_admin() {
        header('Location: /admin');
    }

}

?>