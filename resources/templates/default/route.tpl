$routes->get('{{routeBase}}', '{{entity}}Controller::index');                     // list
$routes->get('{{routeBase}}/create', '{{entity}}Controller::create');             // form
$routes->post('{{routeBase}}/create', '{{entity}}Controller::create');            // submit
$routes->get('{{routeBase}}/edit/(:num)', '{{entity}}Controller::edit/$1');       // form
$routes->post('{{routeBase}}/edit/(:num)', '{{entity}}Controller::edit/$1');      // submit
$routes->get('{{routeBase}}/delete/(:num)', '{{entity}}Controller::delete/$1');   // delete
$routes->get('{{routeBase}}/(:num)', '{{entity}}Controller::show/$1');            // details