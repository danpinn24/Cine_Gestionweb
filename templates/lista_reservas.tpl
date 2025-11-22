<div class="container">
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
            {foreach from=$reservas item=reserva}
                <tr>
                    <td>{$reserva.fecha_reserva|date_format:"%d/%m %H:%M"}</td>
                    
                    <td><strong>{$reserva.cliente_nombre}</strong></td>
                    <td>{$reserva.cliente_email}</td>
                    <td>{$reserva.pelicula_titulo}</td>
                    
                    <td style="background-color: #e8f0fe; font-weight: bold; color: #0056b3;">
                        {$reserva.fecha_funcion|date_format:"%d/%m/%Y"}
                    </td>
                    
                    <td>{$reserva.sala_nombre}</td>
                    
                    <td style="text-align: center;">
                        <span style="background: #eee; padding: 5px 10px; border-radius: 4px;">
                            {$reserva.cantidad_entradas}
                        </span>
                    </td>
                </tr>
            {foreachelse}
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        No hay reservas registradas en el sistema.
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>