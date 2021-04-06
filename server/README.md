# php-rest-telbook/server

The backend. It uses a MySql database to persist the data. A sample database is in the `db/` subdirectory.

## index.php 

Setups all objects needed for `database`, `error handling`, `request` and `response`.

  - `$db` instance of MysqliBinder
  - `$request` instance of JsonRequest
  - `$response` instance of JsonResponse
  
**Calls `router.php` at the end**

## router.php 

Evaluates the request URL and renders JSON output. 
Contains `if-elseif-else` structure for routing. The final else is for 404 (Not Found).
At the end renders the response as JSON.

# php-rest-telbook/server/include

## include/JsonRequest.php

Parses input environment. Provides test methods for the router.

### Methods:

  - `is($method, $regexp)` returns true if URL matches `$regexp` and method is equal to `$method`
  - `segment($n, $default=null)` returns the value of the `$n`-th segment. If it does not exist returns `$default`
   
### Properties:

  - `$path` contains the `PATH` part of the URL
  - `method` contains `GET` `POST` `DELETE` etc.
  - `body` contains unparsed body string of the request
  - `data` contains parsed JSON sent from the browser

## include/JsonResponse.php

Creates JSON serialized response. It is used even in case of an error.
  
### Methods:
  - `code($code)` Sets the HTTP status code
  - `info($message)` Adds a success message to `->messages[]`
  - `error($message)` Adds an error message to `->messages[]`
  - `hasError()` is true if `->messages[]` contains an error

### Properties:

Whatever you add as a dynamic property it will be encoded within the output JSON.
It is marked `...` below.

### Rendered JSON structure is:
  
  - `code` duplicate of the HTTP status code
  - `messages` an array of success of error messages
  - `...` the object or array of the actual data payload
  
## include/MysqliBinder.php

Provides easy anti-injection pattern through `?` markers and arguments.

### Methods:

  - `bind($sql, $args)` Replaces all `?` in `$sql` with corresponding `$args[N]`. Escapes.
  - `exec($sql, $args)` Same as above but executes the `$sql`. Good for `INSERT`, `UPDATE`, `DELETE`
  - `one($sql, $args)` Executes the `$sql` and returns first row as object. Good for `SELECT` by primary key.
  - `all($sql, $args)` Executes the `$sql` and returns all rows as array of object. Good for `SELECT`.
  
    Example: `$db->querybind_all('SELECT * FROM telephones WHERE person_id=?', [3]);`
