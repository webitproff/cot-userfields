# Userfields Plugin for Cotonti 0.9.26

## Overview

The **Userfields** plugin for Cotonti CMS allows creating and managing custom user fields (e.g., phone number, company name, address) without modifying the `cot_users` table. It uses dedicated tables `cot_userfield_types` (field types) and `cot_userfield_values` (field values), offloading `cot_users` for scalability and ease of use. Fields integrate into user profiles, the admin panel, and are displayed in templates (user lists, articles, forums, mstore module).

### Key Features
- Create, edit, and delete field types with unique codes, titles, and sort orders via the admin panel.
- Store values in a separate table linked to user IDs.
- Edit fields in user profiles (`users.profile.tpl`) and admin user editor (`users.edit.tpl`).
- Display fields in user lists (`users.tpl`), profile pages (`users.details.tpl`), and other templates via Cotonti tags.
- Automatically save values when updating profiles or user data.
- Sort fields by `order_num` parameter.
- Include test fields (`cell_number`, `company_name`) for quick setup.
- Convenient admin panel for field management.

## Requirements
- Cotonti CMS 0.9.26 or higher.
- PHP 8.4 or higher.
- Active `users` module.
- MySQL 8.0 with InnoDB support (for foreign keys).

## Installation

1. **Prepare Files**:
   - Download the source code from the [GitHub repository](https://github.com/webitproff/cot-userfields).
   - Extract the contents of `cot-userfields-main.zip` and upload the `userfields` folder to the `plugins` directory in your Cotonti root.

2. **Install via Admin Panel**:
   - Log into the Cotonti admin panel (`/admin.php`).
   - Navigate to **Administration > Extensions > User Fields**.
   - Find the **Userfields** plugin and click **Install**.
   - The plugin creates tables `cot_userfield_types` and `cot_userfield_values`, adding test fields: `cell_number` (Mobile Phone Number, order 1) and `company_name` (Company Name, order 2).
   - These test fields are examples; you can delete, edit, or create new ones as needed.

3. **Plugin Files**:
   - `userfields.setup.php` (plugin configuration).
   - `userfields.install.sql` (creates tables and test data).
   - `userfields.uninstall.sql` (removes tables).
   - `userfields.admin.php` (admin panel logic).
   - `userfields.admin.tpl` (admin panel template).
   - `userfields.ru.lang.php` (Russian localization).
   - `userfields.functions.php` (core functions).
   - `userfields.users.details.tags.php` (tags for user details page).
   - `userfields.users.profile.tags.php` (tags for profile editing).
   - `userfields.users.edit.tags.php` (tags for admin user editing).
   - `userfields.users.profile.update.done.php` (handles profile updates).
   - `userfields.users.edit.update.done.php` (handles admin user updates).
   - `userfields.users.loop.php` (displays fields in user lists).
   - `userfields.usertags.php` (integrates with `usertags` for global use).

4. **Uninstallation**:
   - In admin panel: **Administration > Extensions > Userfields > Uninstall**.
   - Executes `userfields.uninstall.sql`, removing tables.
   - Manually delete the `plugins/userfields` folder.

5. **Troubleshooting**:
   - **Plugin Not Visible**: Check that files are in `plugins/userfields`.
   - **Database Issues**: Ensure the MySQL user has permissions for table creation and foreign keys.

## Managing Fields in Admin Panel

Access the admin panel at **Administration > Other > Userfields** (requires admin privileges).

### Interface
- **Title**: "Manage Additional User Fields".
- **Field Types List**: Table with columns: Code, Title, Sort Order, Edit, Delete.
- **Forms**: For adding/editing field types.

### Adding a Field Type
- Click **Add Field Type**.
- Form:
  - **Code**: Unique identifier (latin letters, numbers, underscore only; max 50 characters). Used in tags (e.g., `cell_number` → `USERFIELDS_CELL_NUMBER`). Required, must be unique.
  - **Title**: Display name (e.g., "Mobile Phone Number"; max 100 characters). Required.
  - **Sort Order (order_num)**: Integer (e.g., 1 for first, 2 for second). Defines display order (lower number = higher priority). Required, defaults to 0.
- Click **Save**. Errors (duplicate code, empty fields) will be displayed.

### Editing a Field Type
- Click **Edit** next to a field.
- Update code, title, or sort order (code must remain unique).
- Click **Save**. Update template tags if the code changes.

### Deleting a Field Type
- Click **Delete** and confirm.
- Removes the field type and associated values in `cot_userfield_values` (via `ON DELETE CASCADE`).

### Field Definitions
- **id**: Auto-generated unique ID.
- **code**: Tag identifier (e.g., `USERFIELDS_CELL_NUMBER` for value, `USERFIELDS_CELL_NUMBER_TITLE` for title).
- **title**: Display name for forms and outputs.
- **order_num**: Controls display order.

### Filling Fields
- **By Users**: In profile (`users.profile.tpl`), fields appear as a table with title and input. Saved on profile update.
- **By Admins**: In user editor (`users.edit.tpl`), similar table for any user. Saved on user update.
- **Format**: Text (TEXT type, no length limit). Fields are optional.

## Template Integration

The plugin provides tags for the `users` module and via `cot_generate_usertags` for other modules (`mstore`, `page`, `forums`). Tags use the field code in uppercase (e.g., `cell_number` → `USERFIELDS_CELL_NUMBER`). All tags are wrapped in `<!-- IF {PHP|cot_plugin_active('userfields')} -->`.

### 1. Users Module Templates

- **users.profile.tpl (Profile Editing)**:
  - Inside `<form>` (e.g., after `{USERS_PROFILE_COUNTRY}`), add:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="userfields-block">
        {USERFIELDS_FORM}
    </div>
    <!-- ENDIF -->
    ```
  - Outputs a table with field titles and input fields.

- **users.edit.tpl (Admin User Editing)**:
  - Inside `<form>` (e.g., after `{USERS_EDIT_COUNTRY}`), add:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="userfields-block">
        {USERFIELDS_FORM}
    </div>
    <!-- ENDIF -->
    ```
  - Outputs a table, similar to profile.

- **users.details.tpl (User Profile Page)**:
  - After `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}`, add:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="userfields-details">
        <h3>Additional Fields</h3>
        {USERFIELDS_FIELDS}
    </div>
    <!-- ENDIF -->
    ```
  - Outputs a `<dl>` list: `<dt>Title</dt> <dd>Value</dd>` (only filled fields).

- **users.tpl (User List)**:
  - Inside `<!-- BEGIN: USERS_ROW -->` (after `{USERS_ROW_NAME}`), add:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="user-fields">
        {USERS_ROW_FIELD_ROWS_HTML}
    </div>
    <!-- ENDIF -->
    ```
  - Outputs a `<div>` list with titles and values.

### 2. Other Modules (via usertags)
Follow existing examples of `cot_generate_usertags($data, 'PREFIX_')` in the Cotonti core to create tags like `{PREFIX_USERFIELDS_CODE}` and `{PREFIX_USERFIELDS_CODE_TITLE}`, where `PREFIX_` is the template-specific prefix.

For example:
- `LIST_ROW_OWNER_` for page lists (see `page.list.php`: `$t->assign(cot_generate_usertags($pag, 'LIST_ROW_OWNER_'));`).
- `PAGE_OWNER_` for full pages (see `page.main.php`: `$t->assign(cot_generate_usertags($pag, 'PAGE_OWNER_'));`).

Example for the [Multistore module](https://github.com/webitproff/cot-multistore):

- **mstore.index.tpl / mstore.list.tpl (Product Lists)**:
  - Inside `<!-- BEGIN: MSTORE_ROW -->` or `<!-- BEGIN: LIST_ROW -->` after `{MSTORE_ROW_TITLE}`:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="row mb-3">
        <label class="col-form-label fw-semibold">{PHP.L.userfields_fieldinfo}:</label>
        <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER} -->
        <div class="userfield">
            <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
            <span class="userfield-value">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER}</span>
        </div>
        <!-- ENDIF -->
        <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME} -->
        <div class="userfield">
            <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
            <span class="userfield-value">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME}</span>
        </div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Prefix: `MSTORE_ROW_OWNER_`.

