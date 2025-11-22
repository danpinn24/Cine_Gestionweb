<?php
// model/ModelCliente.php

class Cliente {
    
    // Propiedades privadas
    private $id;
    private $nombre;
    private $email;

    // Constructor
    public function __construct($nombre, $email, $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
    }

    // --- Getters ---
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }

    // --- Setters ---
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setEmail($email) { $this->email = $email; }
}
