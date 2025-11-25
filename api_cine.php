<?php
// api.php - API Completa para el Sistema de Cine
header("Content-Type: application/json"); 
header("Access-Control-Allow-Origin: *"); 

require_once 'db/class_db.php';

$db = DB::getInstance();
$recurso = $_GET['recurso'] ?? null;
$metodo = $_SERVER['REQUEST_METHOD']; 

switch ($metodo) {
    case 'GET':
        switch ($recurso) {
            
            // --- 1. PELÍCULAS ---
            case 'peliculas':
                if (isset($_GET['id'])) {
                    $pelicula = $db->getPelicula($_GET['id']);
                    if ($pelicula) {
                        echo json_encode([
                            'id' => $pelicula->getId(),
                            'titulo' => $pelicula->getTitulo(),
                            'genero' => $pelicula->getGenero(),
                            'horario' => $pelicula->getHorario(),
                            'sala_id' => $pelicula->getIdSala()
                        ]);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Pelicula no encontrada']);
                    }
                } else {
                    $peliculas = $db->getCarteleraDetallada(); 
                    echo json_encode($peliculas);
                }
                break;

            // --- 2. RESERVAS ---
            case 'reservas':
                $reservas = $db->getTodasLasReservas();
                echo json_encode($reservas);
                break;

            // --- 3. SALAS (NUEVO) ---
            case 'salas':
                $salas = $db->getSalas();
                $data = [];
                // Convertimos los Objetos Sala a Arrays para JSON
                foreach($salas as $sala) {
                    $data[] = [
                        'id' => $sala->getId(),
                        'nombre' => $sala->getNombre(),
                        'capacidad' => $sala->getCapacidad()
                    ];
                }
                echo json_encode($data);
                break;

            // --- 4. CLIENTES (NUEVO) ---
            case 'clientes':
                // Usa la función nueva que agregamos en class_db.php
                $clientes = $db->getTodosLosClientes();
                echo json_encode($clientes);
                break;

            default:
                http_response_code(400);
                echo json_encode([
                    'error' => 'Recurso no valido', 
                    'opciones_validas' => ['peliculas', 'reservas', 'salas', 'clientes']
                ]);
                break;
        }
        break;
    
    // --- SIMULACIÓN DE CREACIÓN (POST) ---
    case 'POST':
        if ($recurso == 'reservas') {
            $input = json_decode(file_get_contents('php://input'), true);
            echo json_encode(['mensaje' => 'Reserva recibida', 'datos' => $input]);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Solo se permite POST en reservas']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Metodo no permitido']);
        break;
}
?>