- **mstore.tpl (Product Page)**:
  - After `{MSTORE_OWNER_NAME}`:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="owner-userfields">
        <!-- IF {MSTORE_OWNER_USERFIELDS_CELL_NUMBER} -->
        <div>{MSTORE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}: {MSTORE_OWNER_USERFIELDS_CELL_NUMBER}</div>
        <!-- ENDIF -->
        <!-- IF {MSTORE_OWNER_USERFIELDS_COMPANY_NAME} -->
        <div>{MSTORE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}: {MSTORE_OWNER_USERFIELDS_COMPANY_NAME}</div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Prefix: `MSTORE_OWNER_`.

- **page.tpl (Articles)**:
  - After `{PAGE_OWNER_NAME}`:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="owner-userfields">
        <!-- IF {PAGE_OWNER_USERFIELDS_CELL_NUMBER} -->
        <div>{PAGE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}: {PAGE_OWNER_USERFIELDS_CELL_NUMBER}</div>
        <!-- ENDIF -->
        <!-- IF {PAGE_OWNER_USERFIELDS_COMPANY_NAME} -->
        <div>{PAGE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}: {PAGE_OWNER_USERFIELDS_COMPANY_NAME}</div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Prefix: `PAGE_OWNER_`.

- **forums.posts.tpl (Forum Posts)**:
  - After `{FORUMS_POSTS_ROW_USER_NAME}` in the post block:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="author-userfields">
        <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER} -->
        <div>{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER_TITLE}: {FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER}</div>
        <!-- ENDIF -->
        <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME} -->
        <div>{FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME_TITLE}: {FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME}</div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Prefix: `FORUMS_POSTS_ROW_USER_`.

