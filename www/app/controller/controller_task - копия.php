<?php

include_once 'app/controller/controller.php';
include_once 'app/model/model_task.php';
include_once 'app/controller/controller_group.php';
include_once 'app/libraries/lib_dates.php';

class controller_task extends controller {

    private $model;

    public function __construct() {
        $this->model = new model_task();
    }

    public function action() {
        parent::notFound();
        //Здесь будет просмотр конкретных заданий. Или скорее переадресация туда
    }

    public function getTaskByID($task_id) {
        return $this->model->getTaskByID($task_id);
    }

    public function action_view($task_id = null) {

        if (is_null($task_id)) {
            parent::notFound();
            exit();
        }
        try {
            $task = $this->getTaskByID($task_id);
            $cg = new controller_group();
            $group = $cg->getGroupByID($task['group_id']);
            $view['haveRights'] = parent::isTeacher() && $group['active'];
            $view['task'] = $task;
            $view['task']['description'] = htmlspecialchars_decode(str_replace("\n", "<br>", $view['task']['description']));
            $view['group'] = $group;
            $view['date'] = dateConverter::sqlToDate($task['taskdate']);
            // print_r($view);

            parent::show("Просмотр занятия", "app/view/view_task.php", $view);
        } catch (Exception $exc) {
            parent::notFound($exc->getMessage());
        }
    }

    public function action_add($group_id = null) {
        parent::teacherRequired();
        if (is_null($group_id)) {
            parent::notFound();
            exit();
        }
        try {
            $cg = new controller_group();
            $group = $cg->getGroupByID($group_id);
            if (!$group) {
                throw new Exception('Группа не найдена.');
            }
            if (!$group['active']) {
                parent::info("Группа " . $group['grade'] . " " . $group['year'] . " находится в архиве. Добавление занятий невозможно.", "/group/view/" . $group['id']);
            }
            $view['group'] = $group;
            $view['date'] = date('j.m.Y');
            // print_r($view);

            parent::show("Добавление нового занятия", "app/view/view_add_task.php", $view);
        } catch (Exception $exc) {
            parent::notFound($exc->getMessage());
        }
    }

    public function action_post_add($group_id = null) {
        parent::teacherRequired();
        if (is_null($group_id)) {
            parent::notFound();
            exit();
        }
        try {
            $cg = new controller_group();
            $group = $cg->getGroupByID($group_id);
            if (!$group) {
                throw new Exception('Группа не найдена.');
            }
            if (!$group['active']) {
                parent::info("Группа " . $group['grade'] . " " . $group['year'] . " находится в архиве. Добавление занятий невозможно.", "/group/view/" . $group['id']);
            }
            //Ладно, окончательно убедились, что всё это валидно, так что уж создадим наконец занятие.
            //$model->addTask($_POST['name'], $_POST['maxScore'], $_POST['description'], $group_id, $_POST['date']);

            $this->model->addTask($_POST['name'], $_POST['maxScore'], $_POST['description'], $group_id, dateConverter::dateToSql($_POST['date']));

            parent::info("Судя по всему, занятие добавлено довольно таки успешно", "/group/view/" . $group_id);
            //parent::show("Добавление нового занятия", "app/view/view_addtask.php", $view);
        } catch (Exception $exc) {
            parent::notFound($exc->getMessage());
        }
    }

    public function action_change($task_id = null) {
        parent::teacherRequired();
        if (is_null($task_id)) {
            parent::notFound();
            exit();
        }
        try {

            $task = $this->model->getTaskByID($task_id);
            if (!$task) {
                throw new Exception('Заданьице не найдено.');
            }
            $cg = new controller_group();
            $group = $cg->getGroupByID($task['group_id']);
            if (!$group) {
                throw new Exception('Группа не найдена.');
            }
            if (!$group['active']) {
                parent::info("Группа " . $group['grade'] . " " . $group['year'] . " находится в архиве. Добавление занятий невозможно.", "/group/view/" . $group['id']);
            }
            $view['group'] = $group;
            $view['task'] = $task;
            $view['date'] = dateConverter::sqlToDate($task['taskdate']);
            // print_r($view);
            //print_r($view['task']['description']);
            parent::show("Изменение занятия", "app/view/view_change_task.php", $view);
        } catch (Exception $exc) {
            parent::notFound($exc->getMessage());
        }
    }

    public function action_post_change($task_id = null) {
        parent::teacherRequired();
        if (is_null($task_id)) {
            parent::notFound();
            exit();
        }
        try {
            $task = $this->getTaskByID($task_id);
            if (!$task) {
                throw new Exception('Заданьице не найдено.');
            }
            $this->model->updTask($task_id, $_POST['name'], $_POST['maxScore'], $_POST['description'],dateConverter::dateToSql($_POST['date']));
            parent::info("Судя по всему, занятие изменено довольно таки успешно", "/task/view/" . $task_id);
            //parent::show("Добавление нового занятия", "app/view/view_addtask.php", $view);
        } catch (Exception $exc) {
            parent::notFound($exc->getMessage());
        }
    }

    public function getTasksForGroup($group_id) {
        $tasks = $this->model->getAllGroupTasks($group_id);
        return $tasks;
    }

    public function getRatingTasksForGroup($group_id) {
        $tasks = $this->model->getGroupRatingTasks($group_id);
        return $tasks;
    }
    public function getAttentanceTasksForGroup($group_id) {
        $tasks = $this->model->getGroupAttendanceTasks($group_id);
        return $tasks;
    }
    
        public function getAllRatingByTaskID($task_id)
    {
        return $this->model->getAllRatingByTaskID($task_id);
    }
    
            public function getAllRatingByStudentID($student_id)
    {
        return $this->model->getALLRatingByStudentID($student_id);
    }
    
    public function groupTasks(array $tasks) //Группировка заданий по месяцам и периодам. Для будущего использования.
    {
        $tasksWithDate =  array_map(function($value){$value['time'] =  getdate(strtotime($value['taskdate'])); return $value;}, $tasks);
        $tasksWithDate = $this->groupTasksBy($tasksWithDate, 'year');
        foreach ($tasksWithDate as $key => $value) {
            if ($key==1970)
            {
              $datum[-1]=$value;  
            }
            else
            {
            $datum[$key]=$this->groupTasksBy($value, 'mon');
            }
        }
        return $datum;
    }
    

    
    private function groupTasksBy(array $tasks, $criteria) //Внутренняя функция группировки заданий.
    {
        $array = array();
        foreach ($tasks as $value) {
            $array[$value['time'][$criteria]][]=$value;
        }
        ksort($array);
        return $array;
    }
    
            public function action_bulkAddTasks($group) //For testing
        {
            parent::adminRequired();
            $date = new DateTime('2015-09-05');
            for ($index = 0; $index < 20; $index++) {
                $date->add(new DateInterval('P7D'));
                $this->model->addTask("Занятие ".$index, 10, "Шаблонное описание", $group, $date->format('Y-m-d'));
            }
        }
    
    
}

?>