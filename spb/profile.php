<?php
include('php/autoload.php');
$userId = isset($_GET['u']) ? $_GET['u'] : 'NONE';
$userExists = false;
$users = $db->getUsers('SELECT * FROM Users WHERE userId = ? OR username = ?', array($userId, $userId), array(SQLITE3_TEXT, SQLITE3_TEXT));
if(count($users) > 0){
	$user = $users[0];
	$userExists = true;
	$templates = $db->getTemplates("SELECT * FROM Templates WHERE userId = ? OR username = ? AND reviewState = 'a' ORDER BY timeAdded", array($userId, $userId), array(SQLITE3_TEXT, SQLITE3_TEXT));
	$sourceImages = $db->getSourceImages("SELECT * FROM SourceImages WHERE userId = ? OR username = ? AND reviewState = 'a' ORDER BY timeAdded", array($userId, $userId), array(SQLITE3_TEXT, SQLITE3_TEXT));
	$admin = $user->getAdmin();
}
echo $twig->render('profile.html', array('userExists' => $userExists, 'user' => $user, 'admin' => $admin, 'templates' => $templates, 'sourceImages' => $sourceImages));
$db->close();
?>