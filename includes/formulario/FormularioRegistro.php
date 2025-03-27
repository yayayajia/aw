<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/model/Usuario.php';

/**
 * Formulario de registro de usuario.
 */
class FormularioRegistro extends Formulario
{
    /**
     * Construye el formulario.
     */
    public function __construct()
    {
        parent::__construct('formRegistro', ['urlRedireccion' => 'login_pantalla.php']);
    }

    /**
     * Genera los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutilizan los datos si existen o se les da valor por defecto
        $userid = $datos['userid'] ?? '';
        $email = $datos['email'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $apellidos = $datos['apellidos'] ?? '';
        $edad = $datos['edad'] ?? '';

        // Se generan los mensajes de error si existen
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores, 'errores-generales');
        $erroresCampos = self::generaErroresCampos(['userid', 'contrasena', 'email', 'nombre', 'apellidos', 'edad'], $this->errores, 'span', ['class' => 'error']);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error
        $html = <<<EOF
        <div class="form-group">
            <label for="userid">User ID:</label>
            <input id="userid" type="text" name="userid" value="$userid" required class="form-control">
            {$erroresCampos['userid']}
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input id="contrasena" type="password" name="contrasena" required class="form-control">
            {$erroresCampos['contrasena']}
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input id="email" type="email" name="email" value="$email" required class="form-control">
            {$erroresCampos['email']}
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="nombre" value="$nombre" required class="form-control">
            {$erroresCampos['nombre']}
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input id="apellidos" type="text" name="apellidos" value="$apellidos" required class="form-control">
            {$erroresCampos['apellidos']}
        </div>
        <div class="form-group">
            <label for="edad">Edad:</label>
            <input id="edad" type="number" name="edad" value="$edad" required min="1" class="form-control">
            {$erroresCampos['edad']}
        </div>
        $htmlErroresGlobales
        <div class="form-group">
            <button type="submit" class="btn">Registrarse</button>
        </div>
        <div class="form-group">
            <p>¿Ya tienes cuenta? <a href="login_pantalla.php">Inicia sesión aquí</a></p>
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

        // Validación del User ID
        $userid = trim($datos['userid'] ?? '');
        $userid = filter_var($userid, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$userid || empty($userid)) {
            $this->errores['userid'] = 'El nombre de usuario no puede estar vacío';
        }
        
        // Comprobamos que el userid no existe
        if (Usuario::buscaUsuario($userid)) {
            $this->errores['userid'] = 'El nombre de usuario ya existe';
        }

        // Validación de la contraseña
        $contrasena = trim($datos['contrasena'] ?? '');
        if (!$contrasena || empty($contrasena) || mb_strlen($contrasena) < 6) {
            $this->errores['contrasena'] = 'La contraseña debe tener al menos 6 caracteres';
        }

        // Validación del correo electrónico
        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!$email || empty($email)) {
            $this->errores['email'] = 'El email no puede estar vacío';
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'Dirección de correo electrónico no válida';
        }
        
        // Comprobar si el email ya existe en la base de datos
        if (Usuario::buscaUsuarioPorEmail($email)) {
            $this->errores['email'] = 'El email ya está registrado';
        }

        // Validación del nombre
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$nombre || empty($nombre)) {
            $this->errores['nombre'] = 'El nombre no puede estar vacío';
        }

        // Validación de los apellidos
        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$apellidos || empty($apellidos)) {
            $this->errores['apellidos'] = 'Los apellidos no pueden estar vacíos';
        }

        // Validación de la edad
        $edad = trim($datos['edad'] ?? '');
        $edad = filter_var($edad, FILTER_SANITIZE_NUMBER_INT);
        if (!$edad || empty($edad) || $edad < 1) {
            $this->errores['edad'] = 'La edad debe ser un número positivo';
        }

        if (count($this->errores) === 0) {
            // Crear el nuevo usuario
            $usuario = Usuario::crea($userid, $contrasena, $email, $nombre, $apellidos, $edad, 'usuario');
            
            if (!$usuario) {
                $this->errores[] = "Error al crear el usuario";
            }
        }
    }
}