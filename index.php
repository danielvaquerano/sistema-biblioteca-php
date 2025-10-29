<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Biblioteca</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; text-align: center; }
        .menu { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-top: 30px; }
        .btn { padding: 15px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; text-align: center; transition: background 0.3s; }
        .btn:hover { background: #2980b9; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #219a52; }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #d35400; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="container">
        <h1> Sistema de Gestión de Biblioteca</h1>
        <div class="menu">
            <a href="paginas/agregar_libro.php" class="btn"> Agregar Libro</a>
            <a href="paginas/buscar_libro.php" class="btn"> Buscar Libro</a>
            <a href="paginas/prestar_libro.php" class="btn btn-success">Prestar Libro</a>
            <a href="paginas/listar_libros.php" class="btn"> Listar Libros</a>
            <a href="paginas/gestionar_libros.php" class="btn btn-warning">Gestionar Libros</a>
        </div>
    </div>
</body>
</html>