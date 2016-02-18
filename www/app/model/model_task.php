<?php
include_once 'app/model/model_db.php';

global $err;

class model_task
{	
	
	public function getTaskByID($task_id)
	{
		$sql = 'SELECT * from tasks where id = :id';
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $task_id);//, PDO::PARAM_INT);
		
		$stmt->execute();
		
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function deleteTask($task_id)
	{
		$sql = 'DELETE FROM students_rating WHERE task_id = :task_id';
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute();

		$sql = 'DELETE FROM tasks where id = :id';
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function getAllGroupTasks($group_id)
	{
        $sql = "(SELECT *, 'id1' OrderKey from tasks WHERE `group_id` = :group_id AND taskdate IS NOT NULL)
        		UNION ALL
        		(SELECT *, 'id2' OrderKey from tasks where `group_id` = :group_id AND taskdate IS NULL) ORDER BY OrderKey, taskdate";
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
		
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getGroupAttendanceTasks($group_id)
	{
        $sql = 'SELECT * from tasks WHERE `group_id` = :group_id AND taskdate IS NOT NULL ORDER BY taskdate';
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
		
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getGroupRatingTasks($group_id)
	{
         $sql = "(SELECT *, 'id1' OrderKey from tasks WHERE `group_id` = :group_id AND taskdate IS NOT NULL and rating>0)
        		UNION ALL
        		(SELECT *, 'id2' OrderKey from tasks where `group_id` = :group_id AND taskdate IS NULL and rating>0) ORDER BY OrderKey, taskdate";
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
		
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	private function addRating($student_id, $task_id, $rating)
	{
        $pdo = model_db::get_instance()->DB;
		$sql = 'INSERT INTO `students_rating` (`student_id`, `task_id`, `rating`, `attendance`)
						VALUES (:student_id, :task_id, :rating, NULL)';
		$stmt = $pdo->prepare($sql);   
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':rating', $rating);//, PDO::PARAM_INT);
		$stmt->execute();
		return $pdo->lastInsertId();
	}

	private function updRating($student_id, $task_id, $rating)
	{
        $pdo = model_db::get_instance()->DB;
        $sql = 'UPDATE `students_rating`
				SET
				rating = :rating
				WHERE student_id = :student_id AND task_id = :task_id';
        $pdo = model_db::get_instance()->DB;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':rating', $rating);//, PDO::PARAM_INT;
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute(); 	
	}

	public function getRating($student_id, $task_id)
	{
        $sql = 'SELECT * from students_rating where `student_id` = :student_id AND task_id = :task_id';
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function setRating($student_id, $task_id, $rating)
	{
        $item = $this->getRating($student_id, $task_id);
		if (!is_null($item) && $item)
		{
			$this->updRating($student_id, $task_id, $rating);
		}
        else
        {
        	$this->addRating($student_id, $task_id, $rating);
        }
	}

	private function addAttendance($student_id, $task_id, $attendance)
	{
        $pdo = model_db::get_instance()->DB;
		$sql = 'INSERT INTO `students_rating` (`student_id`, `task_id`, `rating`, `attendance`)
						VALUES (:student_id, :task_id, NULL, :attendance)';
		$stmt = $pdo->prepare($sql);   
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':attendance', $attendance);//, PDO::PARAM_INT);
		$stmt->execute();
		return $pdo->lastInsertId();
	}

	private function updAttendance($student_id, $task_id, $attendance)
	{
        $pdo = model_db::get_instance()->DB;
        $sql = 'UPDATE `students_rating`
				SET
				attendance = :attendance
				WHERE student_id = :student_id AND task_id = :task_id';
        $pdo = model_db::get_instance()->DB;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':attendance', $attendance);//, PDO::PARAM_INT;
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute(); 	
	}

	public function getAttendance($student_id, $task_id)
	{
        $sql = 'SELECT * from students_rating where `student_id` = :student_id AND task_id = :task_id';
        $pdo = model_db::get_instance()->DB;
        $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function setAttendance($student_id, $task_id, $attendance)
	{
        $item = $this->getAttendance($student_id, $task_id);
		if (!is_null($item) && $item)
		{
			$this->updAttendance($student_id, $task_id, $attendance);
		}
        else
        {
        	$this->addAttendance($student_id, $task_id, $attendance);
        }
	}

// Эта функция полностью дублирует предыдущую
//	public function getAllGroupRating($group_id)
//	{
//		$sql = 'SELECT * from tasks where group_id = :group_id';
//                $pdo = model_db::get_instance()->DB;
//                $stmt = $pdo->prepare($sql);
//		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
//		
//		$stmt->execute();
//
//		return $stmt->fetchAll(PDO::FETCH_ASSOC);
//	}


	public function addTask($taskname, $rating, $description, $group_id, $taskdate) //($task)
	{
		$task['group'] = $group_id;
		$task['taskdate'] = $taskdate;
		$task['taskname'] = $taskname;
		$task['description'] = $description;
		$task['rating'] = $rating;

		$pdo = model_db::get_instance()->DB;
		$sql = 'INSERT INTO `tasks` (`id`, `group_id`, `taskdate`, `taskname`, `description`, `rating`)
						VALUES (NULL, :group, :taskdate, :taskname, :description, :rating)';
		$stmt = $pdo->prepare($sql);
                
		$stmt->bindParam(':group', $task['group']);//, PDO::PARAM_INT);
		$stmt->bindParam(':taskdate', $task['taskdate']);
        $stmt->bindParam(':taskname', $task['taskname']);//, PDO::PARAM_STR, 50);
		$stmt->bindParam(':description', $task['description']);//, PDO::PARAM_STR, 500);
		$stmt->bindParam(':rating', $task['rating']);//, PDO::PARAM_INT);
                
		$stmt->execute();
                //echo "lol";
                $er=$stmt->errorInfo();
                if ($er[0]!='00000'){
                    print_r($er);
                    exit();
                }
		return $pdo->lastInsertId();
	}

	public function updTask($task_id, $taskname, $rating, $description, $taskdate) //($task)
	{
		$task['id'] = $task_id;
		$task['taskdate'] = $taskdate;
		$task['taskname'] = $taskname;
		$task['description'] = $description;
		$task['rating'] = $rating;
		
		$sql = 'UPDATE tasks
				SET
				taskdate = :taskdate,
				taskname = :taskname,
				description = :description,
				rating = :rating
				WHERE id = :id';
                $pdo = model_db::get_instance()->DB;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':taskdate', $taskdate);
		$stmt->bindParam(':taskname', $taskname);//, PDO::PARAM_INT, 50);
		$stmt->bindParam(':description', $description);//, PDO::PARAM_STR, 500);
		$stmt->bindParam(':rating', $rating);//, PDO::PARAM_STR, 500);
		$stmt->bindParam(':id', $task['id']);//, PDO::PARAM_INT);
		$stmt->execute(); 	
		                //echo "lol";
                $er=$stmt->errorInfo();
                if ($er[0]!='00000'){
                    print_r($er);
                    exit();
                }	
	}

	public function getAllRatingByTaskID($task_id)
	{
		$sql = 'SELECT * from students_rating where task_id = :task_id';
                $pdo = model_db::get_instance()->DB;
                $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':task_id', $task_id);//, PDO::PARAM_INT);
		
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);	
	}
	
	public function getAllRatingByStudentID($student_id)
	{
		$sql = 'SELECT * from students_rating where student_id = :student_id';
                $pdo = model_db::get_instance()->DB;
                $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);	
	}

	public function delTask($task_id)
	{
		$sql = 'DELETE from tasks where id = :id';
                $pdo = model_db::get_instance()->DB;
                $stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $task_id);//, PDO::PARAM_INT);
		$stmt->execute();
		
		$sql2 = 'DELETE from students_rating where task_id = :task_id';
                
                $stmt2 = $pdo->prepare($sql2);
		$stmt2->bindParam(':id', $task_id);//, PDO::PARAM_INT);
		
		$stmt2->execute();
		
	}
}

?>