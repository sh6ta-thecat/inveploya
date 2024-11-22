-- Crear la base de datos para el sistema de inventario
CREATE DATABASE IF NOT EXISTS sistema_inventario;
USE sistema_inventario;

-- Tabla para usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID único para cada usuario
    nombres VARCHAR(100) NOT NULL, -- Nombre(s) del usuario
    apellidos VARCHAR(100) NOT NULL, -- Apellidos del usuario
    cargo ENUM('administrador', 'usuario') NOT NULL, -- Tipo de usuario
    contraseña VARCHAR(255) NOT NULL, -- Contraseña encriptada
    direccion VARCHAR(255), -- Dirección del usuario
    telefono VARCHAR(15), -- Teléfono del usuario
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Fecha de registro
);

-- Tabla para categorías de productos
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY, -- ID único de la categoría
    nombre_categoria VARCHAR(100) NOT NULL, -- Nombre de la categoría
    presentacion VARCHAR(50) NOT NULL -- Presentación de los productos de la categoría
);

-- Tabla para proveedores
CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY, -- ID único del proveedor
    nombres VARCHAR(100) NOT NULL, -- Nombre del proveedor
    apellidos VARCHAR(100), -- Apellidos del proveedor
    empresa_nombre VARCHAR(100) NOT NULL, -- Nombre de la empresa
    ruc VARCHAR(20) NOT NULL UNIQUE, -- RUC de la empresa
    direccion VARCHAR(255), -- Dirección del proveedor
    telefono VARCHAR(15), -- Teléfono del proveedor
    categoria_empresa VARCHAR(100) -- Categoría de la empresa
);

-- Tabla para productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY, -- ID único del producto
    id_categoria INT NOT NULL, -- ID de la categoría (relación con tabla 'categorias')
    nombre_articulo VARCHAR(100) NOT NULL, -- Nombre del producto
    presentacion VARCHAR(50) NOT NULL, -- Presentación del producto
    precio_venta DECIMAL(10, 2) NOT NULL, -- Precio de venta del producto
    ganancia DECIMAL(10, 2) NOT NULL, -- Ganancia del producto
    costo DECIMAL(10, 2) NOT NULL, -- Costo del producto
    estado ENUM('abastecido', 'agotado') DEFAULT 'agotado', -- Estado del producto
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) -- Llave foránea
);

-- Tabla para entradas de productos
CREATE TABLE entradas (
    id_entrada INT AUTO_INCREMENT PRIMARY KEY, -- ID único de la entrada
    codigo VARCHAR(50) NOT NULL, -- Código del producto
    id_producto INT NOT NULL, -- ID del producto (relación con tabla 'productos')
    categoria VARCHAR(100) NOT NULL, -- Categoría del producto
    nombre_articulo VARCHAR(100) NOT NULL, -- Nombre del producto
    cantidad INT NOT NULL, -- Cantidad de productos ingresados
    presentacion VARCHAR(50), -- Presentación del producto
    precio DECIMAL(10, 2), -- Precio unitario del producto
    costo_total DECIMAL(10, 2), -- Costo total del lote ingresado
    fecha DATE NOT NULL, -- Fecha de la entrada
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) -- Llave foránea
);

-- Tabla para salidas de productos
CREATE TABLE salidas (
    id_salida INT AUTO_INCREMENT PRIMARY KEY, -- ID único de la salida
    codigo VARCHAR(50) NOT NULL, -- Código del producto
    id_producto INT NOT NULL, -- ID del producto (relación con tabla 'productos')
    categoria VARCHAR(100) NOT NULL, -- Categoría del producto
    nombre_articulo VARCHAR(100) NOT NULL, -- Nombre del producto
    cantidad INT NOT NULL, -- Cantidad de productos retirados
    presentacion VARCHAR(50), -- Presentación del producto
    precio DECIMAL(10, 2), -- Precio unitario del producto
    costo_total DECIMAL(10, 2), -- Costo total del lote retirado
    venta_total DECIMAL(10, 2), -- Ganancia total de la venta
    fecha DATE NOT NULL, -- Fecha de la salida
    id_proveedor INT, -- ID del proveedor (opcional, relación con tabla 'proveedores')
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto), -- Llave foránea
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor) -- Llave foránea
);

-- Tabla para el registro de inventarios
CREATE TABLE inventario (
    id_inventario INT AUTO_INCREMENT PRIMARY KEY, -- ID único del inventario
    id_producto INT NOT NULL, -- ID del producto (relación con tabla 'productos')
    categoria VARCHAR(100) NOT NULL, -- Categoría del producto
    nombre_articulo VARCHAR(100) NOT NULL, -- Nombre del producto
    cantidad_actual INT NOT NULL, -- Cantidad disponible
    estado ENUM('abastecido', 'agotado') DEFAULT 'agotado', -- Estado del inventario
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) -- Llave foránea
);

-- Tabla de permisos
CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_permiso VARCHAR(50) NOT NULL, -- Nombre del permiso (CRUD, etc.)
    descripcion TEXT                      -- Descripción opcional del permiso
);

-- Relación entre usuarios y permisos
CREATE TABLE usuario_permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id VARCHAR(50),              -- Relación con los usuarios
    permiso_id INT,                      -- Relación con los permisos
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permisos(id) ON DELETE CASCADE
);
