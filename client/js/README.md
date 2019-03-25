# php-rest-telbook/client

The frontend. It uses a JQuery to: 

  * Fetch data from server using AJAX: `$.get(url)`
  * Post JSON data to server: `$.postJSON(url, data)`
  * Delete data from server: `$.delete(url)`
  * Make the interface interactive: `$(document).on(event, selector, lambda_function)`
  
## client.js

Contains all event (click, submit) bindings to make the interface interactive.
Has few helper function for fetching data from server that are reused.

## client-render.js

Contains all function for rendering data and errors. They receive data and return `html` strings.

## jquery-3.1.1.js

Opensource. Downloaded from https://jquery.com/download/

## jquery-rest.js

Adds several function to JQuery:

  - $.postJSON(url, data)
  - $.delete(url)
  - $.serializeObject() - when executed on a `<form>` returns an object containing all fields with their respective values
