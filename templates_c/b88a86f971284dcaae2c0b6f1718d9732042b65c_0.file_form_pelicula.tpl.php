<?php
/* Smarty version 5.5.1, created on 2025-11-20 21:40:31
  from 'file:form_pelicula.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_691f7cbf4788b8_64867987',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b88a86f971284dcaae2c0b6f1718d9732042b65c' => 
    array (
      0 => 'form_pelicula.tpl',
      1 => 1763564586,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_691f7cbf4788b8_64867987 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CINE_Web\\templates';
?><div class="container">
    <h2><?php echo $_smarty_tpl->getValue('titulo');?>
</h2>
    <form action="index.php?action=guardar_pelicula" method="POST">
        
        <input type="hidden" name="id" value="<?php if ((true && ($_smarty_tpl->hasVariable('pelicula') && null !== ($_smarty_tpl->getValue('pelicula') ?? null)))) {
echo $_smarty_tpl->getValue('pelicula')->getId();
}?>">

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required value="<?php if ((true && ($_smarty_tpl->hasVariable('pelicula') && null !== ($_smarty_tpl->getValue('pelicula') ?? null)))) {
echo $_smarty_tpl->getValue('pelicula')->getTitulo();
}?>">
        </div>
        
        <div class="form-group">
            <label for="genero">Género:</label>
            <input type="text" name="genero" value="<?php if ((true && ($_smarty_tpl->hasVariable('pelicula') && null !== ($_smarty_tpl->getValue('pelicula') ?? null)))) {
echo $_smarty_tpl->getValue('pelicula')->getGenero();
}?>">
        </div>

        <div class="form-group">
            <label for="horario">Horario:</label>
            <input type="time" name="horario" required value="<?php if ((true && ($_smarty_tpl->hasVariable('pelicula') && null !== ($_smarty_tpl->getValue('pelicula') ?? null)))) {
echo $_smarty_tpl->getValue('pelicula')->getHorario();
} else { ?>20:00<?php }?>">
        </div>
        
        <div class="form-group">
            <label for="id_sala">Sala:</label>
            <select name="id_sala" required>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('salas'), 'sala');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('sala')->value) {
$foreach0DoElse = false;
?>
                    <option value="<?php echo $_smarty_tpl->getValue('sala')->getId();?>
" 
                        <?php if ((true && ($_smarty_tpl->hasVariable('pelicula') && null !== ($_smarty_tpl->getValue('pelicula') ?? null))) && $_smarty_tpl->getValue('pelicula')->getIdSala() == $_smarty_tpl->getValue('sala')->getId()) {?>selected<?php }?>>
                        <?php echo $_smarty_tpl->getValue('sala')->getNombre();?>
 (Cap: <?php echo $_smarty_tpl->getValue('sala')->getCapacidad();?>
)
                    </option>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </select>
        </div>

        <button type="submit" class="btn-primary form-submit-btn">Guardar Cambios</button>
    </form>
</div><?php }
}
