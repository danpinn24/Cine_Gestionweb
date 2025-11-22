<?php
/* Smarty version 5.5.1, created on 2025-11-20 21:33:15
  from 'file:lista_reservas.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_691f7b0bd85577_12065493',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6d5e134ca2e39041edded751d95ccb79d49f5776' => 
    array (
      0 => 'lista_reservas.tpl',
      1 => 1763669639,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_691f7b0bd85577_12065493 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CINE_Web\\templates';
?><div class="container">
    <h2>📋 Listado de Reservas y Clientes</h2>

    <div class="actions" style="margin-bottom: 20px;">
        <a href="index.php" class="btn-primary" style="background-color: #6c757d;">⬅ Volver a Cartelera</a>
    </div>

    <table class="table-reservas"> <thead>
            <tr>
                <th>Fecha Compra</th> <th>Cliente</th>
                <th>Email</th>
                <th>Película</th>
                <th>Función (Día)</th> <th>Sala</th>
                <th>Entradas</th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('reservas'), 'reserva');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('reserva')->value) {
$foreach0DoElse = false;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('reserva')['fecha_reserva'],"%d/%m %H:%M");?>
</td>
                    
                    <td><strong><?php echo $_smarty_tpl->getValue('reserva')['cliente_nombre'];?>
</strong></td>
                    <td><?php echo $_smarty_tpl->getValue('reserva')['cliente_email'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('reserva')['pelicula_titulo'];?>
</td>
                    
                    <td style="background-color: #e8f0fe; font-weight: bold; color: #0056b3;">
                        <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('reserva')['fecha_funcion'],"%d/%m/%Y");?>

                    </td>
                    
                    <td><?php echo $_smarty_tpl->getValue('reserva')['sala_nombre'];?>
</td>
                    
                    <td style="text-align: center;">
                        <span style="background: #eee; padding: 5px 10px; border-radius: 4px;">
                            <?php echo $_smarty_tpl->getValue('reserva')['cantidad_entradas'];?>

                        </span>
                    </td>
                </tr>
            <?php
}
if ($foreach0DoElse) {
?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        No hay reservas registradas en el sistema.
                    </td>
                </tr>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div><?php }
}
