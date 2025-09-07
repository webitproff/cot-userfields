<?php
/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.functions.php
 * @package userfields
 * @version 1.1.7
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Неверный URL');

require_once cot_incfile('forms');

global $db, $db_x, $db_userfield_types, $db_userfield_values, $cot_countries, $sys;

$db_userfield_types = $db_x . 'userfield_types';
$db_userfield_values = $db_x . 'userfield_values';

/**
 * Удаление ссылок и потенциально вредоносного кода из текста
 */
function userfields_strip_links(string $html): string {
    global $cfg;
    if (!isset($cfg['plugin']['userfields']['use_function_strip_links']) || $cfg['plugin']['userfields']['use_function_strip_links'] !== '1') {
        return $html;
    }

    // Удаляем теги <script> и их содержимое
    $html = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $html);

    // Заменяем <div> на <p>
    $html = preg_replace('#<div\b([^>]*)>#i', '<p$1>', $html);
    $html = preg_replace('#</div>#i', '</p>', $html);

    // Удаляем атрибуты событий (onclick, onload и т.д.)
    $html = preg_replace('#\s(on\w+)\s*=\s*(["\']).*?\2#i', '', $html);

    // Удаляем javascript: и data: из href/src
    $html = preg_replace_callback('#\s(href|src)\s*=\s*(["\'])(.*?)\2#i', function($m) {
        $attr = $m[1];
        $quote = $m[2];
        $val = trim($m[3]);
        if (preg_match('#^(javascript:|data:)#i', $val)) {
            return '';
        }
        return " $attr=$quote$val$quote";
    }, $html);

    // Удаляем теги <a>, оставляя текст
    $html = preg_replace_callback('#<a\b[^>]*>(.*?)</a>#si', function ($m) {
        return strip_tags($m[1]);
    }, $html);

    // Удаляем прямые URL (https://, http://, ftp://, www.)
    $html = preg_replace('#\b(?:https?://|ftp://|www\.)\S+\b#i', '', $html);

    // Удаляем пустые теги
    $html = preg_replace('#<(\w+)[^>]*>\s*</\1>#', '', $html);

    // Очищаем лишние пробелы
    $html = trim($html);

    return $html;
}

/**
 * Returns list of all field types from database
 * @return array List of field types
 */
function userfields_get_field_types() {
    global $db, $db_userfield_types;
    return $db->query("SELECT * FROM $db_userfield_types ORDER BY order_num ASC")->fetchAll();
}

/**
 * Gets all fields for the specified user
 * @param int $user_id User ID
 * @return array List of fields
 */
