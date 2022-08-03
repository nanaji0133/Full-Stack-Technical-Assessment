<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$attributes = [
    // do not change the prefix our the endpoints
    'prefix' => 'user',
    // Can change the namespace
    'namespace' => 'User',
];
$router->group(
    $attributes,
    function () use ($router, $attributes) {

    // create a new user and login the user
    // inputs: [username, password, confirm_password]
    // returns: api_token
    $router->post('/signup', 'UsersController@signup'); 
    
    // return an API token that is stored in the db/redis
    // inputs: [username, password]
    // returns: api_token
    $router->post('/login', 'UsersController@login');

    // invalidate the token api key in the db/redis.
    // Return if successful, fail for non-valid api tokens
    // inputs: [api_token]
    // return: [success]
    $router->post('/logout', 'UsersController@logout');

    // Return the username for a given api token
    // inputs: [api_token]
    // return: [username]
    $router->post('/me', 'UsersController@me');

});

$attributes = [
    // do not change the prefix our the endpoints
    'prefix' => 'todonotes',
    'namespace' => 'TodoNotes',
    'middleware' => 'auth'
];
$router->group(
    $attributes,
    function () use ($router, $attributes) {

    // return paginated results of sorted (created_at) todonotes for this user
    // inputs: [api_token, ?page]
    // returns: {notes: [{todonote}, ...], next_page_exists: boolean, prev_page_exists: boolean}
    //     todonote = {id, note_string, created_at, completed_at}
    //     next_page_exists = true only if there exists todonotes in the next page number
    //     prev_page_exists = true only if there exists todonotes in the prev page number
    $router->get('/', 'TodoNotesController@getAllTodoNotes');

    // return an API token that is stored in the db/redis
    // inputs: [api_token, todo_note_string]
    // returns: api_token
    $router->post('/create', 'TodoNotesController@store');

    // Marks a todo note as done and store the time it was finished
    // inputs: [api_token]
    // return: [success]
    $router->post('/mark/done/{todo_id}', 'TodoNotesController@markTodoNotesDone' );

    // Marks a todo note as pending
    // inputs: [api_token]
    // return: [success]
    $router->post('/mark/pending/{todo_id}', 'TodoNotesController@markTodoNotesPending');

});
