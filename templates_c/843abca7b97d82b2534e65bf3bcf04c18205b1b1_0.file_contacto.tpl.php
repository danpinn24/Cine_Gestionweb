<?php
/* Smarty version 5.5.1, created on 2025-11-22 16:49:05
  from 'file:contacto.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6921db71238f27_55066936',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '843abca7b97d82b2534e65bf3bcf04c18205b1b1' => 
    array (
      0 => 'contacto.tpl',
      1 => 1763826256,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6921db71238f27_55066936 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CINE_Web\\templates';
?><div class="container">
    <h2>✉️ Contacto</h2>
    
    <div class="contact-layout">
        
        <div class="contact-column contact-data">
            <h3>Datos de contacto</h3>
            <p>📧 <strong>Email:</strong> info@cineapp.com</p>
            <p>📞 <strong>Teléfono:</strong> (011) 4444-5555</p>
            <p>🕒 <strong>Horario:</strong> Lunes a Domingo de 12:00 a 00:00 hs.</p>
            <p>🏢 <strong>Oficinas:</strong> Calle Falsa 123, Piso 4.</p>
        </div>

        <div class="contact-column">
            <h3>Envíanos un mensaje</h3>
            <form action="#" method="POST">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" required placeholder="Tu nombre...">
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" required placeholder="tu@email.com">
                </div>

                <div class="form-group">
                    <label>Mensaje:</label>
                    <textarea rows="5" placeholder="Escribe tu consulta aquí..."></textarea>
                </div>
                
                <button class="btn-primary">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</div><?php }
}
