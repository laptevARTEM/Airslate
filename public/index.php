<?php
session_start();
include_once(__DIR__ . '/../config/db.php');
include_once(__DIR__ . '/../route/web.php');

$controllerName = $_GET['controller'] ?? 'index';
$actionName = $_GET['action'] ?? 'index';
$routing = new Route();
$db = new Db();

$routing->loadPage($db, $controllerName, $actionName);
