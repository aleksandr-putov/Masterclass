<?php

include_once 'app/controller/controller.php';
include_once 'app/model/model_group.php';
include_once 'app/model/model_task.php';
include_once 'app/controller/controller_group.php';

class controller_rating extends controller {
    

    public function action() {
        echo "rating";
    }
    
    public function setScore($student_id, $task_id, $score, $model){
        $model->setRating($student_id, $task_id, $score);
    }
    
        public function setAttendance($student_id, $task_id, $attendance, $model){
        $model->setAttendance($student_id, $task_id, $attendance);
    }
    
    public function action_post_schange($group_id)
    {
        $json = htmlspecialchars_decode($_POST["json"]); 
        $json = preg_replace('/[^(\x20-\x7F)]*/','', $json); //Даже не спрашивайте..      

        $rate=json_decode($json, true);
       // print_r($rate);
        if (count($rate)>0)
        {
            $info;
            $model = new model_task();
            foreach ($rate as $value) {
                $info.="Adding student ".$value['id_s'].", task ".$value['id_t'].", score ".$value['score']."<br/>";
                $this->setScore($value['id_s'], $value['id_t'], $value['score'], $model);
            }
        }
        parent::info("Кажется, оценки успешно обновлены.<br/>".$info, "/rating/s/".$group_id);
    }

