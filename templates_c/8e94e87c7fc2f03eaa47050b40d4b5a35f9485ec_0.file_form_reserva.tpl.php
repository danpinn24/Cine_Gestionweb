<?php
/* Smarty version 5.5.1, created on 2025-11-20 21:38:35
  from 'file:form_reserva.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_691f7c4bc18874_53875655',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e94e87c7fc2f03eaa47050b40d4b5a35f9485ec' => 
    array (
      0 => 'form_reserva.tpl',
      1 => 1763671105,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_691f7c4bc18874_53875655 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CINE_Web\\templates';
?><div class="container">
    <h2>🎟️ <?php echo $_smarty_tpl->getValue('titulo');?>
</h2>
    
    <div style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border-left: 5px solid #ffc107;">
        <p><strong>Película:</strong> <?php echo $_smarty_tpl->getValue('pelicula')->getTitulo();?>
</p>
        <p><strong>Horario habitual:</strong> <?php echo $_smarty_tpl->getValue('pelicula')->getHorario();?>
 hs</p>
    </div>

    <form action="index.php?action=confirmar_reserva" method="POST">
        <input type="hidden" name="id_pelicula" value="<?php echo $_smarty_tpl->getValue('pelicula')->getId();?>
">
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
            <h3 style="margin-top: 0; font-size: 1.1em;">Datos de la Función</h3>
            
            <div class="form-group">
                <label>Fecha de la Función:</label>
                <input type="date" name="fecha_funcion" required 
                       min="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')(time(),'%Y-%m-%d');?>
" 
                       value="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')(time(),'%Y-%m-%d');?>
"
                       style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; display: block; width: 100%; max-width: 300px;">
                <small style="color: #666;">Selecciona el día que vendrás al cine.</small>
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label>Cantidad de Entradas:</label>
                <input type="number" name="cantidad" min="1" max="<?php echo $_smarty_tpl->getValue('maximo');?>
" value="1" required style="padding: 8px;">
                <small style="color: #666; display: block;">(Quedan <?php echo $_smarty_tpl->getValue('maximo');?>
 asientos para hoy)</small>
            </div>
        </div>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
            <h3 style="margin-top: 0; font-size: 1.1em;">Datos del Cliente</h3>
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre_cliente" required placeholder="Ej: Ana García" style="padding: 8px; width: 100%;">
            </div>
            
            <div class="form-group" style="margin-top: 10px;">
                <label>Email:</label>
                <input type="email" name="email_cliente" required placeholder="Ej: ana@email.com" style="padding: 8px; width: 100%;">
            </div>
        </div>

        <button type="submit" class="btn-primary form-submit-btn" onclick="this.form.submit(); this.disabled=true; this.innerText='Guardando...';">Confirmar Reserva</button>
        <a href="index.php" class="btn-primary" style="background-color: #6c757d;">Cancelar</a>
    </form>
</div><?php }
}
