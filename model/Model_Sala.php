<?php
// model/ModelSala.php

class Sala {
    
    // Propiedades
    private $id;
    private $nombre;
    private $capacidad;

    // Constructor
    public function __construct($nombre, $capacidad, $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->capacidad = $capacidad;
    }

    // --- Getters ---
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getCapacidad() { return $this->capacidad; }

    // --- Setters ---
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setCapacidad($capacidad) { $this->capacidad = $capacidad; }
}
