<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = true;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

$route['scoreList']['GET'] = 'api/home/scoreList';
$route['scoreList/(:num)']['GET'] = 'api/home/scoreListByUser/$1';
$route['globalScoreAvg/(:num)']['GET'] = 'api/home/globalScoreAvg/$1';
$route['userScoreAvg/(:num)']['GET'] = 'api/home/userScoreAvg/$1';
// $route['addScore']['POST'] = 'api/home/addScore';
$route['addScore/(:num)/(:num)/(:num)']['GET'] = 'api/home/addScore/$1/$2/$3';
$route['checkUser/(:any)']['GET'] = 'api/home/checkUser/$1';
$route['user']['GET'] = 'api/home/user';
$route['createUser/(:any)/(:num)']['GET'] = 'api/home/createUser/$1/$2';
$route['updateAge/(:num)/(:num)']['GET'] = 'api/home/updateAge/$1/$2';
