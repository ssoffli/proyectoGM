
--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `role` enum('admin','jefatura','dependencia') NOT NULL,
  `name` varchar(60) NOT NULL,
  `nick` varchar(60) NOT NULL UNIQUE KEY,
  `pass` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`role`, `name`, `nick`, `pass`) VALUES
('admin', 'Administrador', 'admin', '1234'),
('dependencia', 'Departamento Ingenieria', 'deping', '1234'),
('jefatura', 'Jefatura Grupo Mantenimiento', 'jefatura', '1234')


