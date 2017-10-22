<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*********** USER DEFINED ROUTES *******************/
$route['itemDetail/(:num)'] = "welcome/itemDetail/$1";
$route['os/(:any)'] = "welcome/itemOs/$1";

$route['dashboard'] = 'admin';
$route['logout'] = 'admin/logout';
$route['loadChangePass'] = "admin/loadChangePass";
$route['changePassword'] = "admin/changePassword";

$route['admin/reference'] = 'admin_reference/index';
$route['admin/reference/:num'] = "admin_reference/index/$1";
$route['reference'] = 'admin/referenceNew';

$route['admin/destination'] = 'admin_destination/index';
$route['admin/destination/:num'] = "admin_destination/index/$1";
$route['admin/destination/create'] = 'admin_destination/create';
$route['admin/destination/save_create'] = 'admin_destination/saveCreate';
$route['admin/destination/edit/(:num)'] = "admin_destination/edit/$1";
$route['admin/destination/save_edit'] = "admin_destination/saveEdit";
$route['admin/destination/delete'] = 'admin_destination/delete';

$route['admin/user'] = 'admin_user/index';
$route['admin/user_init'] = 'admin_user/init_admin';
$route['admin/user/:num'] = "admin_user/index/$1";
$route['admin/user/create'] = 'admin_user/create';
$route['admin/user/save_create'] = 'admin_user/saveCreate';
$route['admin/user/edit/(:num)'] = "admin_user/edit/$1";
$route['admin/user/save_edit'] = "admin_user/saveEdit";
$route['admin/user/delete'] = 'admin_user/delete';

$route['login'] = 'user';
$route['loginMe'] = 'user/loginMe';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";