### CSS Styling
Add to your theme's CSS (e.g., `themes/yourtheme/yourtheme.css`):
```css
.userfields-block, .userfields-details, .user-fields, .owner-userfields, .author-userfields {
    margin: 20px 0;
}
.userfields-table {
    max-width: 600px;
}
.userfields-table th, .userfields-table td {
    vertical-align: middle;
}
.userfield {
    margin-bottom: 10px;
}
.userfield-title {
    font-weight: bold;
    margin-right: 5px;
}
.userfield-value {
    color: #333;
}
```

## Support
Discuss the plugin, ask questions, or get help in the [dedicated forum thread](https://abuyfile.com/en/forums/cotonti/custom/plugs/topic155).

## License
BSD License. Copyright (c) webitproff 2025.


# cot-userfields

# Плагин Userfields для Cotonti 0.9.26

## Описание

Плагин **Userfields** для CMS Cotonti позволяет создавать и управлять дополнительными пользовательскими полями (например, номер телефона, название компании, адрес) без изменения таблицы `cot_users`. Использует собственные таблицы `cot_userfield_types` (типы полей) и `cot_userfield_values` (значения полей), что разгружает `cot_users`, обеспечивая масштабируемость и удобство. Поля интегрируются в профили пользователей, админку и отображаются в шаблонах (список пользователей, статьи, форум, модуль mstore).

### Основные возможности
- Создание, редактирование, удаление типов полей с уникальным кодом, названием и порядком сортировки через админ-панель.
- Хранение значений в отдельной таблице, привязанной к ID пользователя.
- Редактирование полей в профиле (`users.profile.tpl`) и админском редакторе (`users.edit.tpl`).
- Вывод полей в списках пользователей (`users.tpl`), на странице профиля (`users.details.tpl`) и других шаблонах через теги Cotonti.
- Автоматическое сохранение значений при обновлении профиля или данных пользователя.
- Сортировка полей по параметру `order_num`.
- Тестовые поля (`cell_number`, `company_name`) для быстрого старта.
- Удобная админ-панель для управления полями.

## Требования
- Cotonti CMS 0.9.26 или выше.
- PHP 8.4+
- Активный модуль `users`.
- MySQL 8.0 с поддержкой InnoDB (для внешних ключей).

## Установка

1. **Подготовка файлов**:
   - Скачать исходный код с репозитория на [GitHub](https://github.com/webitproff/cot-userfields)
   - Содержимое архива cot-userfields-main.zip, а именно папку `userfields` закачать в папку `plugins`
   - Создайте папку `plugins/userfields` в корне сайта.



2. **Установка через админ-панель**:
   - Зайдите в админку -> Управление сайтом -> Расширения -> User Fields .
   - Войдите в карточку плагина **Userfields** и нажмите **Установить**.
   - Плагин создаст таблицы `cot_userfield_types` и `cot_userfield_values`, добавит тестовые поля: `cell_number` (Номер мобильного телефона, порядок 1), `company_name` (Название компании, порядок 2).
   - Эти поля для примера, их можете сразу удалить, отредактировать или создать новые.
   
5. **Описание файлов плагина**
     - `userfields.setup.php` (конфигурация).
     - `userfields.install.sql` (таблицы и тестовые данные).
     - `userfields.uninstall.sql` (удаление таблиц).
     - `userfields.admin.php` (логика админ-панели).
     - `userfields.admin.tpl` (шаблон админ-панели).
     - `userfields.ru.lang.php` (русская локализация).
     - `userfields.functions.php` (функции).
     - `userfields.users.details.tags.php` (теги для страницы профиля).
     - `userfields.users.profile.tags.php` (теги для редактирования профиля).
     - `userfields.users.edit.tags.php` (теги для админского редактирования).
     - `userfields.users.profile.update.done.php` (сохранение профиля).
     - `userfields.users.edit.update.done.php` (сохранение в админке).
     - `userfields.users.loop.php` (вывод в списке пользователей).
     - `userfields.usertags.php` (интеграция с `usertags`).
	 
	 
## Управление полями в админ-панели

Админ-панель: **Администрирование > Другие > Userfields**.

### Интерфейс
- **Заголовок**: "Управление дополнительными полями пользователей".
- **Список типов полей**: Таблица с колонками: Код, Название, Порядок сортировки, Редактировать, Удалить.
- **Формы**: Для добавления/редактирования типов полей.

### Добавление типа поля
- Нажмите **Добавить тип поля**.
- Форма:
  - **Код (code)**: Уникальный идентификатор (только латинские буквы, цифры, нижнее подчеркивание; макс. 50 символов). Используется в тегах (например, `cell_number` → `USERFIELDS_CELL_NUMBER`). Обязательное, уникальное.
  - **Название (title)**: Отображаемое имя (например, "Номер мобильного телефона"; макс. 100 символов). Обязательное.
  - **Порядок сортировки (order_num)**: Целое число (1 — первый, 2 — второй). Порядок вывода (меньше — выше). Обязательное, по умолчанию 0.
- Нажмите **Сохранить**. Ошибки (дубликат кода, пустые поля) отобразятся.

### Редактирование типа поля
- Нажмите **Редактировать**.
- Измените код, название или порядок (код должен быть уникальным).
- Нажмите **Сохранить**. Обновите теги в шаблонах, если код изменился.

### Удаление типа поля
- Нажмите **Удалить** и подтвердите.
- Удаляет тип и связанные значения (`ON DELETE CASCADE`).

### Поля типов
- **id**: Автоматический уникальный ID.
- **code**: Ключ для тегов (`USERFIELDS_CODE` — значение, `USERFIELDS_CODE_TITLE` — название).
- **title**: Название для форм и списков.
- **order_num**: Порядок вывода.

### Заполнение полей
- **Пользователями**: В профиле (`users.profile.tpl`) — таблица с названием и input. Сохраняется при обновлении профиля.
- **Администраторами**: В редакторе (`users.edit.tpl`) — аналогичная таблица.
- **Формат**: Текст (тип TEXT, без ограничения длины). Поля необязательные.

## Интеграция в шаблоны

Плагин использует теги для модуля `users` и `cot_generate_usertags` для других модулей (`mstore`, `page`, `forums`). 
Теги используют код поля в верхнем регистре (например, `cell_number` → `USERFIELDS_CELL_NUMBER`). 
Все теги оборачиваются в проверку активности плагина: `<!-- IF {PHP|cot_plugin_active('userfields')} -->`.

### 1. Шаблоны модуля `users`

- **users.profile.tpl (редактирование профиля)**:
  - Внутри `<form>` (например, после `{USERS_PROFILE_COUNTRY}`) добавьте:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="userfields-block">
        {USERFIELDS_FORM}
    </div>
    <!-- ENDIF -->
    ```
  - Выводит таблицу: название поля + input.

- **users.edit.tpl (админское редактирование)**:
  - Внутри `<form>` (например, после `{USERS_EDIT_COUNTRY}`) добавьте:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="userfields-block">
        {USERFIELDS_FORM}
    </div>
    <!-- ENDIF -->
    ```
  - Выводит таблицу, как в профиле.

- **users.details.tpl (страница профиля)**:
  - Например, после тегов `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}` добавьте:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="userfields-details">
        <h3>Дополнительные поля</h3>
        {USERFIELDS_FIELDS}
    </div>
    <!-- ENDIF -->
    ```
  - Выводит `<dl>`: `<dt>Название</dt> <dd>Значение</dd>` (только заполненные).

- **users.tpl (список пользователей)**:
  - Внутри `<!-- BEGIN: USERS_ROW -->` (после `{USERS_ROW_NAME}`) добавьте:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="user-fields">
        {USERS_ROW_FIELD_ROWS_HTML}
    </div>
    <!-- ENDIF -->
    ```
  - Выводит `<div>`: название + значение.

### 2. Другие модули (через usertags)
Используйте за пример существующие примеры использования `cot_generate_usertags($data, 'PREFIX_')` в движке, для создания своих тегов типа `{PREFIX_USERFIELDS_CODE}` и `{PREFIX_USERFIELDS_CODE_TITLE}`, 
где `PREFIX_` это преффикс вашего тега соответствующего шаблона вашего модуля или плагина, например:

это `LIST_ROW_OWNER_` для списков страниц модуля `page` 
узнать больше в page.list.php `$t->assign(cot_generate_usertags($pag, 'LIST_ROW_OWNER_'));`

или это `PAGE_OWNER_` для полной страницы модуля `page` 
(узнать больше в page.main.php `$t->assign(cot_generate_usertags($pag, 'PAGE_OWNER_'));`).

Вот пример для реализации в сборке [Multistore](https://github.com/webitproff/cot-multistore)

- **mstore.index.tpl / mstore.list.tpl (списки товаров)**:
  - Внутри `<!-- BEGIN: MSTORE_ROW -->` или `<!-- BEGIN: LIST_ROW -->` после `{MSTORE_ROW_TITLE}`:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="row mb-3">
        <label class="col-form-label fw-semibold">{PHP.L.userfields_fieldinfo}:</label>
        <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER} -->
        <div class="userfield">
            <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
            <span class="userfield-value">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER}</span>
        </div>
        <!-- ENDIF -->
        <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME} -->
        <div class="userfield">
            <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
            <span class="userfield-value">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME}</span>
        </div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Префикс: `MSTORE_ROW_OWNER_`.

