# php-rest-telbook

A simple `telbook` web-application, using REST backend written in `php` and simple `js/jquery` frontend.

## How Does it Work?

	1. Browser opens `index.html` (you may omit it from the URL)
	2. `index.html` loads all `client/js` files and makes the app interactive.
	3. When browser AJAX-es to URL (that doesn't physically exist as a file) `.htaccess` reroutes request to `server/index.php`.
	4. `index.php` setups error handling and creates `$db`, `$request` and `$response`. Then calls `router.php`.
	5. `router.php` matches the URL and HTTP method and executes piece of code. Sends JSON response.
	6. Browser receives JSON and renders the data appropriately. Uses `client-render.js`.

## Utilizes:

	.htaccess (for URL rewriting at the server backend, mod_rewrite needed)

	HTML/CSS (browser visualization)
	AJAX/JSON (transport of data between server and browser)
	JQuery.js Library: https://api.jquery.com/ (ver 3.0+)

	PHP: http://php.net/manual/en/ (ver 7.0+)

	MySQL database (with 3 tables: persons, telephones, teltypes)

## Backend URLs:
				
	* [GET] persons
	* [GET, POST, DELETE] persons/{ID}
	* [GET] persons/{ID}/telephones
	* [GET] telephones
	* [GET, POST, DELETE] telephones/{ID}
	* [GET] teltypes

## JSON entities:

	* person: {id:1, fname:"Krali", lname:"Marko", address:"St. Petersburg 63"}
	* teltype: {id:2, name:"Mobile"} 
	* telephone: {id:5, person_id:1, teltype_id:2, number:"0893199422"}
	* message: {type:"error", text:"An Error Ocurred!"}
	* server-response: {code:200, messages:[], person/persons/telephones...}
