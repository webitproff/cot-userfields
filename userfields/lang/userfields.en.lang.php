<?php
/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+ English Language File for the Plugin User Fields
 * Filename: userfields.en.lang.php
 *
 * Date: Jan 14Th, 2026
 *
 * @package userfields
 * @version 2.0.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */

 
defined('COT_CODE') or die('Wrong URL');

/**
 * Plugin Info
 */
$L['info_name'] = 'User Fields';
$L['info_desc'] = 'Manage additional user fields without creating extra fields';
$L['info_notes'] = 'Use only Latin letters, numbers, or underscores for field codes';

$L['userfields'] = 'Manage Additional User Fields';
$L['userfields_field_types'] = 'Field Types';
$L['userfields_code'] = 'Code';
$L['userfields_field_title'] = 'Title';
$L['userfields_type'] = 'Field Type';
$L['userfields_params'] = 'Field Parameters';
$L['userfields_params_hint'] = 'For select, radio, checklistbox - options comma-separated; for range - min,max; for datetime - min,max,format';
$L['userfields_order'] = 'Sort Order';
$L['userfields_add_field_type'] = 'Add Field Type';
$L['userfields_fields'] = 'Fields';
$L['userfields_field'] = 'Field';
$L['userfields_value'] = 'Value';
$L['userfields_add_field'] = 'Add Field';
$L['userfields_delete'] = 'Delete';
$L['userfields_save'] = 'Save';
$L['userfields_edit'] = 'Edit';
$L['userfields_cancel'] = 'Cancel';
$L['userfields_confirm_delete'] = 'Are you sure you want to delete?';
$L['userfields_error_empty_fields'] = 'Code, title, and sort order are required';
$L['userfields_error_long_code_or_title'] = 'Code or title is too long';
$L['userfields_error_invalid_code_format'] = 'Code must contain only letters, numbers, or underscores';
$L['userfields_error_field_type_code_exists'] = 'Field type code already exists';
$L['userfields_field_type_added'] = 'Field type added';
$L['userfields_field_type_updated'] = 'Field type updated';
$L['userfields_field_type_deleted'] = 'Field type deleted';
$L['userfields_fieldinfo'] = 'User Custom Fields';

$L['userfields_type_input'] = 'Text';
$L['userfields_type_inputint'] = 'Integer';
$L['userfields_type_currency'] = 'Currency';
$L['userfields_type_double'] = 'Decimal';
$L['userfields_type_textarea'] = 'Textarea';
$L['userfields_type_select'] = 'Select';
$L['userfields_type_radio'] = 'Radio';
$L['userfields_type_checkbox'] = 'Checkbox';
$L['userfields_type_datetime'] = 'Datetime';
$L['userfields_type_country'] = 'Country';
$L['userfields_type_range'] = 'Range';
$L['userfields_type_checklistbox'] = 'Checklistbox';


$L['userfields_promo_text_profile'] = 'Рассказ о навыках и услугах';
$L['userfields_promo_text_profile_hint'] = 'Несколькими предложениями расскажите о своих услугах, если вы их предалагаете. Только текст, ссылки здесь писать нет смысла';

$L['userfields_github_profile'] = 'Если желаете поделиться разработками';
$L['userfields_github_profile_hint'] = 'Укажите только алиас вашего никнейма из ссылки https://github.com/<code>aliasnickname</code> на ваш профиль на GitHub, (ссылка формируется автоматически)';
$L['userfields_github_details'] = 'Смотреть разработки и скачать';
$L['userfields_github_details_hint'] = '';


$L['userfields_telegram_profile'] = 'Если желаете поделиться разработками';
$L['userfields_telegram_profile_hint'] = 'Укажите только алиас вашего никнейма из ссылки https://github.com/<code>aliasnickname</code> на ваш профиль на GitHub, (ссылка формируется автоматически)';
$L['userfields_telegram_details'] = 'Send a message via Telegram';
$L['userfields_telegram_details_hint'] = '';