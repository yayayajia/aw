-- Insertar usuarios de prueba
-- Contraseña: password123 (hash generado con password_hash usando PASSWORD_BCRYPT)
INSERT INTO Usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) VALUES
('admin', '$2y$10$jGP9EVIUB1ZyVYrxlpfYd.i8kNO0G8.y.7KZw5aCRFY84rE9HXGyO', 'admin@mercaswapp.com', 'Administrador', 'Del Sistema', 30, 'admin'),
('usuario1', '$2y$10$jGP9EVIUB1ZyVYrxlpfYd.i8kNO0G8.y.7KZw5aCRFY84rE9HXGyO', 'usuario1@ejemplo.com', 'Juan', 'Pérez González', 25, 'usuario'),
('usuario2', '$2y$10$jGP9EVIUB1ZyVYrxlpfYd.i8kNO0G8.y.7KZw5aCRFY84rE9HXGyO', 'usuario2@ejemplo.com', 'María', 'López Sánchez', 32, 'usuario'),
('usuario3', '$2y$10$jGP9EVIUB1ZyVYrxlpfYd.i8kNO0G8.y.7KZw5aCRFY84rE9HXGyO', 'usuario3@ejemplo.com', 'Carlos', 'Martínez Ruiz', 28, 'usuario');

-- Insertar productos de prueba
INSERT INTO Productos (nombreProducto, descripcionProducto, precio, categoriaProducto, idVendedor, rutaImagen) VALUES
('Portátil HP Pavilion', 'Portátil HP Pavilion con 16GB RAM, 512GB SSD, pantalla 15.6", procesador i7.', 599.99, 'computadora', 'usuario1', '/fotos/laptop1.jpg'),
('Monitor Samsung 27"', 'Monitor Samsung curvo de 27 pulgadas, resolución 2K, panel VA.', 199.50, 'pantalla', 'usuario2', '/fotos/monitor1.jpg'),
('Teclado mecánico Logitech', 'Teclado mecánico Logitech con retroiluminación RGB y switches Blue.', 79.99, 'teclado', 'usuario3', '/fotos/teclado1.jpg'),
('Ratón gaming Razer', 'Ratón gaming Razer con 16000 DPI, 8 botones programables.', 45.50, 'ratón', 'usuario1', '/fotos/raton1.jpg'),
('Auriculares Sony', 'Auriculares Sony inalámbricos con cancelación de ruido.', 89.99, 'auriculares', 'usuario2', '/fotos/auriculares1.jpg'),
('Altavoces Bose', 'Altavoces Bose con conexión Bluetooth y gran calidad de sonido.', 120.00, 'altavoces', 'usuario3', '/fotos/altavoces1.jpg'),
('Impresora HP Laserjet', 'Impresora láser HP con escáner y conectividad WiFi.', 150.00, 'impresora', 'usuario1', '/fotos/impresora1.jpg'),
('Nintendo Switch', 'Consola Nintendo Switch con dos Joy-Con y dock para TV.', 299.99, 'juegos', 'usuario2', '/fotos/switch1.jpg');

-- Insertar algunas ventas de ejemplo
INSERT INTO Ventas (producto_id, user_id, fechaVenta, comprador_id, precio) VALUES
(3, 'usuario3', '2025-02-15', 'usuario1', 79.99),
(4, 'usuario1', '2025-03-10', 'usuario2', 45.50),
(7, 'usuario1', '2025-03-20', 'usuario3', 150.00);