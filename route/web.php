<?php
include_once __DIR__ . '/../app/Controllers/IndexController.php';
include_once __DIR__ . '/../app/Controllers/AddressController.php';

class Route
{
   function loadPage($db, $controllerName, $actionName = 'index')
   {
       $pathinfo = explode('/', $_SERVER['REQUEST_URI'] ?? '');
       $pathinfo = array_values(array_filter($pathinfo));
       error_log(print_r($pathinfo, 1));
       if (!empty($pathinfo) && $pathinfo[0] === 'api') {
           $entityName = $pathinfo[1];
           $action = $pathinfo[2];
           $queryParams = $_POST;
           $needAddParams = true;
           switch ($entityName) {
               case 'address':
                   $controller = new AddressController($db);
                   break;
               default:
                   $controller = new IndexController($db);
                   $action = 'index';
                   $needAddParams = false;
                   break;
           }
           $needAddParams ? $controller->$action($queryParams) : $controller->$action();
       } else {
           $pathinfo = explode('/', $_SERVER['REQUEST_URI'] ?? '');
           $pathinfo = array_values(array_filter($pathinfo));
           if (!empty($pathinfo)) {
               $entityName = $pathinfo[0];
               $action = $pathinfo[1];
               $additionalParams = $pathinfo[2];
               $needAddParams = true;
               $notFound = false;
               switch ($entityName) {
                   case 'address':
                       $controller = new AddressController($db);
                       break;
                   default:
                       $notFound = true;
                       break;
               }
               if (!$notFound) {
                   $needAddParams ? $controller->$action($additionalParams) : $controller->$action();
               } else {
                   http_response_code(404);

                   include_once __DIR__ . '/../views/notFound.php';
               }
           } else {
               $controller = new IndexController($db);
               $controller->$actionName();
           }
       }
   }
}
