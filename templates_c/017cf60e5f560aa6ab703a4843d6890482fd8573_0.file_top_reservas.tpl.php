<?php
/* Smarty version 5.5.1, created on 2025-11-22 17:05:25
  from 'file:top_reservas.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6921df453ccae6_24976604',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '017cf60e5f560aa6ab703a4843d6890482fd8573' => 
    array (
      0 => 'top_reservas.tpl',
      1 => 1763564028,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6921df453ccae6_24976604 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CINE_Web\\templates';
?><div class="container">
<h2>⭐ <?php echo $_smarty_tpl->getValue('titulo');?>
</h2>

<div class="actions" style="margin-bottom: 20px;">
    <a href="index.php" class="btn-primary" style="background-color: #6c757d;">⬅ Volver a Cartelera</a>
</div>

<div style="max-width: 800px; margin: 0 auto;">
    <table style="border: 2px solid var(--primary-color);">
        <thead>
            <tr style="background-color: var(--primary-color); color: white;">
                <th style="width: 10%; text-align: center;">#</th>
                <th>Película</th>
                <th>Género</th>
                <th style="text-align: center;">Total Entradas Vendidas</th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('top_peliculas'), 'peli', false, 'index');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('index')->value => $_smarty_tpl->getVariable('peli')->value) {
$foreach0DoElse = false;
?>
                <tr style="background-color: <?php if ($_smarty_tpl->getValue('index') == 0) {?>#fff3cd<?php } else { ?>white<?php }?>;">
                    <td style="text-align: center; font-weight: bold; font-size: 1.2em;">
                        <?php if ($_smarty_tpl->getValue('index') == 0) {?>🥇<?php } elseif ($_smarty_tpl->getValue('index') == 1) {?>🥈<?php } elseif ($_smarty_tpl->getValue('index') == 2) {?>🥉<?php } else {
echo $_smarty_tpl->getValue('index')+1;
}?>
                    </td>
                    <td style="font-weight: bold;"><?php echo $_smarty_tpl->getValue('peli')['titulo'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('peli')['genero'];?>
</td>
                    <td style="text-align: center;">
                        <span style="font-size: 1.1em; padding: 5px 15px; background-color: #e2e3e5; border-radius: 20px;">
                            <?php echo $_smarty_tpl->getValue('peli')['total_entradas'];?>
 🎟️
                        </span>
                    </td>
                </tr>
            <?php
}
if ($foreach0DoElse) {
?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px;">
                        Aún no hay datos suficientes para generar el ranking.
                    </td>
                </tr>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</div>


</div><?php }
}
