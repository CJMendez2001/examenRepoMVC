Create DATABASE Viajes

USE Viajes

CREATE TABLE DatosViajes (
    id_viaje INT AUTO_INCREMENT PRIMARY KEY,
    destino VARCHAR(100) NOT NULL,
    medio_transporte VARCHAR(50),
    duracion_dias INT,
    costo_total DECIMAL(10, 2),
    fecha_inicio DATE
);

-- Tabla: Datos de Vehículos
CREATE TABLE DatosVehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50),
    año_fabricacion INT,
    tipo_combustible VARCHAR(20),
    kilometraje INT
);
