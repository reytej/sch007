<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "website";
$route['404_override'] = '';

$route['login'] = "site/login";

$route['users'] = "pages/users";
$route['users/(:any)'] = "pages/users/$1";
$route['admin'] = "pages/admin";
$route['admin/(:any)'] = "pages/admin/$1";

$route['academic'] = "school/academic";
$route['academic/(:any)'] = "school/academic/$1";
$route['students'] = "school/students";
$route['students/(:any)'] = "school/students/$1";
$route['enrollment'] = "school/enrollment";
$route['enrollment/(:any)'] = "school/enrollment/$1";
$route['payment'] = "school/payment";
$route['payment/(:any)'] = "school/payment/$1";
$route['class_record'] = "school/class_record";
$route['class_record/(:any)'] = "school/class_record/$1";

$route['inventory'] = "inventory/inventory";
$route['inventory/(:any)'] = "inventory/inventory/$1";
$route['items'] = "inventory/items";
$route['items/(:any)'] = "inventory/items/$1";

$route['lists'] = "core/lists";
$route['lists/(:any)'] = "core/lists/$1";
$route['fetch'] = "core/fetch";
$route['fetch/(:any)'] = "core/fetch/$1";
$route['dashboard'] = "core/dashboard";
$route['dashboard/(:any)'] = "core/dashboard/$1";
$route['cart'] = "core/cart";
$route['cart/(:any)'] = "core/cart/$1";
$route['void'] = "core/void";
$route['void/(:any)'] = "core/void/$1";
/* End of file routes.php */
/* Location: ./application/config/routes.php */