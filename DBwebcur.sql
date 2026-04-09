DROP DATABASE IF EXISTS cursos_online;
CREATE DATABASE cursos_online;
USE cursos_online;

-- =========================
-- 👤 USUARIOS Y ROLES
-- =========================

CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
);
INSERT INTO roles (nombre, descripcion) VALUES
('admin', 'Administrador del sistema'),
('gerencia', 'Administrador de la plataforma'),
('instructor', 'Creador de cursos'),
('colaborador', 'Creador de noticias y eventos'),
('estudiante', 'Usuario que consume cursos');

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    dni VARCHAR(20) UNIQUE,
    password VARCHAR(255),
    telefono VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo','inactivo') DEFAULT 'activo'
);

CREATE TABLE usuario_roles (
    id_usuario INT,
    id_rol INT,
    PRIMARY KEY (id_usuario, id_rol),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE
);
INSERT INTO usuarios (id_usuario, nombre, apellido, email, dni, password, telefono) VALUES
/* password general -- 123 -- */
(1, 'Admin', 'General', 'admin@gmail.com', '0000', '$2y$10$QD1TgBoGhFTUdWdST.seHu5a24mmpaDFFeBRxstprU5KK9l/Mhn8q', '999111222'),
(2, 'Juan', 'Perez', 'juan@gmail.com', '10', '$2y$10$QD1TgBoGhFTUdWdST.seHu5a24mmpaDFFeBRxstprU5KK9l/Mhn8q', '999111222'),
(3, 'Maria', 'Lopez', 'maria@gmail.com', '11', '$2y$10$QD1TgBoGhFTUdWdST.seHu5a24mmpaDFFeBRxstprU5KK9l/Mhn8q', '999333444'),
(4, 'Carlos', 'Ramirez', 'carlos@gmail.com', '12', '$2y$10$QD1TgBoGhFTUdWdST.seHu5a24mmpaDFFeBRxstprU5KK9l/Mhn8q', '999555666'),
(5, 'Ana', 'Torres', 'ana@gmail.com', '13', '$2y$10$QD1TgBoGhFTUdWdST.seHu5a24mmpaDFFeBRxstprU5KK9l/Mhn8q', '999777888');

INSERT INTO usuario_roles (id_usuario, id_rol) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- =========================
-- 📚 CURSOS Y MÓDULOS
-- =========================

CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    descripcion TEXT,
    nivel ENUM('basico','intermedio','avanzado'),
    duracion_horas INT,
    imagen VARCHAR(255),
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_instructor INT,
    FOREIGN KEY (id_instructor) REFERENCES usuarios(id_usuario)
);
INSERT INTO cursos (titulo, descripcion, nivel, duracion_horas, id_instructor) VALUES
('Python desde cero', 'Aprende Python básico a avanzado', 'basico', 40, 2),
('Desarrollo Web Full Stack', 'HTML, CSS, JS, Backend', 'intermedio', 60, 2),
('Base de Datos MySQL', 'Modelado y consultas SQL', 'basico', 30, 2);

CREATE TABLE modulos (
    id_modulo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    descripcion TEXT,
    orden INT,
    id_curso INT,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO modulos (titulo, descripcion, orden, id_curso) VALUES
('Introducción a Python', 'Conceptos básicos', 1, 1),
('Estructuras de Control', 'If, loops', 2, 1),
('HTML y CSS', 'Diseño web', 1, 2),
('JavaScript', 'Programación web', 2, 2),
('Introducción a SQL', 'Consultas básicas', 1, 3);

CREATE TABLE contenidos (
    id_contenido INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('pdf','video','link'),
    url VARCHAR(255),
    titulo VARCHAR(200),
    id_modulo INT,
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo)
);
INSERT INTO contenidos (tipo, url, titulo, id_modulo) VALUES
('pdf', 'docs/python_intro.pdf', 'Guía Python', 1),
('video', 'videos/python_intro.mp4', 'Clase Python', 1),
('pdf', 'docs/html.pdf', 'Guía HTML', 3),
('video', 'videos/js.mp4', 'Clase JS', 4),
('pdf', 'docs/sql.pdf', 'Guía SQL', 5);

-- =========================
-- 📝 EXÁMENES Y NOTAS
-- =========================

CREATE TABLE examenes (
    id_examen INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    descripcion TEXT,
    id_modulo INT,
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo) ON DELETE CASCADE
);
INSERT INTO examenes (titulo, descripcion, id_modulo) VALUES
('Examen de Python', 'Evalúa conceptos básicos de Python', 1);

CREATE TABLE preguntas (
    id_pregunta INT AUTO_INCREMENT PRIMARY KEY,
    texto_pregunta TEXT,
    puntos INT DEFAULT 1,
    id_examen INT,
    FOREIGN KEY (id_examen) REFERENCES examenes(id_examen) ON DELETE CASCADE
);
INSERT INTO preguntas (texto_pregunta, puntos, id_examen) VALUES
('¿Qué función se usa para imprimir en consola en Python?', 10, 1),
('¿Python es compilado o interpretado?', 10, 1);

CREATE TABLE opciones (
    id_opcion INT AUTO_INCREMENT PRIMARY KEY,
    texto_opcion TEXT,
    es_correcta BOOLEAN DEFAULT FALSE,
    id_pregunta INT,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta) ON DELETE CASCADE
);
INSERT INTO opciones (texto_opcion, es_correcta, id_pregunta) VALUES
('print()', TRUE, 1), ('echo()', FALSE, 1),
('Interpretado', TRUE, 2), ('Compilado', FALSE, 2);

CREATE TABLE notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_examen INT,
    puntaje_obtenido INT,
    fecha_examen TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_examen) REFERENCES examenes(id_examen) ON DELETE CASCADE
);
INSERT INTO notas (id_usuario, id_examen, puntaje_obtenido) VALUES
(3, 1, 20);

