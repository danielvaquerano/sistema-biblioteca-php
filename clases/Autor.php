<?php
class Autor {
        private $id;
        private $nombre;
        private $nacionalidad;

        public function __construct($id, $nombre, $nacionalidad = "") {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->nacionalidad = $nacionalidad;
        }

        public function getId() { return $this->id; }
        public function getNombre() { return $this->nombre; }
        public function getNacionalidad() { return $this->nacionalidad; }

        public function setNombre($nombre) { $this->nombre = $nombre; }
        public function setNacionalidad($nacionalidad) { $this->nacionalidad = $nacionalidad; }

        public function __toString() {
            return $this->nombre . ($this->nacionalidad ? " ({$this->nacionalidad})" : "");
        }
    }
?>