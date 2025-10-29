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

if (isset($_POST['prestar'])) {
    $libroId = $_POST['libro_id'];
    $libro = $biblioteca->prestarLibro($libroId);
    if ($libro) {
        $mensaje = '<div class="alert alert-success">✅ Libro "' . $libro->getTitulo() . '" prestado correctamente</div>';
    } else {
        $mensaje = '<div class="alert alert-danger">❌ No se pudo prestar el libro. Puede que no esté disponible</div>';
    }
}

if (isset($_POST['devolver'])) {
    $libroId = $_POST['libro_id'];
    $libro = $biblioteca->devolverLibro($libroId);
    if ($libro) {
        $mensaje = '<div class="alert alert-success">✅ Libro "' . $libro->getTitulo() . '" devuelto correctamente</div>';
    } else {
        $mensaje = '<div class="alert alert-danger">❌ No se pudo devolver el libro</div>';
    }
}

$librosDisponibles = array_filter($biblioteca->getLibros(), function($libro) {
    return $libro->getDisponible();
});

$librosPrestados = array_filter($biblioteca->getLibros(), function($libro) {
    return !$libro->getDisponible();
});
?>
<!DOCTYPE html>
<html>
<head>
    <title>Prestar Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="nav">
                <div class="logo"> Biblioteca</div>
                <div class="menu">
                    <a href="../index.php"> Inicio</a>
                    <a href="agregar_libro.php"> Agregar Libro</a>
                    <a href="buscar_libro.php"> Buscar</a>
                    <a href="listar_libros.php"> Libros</a>
                    <a href="prestar_libro.php"> Préstamos</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <h1>Gestión de Préstamos</h1>
            
            <?php echo $mensaje; ?>

            <div class="tabs">
                <div class="tab active" onclick="showTab('disponibles')">📚 Libros Disponibles</div>
                <div class="tab" onclick="showTab('prestados')">📖 Libros Prestados</div>
            </div>

            <div id="disponibles" class="tab-content">
                <h2>Libros Disponibles para Préstamo</h2>
                
                <?php if (count($librosDisponibles) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Categoría</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($librosDisponibles as $libro): ?>
                                <tr>
                                    <td><?php echo $libro->getId(); ?></td>
                                    <td><strong><?php echo $libro->getTitulo(); ?></strong></td>
                                    <td><?php echo $libro->getAutor()->getNombre(); ?></td>
                                    <td><?php echo $libro->getCategoria()->getNombre(); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="libro_id" value="<?php echo $libro->getId(); ?>">
                                            <button type="submit" name="prestar" class="btn btn-success">📖 Prestar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay libros disponibles para préstamo en este momento.</p>
                <?php endif; ?>
            </div>

            <div id="prestados" class="tab-content" style="display: none;">
                <h2>Libros Actualmente Prestados</h2>
                
                <?php if (count($librosPrestados) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Categoría</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($librosPrestados as $libro): ?>
                                <tr>
                                    <td><?php echo $libro->getId(); ?></td>
                                    <td><strong><?php echo $libro->getTitulo(); ?></strong></td>
                                    <td><?php echo $libro->getAutor()->getNombre(); ?></td>
                                    <td><?php echo $libro->getCategoria()->getNombre(); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="libro_id" value="<?php echo $libro->getId(); ?>">
                                            <button type="submit" name="devolver" class="btn btn-warning">↩️ Devolver</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay libros prestados en este momento.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            document.getElementById(tabName).style.display = 'block';
            event.target.classList.add('active');
        }
    </script>
</body>
</html>