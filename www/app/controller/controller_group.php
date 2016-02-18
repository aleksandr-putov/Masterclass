<?php

include_once 'app/controller/controller.php';
include_once 'app/model/model_group.php';
//include_once 'app/controller/controller_cart.php';
include_once 'app/controller/controller_user.php';
include_once 'app/controller/controller_task.php';

//include_once 'app/controller/controller_order.php';


class controller_group extends controller {

    public function action($id = null) {
        //echo "tryin";
        if (!is_null($id))
            header('location: /group/view/' . $id);
        else {

            parent::show("Группы", "app/view/view_stages.php"); //заглушка
            exit();
        }
    }
    
    public function action_view($id = null) { //Сюда навесить просмотр конкретной группы (по айди)
        if (is_null($id)) {
            $this->action();
        } else {
            try {
                $group = $this->getGroupByID($id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['header'] = $this->getGroupHeader($group);
                $view['group'] = $group;
                $view['students'] = $cu->getUsersFromGroup($group['id']);
                $view['studentsOld'] = $cu->getOldUsersFromGroup($group['id']);
                // print_r($view);
                $view['haveRights'] =  parent::isTeacher() && $group['active'];
                $view['haveAdminRights'] =  parent::isAdmin();
               // echo $view['haveRights'];
                $ct = new controller_task();
                $view['tasks']=$ct->getTasksForGroup($id);
                //print_r($view['tasks']);
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group.php", $view);
            } catch (Exception $exc) {
                parent::notFound($id);
            }
        }
    }
    public function action_rating($id=null)
    {
        if (is_null($id)) {
            $this->action();
        } else {
            try {
                $group = $this->getGroupByID($id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['header'] = $this->getGroupHeader($group);
                $view['group'] = $group;
                $view['students'] = $cu->getUsersFromGroup($group['id']);
                // print_r($view);
                $view['haveRights'] =  parent::isTeacher() && $group['active'];
               // echo $view['haveRights'];
                $ct = new controller_task();
                $tasks=($ct->getTasksForGroup($id));
                foreach ($tasks as $value) {
                    $value['rating']=$ct->getAllRatingByTaskID($value['id']);
                }
                $tasks=$ct->groupTasks($tasks);
                //print_r($view['tasks']);
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group_rating.php", $view);
            } catch (Exception $exc) {
                parent::notFound($id);
            }
        }
    }
    public function getGroupByID($id) {
        $mg = new model_group();
       // echo "findin ".$id."<br/>";
        return $mg->getGroupByID($id);
    }

    public function getAllActiveGroups() {
        $mg = new model_group();
        return $mg->getAllGroups();
    }

    public function getAllTeachers() {
        $cu = new controller_user();
        return $cu->getAllTeachers();
    }

    public function getAllOldGroups() {
        $mg = new model_group();
        return $mg->getAllOldGroups();
    }

    public function setGroupArchived($id) {
        $mg = new model_group();
        $mg->setGroupArchived($id);
    }

    public function setGroupActive($id) {
        $mg = new model_group();
        $mg->setGroupActive($id);
    }

    public function getGroupHeader($group) {
        $cu = new controller_user();
        $teacher = $cu->getUserByID($group['teacher_id']);
        $out = "<div><h2><a href='/group/" . $group['id'] . "'>" . $group['grade'] . " " . $group['year'] . "</a></h2>";
        $out.=($group['active'] == '1') ? "Активная" : "В архиве";
        $out.="<br/>Преподаватель: ";
        $out.=($teacher) ? "<a href='/user/view/" . $teacher['login'] . "'>" . $teacher['fio'] . "</a>" : "-";
        $out.="</br><br/></div>";
        return $out;
    }

    public function addGroup($grade, $year) {
        $mg = new model_group();
        return $mg->addGroup($grade, $year);
    }

    public function setTeacherForGroup($teacher_id, $group_id) {
        $mg = new model_group();
        $mg->setTeacherForGroup($teacher_id, $group_id);
    }

    public function action_setarchived($group_id = null) {

        parent::adminRequired();
        $group = $this->getGroupByID($group_id);
        if (!is_null($group)) {
            $cu = new controller_user();
            
            $students = $cu->getUsersFromGroup($group_id);
            //print_r($students);
            if (!is_null($students))
            {
                $model = new model_user();
                foreach ($students as $value) {
                   $model->changeGroupForStudent($group_id, -1, $value['student_id']);
                }
            }
            $this->setGroupArchived($group_id);
            header("Location: /admin/group/" . $group_id);
            //}
            //else
            //	parent::restricted();
        } else {
            parent::notFound($group_id);
            //header('Location: /not_found');
        }
    }

    public function action_setactive($group_id = null) {
        parent::adminRequired();
        $group = $this->getGroupByID($group_id);
        if (!is_null($group)) {
            $this->setGroupActive($group_id);
            header("Location: /admin/group/" . $group_id);
            //}
            //else
            //	parent::restricted();
        } else {
            parent::notFound($group_id);
            //header('Location: /not_found');
        }
    }
    
    public function action_schedule($group_id=null)
    {
        parent::info("Зачем менять расписание? Оно ведь и так прекрасно!","/group/view/".$group_id);
    }

    public function action_archive() {
        $rawgroups = $this->getAllOldGroups();
        $years = array();
        $groups = array(array());
        foreach ($rawgroups as $group) {
            if ($group['year'] != end($years)) {
                array_push($years, $group['year']);
            }
            $groups[$group['year']][] = $group;
        }
        if (count($years) > 0) {
            $view['groups'] = $groups;
            $view['years'] = $years;
        }
        parent::show("Список групп", "app/view/view_groups_archived.php", $view);
    }

    public function action_post_change($group_id = null) { //На самом деле меняет преподавателя
        parent::adminRequired();
        $group = $this->getGroupByID($_POST['id']);
        if (!is_null($group)) {
            //$usr = $this->getCurrentUser();
            //if ($this->isAdmin($usr))
            //{

            $this->setTeacherForGroup($_POST['teacher'], $_POST['id']);
            header("Location: /admin/group/" . $_POST['id']);
            //}
            //else
            //	parent::restricted();
        } else {
            parent::notFound($group_id);
            //header('Location: /not_found');
        }
    }

    public function action_change($group_id = null) { //На самом деле меняет преподавателя
        parent::adminRequired();
        if (!$group_id) {
                header('Location: /admin');
        }
        else {
            $group = $this->getGroupByID($group_id);
            if (!is_null($group)) {
                //	$user = $this->getCurrentUser();
                //	if ($this->isAdmin($user))
                //	{
                $view['group'] = $group;
                $teachers = $this->getAllTeachers();
                $view['teachers'] = $teachers;
                $cu = new controller_user();
                $teacher = $cu->getUserByID($group['teacher_id']);
                $view['teacher'] = $teacher['id'];
                parent::show("Смена преподавателя", "app/view/view_group_change.php", $view);
                //var_dump($user);
                //	}
                //	else
                //		parent::restricted();
            } else {
                parent::notFound($group_id);
                //header('Location: /not_found');
            }
        }
    }


    
    public function action_post_transfer($oldgroup_id) //Переводит из одной группы в другую
    {
         parent::adminRequired();
        $model = new model_user();
        $newgroup_id = $_POST['group'];
        $list = '';
        //print_r($_POST);
        foreach($_POST as $key => $val)
        {
            //echo($key. ' -> ' . $val . '; ');
            
            if ($val == 'on')
            {
               // echo ('студент №' . $key . ' переведён из #' . $oldgroup_id . ' в #' . $newgroup_id . '; ');
                
                $model->changeGroupForStudent($oldgroup_id, $newgroup_id, $key);
                $user = $model->getUserByID($key);
               $list = $list . '<span>' . $user['fio'] . '</span><br />';     
            }

        }
        if ($oldgroup_id > 0) {
            parent::info("Перевод был успешно осуществлён для:<br /><br />" . $list, "/group/view/" . $oldgroup_id);
        } else {
            parent::info("Перевод был успешно осуществлён для:<br /><br />" . $list, "/admin/deadSouls/");
        }
    }

    public function action_transfer($group_id = null) //Переводит из одной группы в другую
        {
        parent::adminRequired();
        if (is_null($group_id)) {
            parent::notFound();
        } else {
            try {
                $cg = new controller_group();
                $group = $cg->getGroupByID($group_id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['group'] = $group;
                $groups = $cg->getAllActiveGroups();
                $students = $cu->getUsersFromGroup($group['id']);

                $view['groups'] = $groups;            
                $view['students'] = $students;
                //print_r($view['tasks']);
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group_transfer.php", $view);
            } catch (Exception $exc) {
                parent::notFound($group_id);
            }
        }
    }
    
        public function action_deadSouls() //Переводит из одной группы в другую
        {
        parent::adminRequired();

                $cg = new controller_group();
                $cu = new controller_user();

                $view['group'] = $group;
                $groups = $cg->getAllActiveGroups();
                $students = $cu->getDeadSouls();

                $view['groups'] = $groups;            
                $view['students'] = $students;
                //print_r($view['tasks']);
                parent::show("Участники без группы", "app/view/view_deadSouls.php", $view);

    }

}

?>