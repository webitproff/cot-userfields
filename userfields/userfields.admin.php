<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.admin.php
 * @package userfields
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Неверный URL');

require_once cot_incfile('users', 'module');
require_once cot_incfile('userfields', 'plug');
require_once cot_incfile('forms');

global $db, $db_x, $L;
cot_block(Cot::$usr['isadmin']);
$adminHelp = Cot::$L['userfields'];
$db_userfield_types = $db_x . 'userfield_types';

$action = cot_import('a', 'G', 'ALP');
$id = cot_import('id', 'G', 'INT');

$t = new XTemplate(cot_tplfile('userfields.admin', 'plug'));

// Form for field types
$form_field_type_values = [
    'id' => '',
    'code' => '',
    'title' => '',
    'field_type' => 'input',
    'field_params' => '',
    'order_num' => '',
];

// Import id as early as possible
$id = cot_import('id', 'G', 'INT');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = cot_import('id', 'P', 'INT');
}

// Processing add/edit form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($action, ['field_type_add', 'field_type_edit'])) {
    $code = cot_import('code', 'P', 'TXT');
    $title = cot_import('title', 'P', 'TXT');
    $field_type = cot_import('field_type', 'P', 'ALP');
    $field_params = cot_import('field_params', 'P', 'TXT');
    $order_num = cot_import('order_num', 'P', 'INT');

    $validation = userfields_validate_field_type($code, $title, $field_type, $field_params, $order_num, $action === 'field_type_edit' ? $id : null);
    if ($validation === true) {
        $data = [
            'code' => $code,
            'title' => $title,
            'field_type' => $field_type,
            'field_params' => $field_params,
            'order_num' => $order_num,
        ];

        if ($action === 'field_type_add') {
            $db->insert($db_userfield_types, $data);
            cot_message($L['userfields_field_type_added']);
        } elseif ($action === 'field_type_edit' && $id > 0) {
            $db->update($db_userfield_types, $data, 'id = ?', [$id]);
            cot_message($L['userfields_field_type_updated']);
        }

        cot_redirect(cot_url('admin', 'm=other&p=userfields', '', true));
        exit;
    } else {
        cot_error($L[$validation]);
    }
}

// Processing delete
if ($action === 'field_type_delete' && $id > 0) {
    $db->delete($db_userfield_types, 'id = ?', [$id]);
    cot_message($L['userfields_field_type_deleted']);
    cot_redirect(cot_url('admin', 'm=other&p=userfields', '', true));
    exit;
}

// Get data for editing
if ($action === 'field_type_edit' && $id > 0) {
    $row = $db->query("SELECT * FROM $db_userfield_types WHERE id = ?", [$id])->fetch();
    if ($row) {
        $form_field_type_values = $row;
    }
}

// Get list of field types
$field_types = userfields_get_field_types();

// Assign variables for field types list
foreach ($field_types as $field_type) {
    $t->assign([
        'FIELD_TYPE_ID' => $field_type['id'],
        'FIELD_TYPE_CODE' => htmlspecialchars($field_type['code']),
        'FIELD_TYPE_TITLE' => htmlspecialchars($field_type['title']),
        'FIELD_TYPE_TYPE' => $L['userfields_type_' . $field_type['field_type']],
        'FIELD_TYPE_PARAMS' => htmlspecialchars($field_type['field_params']),
        'FIELD_TYPE_ORDER' => $field_type['order_num'],
        'FIELD_TYPE_EDIT_URL' => cot_url('admin', 'm=other&p=userfields&a=field_type_edit&id=' . $field_type['id']),
        'FIELD_TYPE_DELETE_URL' => cot_confirm_url(cot_url('admin', 'm=other&p=userfields&a=field_type_delete&id=' . $field_type['id'])),
    ]);
    $t->parse('MAIN.FIELD_TYPE_ROW');
}

// Assign variables for forms
$t->assign([
    'FIELD_TYPE_FORM_ACTION' => cot_url('admin', 'm=other&p=userfields&a=field_type_' . ($action === 'field_type_edit' ? 'edit' : 'add')),
    'FIELD_TYPE_FORM_ID' => htmlspecialchars($form_field_type_values['id']),
    'FIELD_TYPE_FORM_CODE' => htmlspecialchars($form_field_type_values['code']),
    'FIELD_TYPE_FORM_TITLE' => htmlspecialchars($form_field_type_values['title']),
    'FIELD_TYPE_FORM_TYPE' => $form_field_type_values['field_type'],
    'FIELD_TYPE_FORM_PARAMS' => htmlspecialchars($form_field_type_values['field_params']),
    'FIELD_TYPE_FORM_ORDER' => htmlspecialchars($form_field_type_values['order_num']),
    'FIELD_TYPE_CANCEL_URL' => cot_url('admin', 'm=other&p=userfields'),
]);

// Control form display
if ($action === 'field_type_add') {
    $t->parse('MAIN.FIELD_TYPE_ADD_FORM');
} elseif ($action === 'field_type_edit') {
    $t->parse('MAIN.FIELD_TYPE_EDIT_FORM');
} else {
    $t->parse('MAIN.FIELD_TYPE_ADD_FORM');
}
cot_display_messages($t);
$t->parse('MAIN');
$adminMain = $t->text('MAIN');
?>