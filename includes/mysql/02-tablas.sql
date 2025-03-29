-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS mercaswapp;
USE mercaswapp;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    userid VARCHAR(50) PRIMARY KEY,
    contrasena VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de Productos
CREATE TABLE IF NOT EXISTS Productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombreProducto VARCHAR(100) NOT NULL,
    descripcionProducto TEXT,
    precio DECIMAL(10,2) NOT NULL,
    categoriaProducto VARCHAR(50) NOT NULL,
    idVendedor VARCHAR(50) NOT NULL,
    rutaImagen VARCHAR(255),
    fechaRegistroProducto TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idVendedor) REFERENCES Usuarios(userid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de Ventas
CREATE TABLE IF NOT EXISTS Ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    user_id VARCHAR(50) NOT NULL,
    fechaVenta DATE NOT NULL,
    comprador_id VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES Productos(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Usuarios(userid) ON DELETE CASCADE,
    FOREIGN KEY (comprador_id) REFERENCES Usuarios(userid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de Subastas (para futuras implementaciones)
CREATE TABLE IF NOT EXISTS Subastas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    precio_inicial DECIMAL(10,2) NOT NULL,
    precio_actual DECIMAL(10,2) NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NOT NULL,
    estado ENUM('activa', 'finalizada', 'cancelada') DEFAULT 'activa',
    FOREIGN KEY (producto_id) REFERENCES Productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla de Pujas (para futuras implementaciones)
CREATE TABLE IF NOT EXISTS Pujas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subasta_id INT NOT NULL,
    user_id VARCHAR(50) NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    fecha_puja TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subasta_id) REFERENCES Subastas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Usuarios(userid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;