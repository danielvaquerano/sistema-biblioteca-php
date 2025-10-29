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

if ($_POST) {
    $titulo = $_POST['titulo'] ?? '';
    $autor_id = $_POST['autor_id'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $anio = $_POST['anio_publicacion'] ?? '';
    
    if ($titulo && $autor_id && $categoria_id) {
        $autores = $biblioteca->getAutores();
        $categorias = $biblioteca->getCategorias();
        
        $autor = null;
        $categoria = null;
        
        foreach ($autores as $a) {
            if ($a->getId() == $autor_id) {
                $autor = $a;
                break;
            }
        }
        
        foreach ($categorias as $c) {
            if ($c->getId() == $categoria_id) {
                $categoria = $c;
                break;
            }
        }
        
        if ($autor && $categoria) {
            $biblioteca->agregarLibro($titulo, $autor, $categoria, $isbn, $anio);
            $mensaje = '<div class="alert alert-success"> Libro agregado correctamente!</div>';
        }
    } else {
        $mensaje = '<div class="alert alert-warning"> Completa todos los campos obligatorios</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Libro - Biblioteca</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="nav">
                <div class="logo">Biblioteca</div>
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
            <h1> Agregar Nuevo Libro</h1>
            
            <?php echo $mensaje ?? ''; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="titulo">Título del Libro:*</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                
                <div class="form-group">
                    <label for="autor_id">Autor:*</label>
                    <select id="autor_id" name="autor_id" required>
                        <option value="">Seleccionar autor</option>
                        <?php foreach ($biblioteca->getAutores() as $autor): ?>
                            <option value="<?php echo $autor->getId(); ?>">
                                <?php echo $autor->getNombre(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="categoria_id">Categoría:*</label>
                    <select id="categoria_id" name="categoria_id" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($biblioteca->getCategorias() as $categoria): ?>
                            <option value="<?php echo $categoria->getId(); ?>">
                                <?php echo $categoria->getNombre(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn">
                </div>
                
                <div class="form-group">
                    <label for="anio_publicacion">Año de Publicación:</label>
                    <input type="number" id="anio_publicacion" name="anio_publicacion" min="1000" max="2024">
                </div>
                
                <button type="submit" class="btn btn-success">Agregar Libro</button>
                <a href="../index.php" class="btn">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>