# php-rest-telbook/server

The backend. It uses a MySql database to persist the data. A sample database is in the `db/` subdirectory.

## index.php 

Setups all objects needed. Calls `router.php` at the end.

## router.php 

Evaluates the request URL and renders JSON output.

## include/JsonRequest.php

Parses input environment. Provides test methods for the router.

### Methods:

  - `get($regexp)` returns true if URL matches `$regexp` and method is `GET`
  - `put($regexp)` returns true if URL matches `$regexp` and method is `PUT`
  - `post($regexp)` returns true if URL matches `$regexp` and method is `POST`
  - `delete($regexp)` returns true if URL matches `$regexp` and method is `DELETE`
  - `any($regexp)` returns true if URL matches `$regexp`
  - `segment($n)` returns the value of the `$n`-th segment
  
### Properties:

  - `$path` contains the `PATH` part of the URL
  - `method` contains `GET` `POST` `DELETE` etc.
  - `data` contains parsed JSON sent from the browser

## include/JsonResponse.php

Creates JSON serialized response. It is used even in case of an error.
  
### Methods:
  - `code($code)` Sets the HTTP status code
  - `info($message)` Adds a success message to `->messages[]`
  - `error($message)` Adds an error message to `->messages[]`

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
  - `querybind($sql, $args)` Same as above but executes the `$sql`. Good for `INSERT`, `UPDATE`, `DELETE`
  - `querybind_one($sql, $args)` Executes the `$sql` and returns first row as object. Good for `SELECT` by primary key.
  - `querybind_all($sql, $args)` Executes the `$sql` and returns all rows as array of object. Good for `SELECT`
