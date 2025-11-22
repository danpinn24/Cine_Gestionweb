<div class="container">
    <h2>{$titulo}</h2>
    <form action="index.php?action=guardar_pelicula" method="POST">
        
        <input type="hidden" name="id" value="{if isset($pelicula)}{$pelicula->getId()}{/if}">

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required value="{if isset($pelicula)}{$pelicula->getTitulo()}{/if}">
        </div>
        
        <div class="form-group">
            <label for="genero">Género:</label>
            <input type="text" name="genero" value="{if isset($pelicula)}{$pelicula->getGenero()}{/if}">
        </div>

        <div class="form-group">
            <label for="horario">Horario:</label>
            <input type="time" name="horario" required value="{if isset($pelicula)}{$pelicula->getHorario()}{else}20:00{/if}">
        </div>
        
        <div class="form-group">
            <label for="id_sala">Sala:</label>
            <select name="id_sala" required>
                {foreach $salas as $sala}
                    <option value="{$sala->getId()}" 
                        {if isset($pelicula) && $pelicula->getIdSala() == $sala->getId()}selected{/if}>
                        {$sala->getNombre()} (Cap: {$sala->getCapacidad()})
                    </option>
                {/foreach}
            </select>
        </div>

        <button type="submit" class="btn-primary form-submit-btn">Guardar Cambios</button>
    </form>
</div>