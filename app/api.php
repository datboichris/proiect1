<?php
// app/api.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permite accesul din frontend (dacă e cazul)
header('Access-Control-Allow-Methods: GET, POST');

// 1. Configurare Bază de Date (folosind numele serviciului 'db' ca host)
// >>> DATE ACTUALIZATE CONFORM .ENV-ului DUMNEAVOASTRĂ <<<
// app/api.php
// ...
// 1. Configurare Bază de Date
$host = 'db';
$db   = 'student_catalog';
$user = 'app_user';
$pass = 'secret_password';
$charset = 'utf8mb4'; // <--- ACEASTA ESTE LINIA CARE LIPSEA

// Construim DSN-ul (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // În cazul unei erori, afișează o eroare 500
    http_response_code(500);
    exit(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

$method = $_SERVER['REQUEST_METHOD'];

// 2. Afișarea listei de studenți (GET)
if ($method === 'GET') {
    $stmt = $pdo->query('SELECT id, name, year, grade FROM students ORDER BY name');
    $students = $stmt->fetchAll();
    echo json_encode($students);
    exit;
}

// 3. Adăugarea unui student nou (POST)
if ($method === 'POST') {
    // Citirea datelor din cererea POST (tip JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['name']) || empty($data['year']) || empty($data['grade'])) {
        http_response_code(400);
        exit(json_encode(['error' => 'All fields (name, year, grade) are required.']));
    }

    $name = $data['name'];
    $year = (int)$data['year'];
    $grade = (float)$data['grade'];

    // Validare simplă
    if ($year < 1 || $year > 4) {
        http_response_code(400);
        exit(json_encode(['error' => 'Year must be between 1 and 4.']));
    }

    try {
        $sql = "INSERT INTO students (name, year, grade) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $year, $grade]);

        // Răspuns de succes, returnează noul student (inclusiv ID-ul generat)
        echo json_encode([
            'message' => 'Student added successfully',
            'id' => $pdo->lastInsertId(),
            'name' => $name,
            'year' => $year,
            'grade' => $grade
        ]);
        http_response_code(201); // Created
    } catch (\PDOException $e) {
        http_response_code(500);
        exit(json_encode(['error' => 'Database insert failed: ' . $e->getMessage()]));
    }
    exit;
}

// Răspuns pentru metode neautorizate
http_response_code(405);
echo json_encode(['error' => 'Method Not Allowed']);
?>
