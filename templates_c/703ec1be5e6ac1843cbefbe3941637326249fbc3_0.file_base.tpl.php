<?php
/* Smarty version 5.5.1, created on 2025-11-22 16:49:03
  from 'file:base.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6921db6fca93c6_69568635',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '703ec1be5e6ac1843cbefbe3941637326249fbc3' => 
    array (
      0 => 'base.tpl',
      1 => 1763826519,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6921db6fca93c6_69568635 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CINE_Web\\templates';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_smarty_tpl->getValue('titulo');?>
</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <div class="header-content">
            <h1>CINEMA ADMIN</h1>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php?action=home">Inicio</a></li>
                    <li><a href="index.php?action=nosotros">Nosotros</a></li>
                    <li><a href="index.php?action=complejos">Complejos</a></li>
                    <li><a href="index.php?action=contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <?php $_smarty_tpl->renderSubTemplate($_smarty_tpl->getValue('contenido_tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?> 
    </main>
    
    <footer>
        <p>&copy; 2025 Cine App - Sistema de Gestión</p>
    </footer>
</body>
</html><?php }
}
