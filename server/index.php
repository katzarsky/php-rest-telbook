<?php

include 'include/init.php';

// Route URL paths
if($request->get('persons')) {
	$result = $db->query('SELECT * FROM persons ORDER BY id');
	$response->persons = [];
	while($p = $result->fetch_object()) {
		$response->persons[] = $p;
	}
}
else if($request->get('persons/[0-9]+')) {
	$sql = $db->bind('SELECT * FROM persons WHERE id = ?', [ (int) $request->segment(1) ]);
	$result = $db->query($sql);
	$person = $result->fetch_object();
	if($person) {
		$response->person = $person;
	}
	else {
		$response->code(404);
		$response->error('404: Person Not Found.');
	}
}
else if($request->post('persons/[0-9]+') || $request->post('persons')) {
	$person_id = $request->segment(1, 0);
	$person = $request->data;
	
	if(strlen($person->fname) < 1) $response->error('First Name is empty.');
	if(strlen($person->lname) < 1) $response->error('Last Name is empty.');
	if(strlen($person->address) < 3) $response->error('Address is shorter then 3 characters.');
	
	if($response->hasErrors()) {
		$response->code(400);
		$response->error('400: Invalid input.');		
	}
	else {
		if($person_id > 0) { // update existing
			$sql = $db->bind('UPDATE persons SET fname=?, lname=?, address=? WHERE id=?', [$person->fname, $person->lname, $person->address, $person_id]);
		} else { // insert new
			$sql = $db->bind('INSERT INTO persons SET fname=?, lname=?, address=?', [$person->fname, $person->lname, $person->address]);
		}
		$result = $db->query($sql);
		
		if($person_id == 0) { // insert
			$person_id = $db->insert_id;
		}
		
		$sql = $db->bind('SELECT * FROM persons WHERE id = ?', [$person_id]);
		$result2 = $db->query($sql);
		$response->person = $result2->fetch_object();

		$response->info('Person saved.');	
	}
}
else if($request->delete('persons/[0-9]+')) {
	$person_id = $request->segment(1);
	$db->query($db->bind('DELETE FROM telephones WHERE person_id = ?', [$person_id] ));
	$db->query($db->bind('DELETE FROM persons WHERE id = ?', [$person_id] ));
	$response->info("Person id=$person_id and its telephones deleted.");
}
else if($request->get('persons/[0-9]+/telephones')) {
	$person_id = $request->segment(1);
	$sql = $db->bind('SELECT * FROM telephones WHERE person_id = ?', [$person_id] );
	$result = $db->query($sql);
	$response->telephones = [];
	while($tel = $result->fetch_object()) {
		$response->telephones[] = $tel;
	}
}
else if($request->post('telephones/[0-9]+') || $request->post('telephones')) {
	$telephone_id = $request->segment(1, 0);
	$telephone = $request->data;
	if($telephone) {
		if(strlen($telephone->number) < 1) $response->error('Number is empty.');
		if($telephone->person_id < 1) $response->error('Missing person_id.');
		if($telephone->teltype_id < 1) $response->error('Type is empty.');
	}
	else {
		$response->error('No JSON data sent.');
	}
	
	if($response->hasErrors()) {
		$response->code(400);
		$response->error('400: Invalid input.');		
	}
	else {
		$args = [$telephone->person_id, $telephone->teltype_id, $telephone->number, $telephone_id];
		if($telephone_id > 0) { // update existing
			$sql = $db->bind('UPDATE telephones SET person_id=?, teltype_id=?, number=? WHERE id=?', $args);
		} else { // insert new
			$sql = $db->bind('INSERT INTO telephones SET person_id=?, teltype_id=?, number=?', $args);
		}
		$result = $db->query($sql);
		
		if($telephone_id == 0) { // insert
			$telephone_id = $db->insert_id;
		}
		
		$sql = $db->bind('SELECT * FROM telephones WHERE id = ?', [$telephone_id]);
		$result2 = $db->query($sql);
		$response->telephone = $result2->fetch_object();

		$response->info('Telephone saved.');	
	}
}
else if($request->delete('telephones/[0-9]+')) {
	$telephone_id = $request->segment(1);
	$sql = $db->bind('DELETE FROM telephones WHERE id = ?', [$telephone_id] );
	$result = $db->query($sql);
	$response->info("Telephone id=$telephone_id deleted.");
}
else if($request->get('teltypes')) {
	$sql = $db->bind('SELECT * FROM teltypes ORDER BY id');
	$result = $db->query($sql);
	$response->teltypes = [];
	while($tt = $result->fetch_object()) {
		$response->teltypes[] = $tt;
	}
}
else {
	$response->error('404: URL Not Found: /'.$request->path);
	$response->code(404);
}

// Output to the client
echo $response->render();
