<?php
// db/class_db.php

require_once __DIR__ . '/../model/ModelPelicula.php'; 
require_once __DIR__ . '/../model/Model_Sala.php'; 
require_once __DIR__ . '/../model/ModelCliente.php';
require_once __DIR__ . '/../model/ModelReserva.php';

class DB {
    private static $instance = null;
    private $pdo; 
    private static $db_file = __DIR__ . '/cine.db'; 

    private function __construct() {
        try {
            $this->pdo = new PDO('sqlite:' . self::$db_file); 
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->init(); 
        } catch (PDOException $e) {
            die("Error de Base de Datos: " . $e->getMessage());
        }
    }
    
    public static function getInstance(): DB {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
    
    private function init() {
        $this->pdo->exec("PRAGMA foreign_keys = ON;");
        
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS salas (id INTEGER PRIMARY KEY AUTOINCREMENT, nombre TEXT NOT NULL, capacidad INTEGER NOT NULL)");
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS peliculas (id INTEGER PRIMARY KEY AUTOINCREMENT, titulo TEXT NOT NULL, genero TEXT, horario TEXT NOT NULL, id_sala INTEGER, FOREIGN KEY (id_sala) REFERENCES salas(id))");
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS clientes (id INTEGER PRIMARY KEY AUTOINCREMENT, nombre TEXT NOT NULL, email TEXT UNIQUE NOT NULL)");
       $this->pdo->exec("CREATE TABLE IF NOT EXISTS reservas (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        id_pelicula INTEGER NOT NULL, 
        id_cliente INTEGER NOT NULL, 
        fecha_reserva TEXT, 
        fecha_funcion TEXT,  -- <--- NUEVA COLUMNA
        cantidad_entradas INTEGER NOT NULL DEFAULT 1, 
        FOREIGN KEY (id_pelicula) REFERENCES peliculas(id), 
        FOREIGN KEY (id_cliente) REFERENCES clientes(id)
    )");
    
    // ... (Inserts de prueba quedan igual)


        // Datos de prueba iniciales (solo si está vacía)
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM salas");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO salas (nombre, capacidad) VALUES ('Sala Premium', 40)");
            $this->pdo->exec("INSERT INTO salas (nombre, capacidad) VALUES ('Sala 2D', 50)");
            $this->pdo->exec("INSERT INTO peliculas (titulo, genero, horario, id_sala) VALUES ('Gladiador 2', 'Acción', '20:00', 1)");
            $this->pdo->exec("INSERT INTO peliculas (titulo, genero, horario, id_sala) VALUES ('Moana 2', 'Animación', '17:00', 2)");
        }
    }

    // --- Mappers ---
    private function arrayToSala(array $data): Sala {
        return new Sala($data['nombre'], $data['capacidad'], $data['id']);
    }
    private function arrayToPelicula(array $data): Pelicula {
        return new Pelicula($data['titulo'], $data['genero'], $data['horario'], $data['id_sala'], $data['id']);
    }
    
    // --- FUNCIONES CRÍTICAS PARA QUE NO FALLE ---

    // 1. Obtener o Crear Cliente (NUEVA - SI FALTA ESTA, DA PANTALLA BLANCA)
    public function obtenerIdCliente($nombre, $email) {
        $stmt = $this->pdo->prepare("SELECT id FROM clientes WHERE email = ?");
        $stmt->execute([$email]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($res) {
            return $res['id'];
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO clientes (nombre, email) VALUES (?, ?)");
            $stmt->execute([$nombre, $email]);
            return $this->pdo->lastInsertId();
        }
    }

    // 2. Registrar Reserva
   public function registrarReserva(Reserva $reserva) {
    // Agregamos fecha_funcion al INSERT
    $sql = "INSERT INTO reservas (id_pelicula, id_cliente, fecha_reserva, fecha_funcion, cantidad_entradas) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $reserva->getIdPelicula(),
        $reserva->getIdCliente(),
        $reserva->getFechaReserva(),
        $reserva->getFechaFuncion(), // <--- GUARDAMOS LA FECHA ELEGIDA
        $reserva->getCantidadEntradas()
    ]);
}

    // 3. Cartelera con Stock actualizado
   // Ahora acepta un parámetro $fecha
