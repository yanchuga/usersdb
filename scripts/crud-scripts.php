<?
//add user
$db = new PDO('mysql:host=localhost;dbname=users_db', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//for add modal

if(isset($_POST["typepost"]) && ($_POST["typepost"]) == "addtodbmod"){

	if(isset($_POST["fname"]) && !empty($_POST["fname"])){
		//Get all state data
		$fname = $_POST["fname"];
	}
	if(isset($_POST["lname"]) && !empty($_POST["lname"])){
		//Get all state data
		$lname = $_POST["lname"];
	}
	if(isset($_POST["role"])){
		//Get all state data
		$role = intval($_POST["role"]);
	}
	if(isset($_POST["mod_checker"])){
		//Get all state data
		$mod_checker = intval($_POST["mod_checker"]);
	}

	$stmt = $db->prepare("INSERT INTO `usersinfo` (`id`, `name`, `surname`, `status`, `role`) VALUES (NULL, :name, :surname, :status,  :role)");
	$stmt->execute(array(':name' => $fname, ':surname' => $lname, ':status' => $mod_checker, ':role' => $role));
}

//for set select opt modal
if(isset($_POST["typepost"]) && ($_POST["typepost"]) == "selectopt"){

	if(isset($_POST["uids"]) && !empty($_POST["uids"])){
		//Get all state data
		$uids = $_POST["uids"];
	}
	if(isset($_POST["seloption"]) && !empty($_POST["seloption"])){
		//Get all state data
		$seloption = $_POST["seloption"];
	}

	if ($seloption == "Set active")
	{
		echo 'set act';
		print_r ($uids);
		foreach($uids as $user)
		{
		$stmt = $db->prepare("UPDATE `usersinfo` SET `status` = '1' WHERE `usersinfo`.`id` = :user");
		$stmt->execute(array(':user' => $user));
		}
	}
	if ($seloption == "Set not active")
	{
		echo 'set not act';
		print_r ($uids);
		foreach($uids as $user)
		{
		$stmt = $db->prepare("UPDATE `usersinfo` SET `status` = '0' WHERE `usersinfo`.`id` = :user");
		$stmt->execute(array(':user' => $user));
		}
	}
	if ($seloption == "Delete")
	{
		echo 'delete';
		print_r ($uids);
		foreach($uids as $user)
		{
		$stmt = $db->prepare("DELETE FROM `usersinfo` WHERE `usersinfo`.`id` = :uid");
		$stmt->execute(array(':uid' => $user));
		}
	}
}
// for delete user
if(isset($_POST["typepost"]) && ($_POST["typepost"]) == "deleteuserdb"){

	if(isset($_POST["uid"]) && !empty($_POST["uid"])){
		//Get all state data
		$uid = $_POST["uid"];
	}
	$stmt = $db->prepare("DELETE FROM `usersinfo` WHERE `usersinfo`.`id` = :uid");
	$stmt->execute(array(':uid' => $uid));
}

// for edit user, select and update
if(isset($_POST["typepost"]) && ($_POST["typepost"]) == "edituserdbget"){
	// print_r($_POST);
	if(isset($_POST["uid"]) && !empty($_POST["uid"])){
		//Get all state data
		$uid = $_POST["uid"];
	}
$stmt = $db->prepare("SELECT * FROM `usersinfo` WHERE `id` = :uid");
$stmt->execute(array(':uid' => $uid));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$jsonresult= json_encode($result);	
print_r($jsonresult);
}

if(isset($_POST["typepost"]) && ($_POST["typepost"]) == "edituserdbupdate"){

	if(isset($_POST["uid"]) && !empty($_POST["uid"])){
		//Get all state data
		$uid = $_POST["uid"];
	}
	if(isset($_POST["fname"]) && !empty($_POST["fname"])){
		//Get all state data
		$fname = $_POST["fname"];
	}
	if(isset($_POST["lname"]) && !empty($_POST["lname"])){
		//Get all state data
		$lname = $_POST["lname"];
	}
	if(isset($_POST["role"])){
		//Get all state data
		$role = intval($_POST["role"]);
	}
	if(isset($_POST["mod_checker"])){
		//Get all state data
		$mod_checker = intval($_POST["mod_checker"]);
	}
	$stmt = $db->prepare("UPDATE `usersinfo` SET `name` = :fname, `surname` = :lname, `role` = :role, `status` = :mod_checker WHERE `usersinfo`.`id` = :uid");
	$stmt->execute(array(':fname' => $fname, ':lname' => $lname, ':role' => $role, ':mod_checker' => $mod_checker, ':uid' => $uid));
}
?>