<?php

ob_start();



require __DIR__ . "/vendor/autoload.php";



/**

 * BOOTSTRAP

 */



use CoffeeCode\Router\Router;

use Source\Core\Session;



$session = new Session();

$route = new Router(url(), ":");

$route->namespace("Source\App");



/**

 * WEB ROUTES

 */

$route->group(null);

$route->get("/", "Web:home");





/**

 * ADMIN ROUTES

 */

$route->namespace("Source\App\Admin");

$route->group("/admin");



//login

$route->get("/", "Login:root");

$route->get("/login", "Login:login");

$route->post("/login", "Login:login");

// $route->get("/register", "Login:register");

// $route->post("/register", "Login:register");

// $route->get("/forget", "Web:forget");

// $route->post("/forget", "Web:forget");

// $route->get("/forget/{code}", "Web:reset");

// $route->post("/forget/reset", "Web:reset");



//dash

$route->get("/dash", "Dash:dash");

$route->get("/dash/home", "Dash:home");

$route->post("/dash/home", "Dash:home");

$route->get("/logoff", "Dash:logoff");

$route->get("/dash/late", "Dash:late");

$route->post("/dash/late", "Dash:late");

$route->get("/dash/completed", "Dash:completed");

$route->post("/dash/completed", "Dash:completed");

$route->get("/dash/waiting", "Dash:waiting");

$route->post("/dash/waiting", "Dash:waiting");

$route->get("/dash/inNegotiations", "Dash:inNegotiations");

$route->post("/dash/inNegotiations", "Dash:inNegotiations");

$route->get("/dash/loss", "Dash:loss");

$route->post("/dash/loss", "Dash:loss");



//users

$route->get("/users/home", "Users:home");

$route->post("/users/home", "Users:home");

$route->get("/users/home/{search}/{page}", "Users:home");

$route->get("/users/user", "Users:user");

$route->post("/users/user", "Users:user");

$route->get("/users/user/{user_id}", "Users:user");

$route->post("/users/user/{user_id}", "Users:user");



//sellers

$route->get("/sellers/home", "Sellers:home");

$route->post("/sellers/home", "Sellers:home");

$route->get("/sellers/home/{search}/{page}", "Sellers:home");

$route->get("/sellers/seller", "Sellers:seller");

$route->post("/sellers/seller", "Sellers:seller");

$route->get("/sellers/seller/{seller_id}", "Sellers:seller");

$route->post("/sellers/seller/{seller_id}", "Sellers:seller");



//clients

$route->get("/clients/home", "Clients:home");

$route->post("/clients/home", "Clients:home");

$route->get("/clients/home/{search}/{page}", "Clients:home");

$route->get("/clients/client", "Clients:client");

$route->post("/clients/client", "Clients:client");

$route->get("/clients/client/{client_id}", "Clients:client");

$route->post("/clients/client/{client_id}", "Clients:client");

//states and cities

$route->post("/clients/address/{state_id}", "Clients:address");



//general premises

$route->get("/funnels/home", "Funnels:home");

$route->post("/funnels/home", "Funnels:home");

$route->get("/funnels/home/{search}/{page}", "Funnels:home");

$route->get("/funnels/funnel", "Funnels:funnel");

$route->post("/funnels/funnel", "Funnels:funnel");

$route->get("/funnels/funnel/{funnel_id}", "Funnels:funnel");

$route->post("/funnels/funnel/{funnel_id}", "Funnels:funnel");

$route->get("/negotiations/home", "Negotiations:home");

$route->get("/negotiations/negotiation/{client_id}", "Negotiations:negotiation");

$route->post("/negotiations/negotiation/{client_id}", "Negotiations:negotiation");



//reports

$route->get("/reports/sellers", "Reports:sellers");

$route->post("/reports/sellers", "Reports:sellers");

$route->get("/reports/sellers/{search}/{page}", "Reports:sellers");

$route->get("/reports/seller/{seller_id}", "Reports:seller");

$route->get("/reports/steps", "Reports:steps");

$route->post("/reports/steps", "Reports:steps");

$route->get("/reports/steps/{search}/{page}", "Reports:steps");

$route->get("/reports/step/{seller_id}", "Reports:step");



//messages

$route->get("/messages/home", "Messages:home");

$route->get("/messages/message", "Messages:message");

$route->post("/messages/message", "Messages:message");

$route->get("/messages/message/{message_id}", "Messages:message");

$route->post("/messages/message/{message_id}", "Messages:message");

$route->get("/messages/sends", "Messages:sends");

$route->get("/messages/response/{message_id}", "Messages:response");



/**

 * ERROR ROUTES

 */

$route->group("/ops");

$route->get("/{errcode}", "Web:error");



/**

 * ROUTE

 */

$route->dispatch();



/**

 * ERROR REDIRECT

 */

if ($route->error()) {

    $route->redirect("/ops/{$route->error()}");

}



ob_end_flush();