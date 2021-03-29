<?php

// Route URL paths
if($request->is('GET','persons')) {
	$response->persons = $db->all('SELECT * FROM persons ORDER BY id');
}
else if($request->is('GET','persons/[0-9]+')) {
	$person_id = (int) $request->segment(1);
	$response->person = $db->one('SELECT * FROM persons WHERE id = ?', [ $person_id ]);
	if(!$response->person) {
		$response->code(404);
		$response->error('404: Person Not Found.');
	}
}
else if($request->is('POST','persons/[0-9]+') || $request->is('POST','persons')) {
	$person_id = (int) $request->segment(1, 0);
	$person = $request->data;
	if($person) {	
		if(strlen($person->fname) < 1) $response->error('First Name is empty.');
		if(strlen($person->lname) < 1) $response->error('Last Name is empty.');
		if(strlen($person->address) < 3) $response->error('Address is shorter then 3 characters.');
	}
	else {
		$response->error('No JSON data sent.');
	}
	
	if($response->hasErrors()) {
		$response->code(400);
		$response->error('400: Invalid input.');
	}
	else {
		if($person_id > 0) { // update existing
			$result = $db->exec(
				'UPDATE persons SET fname=?, lname=?, address=? WHERE id=?', 
				[$person->fname, $person->lname, $person->address, $person_id]
			);
		} else { // insert new
			$result = $db->exec(
				'INSERT INTO persons SET fname=?, lname=?, address=?', 
				[$person->fname, $person->lname, $person->address]
			);
			$person_id = $db->insert_id;
		}
		
		$response->person = $db->one('SELECT * FROM persons WHERE id = ?', [$person_id]);
		$response->info('Person saved.');	
	}
}
else if($request->is('DELETE','persons/[0-9]+')) {
	$person_id = (int) $request->segment(1);
	$db->exec('DELETE FROM telephones WHERE person_id = ?', [$person_id] );
	$db->exec('DELETE FROM persons WHERE id = ?', [$person_id] );
	$response->info("Person id=$person_id and its telephones deleted.");
}
else if($request->is('GET','persons/[0-9]+/telephones')) {
	$person_id = (int) $request->segment(1);
	$response->person = $db->one('SELECT * FROM persons WHERE id = ?', [$person_id] );
	$response->telephones = [];
	if($response->person) {
		$response->telephones = $db->all('SELECT * FROM telephones WHERE person_id = ?', [$person_id] );
	}
	else {
		$response->code(404);
		$response->error("404: Person id=$person_id not found.");
	}
}
else if($request->is('GET','telephones/[0-9]+')) {
	$telephone_id = (int) $request->segment(1);
	$response->telephone = $db->one('SELECT * FROM telephones WHERE id = ?', [ $telephone_id ]);
	if(!$response->telephone) {
		$response->code(404);
		$response->error('404: Telephone Not Found.');
	}
}
else if($request->is('POST','telephones/[0-9]+') || $request->is('POST','telephones')) {
	$telephone_id = (int) $request->segment(1);
	$telephone = $request->data; // deserialized JSON object sent over the network.
	if($telephone) {
		if(strlen($telephone->number) < 1) $response->error('Number is empty.');
		if($telephone->person_id < 1) $response->error('Missing person_id.');
		if($telephone->teltype_id < 1) $response->error('Type is empty.');
//		$teltype = $db->one("SELECT * FROM teltypes WHERE id = ?", [$telephone->teltype_id + 0]);
//		if(!$teltype) $response->error('Type is invalid.');
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
			$result = $db->exec('UPDATE telephones SET person_id=?, teltype_id=?, number=? WHERE id=?', $args);
		} else { // insert new
			$result = $db->exec('INSERT INTO telephones SET person_id=?, teltype_id=?, number=?', $args);
			$telephone_id = $db->insert_id;
		}

		$response->telephone = $db->one('SELECT * FROM telephones WHERE id = ?', [$telephone_id]);
		$response->info('Telephone saved.');	
	}
}
else if($request->is('DELETE','telephones/[0-9]+')) {
	$telephone_id = (int) $request->segment(1);
	$db->exec('DELETE FROM telephones WHERE id = ?', [$telephone_id] );
	$response->info("Telephone id=$telephone_id deleted.");
}
else if($request->is('GET','teltypes')) {
	$response->teltypes = $db->all('SELECT * FROM teltypes ORDER BY id');
}
else {
	$response->error('404: URL Not Found: /'.$request->path);
	$response->code(404);
}

// Outputs $response object as JSON to the client.
echo $response->render();
