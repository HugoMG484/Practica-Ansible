-- Crear la base de datos
-- CREATE DATABASE db_practica;
USE db_practica;

-- Crear la tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

-- Insertar algunos registros
INSERT INTO usuarios (nombre, email, contraseña) VALUES
    ('Juan Pérez', 'juan@app.hmancera.com', 'asdj'),
    ('María García', 'maria@app.hmancera.com', 'asdm'),
    ('Carlos Rodríguez', 'carlos@app.hmancera.com', 'asdc');

-- Crear la tabla de componentes electrónicos
CREATE TABLE componentes_electronicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL
);

-- Insertar 10 registros
INSERT INTO componentes_electronicos (nombre, descripcion, precio) VALUES
    ('Resistor 100 Ohm', 'Resistor de película metálica de 100 Ohm', 0.50),
    ('Transistor NPN 2N2222', 'Transistor NPN de uso general', 1.25),
    ('LED Rojo 5mm', 'LED de color rojo de 5mm', 0.20),
    ('Condensador Electrolítico 100uF', 'Condensador electrolítico de 100uF', 0.75),
    ('Microcontrolador Arduino Uno', 'Microcontrolador Arduino Uno R3', 9.99),
    ('Sensor de Temperatura LM35', 'Sensor de temperatura analógico LM35', 1.99),
    ('Servomotor SG90', 'Servomotor de pequeño tamaño', 3.50),
    ('Batería 9V', 'Batería de 9V para proyectos electrónicos', 2.00),
    ('Display LCD 16x2', 'Pantalla LCD alfanumérica de 16x2 caracteres', 4.50),
    ('Cable Jumper Macho-Hembra', 'Set de cables jumper macho-hembra', 3.99);

