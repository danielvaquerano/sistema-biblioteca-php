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
$mensaje = '';

if (isset($_POST['eliminar'])) {
    $libroId = $_POST['libro_id'];
    if ($biblioteca->eliminarLibro($libroId)) {
        $mensaje = '<div class="alert alert-success">✅ Libro eliminado correctamente</div>';
    } else {
        $mensaje = '<div class="alert alert-danger">❌ No se pudo eliminar el libro</div>';
    }
}

$libros = $biblioteca->getLibros();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestionar Libros - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="nav">
                <div class="logo"> Biblioteca</div>
                <div class="menu">
                    <a href="../index.php"> Inicio</a>
                    <a href="agregar_libro.php">Agregar Libro</a>
                    <a href="buscar_libro.php"> Buscar</a>
                    <a href="listar_libros.php">Libros</a>
                    <a href="prestar_libro.php">Préstamos</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <h1> Gestionar Libros</h1>
            
            <?php echo $mensaje; ?>

            <h2>Lista Completa de Libros</h2>
            
            <?php if (count($libros) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td><?php echo $libro->getId(); ?></td>
                                <td><strong><?php echo $libro->getTitulo(); ?></strong></td>
                                <td><?php echo $libro->getAutor()->getNombre(); ?></td>
                                <td><?php echo $libro->getCategoria()->getNombre(); ?></td>
                                <td>
                                    <?php if ($libro->getDisponible()): ?>
                                        <span style="color: #27ae60; font-weight: bold;">✅ Disponible</span>
                                    <?php else: ?>
                                        <span style="color: #e74c3c; font-weight: bold;">❌ Prestado</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este libro?')">
                                        <input type="hidden" name="libro_id" value="<?php echo $libro->getId(); ?>">
                                        <button type="submit" name="eliminar" class="btn btn-danger">🗑️ Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <p><strong>Total de libros:</strong> <?php echo count($libros); ?></p>
                
            <?php else: ?>
                <div class="no-result">
                    <h3>📭 No hay libros en la biblioteca</h3>
                    <p>Agrega el primer libro haciendo clic en el botón "Agregar Libro"</p>
                    <a href="agregar_libro.php" class="btn">➕ Agregar Primer Libro</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>