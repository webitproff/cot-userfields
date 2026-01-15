/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+ запрос на удаление таблиц плагина
 * Filename: userfields.uninstall.sql
 *
 * Date: Jan 14Th, 2026
 *
 * --package userfields
 * --version 2.0.1
 * --author webitproff
 * --copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * --license BSD
 */

DROP TABLE IF EXISTS `cot_userfield_values`;
DROP TABLE IF EXISTS `cot_userfield_types`;