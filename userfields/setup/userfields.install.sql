CREATE TABLE IF NOT EXISTS `cot_userfield_types` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `title` VARCHAR(100) NOT NULL,
  `field_type` ENUM('input', 'inputint', 'currency', 'double', 'textarea', 'select', 'radio', 'checkbox', 'datetime', 'country', 'range', 'checklistbox') NOT NULL DEFAULT 'input',
  `field_params` TEXT NOT NULL,
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

-- Тестовые данные для типов полей
INSERT INTO `cot_userfield_types` (`code`, `title`, `field_type`, `field_params`, `order_num`) VALUES
('cell_number', 'Номер мобильного телефона', 'input', '', 1),
('company_name', 'Название компании', 'input', '', 2),
('age', 'Возраст', 'inputint', '', 3),
('salary', 'Зарплата', 'currency', '', 4),
('weight', 'Вес', 'double', '', 5),
('bio', 'О себе', 'textarea', '', 6),
('gender', 'Пол', 'select', 'Мужской,Женский,Другое', 7),
('status', 'Статус', 'radio', 'Студент,Работающий,Безработный', 8),
('newsletter', 'Подписка на новости', 'checkbox', '', 9),
('birthdate', 'Дата рождения', 'datetime', '1970,2030,datetime_medium', 10),
('country', 'Страна', 'country', '', 11),
('experience', 'Опыт работы (лет)', 'range', '0,20', 12),
('skills', 'Навыки', 'checklistbox', 'PHP,JavaScript,Python,SQL', 13);

-- Тестовые данные для значений полей (для user_id = 1)
INSERT INTO `cot_userfield_values` (`user_id`, `field_id`, `value`) VALUES
(1, 1, '+79991234567'), -- cell_number (input)
(1, 2, 'ООО Ромашка'), -- company_name (input)
(1, 3, '30'), -- age (inputint)
(1, 4, '50000.00'), -- salary (currency)
(1, 5, '70.5'), -- weight (double)
(1, 6, 'Люблю программировать и путешествовать.'), -- bio (textarea)
(1, 7, 'Мужской'), -- gender (select)
(1, 8, 'Работающий'), -- status (radio)
(1, 9, '1'), -- newsletter (checkbox)
(1, 10, '946684800'), -- birthdate (datetime, timestamp для 01.01.2000)
(1, 11, 'ru'), -- country (страна, код России)
(1, 12, '5'), -- experience (range)
(1, 13, 'PHP,JavaScript,SQL'); -- skills (checklistbox)