- **mstore.tpl (страница товара)**:
  - После `{MSTORE_OWNER_NAME}`:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="owner-userfields">
        <!-- IF {MSTORE_OWNER_USERFIELDS_CELL_NUMBER} -->
        <div>{MSTORE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}: {MSTORE_OWNER_USERFIELDS_CELL_NUMBER}</div>
        <!-- ENDIF -->
        <!-- IF {MSTORE_OWNER_USERFIELDS_COMPANY_NAME} -->
        <div>{MSTORE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}: {MSTORE_OWNER_USERFIELDS_COMPANY_NAME}</div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Префикс: `MSTORE_OWNER_`.
### Модуль page (статьи)
- **page.tpl**:
  - После `{PAGE_OWNER_NAME}`:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="owner-userfields">
        <!-- IF {PAGE_OWNER_USERFIELDS_CELL_NUMBER} -->
        <div>{PAGE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}: {PAGE_OWNER_USERFIELDS_CELL_NUMBER}</div>
        <!-- ENDIF -->
        <!-- IF {PAGE_OWNER_USERFIELDS_COMPANY_NAME} -->
        <div>{PAGE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}: {PAGE_OWNER_USERFIELDS_COMPANY_NAME}</div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Префикс: `PAGE_OWNER_`.
### Модуль forums, шаблон посты форума
- **forums.posts.tpl**:
  - После `{FORUMS_POSTS_ROW_USER_NAME}` в блоке поста:
    ```html
    <!-- IF {PHP|cot_plugin_active('userfields')} -->
    <div class="author-userfields">
        <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER} -->
        <div>{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER_TITLE}: {FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER}</div>
        <!-- ENDIF -->
        <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME} -->
        <div>{FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME_TITLE}: {FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME}</div>
        <!-- ENDIF -->
    </div>
    <!-- ENDIF -->
    ```
  - Префикс: `FORUMS_POSTS_ROW_USER_`.

### Стили CSS
В CSS темы (например, `themes/yourtheme/yourtheme.css`):
```css
.userfields-block, .userfields-details, .user-fields, .owner-userfields, .author-userfields {
    margin: 20px 0;
}
.userfields-table {
    max-width: 600px;
}
.userfields-table th, .userfields-table td {
    vertical-align: middle;
}
.userfield {
    margin-bottom: 10px;
}
.userfield-title {
    font-weight: bold;
    margin-right: 5px;
}
.userfield-value {
    color: #333;
}
```

## Поддержка
Обсуждение плагина, вопросы и помощь в [отдельной теме на форуме разработчика](https://abuyfile.com/ru/forums/cotonti/custom/plugs/topic155)


## Лицензия
BSD License. Copyright (c) webitproff 2025.
