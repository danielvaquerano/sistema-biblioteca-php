<?php
class Libro {
        private $id;
        private $titulo;
        private $autor;
        private $categoria;
        private $isbn;
        private $anioPublicacion;
        private $disponible;

        public function __construct($id, $titulo, $autor, $categoria, $isbn = "", $anioPublicacion = "") {
            $this->id = $id;
            $this->titulo = $titulo;
            $this->autor = $autor;
            $this->categoria = $categoria;
            $this->isbn = $isbn;
            $this->anioPublicacion = $anioPublicacion;
            $this->disponible = true;
        }

        public function getId() { return $this->id; }
        public function getTitulo() { return $this->titulo; }
        public function getAutor() { return $this->autor; }
        public function getCategoria() { return $this->categoria; }
        public function getIsbn() { return $this->isbn; }
        public function getAnioPublicacion() { return $this->anioPublicacion; }
        public function getDisponible() { return $this->disponible; }

        public function setTitulo($titulo) { $this->titulo = $titulo; }
        public function setAutor($autor) { $this->autor = $autor; }
        public function setCategoria($categoria) { $this->categoria = $categoria; }
        public function setIsbn($isbn) { $this->isbn = $isbn; }
        public function setAnioPublicacion($anioPublicacion) { $this->anioPublicacion = $anioPublicacion; }
        public function setDisponible($disponible) { $this->disponible = $disponible; }

        public function prestar() {
            if ($this->disponible) {
                $this->disponible = false;
                return true;
            }
            return false;
        }

        public function devolver() {
            $this->disponible = true;
            return true;
        }

        public function __toString() {
            $estado = $this->disponible ? "Disponible" : "Prestado";
            return "{$this->titulo} - {$this->autor} - {$this->categoria} ({$estado})";
        }
    }
?>