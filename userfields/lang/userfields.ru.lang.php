<?php
/**
 * Russian Language File for the Plugin User Fields
 *
 * Userfields plugin for Cotonti 0.9.26
 * Filename: userfields.ru.lang.php
 * @package userfields
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */
 
defined('COT_CODE') or die('Wrong URL');

/**
 * Plugin Info
 */
$L['info_name'] = 'User Fields';
$L['info_desc'] = 'Управление дополнительными полями пользователей без создания экстраполей';
$L['info_notes'] = 'При заполнении кода полей использовать только латинские буквы, цифры или нижнее подчеркивание';

$L['userfields'] = 'Управление дополнительными полями пользователей';
$L['userfields_field_types'] = 'Типы полей';
$L['userfields_code'] = 'Код';
$L['userfields_field_title'] = 'Название';
$L['userfields_type'] = 'Тип поля';
$L['userfields_params'] = 'Параметры поля';
$L['userfields_params_hint'] = 'Для select, radio, checklistbox - варианты через запятую; для range - min,max; для datetime - min,max,format';
$L['userfields_order'] = 'Порядок сортировки';
$L['userfields_add_field_type'] = 'Додати тип поля';
$L['userfields_fields'] = 'Поля';
$L['userfields_field'] = 'Поле';
$L['userfields_value'] = 'Значение';
$L['userfields_add_field'] = 'Додати поле';
$L['userfields_delete'] = 'Удалить';
$L['userfields_save'] = 'Сохранить';
$L['userfields_edit'] = 'Редактировать';
$L['userfields_cancel'] = 'Отмена';
$L['userfields_confirm_delete'] = 'Вы уверены, что хотите удалить?';
$L['userfields_error_empty_fields'] = 'Код, название и порядок обязательны';
$L['userfields_error_long_code_or_title'] = 'Код или название слишком длинные';
$L['userfields_error_invalid_code_format'] = 'Код должен содержать только буквы, цифры или подчеркивание';
$L['userfields_error_field_type_code_exists'] = 'Код типа поля уже существует';
$L['userfields_field_type_added'] = 'Тип поля добавлен';
$L['userfields_field_type_updated'] = 'Тип поля обновлён';
$L['userfields_field_type_deleted'] = 'Тип поля удалён';
$L['userfields_fieldinfo'] = 'Пользовательские поля пользователя';

$L['userfields_type_input'] = 'Текст';
$L['userfields_type_inputint'] = 'Целое число';
$L['userfields_type_currency'] = 'Валюта';
$L['userfields_type_double'] = 'Дробное число';
$L['userfields_type_textarea'] = 'Текстовая область';
$L['userfields_type_select'] = 'Выпадающий список';
$L['userfields_type_radio'] = 'Радиокнопки';
$L['userfields_type_checkbox'] = 'Чекбокс';
$L['userfields_type_datetime'] = 'Дата/Время';
$L['userfields_type_country'] = 'Страна';
$L['userfields_type_range'] = 'Диапазон чисел';
$L['userfields_type_checklistbox'] = 'Список чекбоксов';
?>