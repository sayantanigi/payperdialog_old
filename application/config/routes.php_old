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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = "home/signup";
$route['email-verification/(:any)'] = "user/login/emailVerification/$1";
$route['login'] = "home/login_page";
$route['forgot-password'] = "user/login/forgot_password";
$route['new-password/(:any)'] = "user/login/new_password/$1";
$route['about-us'] = "home/about";
$route['contact-us'] = "home/contact";
//$route['pricing'] = "home/pricing";
$route['vendor_pricing'] = "home/vendor_pricing";
$route['freelancer_pricing'] = "home/freelancer_pricing";
$route['privacy-policy'] = "home/privacy";
$route['term-and-conditions'] = "home/term_and_conditions";
$route['employees_list/(:any)'] = "Welcome/employees_list/$1";
$route['employer-list'] = "home/employer_list";
$route['employerdetail/(:any)'] = "Welcome/employer_detail/$1";
$route['productdetail/(:any)'] = "Welcome/product_detail/$1";
$route['workers-list'] = "home/workers_list";
$route['worker-detail/(:any)'] = "home/worker_detail/$1";
$route['ourjobs'] = "home/our_jobs";
$route['postdetail/(:any)'] = "home/post_bidding/$1";
$route['stripe/(:any)'] = "Stripe/index/$1";
$route['career-tip/(:any)'] = "home/career_tip/$1";
$route['save'] = "user/login/reg";
$route['validate'] = "user/login/validate_user";
$route['logout'] = "user/login/logout";
$route['profile'] = "user/dashboard/profile";
$route['profile/(:any)'] = "user/dashboard/profile/$1";
$route['subscription'] = "user/dashboard/subscription";
$route['myservice'] = "user/dashboard/myservice";
$route['myjob'] = "user/dashboard/myjob";
$route['dashboard'] = "user/dashboard/index";
$route['postjob'] = "welcome/post_job";
$route['search-job'] = "welcome/searchjob";
$route['addservice'] = "user/dashboard/service_form";
$route['jobbid'] = "user/dashboard/jobbid";
$route['calender'] = "user/dashboard/calender";
$route['chat'] = "user/dashboard/chat";
$route['video'] = "user/dashboard/video_call";
$route['product'] = "user/dashboard/products";
$route['password-reset'] = "user/dashboard/change_password";
$route['education-list'] = "user/dashboard/education_list";
$route['add-education'] = "user/dashboard/add_education";
$route['update-education/(:any)'] = "user/dashboard/update_education/$1";
$route['workexperience-list'] = "user/dashboard/workexperience_list";
$route['add-workexperience'] = "user/dashboard/add_workexperience";
$route['update-workexperience/(:any)'] = "user/dashboard/update_workexperience/$1";
$route['product-list'] = "user/dashboard/product_list";
$route['add-product'] = "user/dashboard/add_product";
$route['update-product/(:any)'] = "user/dashboard/update_product/$1";
$route['success/(:any)'] = "stripe/payment_success/$1";
$route['view_profile'] = "user/dashboard/view_profile";
$route['update-postjob/(:any)'] = "welcome/update_post_job/$1";
$route['checkSubscriptionForUser'] = "user/dashboard/checkSubscriptionForUser";
$route['paystackCheckout/(:any)/(:any)/(:any)'] = "Home/paystackCheckout/$1/$2/$3";

//ADMIN URL
$route['admin'] = 'admin/login/index';
$route['admin/logout'] = 'admin/login/logout';
$route['admin/dashboard'] = 'admin/login/dashboard';
$route['admin/profile'] = 'admin/login/profile';
$route['admin/jobsbid'] = 'admin/jobsbidding/index';
$route['admin/company-logo'] = 'admin/manage_home/Company_logo/index';
$route['admin/career'] = 'admin/manage_home/Career_tips/index';
$route['admin/our-services'] = 'admin/manage_home/Our_services/index';
$route['admin/banner'] = 'admin/manage_home/Banner/index';
$route['admin/email-template'] = 'admin/Email_template/index';
$route['admin/chat_details/(:any)/(:any)'] = "admin/chat/adminShowMessage_list/$1/$2";
$route['admin/deletepostdetail/(:any)'] = "admin/Post_job/deletepostdetail/$1";
