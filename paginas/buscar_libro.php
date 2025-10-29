<?php
// CLASES PRIMERO - esto debe ir AL INICIO, sin espacios antes
require_once '../clases/Autor.php';
require_once '../clases/Categoria.php';
require_once '../clases/Libro.php';
require_once '../clases/Biblioteca.php';

// LUEGO la sesión
session_start();

if (!isset($_SESSION['biblioteca'])) {
    $_SESSION['biblioteca'] = new Biblioteca();
}

$biblioteca = $_SESSION['biblioteca'];
$resultados = [];

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $termino = $_GET['q'];
    $resultados = $biblioteca->buscarLibros($termino);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buscar Libro - Biblioteca</title>
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
            <h1>🔍 Buscar Libros</h1>
            
            <div class="search-form">
                <form method="GET">
                    <div class="form-group">
                        <label for="busqueda">Buscar por título, autor o categoría:</label>
                        <input type="text" id="busqueda" name="q" placeholder="Ej: Cien años, García Márquez, Novela..." value="<?php echo $_GET['q'] ?? ''; ?>">
                    </div>
                    <button type="submit" class="btn">🔍 Buscar</button>
                    <a href="buscar_libro.php" class="btn">🔄 Limpiar</a>
                </form>
            </div>

            <?php if (isset($_GET['q'])): ?>
                <h2>Resultados de búsqueda para "<?php echo htmlspecialchars($_GET['q']); ?>"</h2>
                
                <?php if (count($resultados) > 0): ?>
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
                            <?php foreach ($resultados as $libro): ?>
                                <tr>
                                    <td><?php echo $libro->getId(); ?></td>
                                    <td><strong><?php echo $libro->getTitulo(); ?></strong></td>
                                    <td><?php echo $libro->getAutor()->getNombre(); ?></td>
                                    <td><?php echo $libro->getCategoria()->getNombre(); ?></td>
                                    <td><?php echo $libro->getIsbn() ?: 'N/A'; ?></td>
                                    <td><?php echo $libro->getAnioPublicacion() ?: 'N/A'; ?></td>
                                    <td>
                                        <span class="<?php echo $libro->getDisponible() ? 'disponible' : 'prestado'; ?>">
                                            <?php echo $libro->getDisponible() ? '✅ Disponible' : '❌ Prestado'; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p><strong>Total encontrado:</strong> <?php echo count($resultados); ?> libro(s)</p>
                <?php else: ?>
                    <div class="no-result">
                        <h3>📭 No se encontraron resultados</h3>
                        <p>Intenta con otros términos de búsqueda</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="no-result">
                    <h3>🔍 Ingresa un término de búsqueda</h3>
                    <p>Puedes buscar por título, autor o categoría</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>