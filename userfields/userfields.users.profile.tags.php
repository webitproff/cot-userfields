<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.profile.tags
Tags=users.profile.tpl:{USERFIELDS_FORM}
[END_COT_EXT]
==================== */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.profile.tags.php
 * @package userfields
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug');

global $db, $db_x, $db_userfield_types, $db_userfield_values, $usr;
$db_userfield_types = $db_x . 'userfield_types';
$db_userfield_values = $db_x . 'userfield_values';

$field_types = userfields_get_field_types(); // id => type
$user_fields = userfields_get_user_fields($usr['id']);

// Index by field_id for convenience
$fields_by_type = [];
foreach ($user_fields as $field) {
    $fields_by_type[$field['field_id']] = $field;
}

$form_html = '<div class="userfields-block">';
$form_html .= '<h3>' . cot::$L['userfields_fields'] . '</h3>';
$form_html .= '<table class="table table-sm table-bordered userfields-table">';
$form_html .= '<thead><tr>';
$form_html .= '<th>' . cot::$L['userfields_field'] . '</th>';
$form_html .= '<th>' . cot::$L['userfields_value'] . '</th>';
$form_html .= '</tr></thead><tbody>';

foreach ($field_types as $type) {
    $type_id = $type['id'];
    $existing = isset($fields_by_type[$type_id]) ? $fields_by_type[$type_id]['value'] : null;

    $form_html .= '<tr>';
    $form_html .= '<td>' . htmlspecialchars($type['title']) . '</td>';
    $form_html .= '<td>' . userfields_build_input("userfields_values[{$type_id}][value]", $type, $existing) . '</td>';
    $form_html .= '</tr>';
}

$form_html .= '</tbody></table>';
$form_html .= '</div>';

$t->assign('USERFIELDS_FORM', $form_html);
?>