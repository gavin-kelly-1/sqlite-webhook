<?php
if($json = json_decode(file_get_contents("php://input"), true)) {
    $data = $json;
} else {
    $data = $_POST;
}

if (!file_exists("hooks.sqlite")) {
    $db = new SQLite3('hooks.sqlite');
    $db->exec('CREATE TABLE hooks (issue INTEGER, repo TEXT, title TEXT, state TEXT);');
} else {
    $db = new SQLite3('hooks.sqlite');
}

switch ($json->action) {
    case 'opened':
	$stmt = $db->prepare("INSERT INTO hooks VALUES (:issue, :repo, :title, "open");");
	break;
    case 'closed':
	$stmt = $db->prepare("INSERT INTO hooks VALUES (:issue, :repo, :title, "closed");");
	break;
    case 'labelled':
	if ($json->label->name=="Live") {
	    $stmt = $db->prepare("INSERT INTO hooks VALUES (:issue, :repo, :title, "Live");");
	} else if ($json->label->name=="Blocked") {
	    $stmt = $db->prepare("INSERT INTO hooks VALUES (:issue, :repo, :title, "Blocked");");
	}
	break;
	
}




?>