function userfields_get_user_fields($user_id) {
    global $db, $db_userfield_types, $db_userfield_values;

    $fields = $db->query("SELECT v.*, 
                             t.code AS field_code, 
                             t.title AS field_title,
                             t.field_type,
                             t.field_params,
                             t.order_num
                      FROM $db_userfield_values v
                      LEFT JOIN $db_userfield_types t ON v.field_id = t.id
                      WHERE v.user_id = ?
                      ORDER BY t.order_num ASC", $user_id)->fetchAll();

    foreach ($fields as &$field) {
        $field['value'] = userfields_format_value($field['field_type'], $field['value'], true);
    }

    return $fields;
}

/**
 * Saves fields for the specified user
 * @param int $user_id User ID
 * @param array $fields Array of fields (field_id => value)
 */
function userfields_save_user_fields($user_id, $fields) {
    global $db, $db_userfield_values;

    if (!$user_id || !is_numeric($user_id)) {
        return false;
    }

    $db->delete($db_userfield_values, "user_id = ?", $user_id);

    if (!empty($fields) && is_array($fields)) {
        foreach ($fields as $field_id => $field) {
            if (!empty($field_id) && isset($field['value']) && $field['value'] !== '') {
                $value = userfields_format_value_for_save($field_id, $field['value']);
                if ($value !== '') {
                    $db->insert($db_userfield_values, [
                        'user_id' => (int)$user_id,
                        'field_id' => (int)$field_id,
                        'value' => $value
                    ]);
                }
            }
        }
    }
}

/**
 * Validates field type data
 * @param string $code Field type code
 * @param string $title Field type title
 * @param string $field_type Field type (enum)
 * @param string $field_params Field parameters
 * @param int $order_num Sort order
 * @param int|null $id Field type ID (for editing to exclude itself from uniqueness check)
 * @return bool|string True if data is valid, or localization error key
 */
function userfields_validate_field_type($code, $title, $field_type, $field_params, $order_num, $id = null) {
    global $db, $db_userfield_types, $L;

    if (empty($code) || empty($title) || !is_numeric($order_num)) {
        return 'userfields_error_empty_fields';
    }
    if (mb_strlen($code) > 50 || mb_strlen($title) > 100) {
        return 'userfields_error_long_code_or_title';
    }
    if (!preg_match('/^[A-Za-z0-9_]+$/', $code)) {
        return 'userfields_error_invalid_code_format';
    }

    $allowed_types = ['input', 'inputint', 'currency', 'double', 'textarea', 'select', 'radio', 'checkbox', 'datetime', 'country', 'range', 'checklistbox'];
    if (!in_array($field_type, $allowed_types)) {
        return 'userfields_error_invalid_type';
    }

    if (in_array($field_type, ['select', 'radio', 'checklistbox', 'range', 'datetime']) && empty($field_params)) {
        return 'userfields_error_empty_params';
    }

    $query = "SELECT COUNT(*) FROM $db_userfield_types WHERE code = ? AND id != ?";
    $params = [$code, $id ?: 0];
    if ($db->query($query, $params)->fetchColumn() > 0) {
        return 'userfields_error_field_type_code_exists';
    }

    return true;
}


/**
 * Builds input HTML for the field
 * @param string $name Input name
 * @param array $extrafield Field config (type, params, etc)
 * @param mixed $data Existing value
 * @param bool $filter_mode Filter mode for search forms
 * @return string HTML input
 */
function userfields_build_input($name, $extrafield, $data, $filter_mode = false) {
    global $L, $cfg, $sys, $cot_countries;

    $type = $extrafield['field_type'];
    $params = $extrafield['field_params'];

    $data = ($data === null) ? '' : $data;

    switch ($type) {
		case 'input':
			// Поле типа "строка"
			$extra_attrs = 'autocomplete="off" readonly onfocus="this.removeAttribute(\'readonly\');" maxlength="255"';
			return '<input type="text" class="form-control" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars(userfields_strip_links($data)) . '" ' . $extra_attrs . '>';
        case 'inputint':
        case 'currency':
        case 'double':
            if ($filter_mode && in_array($type, ['inputint', 'currency', 'double', 'range'])) {
                return cot_inputbox('text', $name . '_min', '', 'placeholder="Min"') . ' - ' . cot_inputbox('text', $name . '_max', '', 'placeholder="Max"');
            }
            return cot_inputbox('text', $name, userfields_strip_links($data));

        case 'textarea':
            return cot_textarea($name, userfields_strip_links($data), 4, 56);

        case 'select':
            $opt_array = explode(",", $params);
            $options_titles = $options_values = [];
            foreach ($opt_array as $ii => $var) {
                $var = trim($var);
                $options_titles[] = (!empty($L[$extrafield['code'] . '_' . $var])) ? $L[$extrafield['code'] . '_' . $var] : $var;
                $options_values[] = $var;
            }
            if ($filter_mode) {
                return cot_selectbox($data, $name . '[]', $options_values, $options_titles, true, '', 'multiple');
            }
            return cot_selectbox($data, $name, $options_values, $options_titles, true);

        case 'radio':
            $opt_array = explode(",", $params);
            $options_titles = $options_values = [];
            foreach ($opt_array as $ii => $var) {
                $var = trim($var);
                $options_titles[] = (!empty($L[$extrafield['code'] . '_' . $var])) ? $L[$extrafield['code'] . '_' . $var] : $var;
                $options_values[] = $var;
            }
            if ($filter_mode) {
                return cot_selectbox($data, $name, $options_values, $options_titles, true);
            }
            return cot_radiobox($data, $name, $options_values, $options_titles, ['class' => 'form-check-input']);

        case 'checkbox':
            $title = $extrafield['title'];
            if ($filter_mode) {
                return cot_checkbox($data, $name, $title);
            }
            return cot_checkbox($data, $name, $title, '', '1');

        case 'datetime':
            list($min, $max, $format) = explode(",", $params . ",,,", 3);
            $max = (int)$max > 0 ? $max : date('Y');
            $min = (int)$min > 0 ? $min : 2000;
            $format = $format ?: 'datetime_medium';
            $data = is_numeric($data) ? (int)$data : 0;
            if ($filter_mode) {
                return cot_selectbox_date(0, 'short', $name . '_from', $max, $min, true) . ' - ' . cot_selectbox_date(0, 'short', $name . '_to', $max, $min, true);
            }
            return cot_selectbox_date($data, $format, $name, (int)$max, (int)$min, true);

        case 'country':
            if ($filter_mode) {
                return cot_selectbox_countries('', $name, true);
            }
            return cot_selectbox_countries($data, $name, true);

        case 'range':
            list($min, $max) = explode(',', $params . ',', 2);
            $min = (int)$min;
            $max = (int)$max;
            if ($filter_mode) {
                return cot_inputbox('text', $name . '_min', '', 'placeholder="Min"') . ' - ' . cot_inputbox('text', $name . '_max', '', 'placeholder="Max"');
            }
            return cot_selectbox($data, $name, range($min, $max), range($min, $max), true);

        case 'checklistbox':
            $opt_array = explode(",", $params);
            $options_titles = $options_values = [];
            foreach ($opt_array as $ii => $var) {
                $var = trim($var);
                $options_titles[] = (!empty($L[$extrafield['code'] . '_' . $var])) ? $L[$extrafield['code'] . '_' . $var] : $var;
                $options_values[] = $var;
            }
            if (!is_array($data)) {
                $data = $data ? explode(',', $data) : [];
            }
            if ($filter_mode) {
                return cot_selectbox($data, $name . '[]', $options_values, $options_titles, true, '', 'multiple');
            }
            return cot_checklistbox($data, $name, $options_values, $options_titles, ['class' => 'form-check-input'], '', true);

        default:
            return '';
    }
}

/**
 * Formats field value for display
 * @param string $type Field type
 * @param mixed $value Field value
 * @param bool $decode Decode from storage format (for get)
 * @return mixed Formatted value
 */
function userfields_format_value($type, $value, $decode = false) {
    global $L, $cot_countries;

    if ($value === null || $value === '') {
        return '';
    }

    if ($decode) {
        if (in_array($type, ['checklistbox', 'checkbox'])) {
            return explode(',', $value);
        }
        return $value;
    } else {
        if (in_array($type, ['checklistbox'])) {
            return implode(', ', (is_array($value) ? $value : explode(',', $value)));
        } elseif ($type === 'checkbox') {
            return $value ? $L['Yes'] : $L['No'];
        } elseif ($type === 'datetime') {
            return cot_date('datetime_medium', (int)$value);
        } elseif ($type === 'country' && isset($cot_countries[$value])) {
            return $cot_countries[$value];
        }
        return userfields_strip_links($value);
    }
}

/**
 * Formats value for save in DB
 * @param int $field_id Field ID
 * @param mixed $value Value to save
 * @return string Formatted value for DB
 */
function userfields_format_value_for_save($field_id, $value) {
    global $db, $db_userfield_types;

    if ($value === null || $value === '' || (is_array($value) && empty($value))) {
        return '';
    }

    $field = $db->query("SELECT field_type FROM $db_userfield_types WHERE id = ?", $field_id)->fetch();
    if (!$field) {
        return '';
    }

    $type = $field['field_type'];

    if ($type === 'checklistbox' && is_array($value)) {
        $filtered_values = array_filter($value, function($val) {
            return !empty($val) && $val !== 'nullval';
        });
        return implode(',', $filtered_values);
    } elseif ($type === 'checkbox') {
        return $value ? '1' : '0';
    } elseif (in_array($type, ['inputint', 'currency', 'double'])) {
        return (float)$value;
    } elseif ($type === 'datetime') {
        if (is_array($value)) {
            $date = cot_mktime($value['year'], $value['month'], $value['day'], $value['hour'], $value['minute'], 0);
            return (int)$date;
        }
        return (int)$value;
    } elseif (in_array($type, ['input', 'textarea'])) {
        return userfields_strip_links(is_array($value) ? implode(',', $value) : $value);
    }
    return is_array($value) ? implode(',', $value) : $value;
}
?>