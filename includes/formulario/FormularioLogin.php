<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/model/Usuario.php';

/**
 * Formulario de login de usuario.
 */
class FormularioLogin extends Formulario
{
    /**
     * Construye el formulario.
     */
    public function __construct()
    {
        parent::__construct('formLogin', ['urlRedireccion' => 'perfil_pantalla.php']);
    }

    /**
     * Genera los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutilizan los datos si existen o se les da valor por defecto
        $userid = $datos['userid'] ?? '';

        // Se generan los mensajes de error si existen
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores, 'errores-generales');
        $erroresCampos = self::generaErroresCampos(['userid', 'contrasena'], $this->errores, 'span', ['class' => 'error']);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error
        $html = <<<EOF
        <div class="form-group">
            <label for="userid">Usuario:</label>
            <input id="userid" type="text" name="userid" value="$userid" required class="form-control">
            {$erroresCampos['userid']}
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input id="contrasena" type="password" name="contrasena" required class="form-control">
            {$erroresCampos['contrasena']}
        </div>
        $htmlErroresGlobales
        <div class="form-group">
            <button type="submit" class="btn">Iniciar Sesión</button>
        </div>
        <div class="form-group">
            <p>¿No tienes cuenta? <a href="register_pantalla.php">Regístrate aquí</a></p>
        </div>
        EOF;
        return $html;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $userid = trim($datos['userid'] ?? '');
        $userid = filter_var($userid, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$userid || empty($userid)) {
            $this->errores['userid'] = 'El nombre de usuario no puede estar vacío';
        }

        $contrasena = trim($datos['contrasena'] ?? '');
        if (!$contrasena || empty($contrasena)) {
            $this->errores['contrasena'] = 'La contraseña no puede estar vacía';
        }

        if (count($this->errores) === 0) {
            // Comprobamos si existe el usuario
            $usuario = Usuario::buscaUsuario($userid);
            if (!$usuario) {
                $this->errores[] = "El usuario o la contraseña no coinciden";
                return;
            }

            // Comprobamos la contraseña
            if (!$usuario->compruebaPassword($contrasena)) {
                $this->errores[] = "El usuario o la contraseña no coinciden";
                return;
            }

            // Iniciamos la sesión con el usuario
            $_SESSION['userid'] = $usuario->getUserId();
            $_SESSION['nombre'] = $usuario->getNombre();
            $_SESSION['rol'] = $usuario->getRol();
        }
    }
}