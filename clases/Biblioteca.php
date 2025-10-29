<?php
class Biblioteca {
        private $libros = [];
        private $autores = [];
        private $categorias = [];
        private $prestamos = [];
        private $nextLibroId = 1;
        private $nextAutorId = 1;
        private $nextCategoriaId = 1;

        public function __construct() {
            $this->inicializarDatos();
        }

        private function inicializarDatos() {
            $autor1 = new Autor($this->nextAutorId++, "Gabriel García Márquez", "Colombia");
            $autor2 = new Autor($this->nextAutorId++, "J.K. Rowling", "Reino Unido");
            $autor3 = new Autor($this->nextAutorId++, "Isabel Allende", "Chile");

            $categoria1 = new Categoria($this->nextCategoriaId++, "Novela");
            $categoria2 = new Categoria($this->nextCategoriaId++, "Fantasía");
            $categoria3 = new Categoria($this->nextCategoriaId++, "Realismo Mágico");

            $this->autores = [$autor1, $autor2, $autor3];
            $this->categorias = [$categoria1, $categoria2, $categoria3];

            $this->agregarLibro("Cien años de soledad", $autor1, $categoria3, "978-8437604947", 1967);
            $this->agregarLibro("Harry Potter y la piedra filosofal", $autor2, $categoria2, "978-8478884452", 1997);
            $this->agregarLibro("La casa de los espíritus", $autor3, $categoria1, "978-8401320751", 1982);
        }

        public function agregarLibro($titulo, $autor, $categoria, $isbn = "", $anioPublicacion = "") {
            $libro = new Libro($this->nextLibroId++, $titulo, $autor, $categoria, $isbn, $anioPublicacion);
            $this->libros[] = $libro;
            return $libro;
        }

        public function buscarLibros($termino) {
            $resultados = [];
            $termino = strtolower($termino);
            
            foreach ($this->libros as $libro) {
                if (strpos(strtolower($libro->getTitulo()), $termino) !== false ||
                    strpos(strtolower($libro->getAutor()->getNombre()), $termino) !== false ||
                    strpos(strtolower($libro->getCategoria()->getNombre()), $termino) !== false) {
                    $resultados[] = $libro;
                }
            }
            return $resultados;
        }

        public function prestarLibro($libroId) {
            foreach ($this->libros as $libro) {
                if ($libro->getId() == $libroId && $libro->getDisponible()) {
                    if ($libro->prestar()) {
                        $this->prestamos[] = [
                            'libro_id' => $libroId,
                            'fecha_prestamo' => date('Y-m-d H:i:s'),
                            'fecha_devolucion' => null
                        ];
                        return $libro;
                    }
                }
            }
            return null;
        }

        public function devolverLibro($libroId) {
            foreach ($this->libros as $libro) {
                if ($libro->getId() == $libroId && !$libro->getDisponible()) {
                    $libro->devolver();
                    
                    foreach ($this->prestamos as &$prestamo) {
                        if ($prestamo['libro_id'] == $libroId && $prestamo['fecha_devolucion'] === null) {
                            $prestamo['fecha_devolucion'] = date('Y-m-d H:i:s');
                            break;
                        }
                    }
                    return $libro;
                }
            }
            return null;
        }

        public function eliminarLibro($libroId) {
            foreach ($this->libros as $key => $libro) {
                if ($libro->getId() == $libroId) {
                    unset($this->libros[$key]);
                    $this->libros = array_values($this->libros);
                    return true;
                }
            }
            return false;
        }

        public function getLibros() { return $this->libros; }
        public function getAutores() { return $this->autores; }
        public function getCategorias() { return $this->categorias; }
        public function getPrestamos() { return $this->prestamos; }

        public function agregarAutor($nombre, $nacionalidad = "") {
            $autor = new Autor($this->nextAutorId++, $nombre, $nacionalidad);
            $this->autores[] = $autor;
            return $autor;
        }

        public function agregarCategoria($nombre, $descripcion = "") {
            $categoria = new Categoria($this->nextCategoriaId++, $nombre, $descripcion);
            $this->categorias[] = $categoria;
            return $categoria;
        }
    }
?>