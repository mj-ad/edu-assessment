<?php
require_once __DIR__ . '/controllers/StudentController.php';
$controller = new StudentController();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

if (preg_match('#^students/?$#', $uri)) {
    if ($method === 'GET') {
        $controller->indexView();
    } elseif ($method === 'POST') {
        $controller->store();
    }
} elseif (preg_match('#^students/search$#', $uri)) {
    if ($method === 'GET') {
        $controller->search();
    }
} elseif (preg_match('#^students/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];
    if ($method === 'GET') {
        $controller->showView($id);
    } elseif ($method === 'POST') {
        $controller->update($id);
    } elseif ($method === 'DELETE') {
        $controller->destroy($id);
    }
} elseif (preg_match('#^students/(\d+)/edit$#', $uri, $matches)) {
    $id = (int)$matches[1];
    if ($method === 'GET') {
        $controller->editView($id);
    } elseif ($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
        $controller->update($id);
    }
} elseif (preg_match('#^students/feestatus/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];
    if ($method === 'PUT') {
        $controller->updateFeeStatus($id);
    }
} elseif ($uri === 'add-student') {
    if ($method === 'GET') {
        $controller->addView();
    } elseif ($method === 'POST') {
        $controller->store();
    }
} else {
    json_response(['error' => 'Route not found'], 404);
}