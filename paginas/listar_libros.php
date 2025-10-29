<?php
require_once '../clases/Autor.php';
require_once '../clases/Categoria.php';
require_once '../clases/Libro.php';
require_once '../clases/Biblioteca.php';

session_start();

if (!isset($_SESSION['biblioteca'])) {
    $_SESSION['biblioteca'] = new Biblioteca();
}

$biblioteca = $_SESSION['biblioteca'];
$libros = $biblioteca->getLibros();

$totalLibros = count($libros);
$disponibles = 0;
$prestados = 0;

foreach ($libros as $libro) {
    if ($libro->getDisponible()) {
        $disponibles++;
    } else {
        $prestados++;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Listar Libros - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="nav">
                <div class="logo">📚 Biblioteca</div>
                <div class="menu">
                    <a href="../index.php">🏠 Inicio</a>
                    <a href="agregar_libro.php">➕ Agregar Libro</a>
                    <a href="buscar_libro.php">🔍 Buscar</a>
                    <a href="listar_libros.php">📚 Libros</a>
                    <a href="prestar_libro.php">📖 Préstamos</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <h1> Todos los Libros</h1>
            
            <div class="stats">
                <h3>Estadísticas</h3>
                <p><strong>Total de libros:</strong> <?php echo $totalLibros; ?></p>
                <p><strong>Disponibles:</strong> <span class="disponible"><?php echo $disponibles; ?></span></p>
                <p><strong>Prestados:</strong> <span class="prestado"><?php echo $prestados; ?></span></p>
            </div>

            <?php if ($totalLibros > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>ISBN</th>
                            <th>Año</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td><?php echo $libro->getId(); ?></td>
                                <td><strong><?php echo $libro->getTitulo(); ?></strong></td>
                                <td><?php echo $libro->getAutor()->getNombre(); ?></td>
                                <td><?php echo $libro->getCategoria()->getNombre(); ?></td>
                                <td><?php echo $libro->getIsbn() ?: 'N/A'; ?></td>
                                <td><?php echo $libro->getAnioPublicacion() ?: 'N/A'; ?></td>
                                <td>
                                    <span class="<?php echo $libro->getDisponible() ? 'disponible' : 'prestado'; ?>">
                                        <?php echo $libro->getDisponible() ? ' Disponible' : ' Prestado'; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-result">
                    <h3>📭 No hay libros en la biblioteca</h3>
                    <p>Agrega el primer libro haciendo clic en el botón "Agregar Libro"</p>
                    <a href="agregar_libro.php" class="btn"> Agregar Primer Libro</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>