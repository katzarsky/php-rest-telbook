# php-rest-telbook

A simple `telbook` web-application, using REST-full PHP backend.

## Utilizes:

	.htaccess (to implement URL rewriting for the server backend)

	HTML/CSS (browser visualization)
	AJAX/JSON (transport of data between server and browser)
	JQuery.js Library: https://api.jquery.com/

	PHP: http://php.net/manual/en/

	MySQL database (with 3 tables: persons, telephones, teltypes)


## Backend URLs:
				
	* [GET] persons
	* [GET, POST, DELETE] persons/{ID}
	* [GET] persons/{ID}/telephones
	* [GET] telephones
	* [GET, POST, DELETE] telephones/{ID}
	* [GET] teltypes

## JSON entities:

	* person: {id:1, fname:"Ivan", lname:"Ivanov", address:"Dragan Tsankov 47"}
	* teltype: {id:2, name:"Mobile"} 
	* telephone: {id:5, person_id:1, teltype_id:2, number:"0883199482"}
	* message: {type:"error", text:"An Error Ocurred!"}
	* server-response: {code:200, messages:[], person/persons/telephones...}
