<?php
// controller/AppController.php

require_once 'librerias/smarty-5.5.1/libs/Smarty.class.php'; // Asegúrate que la ruta a Smarty sea correcta

abstract class AppController {
    protected $db;
    protected $smarty;

    public function __construct(DB $db) {
        $this->db = $db;
        
        // Inicialización de Smarty
         $this->smarty = new \Smarty\Smarty();  
        $this->smarty->setTemplateDir('templates/'); 
        $this->smarty->setCompileDir('templates_c/'); 
        
        // Asignar la base URL para estilos y links
        $this->smarty->assign('BASE_URL', 'http://localhost/cine-app/'); // Ajusta según tu carpeta
    }
    
    /**
     * Muestra una vista usando Smarty
     */
    protected function render($template, $data = []) {
        // Asignar datos comunes (como el título o usuario logueado)
        $this->smarty->assign('titulo', 'Sistema de Cine');
        
        // Asignar datos específicos que envíe el hijo
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        
        $this->smarty->display($template);
    }
}
?>