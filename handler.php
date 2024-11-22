<?php
session_start();

define('API_URL', 'https://crm.belmar.pro/api/v1');
define('TOKEN', 'ba67df6a-a17c-476f-8e95-bcdb75ed3958');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_GET['action']) && $_GET['action'] === 'addLead')) {
    $data = validateData();
    $response = addLead($data);
    $responseBody = json_decode($response, true);
    if (!isset($responseBody['status']) || $responseBody['status'] !== true) {
        $_SESSION['errors'][] = $responseBody['error'] ?? 'Unknown error.';
        header('Location: index.php');
        exit;
    }
    $_SESSION['success'] = "Lead add success";
    header('Location: index.php');
    exit;
}

function addLead(array $data)
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL . '/addlead',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'token: ' . TOKEN
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function validateData()
{
    $errors = [];
    $data = [
        'firstName' => $_POST['firstName'] ?? null,
        'lastName' => $_POST['lastName'] ?? null,
        'phone' => $_POST['phone'] ?? null,
        'email' => $_POST['email'] ?? null,
        'countryCode' => 'RU',
        'box_id' => 28,
        'offer_id' => 3,
        'landingUrl' => $_SERVER['HTTP_HOST'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'password' => 'qwerty12',
        'language' => 'ru',
    ];

    foreach (['firstName', 'lastName', 'phone', 'email'] as $field) {
        if (empty($data[$field])) {
            $errors[$field] = ucfirst($field) . ' is required.';
        }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }

    return $data;
}

function getLeadStatuses($date_from = null, $date_to = null)
{
    $currentDate = date('Y-m-d');

    if ($date_from && strtotime($date_from) > strtotime($currentDate)) {
        $date_from = null;
    }
    $data = [
        'date_from' => $date_from ? $date_from . ' 00:00:00' : date('Y-m-d', strtotime('-30 days')) . ' 00:00:00',
        'date_to' => $date_to ? $date_to . ' 23:59:59' : $currentDate . ' 23:59:59',
        'page' => 1,
        'limit' => 100,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL . '/getstatuses',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'token: ' . TOKEN
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}