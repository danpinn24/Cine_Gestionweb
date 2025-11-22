<?php
require_once __DIR__ . '/../db/class_db.php';
require_once __DIR__ . '/AppController.php'; 
require_once __DIR__ . '/../model/ModelPelicula.php'; 
require_once __DIR__ . '/../model/ModelReserva.php'; 

class ControllerPeliculas extends AppController {
    
    public function __construct($db) {
        parent::__construct($db);
    }

public function nosotros() {
        $this->render('base.tpl', [
            'titulo' => 'Sobre Nosotros',
            'contenido_tpl' => 'nosotros.tpl'
        ]);
    }

    public function complejos() {
        $this->render('base.tpl', [
            'titulo' => 'Nuestras Sedes',
            'contenido_tpl' => 'complejos.tpl'
        ]);
    }

    public function contacto() {
        $this->render('base.tpl', [
            'titulo' => 'Contáctanos',
            'contenido_tpl' => 'contacto.tpl'
        ]);
    }
 public function mostrarCartelera() {
    // 1. ¿El usuario eligió una fecha? Si no, usamos la de HOY.
    $fecha_filtro = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

    // 2. Pedimos la cartelera DE ESA FECHA
    $cartelera = $this->db->getCarteleraDetallada($fecha_filtro);

    // 3. Pasamos los datos a la vista (incluyendo la fecha elegida para que el input no se borre)
    $this->render('base.tpl', [
        'titulo' => "Cartelera - Cine Tandil", 
        'cartelera' => $cartelera, 
        'fecha_actual' => $fecha_filtro, // <--- ESTO ES IMPORTANTE
        'contenido_tpl' => 'lista_peliculas.tpl'
    ]);
}
    
    public function nuevaPelicula() {
        $this->render('base.tpl', ['titulo' => 'Nueva Película', 'salas' => $this->db->getSalas(), 'contenido_tpl' => 'form_pelicula.tpl']);
    }

    public function modificarPelicula() {
        if (isset($_GET['id'])) {
            $peli = $this->db->getPelicula($_GET['id']);
            if ($peli) {
                $this->render('base.tpl', ['titulo' => 'Editar Película', 'salas' => $this->db->getSalas(), 'pelicula' => $peli, 'contenido_tpl' => 'form_pelicula.tpl']);
            } else header("Location: index.php");
        }
    }
    
    public function guardarPelicula() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['titulo']) && !empty($_POST['id_sala'])) {
                $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
                $peli = new Pelicula($_POST['titulo'], $_POST['genero'] ?? '', $_POST['horario'] ?? '00:00', (int)$_POST['id_sala'], $id);
                if ($id) $this->db->actualizarPelicula($peli);
                else $this->db->agregarPelicula($peli);
                header("Location: index.php");
                exit;
            }
        }
    }

    public function eliminarPelicula() {
        if (isset($_GET['id'])) $this->db->eliminarPelicula($_GET['id']);
        header("Location: index.php");
    }

   public function reservarEntrada() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $peli = $this->db->getPelicula($id);
            
            // NUEVO: Consultamos el stock disponible
            $stock = $this->db->getDisponibilidad($id);

            if ($peli) {
                $this->render('base.tpl', [
                    'titulo' => 'Reservar Entrada', 
                    'pelicula' => $peli, 
                    'maximo' => $stock, // <--- Enviamos el límite a la vista
                    'contenido_tpl' => 'form_reserva.tpl'
                ]);
            
        }
    }
}

    // --- FUNCIÓN CORREGIDA ---
public function confirmarReserva() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $idPeli = $_POST['id_pelicula'];
            $cant = (int)$_POST['cantidad'];
            $fechaFuncion = $_POST['fecha_funcion']; // <--- RECIBIMOS FECHA
            $nombre = $_POST['nombre_cliente'];
            $email = $_POST['email_cliente'];

            // 1. Validamos stock para ESA fecha específica
            $disponibles = $this->db->getDisponibilidadPorFecha($idPeli, $fechaFuncion);
            
            if ($disponibles < $cant) {
                throw new Exception("Solo quedan $disponibles asientos para el día $fechaFuncion.");
            }

            // 2. Obtenemos cliente
            $idCliente = $this->db->obtenerIdCliente($nombre, $email);

            // 3. Guardamos Reserva CON la fecha de función
            $reserva = new Reserva($idPeli, $idCliente, date('Y-m-d H:i:s'), $fechaFuncion, $cant);
            
            $this->db->registrarReserva($reserva);
            
            header("Location: index.php?mensaje=exito");
            exit;

        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
    // -------------------------

    public function buscar() {
        $termino = $_POST['termino'] ?? '';
        $this->render('base.tpl', ['titulo' => "Resultados: '$termino'", 'cartelera' => $this->db->buscarPeliculas($termino), 'contenido_tpl' => 'lista_peliculas.tpl']);
    }
    public function verReservas() {
        $this->render('base.tpl', ['titulo' => 'Listado de Reservas', 'reservas' => $this->db->getTodasLasReservas(), 'contenido_tpl' => 'lista_reservas.tpl']);
    }
    public function topReservas() {
        $this->render('base.tpl', ['titulo' => 'Top Películas', 'top_peliculas' => $this->db->getTopPeliculasReservadas(5), 'contenido_tpl' => 'top_reservas.tpl']);
    }



}
