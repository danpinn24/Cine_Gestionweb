<div class="container">
    <h2>Catálogo Actual: {$titulo}</h2>


    <div class="netflix-container">
        <h3 class="netflix-title">🍿 Próximamente en Cines</h3>
        
        <div class="slider-wrapper">
            <button class="handle left-handle" id="btn-left">‹</button>
            
            <div class="slider" id="slider">
                <div class="netflix-card">
                    <img src="img/barco.jpg">
                </div>
                <div class="netflix-card">
                    <img src="img/guardianes.jpg">
                </div>
                <div class="netflix-card" >
                    <img src="img/shrek.jpg">
                </div>
                 <div class="netflix-card" >
                    <img src="img/scream.jpg">
                </div>
                <div class="netflix-card" title="Karate Kid">
                    <img src="img/avengers.jpg">
                </div>
                <div class="netflix-card" title="Elio">
                    <img src="img/OIP.webp">
                </div>
                <div class="netflix-card" >
                    <img src="img/toy.jpg">
                </div>
                 <div class="netflix-card" >
                    <img src="img/mario.jpg">
                </div>
            </div>

            <button class="handle right-handle" id="btn-right">›</button>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const slider = document.getElementById('slider');
        const btnLeft = document.getElementById('btn-left');
        const btnRight = document.getElementById('btn-right');

        btnRight.addEventListener('click', () => {
            const maxScrollLeft = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScrollLeft - 10) {
                slider.scrollLeft = 0; 
            } else {
                slider.scrollLeft += slider.clientWidth;
            }
        });

        btnLeft.addEventListener('click', () => {
            if (slider.scrollLeft === 0) {
                slider.scrollLeft = slider.scrollWidth;
            } else {
                slider.scrollLeft -= slider.clientWidth;
            }
        });
    });
    </script>


    <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; border: 1px solid #ddd; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 15px;">
        
        <form action="index.php" method="GET" style="margin: 0; display: flex; align-items: center; gap: 10px;">
            <input type="hidden" name="action" value="home">
            <label style="font-weight: bold; color: #555; margin: 0;">📅 Ver cupos para:</label>
            <input type="date" name="fecha" 
                   value="{$fecha_actual}" 
                   min="{$smarty.now|date_format:'%Y-%m-%d'}"
                   onchange="this.form.submit()" 
                   style="padding: 8px 12px; border-radius: 4px; border: 1px solid #ccc; font-weight: bold; color: #007bff; cursor: pointer;">
        </form>

        <form action="index.php?action=buscar" method="POST" style="display: flex; gap: 10px; flex-grow: 1; justify-content: flex-end;">
            <input type="text" name="termino" placeholder="🔍 Buscar película..." style="min-width: 200px; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            <button type="submit" class="btn-primary">Buscar</button>
            <a href="index.php" class="btn-primary" style="background-color: #6c757d; line-height: 20px; text-decoration: none;">Ver Todo</a>
        </form>
    </div>


    <div class="actions" style="margin-bottom: 20px;">
        <a href="index.php?action=nueva_pelicula" class="btn-primary">➕ Registrar Nueva Película</a>
        <a href="index.php?action=ver_reservas" class="btn-primary" style="background-color: #28a745;">📋 Ver Reservas</a>
        <a href="index.php?action=top_reservas" class="btn-primary" style="background-color: #ffc107; color: #333;">⭐ Top Más Vistas</a>
    </div>

    {if isset($smarty.get.mensaje) && $smarty.get.mensaje == 'exito'}
        <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px;">
            ✅ <strong>¡Operación exitosa!</strong> Reserva guardada correctamente.
        </div>
    {/if}
    
    {if isset($smarty.get.error)}
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 5px;">
            ❌ <strong>Error:</strong> {$smarty.get.error}
        </div>
    {/if}


    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Género</th>
                <th>Horario</th>
                <th>Sala</th>
                <th>Capacidad</th>
                <th style="background-color: #e8f0fe; border-bottom: 2px solid #0056b3;">Disponibilidad ({$fecha_actual|date_format:"%d/%m"})</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {foreach $cartelera as $peli}
                {$disponibles = $peli.capacidad - $peli.entradas_reservadas}
                
                <tr>
                    <td><strong>{$peli.titulo}</strong></td>
                    <td>{$peli.genero}</td>
                    <td>{$peli.horario}</td>
                    <td>{$peli.sala_nombre}</td>
                    <td>{$peli.capacidad}</td>
                    
                    <td style="background-color: #f8f9fa;">
                        <span style="font-weight: bold; color: {if $disponibles > 0}green{else}red{/if}; font-size: 1.1em;">
                            {if $disponibles > 0}
                                {$disponibles} Asientos
                            {else}
                                AGOTADO
                            {/if}
                        </span>
                        <br>
                        <small style="color: #666;">({$peli.entradas_reservadas} ocupados el {$fecha_actual|date_format:"%d/%m"})</small>
                    </td>

                    <td>
                        <div style="display: flex; flex-direction: column; gap: 5px;">
                            {if $disponibles > 0}
                                <a href="index.php?action=reservar_entrada&id={$peli.id}" class="btn-primary" style="padding: 5px 10px; font-size: 0.9em; text-align: center;">🎟️ Comprar</a>
                            {else}
                                <span style="color: #999; font-style: italic; font-size: 0.9em; text-align: center;">Sin cupo</span>
                            {/if}
                            
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <a href="index.php?action=modificar_pelicula&id={$peli.id}" style="color: #007bff; font-size: 0.9em; text-decoration: none;">✏️ Editar</a>
                                <a href="index.php?action=eliminar_pelicula&id={$peli.id}" style="color: #dc3545; font-size: 0.9em; text-decoration: none;" onclick="return confirm('¿Borrar esta película?');">🗑️ Borrar</a>
                            </div>
                        </div>
                    </td>
                </tr>
            {foreachelse}
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; background-color: #fff3cd;">
                        No hay películas disponibles para la fecha seleccionada.
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>