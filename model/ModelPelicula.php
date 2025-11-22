<?php
// model/ModelPelicula.php

class Pelicula {
    
    // Propiedades privadas (igual que las columnas de la DB)
    private $id;
    private $titulo;
    private $genero;
    private $horario;
    private $id_sala; // Guardamos solo el ID de la sala (Relación)

    // Constructor
    public function __construct($titulo, $genero, $horario, $id_sala, $id = null) {
        // El ID es opcional (null) porque al crear una nueva peli aún no lo tenemos
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->horario = $horario;
        $this->id_sala = $id_sala;
    }

    // --- Getters (Para leer datos) ---
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getGenero() { return $this->genero; }
    public function getHorario() { return $this->horario; }
    public function getIdSala() { return $this->id_sala; }

    // --- Setters (Para modificar datos) ---
    public function setId($id) { $this->id = $id; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }
    public function setGenero($genero) { $this->genero = $genero; }
    public function setHorario($horario) { $this->horario = $horario; }
    public function setIdSala($id_sala) { $this->id_sala = $id_sala; }
}
