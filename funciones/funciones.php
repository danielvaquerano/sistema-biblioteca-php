<?php
    session_start();

    if (!isset($_SESSION['biblioteca'])) {
        $_SESSION['biblioteca'] = new Biblioteca();
    }

    function getBiblioteca() {
        return $_SESSION['biblioteca'];
    }

    function mostrarMensaje($mensaje, $tipo = 'info') {
        $clases = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info'
        ];
        
        $clase = $clases[$tipo] ?? $clases['info'];
        return "<div class='alert {$clase}'>{$mensaje}</div>";
    }
?>