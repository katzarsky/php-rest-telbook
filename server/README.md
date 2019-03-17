# php-rest-telbook/server

## index.php 

Setups all objects needed.

## router.php 

Evaluates the request URL and renders JSON output.

## include/JsonRequest.php

Parses input environment. Provides test methods for the router:
  - `get($regexp)` returns true if URL matches `$regexp` and method is `GET`
  - `put($regexp)` returns true if URL matches `$regexp` and method is `PUT`
  - `post($regexp)` returns true if URL matches `$regexp` and method is `POST`
  - `delete($regexp)` returns true if URL matches `$regexp` and method is `DELETE`

## include/JsonResponse.php

Creates JSON serialized response. It is used even in case of an error.

JSON structure is:
  
  - `code` duplicate of the HTTP status code
  - `messages` an array of success of error messages
  - `data` the object or array of the actual data payload
  
  
## include/MysqliBinder.php

Provides easy anti-injection pattern through `?` markers and arguments.
