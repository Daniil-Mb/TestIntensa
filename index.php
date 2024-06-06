<?php

session_start();

require_once 'config.php';
require_once 'models/DB.php';
require_once 'controllers/LeadController.php';
require_once 'helpers/CSRF.php';
require_once 'helpers/Throttle.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'form';
$controller = new LeadController();

switch ($action) {
    case 'submit':
        $controller->submitForm();
        break;
    case 'list':
        $controller->listLeads();
        break;
    case 'export':
        $controller->exportCSV();
        break;
    case 'form':
    default:
        $controller->showForm();
        break;
}
?>
