<?php

function ret_post($params): never {
	unset($params['a']);
	$query = http_build_query($params);
	$url = $_SERVER['PHP_SELF'];
	if (!empty($query)) {
			$url .= '?' . $query;
	}
	session_write_close();
	header("Location: " . $url, true, 303); exit();
}

function account_login($db): never {
	/* INIT */
	$params = $_GET;
	$params['r'] = 'account_login';
	/* BODY */
	$params['err'] = "invalid credentials";
	if (!isset($_POST['user'],$_POST['pass'])){goto ret;}
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$st = $db->prepare('SELECT * FROM users WHERE username=:user');
	$st->execute([':user' => $user]);
	if (!($row = $st->fetch())) {goto ret;}
	if (!password_verify($pass,$row["password"])){goto ret;}

	$_SESSION['username'] = $row["username"];
	$_SESSION['user_id']  = $row["user_id"];

	if ($row['user_type'] == 'admin') {$_SESSION['admin'] = true;}
	else                              {unset($_SESSION['admin']);}
	/* Success */
	unset($params['err']);
	unset($params['r']);

	/* DONE */
	ret:ret_post($params);
}

function account_signup($db): never {
	/* INIT */
	$params = $_GET;
	$params['r'] = 'account_signup';
	/* BODY */
	// if logged in logout
	if (isset($_SESSION['user_id'])){ session_destroy(); }

	if (!isset($_POST['user'])) { $params['err'] = 'username not set'; goto ret;}
	if (!isset($_POST['pass'])) { $params['err'] = 'password not set'; goto ret;}

	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$pass = password_hash($pass,PASSWORD_BCRYPT);
	$st = $db->prepare('INSERT INTO users (username,password) VALUES (:user, :pass)');
	try {
		$st->execute([':user' => $user, ':pass' => $pass]);
		$_SESSION["username"] = $user;
		$_SESSION["user_id"]  = $db->lastInsertId();
	} catch (Exception $e) {
		$params['err'] = 'username already taken'; goto ret;
	}
	/* Success */
	unset($params['r']);

	/* DONE */
	ret:ret_post($params);
}

function account_logout(): never {
	/* INIT */
	$params = $_GET;
	$params['r'] = 'account_logout';
	/* BODY */
	if (isset($_SESSION['user_id'])){ session_destroy(); }
	/* Success */
	unset($params['r']);
	/* DONE */
	ret:ret_post($params);
}

function account_delete($db): never {
	/* INIT */
	$params = $_GET;
	$params['r'] = 'account_delete';
	/* BODY */
	if (!isset($_SESSION['user_id'])){
		$params['err'] = 'Not logged in';
		goto ret;
	}

	$st = $db->prepare('DELETE FROM users WHERE username=:user');
	$st->execute([':user' => $user]);
	/* Success */
	unset($params['r']);
	/* DONE */
	ret:ret_post($params);
}

function cart_append($db){
	/* INIT */
	$params = $_GET;
	$params['r'] = 'cart_app';
	/* BODY */
	if (!isset($_SESSION['user_id'])){$params['err'] = 'Not logged in'; goto ret; }
	if (!isset($_POST['pID'])){$param['err'] = 'No pID in request'; goto ret;}
	if (!isset($_POST['cnt'])){$param['err'] = 'No cnt in request'; goto ret;}

	$uID = (int)$_SESSION['user_id'];
	$pID = (int)$_POST["pID"];
	$cnt = (int)$_POST["cnt"];

	$st = $db->prepare('
		INSERT INTO cart (user_id, product_id, amount) VALUES
		(:uID, :pID, :cnt)
		ON DUPLICATE KEY UPDATE
			amount = amount + VALUES(amount)
	');
	$st->execute([':uID' => $uID, ':pID' => $pID, ':cnt' =>  $cnt]);
	/* Success */
	unset($params['r']);
	/* DONE */
	ret:ret_post($params);
}

function cart_modify($db){
	/* INIT */
	$params = $_GET;
	$params['r'] = 'cart_mod';
	/* BODY */
	if (!isset($_SESSION['user_id'])){$params['err'] = 'Not logged in'; goto ret; }
	$uID = (int)$_SESSION['user_id'];

	try {
		$db->beginTransaction();

		$stDel = $db->prepare("
			DELETE FROM cart WHERE 
			user_id = :uID AND product_id = :pID
		");
		$st = $db->prepare("
			INSERT INTO cart (user_id, product_id, amount)
			VALUES (:uID, :pID, :cnt)
			ON DUPLICATE KEY UPDATE amount = VALUES(amount)
		");

		foreach ($_POST as $postID => $postCnt) {
			if (!isset($postID)) {throw new Exception("product id cannot be null");}
			$pID = (int)$postID;
			$cnt = (int)$postCnt;
			if ($cnt <= 0){
				$stDel->execute([':uID' => $uID, ':pID' => $pID]);
			} else { $st->execute([':uID' => $uID, ':pID' => $pID, ':cnt' => $cnt]); }
		}
		$db->commit();
	} catch (Exception $err) {
		$db->rollBack();
		$params['err'] = "Invalid Request"; goto ret;
	}
	/* Success */
	unset($params['r']);
	/* DONE */
	ret:ret_post($params);
}

function theme(){
	/* INIT */
	$params = $_GET;
	$params['r'] = 'theme';
	/* BODY */
	$_SESSION['bg'] = $_POST['bg'] ?? $_SESSION['bg'] ?? 'black';
	$_SESSION['fg'] = $_POST['fg'] ?? $_SESSION['fg'] ?? 'gray';
	$_SESSION['br'] = $_POST['br'] ?? $_SESSION['br'] ?? 'gray';
	/* Success */
	unset($params['r']);
	/* DONE */
	ret:ret_post($params);
}

/*----------------------------------------------------------------------------*/
function init_head($name) {
	echo "<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>{$name}</title>
<link rel='shortcut icon' href='favicon.ico'>
<link rel='stylesheet' href='css/default.css'>
<style>:root{--bg:{$_SESSION['bg']};--fg:{$_SESSION['fg']};--br:{$_SESSION['br']}}</style>
<noscript><style>
	.script{display:none !important;}
	.noscript{display:block;}
</style></noscript>
</head>";
}
function init_script() {
	echo "<main class='script' style='padding-top:50vh;text-align:center;height:100vh;'>
	javascript must be disabled
	</main>";
}

/*----------------------------------------------------------------------------*/

require_once __DIR__ . '/db.php';

session_start();

match($_GET['a']){
	// no return
	'account_login'   => account_login ($db),
	'account_logout'  => account_logout(),
	'account_signup'  => account_signup($db),
	'account_delete'  => account_delete($db),
	'cart_add'        => cart_append ($db),
	'cart_mod'        => cart_modify ($db),
	/* 'comment'         => comment($db), */
	/* 'order'           => order  ($db), */
	'theme'           => theme  (),
	// returns
	default   => null,
};

$_SESSION['bg'] = $_SESSION['bg'] ?? '#000000';
$_SESSION['fg'] = $_SESSION['fg'] ?? '#808080';
$_SESSION['br'] = $_SESSION['br'] ?? '#808080';
?>
