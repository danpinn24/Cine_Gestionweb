<?php
class Reserva {
    private $id;
    private $id_pelicula;
    private $id_cliente;
    private $fecha_reserva;
    private $fecha_funcion; // <--- NUEVO
    private $cantidad_entradas;

    public function __construct($id_pelicula, $id_cliente, $fecha_reserva, $fecha_funcion, $cantidad_entradas, $id = null) {
        $this->id = $id;
        $this->id_pelicula = $id_pelicula;
        $this->id_cliente = $id_cliente;
        $this->fecha_reserva = $fecha_reserva;
        $this->fecha_funcion = $fecha_funcion; // <--- ASIGNAR
        $this->cantidad_entradas = $cantidad_entradas;
    }

    public function getId() { return $this->id; }
    public function getIdPelicula() { return $this->id_pelicula; }
    public function getIdCliente() { return $this->id_cliente; }
    public function getFechaReserva() { return $this->fecha_reserva; }
    public function getFechaFuncion() { return $this->fecha_funcion; } // <--- GETTER
    public function getCantidadEntradas() { return $this->cantidad_entradas; }
}