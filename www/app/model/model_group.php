<?php
include_once 'app/model/model_db.php';
$session_timeout=30;
global $err;

class model_group
{	
	public function getGroupByID($id)
	{
		$pdo = model_db::get_instance()->DB;		
		$sql = 'SELECT * from groups where id = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id);//, PDO::PARAM_INT);
		$stmt->execute();
		$group = $stmt->fetch(PDO::FETCH_ASSOC);
		return  $group;
	}

	public function getAllGroups()
	{
		$pdo = model_db::get_instance()->DB;		
		$sql = 'SELECT * from groups where active = 1';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();		
		$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $groups;
	}

	public function getAllOldGroups()
	{
		$pdo = model_db::get_instance()->DB;		
		$sql = 'SELECT * from groups where active = 0 ORDER BY year desc';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();		
		$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $groups;
	}

	public function setTeacherForGroup($teacher_id, $group_id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'UPDATE groups SET teacher_id = :teacher_id WHERE id = :group_id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':teacher_id', $teacher_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
		$stmt->execute();
	}


	public function addGroup($grade, $year)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'INSERT INTO groups (id, year, grade, teacher_id, active)
						VALUES (NULL, :year, :grade, null, 1)' ;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':year', $year);//, PDO::PARAM_INT);
		$stmt->bindParam(':grade', $grade);//, PDO::PARAM_STR, 20);
		$stmt->execute();

		return $pdo->lastInsertId();
	}

	public function setGroupArchived($id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'UPDATE groups SET active = 0 WHERE id = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id);//, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function setGroupActive($id)	
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'UPDATE groups SET active = 1 WHERE id = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id);//, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function changeGroupForStudent($oldgroup_id, $newgroup_id, $student_id)
	{
		$pdo = model_db::get_instance()->DB;
		
		if ($oldgroup_id > 0)
		{
			$sql = 'UPDATE groups_students SET current = 0 WHERE group_id = :group_id AND student_id = :student_id' ;
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':group_id', $oldgroup_id);//, PDO::PARAM_INT);
			$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
			$stmt->execute();
		}
		$sql = 'INSERT INTO groups_students (group_id, student_id, current) VALUES (:group_id, :student_id, 1)' ;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':group_id', $newgroup_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->execute();
	}
}

?>