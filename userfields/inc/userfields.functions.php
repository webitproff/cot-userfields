<?php

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.functions.php
 * @package userfields
 * @version 1.0.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Неверный URL');

global $db, $db_x, $db_userfield_types, $db_userfield_values;

$db_userfield_types = $db_x . 'userfield_types';
$db_userfield_values = $db_x . 'userfield_values';

/**
 * Возвращает список всех типов полей из базы данных
 * @return array Список типов полей
 */
function userfields_get_field_types() {
    global $db, $db_userfield_types;
    return $db->query("SELECT * FROM $db_userfield_types ORDER BY order_num ASC")->fetchAll();
}

/**
 * Получает все поля для указанного пользователя
 * @param int $user_id ID пользователя
 * @return array Список полей
 */
function userfields_get_user_fields($user_id) {
    global $db, $db_userfield_types, $db_userfield_values;

    return $db->query("SELECT v.*, 
                             t.code AS field_code, 
                             t.title AS field_title,
                             t.order_num
                      FROM $db_userfield_values v
                      LEFT JOIN $db_userfield_types t ON v.field_id = t.id
                      WHERE v.user_id = ?
                      ORDER BY t.order_num ASC", $user_id)->fetchAll();
}

/**
 * Сохраняет поля для указанного пользователя
 * @param int $user_id ID пользователя
 * @param array $fields Массив полей (field_id, value)
 */
function userfields_save_user_fields($user_id, $fields) {
    global $db, $db_userfield_values;
    
    $db->delete($db_userfield_values, "user_id = ?", $user_id);
    
    if (!empty($fields) && is_array($fields)) {
        foreach ($fields as $field_id => $field) {
            if (!empty($field_id) && isset($field['value']) && $field['value'] !== '') {
                $db->insert($db_userfield_values, [
                    'user_id' => $user_id,
                    'field_id' => (int)$field_id,
                    'value' => $field['value']
                ]);
            }
        }
    }
}

/**
 * Проверяет валидность данных типа поля
 * @param string $code Код типа поля
 * @param string $title Название типа поля
 * @param int $order_num Порядок сортировки
 * @param int|null $id ID типа поля (для редактирования, чтобы исключить себя из проверки уникальности)
 * @return bool|string Возвращает true, если данные валидны, или ключ строки ошибки из локализации
 */
function userfields_validate_field_type($code, $title, $order_num, $id = null) {
    global $db, $db_userfield_types, $L;

    if (empty($code) || empty($title) || !is_numeric($order_num)) {
        return 'userfields_error_empty_fields';
    }
    if (mb_strlen($code) > 50 || mb_strlen($title) > 100) {
        return 'userfields_error_long_code_or_title';
    }
    if (!preg_match('/^[A-Za-z0-9_-]+$/', $code)) {
        return 'userfields_error_invalid_code_format';
    }

    $query = "SELECT COUNT(*) FROM $db_userfield_types WHERE code = ? AND id != ?";
    $params = [$code, $id ?: 0];
    if ($db->query($query, $params)->fetchColumn() > 0) {
        return 'userfields_error_field_type_code_exists';
    }

    return true;
}
?>