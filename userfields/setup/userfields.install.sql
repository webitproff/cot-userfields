CREATE TABLE IF NOT EXISTS `cot_userfield_types` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `title` VARCHAR(100) NOT NULL,
  `order_num` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cot_userfield_values` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `field_id` INT UNSIGNED NOT NULL,
  `value` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_field` (`user_id`, `field_id`),
  FOREIGN KEY (`field_id`) REFERENCES `cot_userfield_types`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Добавление тестовых типов полей
INSERT INTO `cot_userfield_types` (`code`, `title`, `order_num`) VALUES
('cell-number', 'Номер мобильного телефона', 1),
('company-name', 'Название компании', 2);