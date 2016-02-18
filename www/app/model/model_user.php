<?php
include_once 'app/model/model_db.php';
const session_timeout=3600;
global $err;

class model_user
{	
	/*
	public function getUser($username)
	{
			
		return model_db::get_instance()->DB->query('SELECT * from users where login = "'.$username.'"')->fetch();
	}
	*/

	public function getUsersFromGroup($group_id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT users.*, students.*, groups_students.*
    			FROM users
    			LEFT JOIN students ON users.id = students.user_id
    			LEFT JOIN groups_students ON students.user_id = groups_students.student_id
				WHERE groups_students.group_id = :group_id AND groups_students.current = 1';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
		$stmt->execute();
		$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $students;
	}
        
	public function getOldUsersFromGroup($group_id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT users.*, students.*, groups_students.*
    			FROM users
    			LEFT JOIN students ON users.id = students.user_id
    			LEFT JOIN groups_students ON students.user_id = groups_students.student_id
				WHERE groups_students.group_id = :group_id AND groups_students.current = 0';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':group_id', $group_id);//, PDO::PARAM_INT);
		$stmt->execute();
		$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $students;
	}
        
	public function getDeadSouls()
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT users.*, students.* FROM students
    			LEFT JOIN users ON users.id = students.user_id WHERE NOT EXISTS
				(SELECT * FROM groups_students as kek WHERE kek.student_id = user_id AND kek.current = 1)';
                $stmt = $pdo->prepare($sql);
		$stmt->execute();
		$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $students;
	}	


    public function getCurrentGroupID($student_id)
    {
        $pdo = model_db::get_instance()->DB;
		$sql = 'SELECT group_id
    			FROM groups_students
				WHERE student_id = :student_id AND current = 1';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
		$stmt->execute();
		$grp = $stmt->fetch(PDO::FETCH_ASSOC);
		return $grp;
    }
    
	public function getLastSimiliarUsername($login)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT login from users where login REGEXP "^' . $login .'(\_[[:digit:]]+)?$" ORDER BY login DESC LIMIT 1';
		$stmt = $pdo->prepare($sql);
		//$stmt->bindParam(':login', $login);//, PDO::PARAM_STR, 40);
		$stmt->execute();
		$user =  $stmt->fetch(PDO::FETCH_ASSOC); 
		return $user['login'];
	}

	public function getStudentCardByID($user_id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT users.*, students.*
    			FROM students
    			LEFT JOIN users
				ON students.user_id = users.id
				WHERE students.user_id = :user_id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->execute();
		$student = $stmt->fetch(PDO::FETCH_ASSOC);
		return $student;
	}

	public function getTeacherCardByID($user_id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT users.*, teachers.*
    			FROM teachers
    			LEFT JOIN users
				ON teachers.user_id = users.id
				WHERE teachers.user_id = :user_id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->execute();
		$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
		return $teacher;
	}

	public function getUserByID($id)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT * from users where id = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id);//, PDO::PARAM_INT);
		$stmt->execute();
		$user =  $stmt->fetch(PDO::FETCH_ASSOC); 
		$rights = $user['rights'];

		if ($rights == 0 || $rights == 1)
		{
			$usercard = $this->getTeacherCardByID($id);
		}
		else
		{
			$usercard = $this->getStudentCardByID($id);
		}
		return $usercard;
	}
	
	public function getUser($username)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT * from users where login = :login';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':login', $username);//, PDO::PARAM_INT);
		$stmt->execute();
		$user =  $stmt->fetch(PDO::FETCH_ASSOC); //model_db::get_instance()->DB->query('SELECT * from users where login = "'.$username.'"')->fetch();	$id = $user['id'];
		$rights = $user['rights'];
		$id = $user['id'];
		if ($rights == 0 || $rights == 1)
		{
			$usercard = $this->getTeacherCardByID($id);
		}
		else
		{
			$usercard = $this->getStudentCardByID($id);
		}
		return $usercard;
	}

	public function getUserID($username)
	{
		$statement = $this->getUser($username);
		return $statement['id'];
	}

	public function getAllTeachers()
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT users.*, teachers.*
    			FROM teachers
    			LEFT JOIN users
				ON teachers.user_id = users.id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $teachers;
	}

	public function updTeacherByID($user_id, $fio)
	{
		$pdo = model_db::get_instance()->DB;
		
		$sql = 'UPDATE teachers SET fio = :fio WHERE user_id = :user_id' ;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':fio', $fio);//, PDO::PARAM_STR, 80);
		$stmt->execute();
	}


	public function updTeacher($username, $fio)
	{
		$user = $this->getUser($username);
		$user_id = $user['id'];
		
		$pdo = model_db::get_instance()->DB;

		$sql = 'UPDATE teachers SET fio = :fio WHERE user_id = :user_id' ;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':fio', $fio);//, PDO::PARAM_STR, 80);
		$stmt->execute();
	}

	public function updStudentByID($user_id, $student)
	{
		
		$pdo = model_db::get_instance()->DB;
		
		$sql = 'UPDATE students
				SET
				fio = :fio,
				placeofliving = :placeofliving,
				schoolgrade = :schoolgrade,
				birthdate = :birthdate,
				phone = :phone,
				email = :email,
				school = :school,
				parentfio = :parentfio,
				parentphone = :parentphone
				WHERE user_id = :user_id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':fio', $student[fio]);//, PDO::PARAM_STR, 80);
	  	$stmt->bindParam(':placeofliving', $student[placeofliving]);//, PDO::PARAM_STR, 200);
	  	$stmt->bindParam(':schoolgrade', $student[schoolgrade]);//, PDO::PARAM_INT);
	  	$stmt->bindParam(':birthdate', $student[birthdate]);
	  	$stmt->bindParam(':phone', $student[phone]);//, PDO::PARAM_STR, 15);
	  	$stmt->bindParam(':email', $student[email]);//, PDO::PARAM_STR, 40);
	  	$stmt->bindParam(':school', $student[school]);//, PDO::PARAM_STR, 200);
	  	$stmt->bindParam(':parentfio', $student[parentfio]);//, PDO::PARAM_STR, 80);
	  	$stmt->bindParam(':parentphone', $student[parentphone]);//, PDO::PARAM_STR, 15);
	  	$stmt->execute();
	}

	public function updStudent($username, $student)
	{
		$user = $this->getUser($username);
		$user_id = $user['id'];
		$pdo = model_db::get_instance()->DB;
		
		$sql = 'UPDATE students
				SET
				fio = :fio,
				placeofliving = :placeofliving,
				schoolgrade = :schoolgrade,
				birthdate = :birthdate,
				phone = :phone,
				email = :email,
				school = :school,
				parentfio = :parentfio,
				parentphone = :parentphone
				WHERE user_id = :user_id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':fio', $student[fio]);//, PDO::PARAM_STR, 80);
	  	$stmt->bindParam(':placeofliving', $student[placeofliving]);//, PDO::PARAM_STR, 200);
	  	$stmt->bindParam(':schoolgrade', $student[schoolgrade]);//, PDO::PARAM_INT);
	  	$stmt->bindParam(':birthdate', $student[birthdate]);
	  	$stmt->bindParam(':phone', $student[phone]);//, PDO::PARAM_STR, 15);
	  	$stmt->bindParam(':email', $student[email]);//, PDO::PARAM_STR, 40);
	  	$stmt->bindParam(':school', $student[school]);//, PDO::PARAM_STR, 200);
	  	$stmt->bindParam(':parentfio', $student[parentfio]);//, PDO::PARAM_STR, 80);
	  	$stmt->bindParam(':parentphone', $student[parentphone]);//, PDO::PARAM_STR, 15);
	  	$stmt->execute();
	}

	public function updUserPassword($username, $pass)
	{
		$sql = 'UPDATE users
				SET
				pass = :pass
				WHERE login = :login';
                $pdo = model_db::get_instance()->DB;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':login', $username);//, PDO::PARAM_STR, 40);
		$stmt->bindParam(':pass', $pass);//, PDO::PARAM_STR, 40);
		$stmt->execute();
	}

	public function updUserPasswordByID($id, $pass)
	{
		$sql = 'UPDATE users
				SET
				pass = :pass
				WHERE id = :id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id);//, PDO::PARAM_STR, 40);
		$stmt->bindParam(':pass', $pass);//, PDO::PARAM_STR, 40);
		$stmt->execute();		
	}

	public function username_is_free($username)
	{
		$user = $this->getUser($username);
		if (is_null($user) || !$user)
		{
			return 1;
		}
		else
		{
			$GLOBALS['err'] = "Username already taken!";
			return 0;
		}
	}

	public function user_exists($username)
	{
		$user = $this->getUser($username);
		if (!is_null($user) && $user)
		{
			return 1;
		}
		else
		{
			$GLOBALS['err'] = "User doesnt exist!";
			return 0;
		}
	}
	
	public function username_is_ok($username)
	{
		if ($username)
			return true;
		else
		{
			$GLOBALS['err']="I do not like this username. Take another one, please.";
			return false;
		}
	}

	public function password_is_ok($password)
	{
		return true;
	}

	public function password_matches($username, $password)
	{
		//echo "starting<br/>";
		$statement = $this->getUser($username);
		if ($statement['pass'] == $password)
			return 1;
		else
		{
			$GLOBALS['err']="Wrong password (or username?). Try another password. Or Username.";
			return 0;
		}
	}

	public function make_session($username)
	{
		$hash=md5($username.rand());
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT * FROM sessions WHERE hash = :hash';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':hash', $hash);//, PDO::PARAM_INT);
		$stmt->execute();
		$statement = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($statement) == 0)

		{
			$uid = $this->getUserID($username);
			$sql = 'INSERT INTO `sessions` (`hash`, `user_id`) VALUES (:hash, :user_id)';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':hash', $hash);//, PDO::PARAM_INT);
			$stmt->bindParam(':user_id', $uid);
			$stmt->execute();
									
			return $hash;
		}
		else
			echo "Really rare error. Better to fix it somehow. Just in case, you know";
			//return (model_db::get_instance()->DB->query('DROP table goddamnTables.AllOfThem;');

	}

	public function changeContact($id, $contact)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'UPDATE users SET address = :contact WHERE id = :id' 	;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':contact', $contact);//, PDO::PARAM_INT);
		$stmt->bindParam(':id', $id);//, PDO::PARAM_INT);
		$stmt->execute();

	}
	
	//is authorized
		//$statement = model_db::get_instance()->DB->query('SELECT * from (SELECT * from user WHERE login="'.$username.'") as t1 join session on session.user_id=t1.id')->fetch();
	public function is_valid_session($username, $hash)
	{
		
		$pdo = model_db::get_instance()->DB;
		$sql = 'SELECT * from users join sessions on sessions.user_id = users.id where (login = :username AND hash = :hash)';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':username', $username);//, PDO::PARAM_INT);
		$stmt->bindParam(':hash', $hash);//, PDO::PARAM_INT);
		$stmt->execute();
		$statement = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($statement) > 0)
		{
                        //echo "".strtotime($statement[0]['time']).":".session_timeout.":".$_SERVER['REQUEST_TIME']."<br/>";
			//echo (strtotime($statement[0]['time'])session_timeout>$_SERVER['REQUEST_TIME']);
			if (strtotime($statement[0]['time'])+session_timeout>$_SERVER['REQUEST_TIME'])
			{
				return 1;
			}
			else
			{
                            //echo "expired:".strtotime($statement[0]['time'].":".$_SERVER['REQUEST_TIME'];
				$this->delete_session($hash);
				return 0;
			}
		}
		else
			return 0;
	}


	public function create_user($username, $password, $fio, $usertype)
	{
		$rights = $usertype;
		/*
		switch ($usertype)
		{
			case "admin":
				$rights = 0;
				break;
			case "teacher":
				$rights = 1;
				break;
			case "student"
				$rights = 2;
				break; 
		}
		*/
		$pdo = model_db::get_instance()->DB;
		

		$sql = 'INSERT INTO users (id, login, pass, rights) VALUES (NULL, :login, :pass, :rights)' ;
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':login', $username);//, PDO::PARAM_STR, 40);
		$stmt->bindParam(':pass', $password);//, PDO::PARAM_STR, 40);
		$stmt->bindParam(':rights', $rights);//, PDO::PARAM_INT);
		$stmt->execute();

		$user_id = $pdo->lastInsertId();
		if ($rights == 0 || $rights == 1)
		{
			$sql = 'INSERT INTO teachers (user_id, fio) VALUES (:user_id, :fio)' ;
		}
		else
		{
			$sql = 'INSERT INTO students (user_id, fio, placeofliving, schoolgrade, birthdate, phone, email, school, parentfio, parentphone) 
			VALUES (:user_id, :fio, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)' ;	
		}
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->bindParam(':fio', $fio);//, PDO::PARAM_STR, 80);
		$stmt->execute();
		$user = $this->getUserByID($user_id); 
		return $user;
	}

	public function changeGroupForStudent($oldgroup_id, $newgroup_id, $student_id)
	{
		$pdo = model_db::get_instance()->DB;
		if ($oldgroup_id > 0)
		{
			$sql = 'UPDATE groups_students SET current = 0 WHERE group_id = :group_id AND student_id = :student_id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':group_id', $oldgroup_id);//, PDO::PARAM_INT);
			$stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
			$stmt->execute();
		}
                if ($newgroup_id > 0)
                {
                    $sql = 'SELECT * FROM groups_students WHERE group_id = :group_id AND student_id = :student_id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':group_id', $newgroup_id);//, PDO::PARAM_INT);
                    $stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
                    $stmt->execute();
                    $record = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (is_null($record) || !$record)
                    {
                            $sql = 'INSERT INTO groups_students (group_id, student_id, current) VALUES (:group_id, :student_id, 1)';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':group_id', $newgroup_id);//, PDO::PARAM_INT);
                            $stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
                            $stmt->execute();
                    }
                    else
                    {
                            $sql = 'UPDATE groups_students SET current = 1 WHERE group_id = :group_id AND student_id = :student_id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':group_id', $newgroup_id);//, PDO::PARAM_INT);
                            $stmt->bindParam(':student_id', $student_id);//, PDO::PARAM_INT);
                            $stmt->execute();	
                    }
                }
	}

	public function deleteAllUsernameSessions($username)
	{
		$user_id = $this->getUserID($username);
		$pdo = model_db::get_instance()->DB;
		$sql = 'DELETE FROM sessions WHERE user_id = :user_id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':user_id', $user_id);//, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function delete_session($hash)
	{
		$pdo = model_db::get_instance()->DB;
		$sql = 'DELETE FROM sessions WHERE hash = :hash';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':hash', $hash);//, PDO::PARAM_INT);
		$stmt->execute();
	}

}

?>