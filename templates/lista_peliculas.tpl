<div class="container">
    <h2>Catálogo Actual: {$titulo}</h2>

    {literal}
    <style>
        /* Estilos del Carrusel */
        .netflix-container {
            background-color: #141414;
            padding: 20px 50px;
            margin-bottom: 30px;
            color: white;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        .netflix-title { margin: 0 0 15px 0; font-size: 1.5rem; border-left: 4px solid #e50914; padding-left: 10px; }
        .slider-wrapper { position: relative; }
        .slider { display: flex; gap: 10px; overflow-x: auto; scroll-behavior: smooth; scrollbar-width: none; }
        .slider::-webkit-scrollbar { display: none; }
        .netflix-card { flex: 0 0 calc(25% - 10px); min-width: calc(25% - 10px); aspect-ratio: 2/3; border-radius: 4px; position: relative; cursor: pointer; transition: transform 0.3s ease; }
        .netflix-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .netflix-card:hover { transform: scale(1.05); z-index: 2; }
        .handle { background: rgba(0,0,0,0.5); border: none; color: white; font-size: 3rem; position: absolute; top: 0; bottom: 0; width: 45px; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; line-height: 0; padding-bottom: 10px; }
        .handle:hover { background: rgba(229, 9, 20, 0.8); }
        .left-handle { left: -45px; }
        .right-handle { right: -45px; }
    </style>
    {/literal}

    <div class="netflix-container">
        <h3 class="netflix-title">🍿 Próximamente en Cines</h3>
        
        <div class="slider-wrapper">
            <button class="handle left-handle" id="btn-left">‹</button>
            
            <div class="slider" id="slider">
                <div class="netflix-card" title="Mufasa">
                    <img src="https://placehold.co/400x600/111/FFF?text=Mufasa" alt="Mufasa">
                </div>
                <div class="netflix-card" title="Sonic 3">
                    <img src="https://placehold.co/400x600/003366/FFF?text=Sonic+3" alt="Sonic 3">
                </div>
                <div class="netflix-card" title="Capitán América">
                    <img src="https://placehold.co/400x600/800000/FFF?text=Capitan+America" alt="Captain America">
                </div>
                 <div class="netflix-card" title="Minecraft">
                    <img src="https://placehold.co/400x600/2ea043/FFF?text=Minecraft" alt="Minecraft">
                </div>
                <div class="netflix-card" title="Karate Kid">
                    <img src="https://placehold.co/400x600/333/FFF?text=Karate+Kid" alt="Karate Kid">
                </div>
                <div class="netflix-card" title="Elio">
                    <img src="https://placehold.co/400x600/444/FFF?text=Elio" alt="Elio">
                </div>
                <div class="netflix-card" title="Nosferatu">
                    <img src="https://placehold.co/400x600/000/FFF?text=Nosferatu" alt="Nosferatu">
                </div>
                 <div class="netflix-card" title="Mickey 17">
                    <img src="https://placehold.co/400x600/555/FFF?text=Mickey+17" alt="Mickey 17">
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