    public function action_s($group_id = null) {
        if (is_null($group_id)) {
            $this->action();
        } else {
            try {
                $cg = new controller_group();
                $group = $cg->getGroupByID($group_id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['group'] = $group;
                $students = $cu->getUsersFromGroup($group['id']);
                $studentsOld = $cu->getOldUsersFromGroup($group['id']);
                //foreach ($unsortedStudents as $value) {
                //    $sortedStudents[$value['id']]=$value; //Теперь к студенту можно обращаться по айди
               // }
                
                //print_r($sortedStudents);
                // print_r($view);
                $view['haveRights'] = parent::isTeacher() && $group['active'];
                // echo $view['haveRights'];
                $ct = new controller_task();
                $tasks = $ct->getRatingTasksForGroup($group_id);
                $studentsComplete;
                foreach ($students as $value) {
                     $prom_rating = $ct->getAllRatingByStudentID($value['id']);
                     //print_r($prom_rating);
                     $rating=null;
                     if ($prom_rating) {
                        foreach ($prom_rating as $value2) {
                            $rating[$value2['task_id']] = $value2;
                        }
                    }
                    $value['rating'] = $rating; //ставит в соответвтвие каждому ключу элементов массива рейтинга значение соотв задания\
                     $studentsComplete[]=$value;
                     //print_r($value);
                }
                
                
                $students = $studentsComplete;
                
                $studentsCompleteOld;
                foreach ($studentsOld as $value) {
                     $prom_rating = $ct->getAllRatingByStudentID($value['id']);
                     //print_r($prom_rating);
                     $rating=null;
                     if ($prom_rating) {
                        foreach ($prom_rating as $value2) {
                            $rating[$value2['task_id']] = $value2;
                        }
                    }
                    $value['rating'] = $rating; //ставит в соответвтвие каждому ключу элементов массива рейтинга значение соотв задания\
                     $studentsCompleteOld[]=$value;
                     //print_r($value);
                }
                
                
                $studentsOld = $studentsCompleteOld;
                
                include_once 'app/libraries/lib_dates.php';
                $tasks = array_map(function($value){ $value['taskdate'] = dateConverter::sqlToShortDate($value['taskdate']); return $value;}, $tasks);
                //print_r($tasks[3]['taskdate']);
                $view['tasks']=$tasks;
               
                $view['students'] = $students;
                $view['studentsOld'] = $studentsOld;
//                echo "<pre>\n"; 
//                print_r($students);
//                echo "</pre>";
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group_rating.php", $view);
            } catch (Exception $exc) {
                parent::notFound($group_id);
            }
        }
    }
    public function action_a($group_id = null) {
        if (is_null($group_id)) {
            $this->action();
        } else {
            try {
                $cg = new controller_group();
                $group = $cg->getGroupByID($group_id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['group'] = $group;
                $students = $cu->getUsersFromGroup($group['id']);
                $studentsOld = $cu->getOldUsersFromGroup($group['id']);
                //foreach ($unsortedStudents as $value) {
                //    $sortedStudents[$value['id']]=$value; //Теперь к студенту можно обращаться по айди
               // }
                
                //print_r($sortedStudents);
                // print_r($view);
                $view['haveRights'] = parent::isTeacher() && $group['active'];
                // echo $view['haveRights'];
                $ct = new controller_task();
                $tasks = $ct->getAttentanceTasksForGroup($group_id);
                $studentsComplete;
                foreach ($students as $value) {
                     $prom_rating = $ct->getAllRatingByStudentID($value['id']);
                     //print_r($prom_rating);
                     $rating=null;
                     if ($prom_rating) {
                        foreach ($prom_rating as $value2) {
                            $rating[$value2['task_id']] = $value2;
                        }
                    }
                    $value['rating'] = $rating; //ставит в соответвтвие каждому ключу элементов массива рейтинга значение соотв задания\
                     $studentsComplete[]=$value;
                     //print_r($value);
                }
                
                
                $students = $studentsComplete;
                
                $studentsCompleteOld;
                foreach ($studentsOld as $value) {
                     $prom_rating = $ct->getAllRatingByStudentID($value['id']);
                     //print_r($prom_rating);
                     $rating=null;
                     if ($prom_rating) {
                        foreach ($prom_rating as $value2) {
                            $rating[$value2['task_id']] = $value2;
                        }
                    }
                    $value['rating'] = $rating; //ставит в соответвтвие каждому ключу элементов массива рейтинга значение соотв задания\
                     $studentsCompleteOld[]=$value;
                     //print_r($value);
                }
                
                
                $studentsOld = $studentsCompleteOld;
                
                
                include_once 'app/libraries/lib_dates.php';
                $tasks = array_map(function($value){ $value['taskdate'] = dateConverter::sqlToShortDate($value['taskdate']); return $value;}, $tasks);
                //print_r($tasks[3]['taskdate']);
                $view['tasks']=$tasks;
               
                $view['students'] = $students;
                $view['studentsOld'] = $studentsOld;
//                echo "<pre>\n"; 
//                print_r($students);
//                echo "</pre>";
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group_attendance.php", $view);
            } catch (Exception $exc) {
                parent::notFound($group_id);
            }
        }
    }
    
    public function action_post_achange($group_id)
    {
        $json = htmlspecialchars_decode($_POST["json"]); 
        $json = preg_replace('/[^(\x20-\x7F)]*/','', $json); //Даже не спрашивайте..      

        $rate=json_decode($json, true);
       // print_r($rate);
        if (count($rate)>0)
        {
            $info;
            $model = new model_task();
            foreach ($rate as $value) {
                $info.="Adding attendance student ".$value['id_s'].", task ".$value['id_t'].", ".(($value['attendance'])?"attended":"not attended")."<br/>";
                $this->setAttendance($value['id_s'], $value['id_t'], $value['attendance'], $model);
            }
        }
        parent::info("Кажется, посещаемость успешно обновлена.<br/>".$info, "/rating/a/".$group_id);
    }
    
    public function action_achange($group_id = null) {
        parent::teacherRequired();
        if (is_null($group_id)) {
            $this->action();
        } else {
            try {
                $cg = new controller_group();
                $group = $cg->getGroupByID($group_id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['group'] = $group;
                $students = $cu->getUsersFromGroup($group['id']);
                //foreach ($unsortedStudents as $value) {
                //    $sortedStudents[$value['id']]=$value; //Теперь к студенту можно обращаться по айди
               // }
                
                //print_r($sortedStudents);
                // print_r($view);
                $view['haveRights'] = parent::isTeacher() && $group['active'];
                // echo $view['haveRights'];
                $ct = new controller_task();
                $tasks = $ct->getAttentanceTasksForGroup($group_id);
                $studentsComplete;
                foreach ($students as $value) {
                     $prom_rating = $ct->getAllRatingByStudentID($value['id']);
                     $rating=null;
                     if ($prom_rating) {
                        foreach ($prom_rating as $value2) {
                            $rating[$value2['task_id']] = $value2;
                        }
                    }
                    $value['rating'] = $rating; //ставит в соответвтвие каждому ключу элементов массива рейтинга значение соотв задания\
                     $studentsComplete[]=$value;
                }
                $students = $studentsComplete;
                include_once 'app/libraries/lib_dates.php';
                
                $tasks = array_map(function($value){ $value['taskdate'] = dateConverter::sqlToShortDate($value['taskdate']); return $value;}, $tasks);
                //print_r($tasks[3]['taskdate']);
                $view['tasks']=$tasks;
               
                $view['students'] = $students;
                //print_r($view['tasks']);
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group_attendance_change.php", $view);
            } catch (Exception $exc) {
                parent::notFound($group_id);
            }
        }
    }
    
    public function action_schange($group_id = null) {
        parent::teacherRequired();
        if (is_null($group_id)) {
            $this->action();
        } else {
            try {
                $cg = new controller_group();
                $group = $cg->getGroupByID($group_id);
                $cu = new controller_user();
                if (!$group) {
                    throw new Exception('Группа не найдена.');
                }
                $view['group'] = $group;
                $students = $cu->getUsersFromGroup($group['id']);
                //foreach ($unsortedStudents as $value) {
                //    $sortedStudents[$value['id']]=$value; //Теперь к студенту можно обращаться по айди
               // }
                
                //print_r($sortedStudents);
                // print_r($view);
                $view['haveRights'] = parent::isTeacher() && $group['active'];
                // echo $view['haveRights'];
                $ct = new controller_task();
                $tasks = $ct->getRatingTasksForGroup($group_id);
                $studentsComplete;
                foreach ($students as $value) {
                     $prom_rating = $ct->getAllRatingByStudentID($value['id']);
                     $rating=null;
                     if ($prom_rating) {
                        foreach ($prom_rating as $value2) {
                            $rating[$value2['task_id']] = $value2;
                        }
                    }
                    $value['rating'] = $rating; //ставит в соответвтвие каждому ключу элементов массива рейтинга значение соотв задания\
                     $studentsComplete[]=$value;
                }
                $students = $studentsComplete;
                include_once 'app/libraries/lib_dates.php';
                
                $tasks = array_map(function($value){ $value['taskdate'] = dateConverter::sqlToShortDate($value['taskdate']); return $value;}, $tasks);
                //print_r($tasks[3]['taskdate']);
                $view['tasks']=$tasks;
               
                $view['students'] = $students;
                //print_r($view['tasks']);
                parent::show($view['group']['grade'] . " " . $view['group']['year'], "app/view/view_group_rating_change.php", $view);
            } catch (Exception $exc) {
                parent::notFound($group_id);
            }
        }
    }

}

?>