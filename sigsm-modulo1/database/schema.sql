CREATE DATABASE IF NOT EXISTS hospital_clinicas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'sigsm_app'@'localhost' IDENTIFIED BY 'CAMBIAR_CONTRASENA';
GRANT SELECT, INSERT, UPDATE, DELETE ON hospital_clinicas.* TO 'sigsm_app'@'localhost';
FLUSH PRIVILEGES;

USE hospital_clinicas;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('administrador','funcionario') NOT NULL DEFAULT 'funcionario',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(180) NOT NULL,
    descripcion TEXT NULL,
    archivo VARCHAR(255) NOT NULL,
    categoria_id INT NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_documentos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS encuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(180) NOT NULL,
    descripcion TEXT NULL,
    segmento VARCHAR(100) NOT NULL,
    activa TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS preguntas_encuesta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    encuesta_id INT NOT NULL,
    pregunta TEXT NOT NULL,
    tipo ENUM('opciones','texto','si_no') NOT NULL DEFAULT 'opciones',
    orden INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_preguntas_encuesta FOREIGN KEY (encuesta_id) REFERENCES encuestas(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS respuestas_encuesta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    encuesta_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    respuesta VARCHAR(500) NOT NULL,
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_respuesta_encuesta FOREIGN KEY (encuesta_id) REFERENCES encuestas(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_respuesta_pregunta FOREIGN KEY (pregunta_id) REFERENCES preguntas_encuesta(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS auditoria (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    accion VARCHAR(50) NOT NULL,
    modulo VARCHAR(50) NOT NULL,
    descripcion VARCHAR(255) NULL,
    ip VARCHAR(45) NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_auditoria_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT IGNORE INTO categorias (id, nombre, descripcion) VALUES
(1, 'Cardiología', 'Indicaciones y documentación de cardiología'),
(2, 'Nefrología y Trasplante', 'Documentación de nefrología y trasplante'),
(3, 'Enfermería', 'Indicaciones y cuidados de enfermería'),
(4, 'Estudios e Imagenología', 'Preparación e indicaciones para estudios'),
(5, 'Información General', 'Información general para pacientes'),
(6, 'Otros', 'Otros documentos del hospital');

INSERT IGNORE INTO encuestas (id, titulo, descripcion, segmento, activa) VALUES
(1, 'Encuesta estándar de satisfacción', 'Encuesta anónima de satisfacción general.', 'General', 1),
(2, 'Encuesta de satisfacción del usuario trasplantado', 'Encuesta anónima para usuarios trasplantados.', 'Trasplante', 1),
(3, 'Encuesta sobre evolución de los programas', 'Encuesta relacionada con la evolución de los programas del Fondo Nacional de Recursos.', 'FNR', 1);

INSERT IGNORE INTO preguntas_encuesta (id, encuesta_id, pregunta, tipo, orden) VALUES
(1, 1, '¿Cómo calificaría la atención recibida?', 'opciones', 1),
(2, 1, '¿La información brindada fue clara?', 'opciones', 2),
(3, 2, '¿Cómo calificaría la atención recibida en el área de trasplante?', 'opciones', 1),
(4, 2, '¿La información brindada fue clara?', 'opciones', 2),
(5, 3, '¿Cómo valora la evolución del programa?', 'opciones', 1);
