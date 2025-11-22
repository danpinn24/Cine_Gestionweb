<?php
// index.php - Router del Cine
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db/class_db.php';
require_once 'controller/ControllerPeliculas.php';

$db = DB::getInstance();
$controller = new ControllerPeliculas($db); 

$action = $_GET['action'] ?? 'home';

switch ($action) {
    // --- SECCIONES ESTÁTICAS (NUEVO) ---
    case 'nosotros':
        $controller->nosotros();
        break;

    case 'complejos':
        $controller->complejos();
        break;

    case 'contacto':
        $controller->contacto();
        break;

    // --- CARTELERA Y LISTADOS ---
    case 'home':
        $controller->mostrarCartelera();
        break;

    case 'buscar':
        $controller->buscar();
        break;

    case 'ver_reservas':
        $controller->verReservas();
        break;

    case 'top_reservas':
        $controller->topReservas();
        break;
        
    // --- GESTIÓN DE PELÍCULAS (CRUD) ---
    case 'nueva_pelicula':
        $controller->nuevaPelicula();
        break;
        
    case 'modificar_pelicula':
        $controller->modificarPelicula();
        break;
        
    case 'guardar_pelicula':
        $controller->guardarPelicula();
        break;

    case 'eliminar_pelicula':
        $controller->eliminarPelicula();
        break;

    // --- GESTIÓN DE RESERVAS (VENTA) ---
    case 'reservar_entrada':
        $controller->reservarEntrada();
        break;

    case 'confirmar_reserva':
        $controller->confirmarReserva();
        break;

    default:
        // Si la acción no existe, volvemos al home
        $controller->mostrarCartelera();
        break;
}
?>