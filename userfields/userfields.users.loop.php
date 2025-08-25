<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.loop
 * Tags=users.tpl:{USERS_ROW_FIELD_ROWS_HTML}
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.users.loop.php
 * @package userfields
 * @version 1.0.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('userfields', 'plug');

$fields = userfields_get_user_fields((int)$urr['user_id']);
$field_rows_html = '';
if (is_array($fields) && !empty($fields)) {
    $field_rows_html .= '<div class="userfields-list">';
    foreach ($fields as $field) {
        $title = htmlspecialchars($field['field_title']);
        $value = htmlspecialchars($field['value']);
        $field_rows_html .= '
            <div class="row mb-1">
                <div class="col-5 fw-bold">' . $title . '</div>
                <div class="col-7">' . $value . '</div>
            </div>';
    }
    $field_rows_html .= '</div>';
}
$t->assign(['USERS_ROW_FIELD_ROWS_HTML' => $field_rows_html]);
?>