-- =========================
-- 💰 PRECIOS Y PLANES
-- =========================

CREATE TABLE precios (
    id_precio INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('modulo','curso','mensual','anual'),
    monto DECIMAL(10,2),
    descripcion TEXT,
    id_curso INT,
    id_modulo INT,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo)
);
INSERT INTO precios (tipo, monto, descripcion, id_curso) VALUES
('curso', 100.00, 'Precio completo Python', 1),
('curso', 150.00, 'Curso Full Stack', 2),
('curso', 80.00, 'Curso MySQL', 3),
('mensual', 50.00, 'Acceso mensual', NULL),
('anual', 400.00, 'Acceso total anual', NULL);

-- =========================
-- 💳 PAGOS Y COMPRAS
-- =========================

CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    monto DECIMAL(10,2),
    metodo_pago VARCHAR(50),
    estado ENUM('pendiente','pagado','rechazado'),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
INSERT INTO pagos (id_usuario, monto, metodo_pago, estado) VALUES
(3, 100.00, 'tarjeta', 'pagado'),
(4, 150.00, 'yape', 'pagado'),
(3, 50.00, 'plin', 'pendiente');

CREATE TABLE detalle_pagos (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pago INT,
    id_curso INT,
    id_modulo INT,
    FOREIGN KEY (id_pago) REFERENCES pagos(id_pago),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo)
);
INSERT INTO detalle_pagos (id_pago, id_curso) VALUES
(1, 1),
(2, 2),
(3, 3);

-- =========================
-- ⭐ CALIFICACIONES
-- =========================

CREATE TABLE calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    id_curso INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO calificaciones (puntuacion, comentario, id_usuario, id_curso) VALUES
(5, 'Excelente curso', 3, 1),
(4, 'Muy bueno', 4, 2),
(3, 'Regular', 3, 3);

-- =========================
-- 📈 PROGRESO DEL USUARIO
-- =========================

CREATE TABLE progreso (
    id_progreso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_curso INT,
    porcentaje DECIMAL(5,2),
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO progreso (id_usuario, id_curso, porcentaje) VALUES
(3, 1, 50.00),
(4, 2, 30.00),
(3, 3, 80.00);

CREATE TABLE progreso_modulo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_modulo INT,
    completado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo)
);
INSERT INTO progreso_modulo (id_usuario, id_modulo, completado) VALUES
(3, 1, TRUE),
(3, 2, FALSE),
(4, 3, TRUE),
(4, 4, FALSE);

-- =========================
-- 🎓 CERTIFICADOS Y DIPLOMADOS
-- =========================

CREATE TABLE certificados (
    id_certificado INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_curso INT,
    fecha_emision DATE,
    codigo_verificacion VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO certificados (id_usuario, id_curso, fecha_emision, codigo_verificacion) VALUES
(3, 1, '2026-01-10', 'CERT12345'),
(4, 2, '2026-02-15', 'CERT67890');

CREATE TABLE diplomados (
    id_diplomado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200),
    descripcion TEXT
);
INSERT INTO diplomados (nombre, descripcion) VALUES
('Diplomado en Programación', 'Incluye Python y Web'),
('Diplomado en Base de Datos', 'Incluye SQL avanzado');

CREATE TABLE diplomado_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_diplomado INT,
    id_curso INT,
    FOREIGN KEY (id_diplomado) REFERENCES diplomados(id_diplomado),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO diplomado_cursos (id_diplomado, id_curso) VALUES
(1, 1),
(1, 2),
(2, 3);

-- =========================
-- 📰 NOTICIAS Y OFERTAS
-- =========================

CREATE TABLE noticias (
    id_noticia INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    contenido TEXT,
    imagen VARCHAR(255),
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_autor INT,
    FOREIGN KEY (id_autor) REFERENCES usuarios(id_usuario)
);
INSERT INTO noticias (titulo, contenido, id_autor) VALUES
('Nueva plataforma lanzada', 'Hemos mejorado el sistema', 1),
('Nuevos cursos disponibles', 'Revisa los cursos nuevos', 2);

CREATE TABLE ofertas (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    descripcion TEXT,
    descuento DECIMAL(5,2),
    fecha_inicio DATE,
    fecha_fin DATE,
    id_curso INT,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO ofertas (titulo, descripcion, descuento, fecha_inicio, fecha_fin, id_curso) VALUES
('Oferta Python', '50% descuento', 50.00, '2026-03-01', '2026-03-31', 1),
('Promo Web', '30% descuento', 30.00, '2026-03-10', '2026-03-25', 2);

-- =========================
-- 📅 CALENDARIO
-- =========================

CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    descripcion TEXT,
    fecha_inicio DATETIME,
    fecha_fin DATETIME,
    id_curso INT,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin, id_curso) VALUES
('Clase en vivo Python', 'Sesión Zoom', '2026-03-20 18:00:00', '2026-03-20 20:00:00', 1),
('Workshop Web', 'Evento práctico', '2026-03-22 17:00:00', '2026-03-22 19:00:00', 2);

-- =========================
-- 🔔 NOTIFICACIONES
-- =========================

CREATE TABLE notificaciones (
    id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
    mensaje TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    leido BOOLEAN DEFAULT FALSE,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
INSERT INTO notificaciones (mensaje, id_usuario) VALUES
('Nuevo curso disponible', 3),
('Tu pago fue confirmado', 4);

CREATE TABLE inscripciones (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_curso INT,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo','finalizado'),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);
INSERT INTO inscripciones (id_usuario, id_curso, estado) VALUES
(3, 1, 'activo'),
(4, 2, 'activo'),
(3, 3, 'finalizado');

