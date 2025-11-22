<div class="container">
<h2>⭐ {$titulo}</h2>

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
            {foreach $top_peliculas as $index => $peli}
                <tr style="background-color: {if $index == 0}#fff3cd{else}white{/if};">
                    <td style="text-align: center; font-weight: bold; font-size: 1.2em;">
                        {if $index == 0}🥇{elseif $index == 1}🥈{elseif $index == 2}🥉{else}{$index + 1}{/if}
                    </td>
                    <td style="font-weight: bold;">{$peli.titulo}</td>
                    <td>{$peli.genero}</td>
                    <td style="text-align: center;">
                        <span style="font-size: 1.1em; padding: 5px 15px; background-color: #e2e3e5; border-radius: 20px;">
                            {$peli.total_entradas} 🎟️
                        </span>
                    </td>
                </tr>
            {foreachelse}
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px;">
                        Aún no hay datos suficientes para generar el ranking.
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>


</div>