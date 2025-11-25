<?php
// db/class_db.php

require_once __DIR__ . '/../model/ModelPelicula.php'; 
require_once __DIR__ . '/../model/Model_Sala.php'; 
require_once __DIR__ . '/../model/ModelCliente.php';
require_once __DIR__ . '/../model/ModelReserva.php';

class DB {
    private static $instance = null;
    private $pdo; 
    
    // CONFIGURACIÓN MYSQL (Ajusta si tienes contraseña en XAMPP/WAMP)
    private $host = 'localhost';
    private $db_name = 'cine_db';
    private $user = 'root';
    private $password = ''; // En XAMPP suele ser vacío, en MAMP es 'root'

    private function __construct() {
        try {
            // CAMBIO: Conexión a MySQL en lugar de SQLite
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Comentar init() si ya creaste la base de datos manualmente en phpMyAdmin
            // O dejarlo si quieres que el código intente crear las tablas
            $this->init(); 
        } catch (PDOException $e) {
            die("Error de Base de Datos: " . $e->getMessage() . "<br>Asegúrate de haber creado la base de datos 'cine_db' en phpMyAdmin.");
        }
    }
    
    public static function getInstance(): DB {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
    
    private function init() {
        // CAMBIO: Sintaxis MySQL (ENGINE=InnoDB y AUTO_INCREMENT)
        
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS salas (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            nombre VARCHAR(100) NOT NULL, 
            capacidad INT NOT NULL
        ) ENGINE=InnoDB");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS peliculas (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            titulo VARCHAR(100) NOT NULL, 
            genero VARCHAR(50), 
            horario VARCHAR(10) NOT NULL, 
            id_sala INT, 
            FOREIGN KEY (id_sala) REFERENCES salas(id)
        ) ENGINE=InnoDB");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            nombre VARCHAR(100) NOT NULL, 
            email VARCHAR(100) UNIQUE NOT NULL
        ) ENGINE=InnoDB");

       $this->pdo->exec("CREATE TABLE IF NOT EXISTS reservas (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            id_pelicula INT NOT NULL, 
            id_cliente INT NOT NULL, 
            fecha_reserva DATETIME, 
            fecha_funcion DATE, 
            cantidad_entradas INT NOT NULL DEFAULT 1, 
            FOREIGN KEY (id_pelicula) REFERENCES peliculas(id), 
            FOREIGN KEY (id_cliente) REFERENCES clientes(id)
        ) ENGINE=InnoDB");
    
        // Datos de prueba iniciales
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM salas");
        if ($stmt->fetchColumn() == 0) {
            $this->pdo->exec("INSERT INTO salas (nombre, capacidad) VALUES ('Sala Premium 3D', 40)");
            $this->pdo->exec("INSERT INTO salas (nombre, capacidad) VALUES ('Sala 2D', 50)");
            $this->pdo->exec("INSERT INTO peliculas (titulo, genero, horario, id_sala) VALUES ('Gladiador 2', 'Acción', '20:00', 1)");
            $this->pdo->exec("INSERT INTO peliculas (titulo, genero, horario, id_sala) VALUES ('La noche del Demonio', 'Terror', '17:00', 2)");
        }
    }

    // --- Mappers ---
    private function arrayToSala(array $data): Sala {
        return new Sala($data['nombre'], $data['capacidad'], $data['id']);
    }
    private function arrayToPelicula(array $data): Pelicula {
        return new Pelicula($data['titulo'], $data['genero'], $data['horario'], $data['id_sala'], $data['id']);
    }
    
    // 1. Obtener o Crear Cliente
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
    $sql = "INSERT INTO reservas (id_pelicula, id_cliente, fecha_reserva, fecha_funcion, cantidad_entradas) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $reserva->getIdPelicula(),
        $reserva->getIdCliente(),
        $reserva->getFechaReserva(),
        $reserva->getFechaFuncion(),
        $reserva->getCantidadEntradas()
    ]);
}

    // 3. Cartelera con Stock actualizado
    public function getCarteleraDetallada($fecha = null): array {
        if ($fecha == null) {
            $fecha = date('Y-m-d');
        }
        // NOTA: En MySQL a veces COALESCE requiere cuidado con NULLs, pero esta query es estándar y funciona bien.
        $sql = "
            SELECT 
                p.id, p.titulo, p.genero, p.horario, p.id_sala,
                s.nombre AS sala_nombre, s.capacidad,
                SUM(COALESCE(r.cantidad_entradas, 0)) AS entradas_reservadas
            FROM peliculas p
            JOIN salas s ON p.id_sala = s.id
            LEFT JOIN reservas r ON p.id = r.id_pelicula AND r.fecha_funcion = ?
            GROUP BY p.id, p.titulo, p.genero, p.horario, p.id_sala, s.nombre, s.capacidad
            ORDER BY p.horario ASC
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fecha]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

public function getTodosLosClientes() {
        return $this->pdo->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
    }
    // --- RESTO DEL CRUD ---
    public function getTodasLasReservas(): array {
    $sql = "SELECT r.*, c.nombre as cliente_nombre, c.email as cliente_email, p.titulo as pelicula_titulo, s.nombre as sala_nombre 
            FROM reservas r 
            JOIN clientes c ON r.id_cliente = c.id 
            JOIN peliculas p ON r.id_pelicula = p.id 
            JOIN salas s ON p.id_sala = s.id 
            ORDER BY r.fecha_reserva DESC";
            
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
    public function getTopPeliculasReservadas(int $limit = 5): array {
        // MySQL requiere PDO::PARAM_INT explícito en LIMIT si las emulaciones están activadas, pero bindValue lo maneja bien.
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