public function getCarteleraDetallada($fecha = null): array {
    
    // Si no nos pasan fecha, usamos HOY
    if ($fecha == null) {
        $fecha = date('Y-m-d');
    }

    // Modificamos el SQL para usar el signo de pregunta (?) en la fecha
    $sql = "
        SELECT 
            p.id, p.titulo, p.genero, p.horario, p.id_sala,
            s.nombre AS sala_nombre, s.capacidad,
            SUM(COALESCE(r.cantidad_entradas, 0)) AS entradas_reservadas
        FROM peliculas p
        JOIN salas s ON p.id_sala = s.id
        -- Aquí filtramos por la fecha que elegimos
        LEFT JOIN reservas r ON p.id = r.id_pelicula AND r.fecha_funcion = ?
        GROUP BY p.id, p.titulo, p.genero, p.horario, p.id_sala, s.nombre, s.capacidad
        ORDER BY p.horario ASC
    ";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$fecha]); // Pasamos la fecha al SQL
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

    // --- RESTO DEL CRUD ---
    public function getTodasLasReservas(): array {
    // Asegúrate de que dice r.* (esto trae TODAS las columnas, incluida la nueva fecha_funcion)
    $sql = "SELECT r.*, c.nombre as cliente_nombre, c.email as cliente_email, p.titulo as pelicula_titulo, s.nombre as sala_nombre 
            FROM reservas r 
            JOIN clientes c ON r.id_cliente = c.id 
            JOIN peliculas p ON r.id_pelicula = p.id 
            JOIN salas s ON p.id_sala = s.id 
            ORDER BY r.fecha_reserva DESC";
            
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
    public function getTopPeliculasReservadas(int $limit = 5): array {
        $sql = "SELECT p.titulo, p.genero, SUM(r.cantidad_entradas) as total_entradas FROM reservas r JOIN peliculas p ON r.id_pelicula = p.id GROUP BY p.id, p.titulo, p.genero ORDER BY total_entradas DESC LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSalas(): array {
        $stmt = $this->pdo->query("SELECT * FROM salas");
        $salas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $salas[] = $this->arrayToSala($row);
        return $salas;
    }
    public function getPelicula(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM peliculas WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->arrayToPelicula($data) : null;
    }
    public function agregarPelicula(Pelicula $p) {
        $stmt = $this->pdo->prepare("INSERT INTO peliculas (titulo, genero, horario, id_sala) VALUES (?,?,?,?)");
        $stmt->execute([$p->getTitulo(), $p->getGenero(), $p->getHorario(), $p->getIdSala()]);
    }
    public function actualizarPelicula(Pelicula $p) {
        $stmt = $this->pdo->prepare("UPDATE peliculas SET titulo=?, genero=?, horario=?, id_sala=? WHERE id=?");
        $stmt->execute([$p->getTitulo(), $p->getGenero(), $p->getHorario(), $p->getIdSala(), $p->getId()]);
    }
    public function eliminarPelicula(int $id) {
        $this->pdo->prepare("DELETE FROM reservas WHERE id_pelicula = ?")->execute([$id]);
        $this->pdo->prepare("DELETE FROM peliculas WHERE id = ?")->execute([$id]);
    }
    public function buscarPeliculas($termino) {
        $sql = "SELECT p.id, p.titulo, p.genero, p.horario, p.id_sala, s.nombre AS sala_nombre, s.capacidad, SUM(COALESCE(r.cantidad_entradas, 0)) AS entradas_reservadas FROM peliculas p JOIN salas s ON p.id_sala = s.id LEFT JOIN reservas r ON p.id = r.id_pelicula WHERE p.titulo LIKE ? GROUP BY p.id, p.titulo, p.genero, p.horario, p.id_sala, s.nombre, s.capacidad";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$termino%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// Calcula cuántos asientos quedan libres para una película específica
    public function getDisponibilidad($id_pelicula) {
        $sql = "SELECT s.capacidad - COALESCE(SUM(r.cantidad_entradas), 0) as disponibles
                FROM peliculas p
                JOIN salas s ON p.id_sala = s.id
                LEFT JOIN reservas r ON p.id = r.id_pelicula
                WHERE p.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_pelicula]);
        return (int)$stmt->fetchColumn();
    }
public function getDisponibilidadPorFecha($id_pelicula, $fecha) {
    // 1. Capacidad total
    $sqlSala = "SELECT s.capacidad FROM peliculas p JOIN salas s ON p.id_sala = s.id WHERE p.id = ?";
    $stmt = $this->pdo->prepare($sqlSala);
    $stmt->execute([$id_pelicula]);
    $capacidad = $stmt->fetchColumn();

    // 2. Ocupados SOLO en esa fecha
    $sqlReservas = "SELECT SUM(cantidad_entradas) FROM reservas WHERE id_pelicula = ? AND fecha_funcion = ?";
    $stmt2 = $this->pdo->prepare($sqlReservas);
    $stmt2->execute([$id_pelicula, $fecha]);
    $ocupadas = (int)$stmt2->fetchColumn();

    return $capacidad - $ocupadas;
}
}
