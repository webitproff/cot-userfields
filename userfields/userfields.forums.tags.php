<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=forums.posts.loop, forums.topics.loop
 * [END_COT_EXT]
 */

/**
 * Userfields plugin for Cotonti 0.9.26, PHP 8.4+
 * дополнительные поля автора в темах и постах форума.
 * Автор поста:  fp_posterid
 * Автор темы:   ft_posterid
 *
 * Filename: userfields.forums.tags.php
 *
 * Date: Jan 14Th, 2026
 *
 * @package userfields
 * @version 2.0.3
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026
 * @license BSD
 */

/**
 * Этот файл вызывается ВНУТРИ циклов XTemplate:
 *  - forums.posts.loop   → список постов
 *  - forums.topics.loop  → список тем
 *
 * Код выполняется МНОГО РАЗ — для каждого поста / темы отдельно.
 */

defined('COT_CODE') or die('Wrong URL.');
require_once cot_incfile('userfields', 'plug');

/**
 * XTemplate и данные форума
 * $row   — текущий пост (в posts.loop)
 * $topic — текущая тема (в topics.loop)
 */
global $t, $row, $topic;

/**
 * Если шаблона нет — работать не с чем
 */
if (!isset($t) || !$t instanceof XTemplate) {
    return;
}


/* ============================================================
   0. ЖЁСТКАЯ ОЧИСТКА ПЕРЕД КАЖДОЙ ИТЕРАЦИЕЙ
   ============================================================

   В XTemplate значения переменных НЕ обнуляются автоматически
   между итерациями loops.
   Если не стереть старые USERFIELDS — они "протекут" в следующий
   пост или тему. 
*/

$all_field_types = userfields_get_field_types();

foreach ($all_field_types as $type) {
    $code = strtoupper($type['code']);

    // Стираем значения тегов вида:
    // {USERFIELDS_AGE}, {USERFIELDS_CITY}, {USERFIELDS_PHONE}, и т.д.
    $t->assign([
        "USERFIELDS_{$code}"       => '',
        "USERFIELDS_{$code}_TITLE" => '',
    ]);
}

// Стираем HTML-блок списка полей
$t->assign('USERFIELDS_ROWS_HTML', '');


/* ============================================================
   1. ОПРЕДЕЛЕНИЕ АВТОРА ТЕКУЩЕЙ СТРОКИ
   ============================================================

   В posts.loop:
       $row['fp_posterid'] — ID автора поста

   В topics.loop:
       $topic['ft_posterid'] — ID автора темы
*/
$user_id = 0;

if (!empty($row) && isset($row['fp_posterid'])) {
    // Мы внутри списка постов
    $user_id = (int)$row['fp_posterid'];

} elseif (!empty($topic) && isset($topic['ft_posterid'])) {
    // Мы внутри списка тем
    $user_id = (int)$topic['ft_posterid'];
}

// Если автора нет — показывать нечего
if ($user_id <= 0) {
    return;
}


/* ============================================================
   2. ПОЛУЧЕНИЕ ПОЛЕЙ ПОЛЬЗОВАТЕЛЯ
   ============================================================

   userfields_get_user_fields() возвращает массив всех
   дополнительных полей этого пользователя.
*/
$user_fields = userfields_get_user_fields($user_id);

if (empty($user_fields) || !is_array($user_fields)) {
    return;
}


/* ============================================================
   3. НАЗНАЧЕНИЕ ПОЛЕЙ В XTemplate
   ============================================================

   Здесь мы:
   - Форматируем значения
   - Назначаем теги USERFIELDS_XXX
   - Собираем HTML-таблицу всех полей
*/

$field_rows_html = '<div class="userfields-list">';

foreach ($user_fields as $field) {

    // Поле без кода нам бесполезно
    if (empty($field['field_code'])) {
        continue;
    }

    // Читаемое название поля
    $title = htmlspecialchars($field['field_title']);

    // Форматированное значение (checkbox, select, date и т.п.)
    $value = userfields_format_value($field['field_type'], $field['value']);

    // Пустые значения не выводим (в шаблон)
    if ($value === '' || $value === null) {
        continue;
    }

    // Код поля → USERFIELDS_AGE, USERFIELDS_CITY, и т.п.
    $code = strtoupper($field['field_code']);

    // Назначаем индивидуальные теги для шаблона (для каждого поля в цикле)
    $t->assign([
        "USERFIELDS_{$code}"       => $value,
        "USERFIELDS_{$code}_TITLE" => $title,
    ]);

    // Формируем HTML-список всех полей
    $field_rows_html .= '
        <div class="row mb-1">
            <div class="col-5 fw-bold">' . $title . '</div>
            <div class="col-7">' . $value . '</div>
        </div>';
}

$field_rows_html .= '</div>';


/* ============================================================
   4. ФИНАЛЬНЫЙ HTML-БЛОК
   ============================================================

   {USERFIELDS_ROWS_HTML} теперь содержит таблицу
   ТОЛЬКО для текущего автора поста / темы.
   (не протекает между итерациями)
*/
$t->assign('USERFIELDS_ROWS_HTML', $field_rows_html);
