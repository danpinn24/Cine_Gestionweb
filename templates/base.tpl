<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$titulo}</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <div class="header-content">
            <h1>CINEMA ADMIN</h1>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php?action=home">Inicio</a></li>
                    <li><a href="index.php?action=nosotros">Nosotros</a></li>
                    <li><a href="index.php?action=complejos">Complejos</a></li>
                    <li><a href="index.php?action=contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        {include file=$contenido_tpl} 
    </main>
    
    <footer>
        <p>&copy; 2025 Cine App - Sistema de Gestión</p>
    </footer>
</body>
</html>