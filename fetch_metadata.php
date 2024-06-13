<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['url'])) {
        echo json_encode(['error' => 'URL is required']);
        http_response_code(400);
        exit();
    }

    $url = $_GET['url'];

    $response = @file_get_contents($url);
    if ($response === FALSE) {
        echo json_encode(['error' => 'Error fetching the URL']);
        http_response_code(500);
        exit();
    }

    $doc = new DOMDocument();
    @$doc->loadHTML($response);

    $nodes = $doc->getElementsByTagName('title');
    $title = $nodes->item(0)->nodeValue;

    if (!$title) {
        $title = 'No title available';
    }

    echo json_encode(['title' => $title]);
    exit();
}

echo json_encode(['error' => 'Invalid request method']);
http_response_code(405);
