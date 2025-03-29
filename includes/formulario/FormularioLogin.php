<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';

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
        parent::__construct('formLogin', ['urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php']);
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
        
            // Depuración de la conexión
    $app = Aplicacion::getInstance();
    $conn = $app->getConexionBd();
    
    if ($conn && !$conn->connect_errno) {
        error_log("DEBUG: Conexión a la BD establecida correctamente durante login");
    } else {
        error_log("DEBUG: Error de conexión a la BD durante login: " . ($conn ? $conn->connect_error : "No hay conexión"));
    }
    
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
            require_once __DIR__ . '/../Usuarios/sa/loginSA.php';
            $usuarioSA = new UsuarioSA();
            
            if ($usuarioSA->loginUsuario($userid, $contrasena)) {
                $_SESSION['login'] = true;
                $_SESSION['userid'] = $userid;
                $_SESSION['nombre'] = $userid; // Aquí deberías obtener el nombre real del usuario
            } else {
                $this->errores[] = "El usuario o la contraseña no coinciden";
            }
        }
    }
}