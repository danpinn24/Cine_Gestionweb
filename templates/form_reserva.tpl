<div class="container">
    <h2>🎟️ {$titulo}</h2>
    
    <div style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border-left: 5px solid #ffc107;">
        <p><strong>Película:</strong> {$pelicula->getTitulo()}</p>
        <p><strong>Horario habitual:</strong> {$pelicula->getHorario()} hs</p>
    </div>

    <form action="index.php?action=confirmar_reserva" method="POST">
        <input type="hidden" name="id_pelicula" value="{$pelicula->getId()}">
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
            <h3 style="margin-top: 0; font-size: 1.1em;">Datos de la Función</h3>
            
            <div class="form-group">
                <label>Fecha de la Función:</label>
                <input type="date" name="fecha_funcion" required 
                       min="{$smarty.now|date_format:'%Y-%m-%d'}" 
                       value="{$smarty.now|date_format:'%Y-%m-%d'}"
                       style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; display: block; width: 100%; max-width: 300px;">
                <small style="color: #666;">Selecciona el día que vendrás al cine.</small>
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label>Cantidad de Entradas:</label>
                <input type="number" name="cantidad" min="1" max="{$maximo}" value="1" required style="padding: 8px;">
                <small style="color: #666; display: block;">(Quedan {$maximo} asientos para hoy)</small>
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
</div>