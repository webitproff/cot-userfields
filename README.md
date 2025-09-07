# Userfields Plugin for Cotonti 0.9.26

## Overview

### 🇬🇧 English

The **Userfields** plugin for Cotonti CMS enables the creation and management of custom user fields (e.g., phone number, company name, address) without modifying the `cot_users` table. It uses dedicated tables `cot_userfield_types` (field types) and `cot_userfield_values` (field values) for scalability and ease of use. Fields seamlessly integrate into user profiles, admin panels, and templates across various modules (user lists, articles, forums, Multistore module).

![Custom Userfields Plugin for Cotonti CMF](https://raw.githubusercontent.com/webitproff/cot-userfields/main/User-fields-Plugin-for-Cotonti_3.webp)

#### Key Features
- Create, edit, and delete field types with unique codes, titles, and sort orders via the admin panel.
- Store field values in a separate table linked to user IDs.
- Edit fields in user profiles (`users.profile.tpl`) and admin user editor (`users.edit.tpl`).
- Display fields in user lists (`users.tpl`), profile pages (`users.details.tpl`), and other templates (e.g., `page.tpl`, `mstore.tpl`, `forums.posts.tpl`) using Cotonti tags.
- Support for individual field tags (e.g., `{USERFIELDS_CELL_NUMBER}`), a loop for all fields (`<!-- BEGIN: USERFIELDS -->`), and an HTML block (`{USERFIELDS_ROWS_HTML}` or `{USERS_ROW_FIELD_ROWS_HTML}`).
- Automatically save field values during profile or user data updates.
- Sort fields by `order_num` parameter.
- Includes test fields (`cell_number`, `company_name`) for quick setup.
- User-friendly admin panel for field management.

### Requirements
- Cotonti CMS 0.9.26 or higher.
- PHP 8.4 or higher.
- Active `users` module.
- MySQL 8.0 with InnoDB support (for foreign keys).

## Installation

1. **Prepare Files**:
   - Download the source code from the [GitHub repository](https://github.com/webitproff/cot-userfields).
   - Extract `cot-userfields-main.zip` and upload the `userfields` folder to the `plugins` directory in your Cotonti root.

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
   - `userfields.en.lang.php` (English localization).
   - `userfields.functions.php` (core functions).
   - `userfields.users.details.tags.php` (tags for user details page).
   - `userfields.users.profile.tags.php` (tags for profile editing).
   - `userfields.users.edit.tags.php` (tags for admin user editing).
   - `userfields.users.profile.update.done.php` (handles profile updates).
   - `userfields.users.edit.update.done.php` (handles admin user updates).
   - `userfields.users.loop.php` (displays fields in user lists).
   - `userfields.usertags.php` (integrates with `usertags` for global use).

### Plugin Files and Structure

```
/userfields/
├── inc/
│   └── userfields.functions.php         # Core functions
├── lang/
│   ├── userfields.ru.lang.php           # Russian localization
│   ├── userfields.en.lang.php           # English localization
├── setup/
│   ├── userfields.install.sql           # SQL for creating tables
│   └── userfields.uninstall.sql         # SQL for dropping tables
├── tpl/
│   └── userfields.admin.tpl             # Template for creating and managing fields
├── userfields.admin.php                 # Logic for managing fields
├── userfields.global.php                # Global inclusion of language files
├── userfields.setup.php                 # Plugin configuration and setup
├── userfields.users.details.tags.php    # Outputs fields and tags for public profile page
├── userfields.users.edit.tags.php       # Outputs fields and tags for admin profile editing
├── userfields.users.edit.update.done.php # Handles profile updates by administrators
├── userfields.users.loop.php            # Outputs fields in user list
├── userfields.users.profile.tags.php     # Outputs fields and tags for user profile editing
├── userfields.users.profile.update.done.php # Handles profile updates by users
└── userfields.usertags.php              # Tags for integration using cot_generate_usertags
```

4. **Uninstallation**:
   - In admin panel: **Administration > Extensions > Userfields > Uninstall**.
   - Executes `userfields.uninstall.sql`, removing tables.
   - Manually delete the `plugins/userfields` folder.

5. **Troubleshooting**:
   - **Plugin Not Visible**: Ensure files are in `plugins/userfields`.
   - **Database Issues**: Verify MySQL user permissions for table creation and foreign keys.

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

The plugin provides tags for the `users` module and via `cot_generate_usertags` for other modules (`mstore`, `page`, `forums`). Tags use the field code in uppercase (e.g., `cell_number` → `USERFIELDS_CELL_NUMBER`). All tags are wrapped in `<!-- IF {PHP|cot_plugin_active('userfields')} -->` to ensure compatibility.

### 1. Users Module Templates

#### users.profile.tpl (Profile Editing)

**Using a Loop (Automatic Output of All Fields)**:
- Inside `<form>` (e.g., after `{USERS_PROFILE_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and input.

**Individual Fields (Custom Styling)**:
- Inside `<form>` (e.g., after `{USERS_PROFILE_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling for each.

#### users.edit.tpl (Admin User Editing)

**Using a Loop (Automatic Output of All Fields)**:
- Inside `<form>` (e.g., after `{USERS_EDIT_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and input.

**Individual Fields (Custom Styling)**:
- Inside `<form>` (e.g., after `{USERS_EDIT_COUNTRY}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling for each.

#### users.details.tpl (User Profile Page)

**Using a Loop (Automatic Output of All Fields)**:
- After `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-details">
      <h3>Additional Fields</h3>
      <!-- BEGIN: USERFIELDS_DETAILS -->
      <div class="userfield">
          <label class="userfield-title text-success">{USERFIELDS_FIELD_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_FIELD}</div>
      </div>
      <!-- END: USERFIELDS_DETAILS -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and value.

**Individual Fields (Custom Styling)**:
- After `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling, e.g., a clickable phone number.

#### users.tpl (User List)

**Using a Loop (Automatic Output of All Fields)**:
- Inside `<!-- BEGIN: USERS_ROW -->` (e.g., after `{USERS_ROW_NAME}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="user-fields">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {USERS_ROW_FIELD_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and value, plus a pre-formatted HTML block.

**Individual Fields (Custom Styling)**:
- Inside `<!-- BEGIN: USERS_ROW -->` (e.g., after `{USERS_ROW_NAME}`), add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="user-fields">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {USERS_ROW_FIELD_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling, plus a pre-formatted HTML block.

### 2. Other Modules (via usertags)

The plugin supports integration with other modules using `cot_generate_usertags($data, 'PREFIX_')`, enabling tags like `{PREFIX_USERFIELDS_CODE}`, `{PREFIX_USERFIELDS_CODE_TITLE}`, and `{PREFIX_USERFIELDS_ROWS_HTML}`.

#### page.tpl (Article Page)

**Using a Loop (Automatic Output of All Fields)**:
- After `{PAGE_OWNER_NAME}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {PAGE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and value, plus a pre-formatted HTML block.
- Prefix: `PAGE_OWNER_`.

**Individual Fields (Custom Styling)**:
- After `{PAGE_OWNER_NAME}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {PAGE_OWNER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{PAGE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{PAGE_OWNER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{PAGE_OWNER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {PAGE_OWNER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{PAGE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{PAGE_OWNER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {PAGE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling, plus a pre-formatted HTML block.
- Prefix: `PAGE_OWNER_`.

#### mstore.index.tpl / mstore.list.tpl (Product Lists)

**Using a Loop (Automatic Output of All Fields)**:
- Inside `<!-- BEGIN: MSTORE_ROW -->` or `<!-- BEGIN: LIST_ROW -->` after `{MSTORE_ROW_TITLE}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {MSTORE_ROW_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and value, plus a pre-formatted HTML block.
- Prefix: `MSTORE_ROW_OWNER_`.

**Individual Fields (Custom Styling)**:
- Inside `<!-- BEGIN: MSTORE_ROW -->` or `<!-- BEGIN: LIST_ROW -->` after `{MSTORE_ROW_TITLE}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {MSTORE_ROW_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling, plus a pre-formatted HTML block.
- Prefix: `MSTORE_ROW_OWNER_`.

#### mstore.tpl (Product Page)

**Using a Loop (Automatic Output of All Fields)**:
- After `{MSTORE_OWNER_NAME}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {MSTORE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and value, plus a pre-formatted HTML block.
- Prefix: `MSTORE_OWNER_`.

**Individual Fields (Custom Styling)**:
- After `{MSTORE_OWNER_NAME}`, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {MSTORE_OWNER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{MSTORE_OWNER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{MSTORE_OWNER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {MSTORE_OWNER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{MSTORE_OWNER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {MSTORE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling, plus a pre-formatted HTML block.
- Prefix: `MSTORE_OWNER_`.

#### forums.posts.tpl (Forum Posts)

**Using a Loop (Automatic Output of All Fields)**:
- After `{FORUMS_POSTS_ROW_USER_NAME}` in the post block, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {FORUMS_POSTS_ROW_USER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs all fields automatically as a loop with title and value, plus a pre-formatted HTML block.
- Prefix: `FORUMS_POSTS_ROW_USER_`.

**Individual Fields (Custom Styling)**:
- After `{FORUMS_POSTS_ROW_USER_NAME}` in the post block, add:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {FORUMS_POSTS_ROW_USER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Outputs specific fields with custom styling, plus a pre-formatted HTML block.
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

---

### 🇷🇺 Русский

# Плагин Userfields для Cotonti 0.9.26

## Описание

Плагин **Userfields** для CMS Cotonti позволяет создавать и управлять дополнительными пользовательскими полями (например, номер телефона, название компании, адрес) без изменения таблицы `cot_users`. Использует таблицы `cot_userfield_types` (типы полей) и `cot_userfield_values` (значения полей) для масштабируемости и удобства. Поля интегрируются в профили пользователей, админ-панель и шаблоны (список пользователей, статьи, форумы, модуль Multistore).

![Плагин дополнительных полей для Cotonti CMF](https://raw.githubusercontent.com/webitproff/cot-userfields/main/User-fields-Plugin-for-Cotonti_3.webp)

#### Основные возможности
- Создание, редактирование и удаление типов полей с уникальными кодами, названиями и порядком сортировки через админ-панель.
- Хранение значений в отдельной таблице, привязанной к ID пользователя.
- Редактирование полей в профиле (`users.profile.tpl`) и админском редакторе (`users.edit.tpl`).
- Вывод полей в списках пользователей (`users.tpl`), страницах профиля (`users.details.tpl`) и других шаблонах (`page.tpl`, `mstore.tpl`, `forums.posts.tpl`) через теги Cotonti.
- Поддержка индивидуальных тегов (например, `{USERFIELDS_CELL_NUMBER}`), цикла для всех полей (`<!-- BEGIN: USERFIELDS -->`) и HTML-блока (`{USERFIELDS_ROWS_HTML}` или `{USERS_ROW_FIELD_ROWS_HTML}`).
- Автоматическое сохранение значений при обновлении профиля или данных пользователя.
- Сортировка полей по параметру `order_num`.
- Тестовые поля (`cell_number`, `company_name`) для быстрого старта.
- Удобная админ-панель для управления полями.

### Требования
- Cotonti CMS 0.9.26 или выше.
- PHP 8.4+.
- Активный модуль `users`.
- MySQL 8.0 с поддержкой InnoDB (для внешних ключей).

## Установка

1. **Подготовка файлов**:
   - Скачайте исходный код с [репозитория на GitHub](https://github.com/webitproff/cot-userfields).
   - Распакуйте `cot-userfields-main.zip` и загрузите папку `userfields` в директорию `plugins` в корне Cotonti.

2. **Установка через админ-панель**:
   - Войдите в админ-панель (`/admin.php`).
   - Перейдите в **Администрирование > Расширения > User Fields**.
   - Найдите плагин **Userfields** и нажмите **Установить**.
   - Плагин создаёт таблицы `cot_userfield_types` и `cot_userfield_values`, добавляя тестовые поля: `cell_number` (Номер мобильного телефона, порядок 1) и `company_name` (Название компании, порядок 2).
   - Эти поля — примеры; их можно удалить, отредактировать или создать новые.

3. **Список файлов плагина**:
   - `userfields.setup.php` (конфигурация плагина).
   - `userfields.install.sql` (создание таблиц и тестовых данных).
   - `userfields.uninstall.sql` (удаление таблиц).
   - `userfields.admin.php` (логика админ-панели).
   - `userfields.admin.tpl` (шаблон админ-панели).
   - `userfields.ru.lang.php` (русская локализация).
   - `userfields.en.lang.php` (английская локализация).
   - `userfields.functions.php` (основные функции).
   - `userfields.users.details.tags.php` (теги для страницы профиля).
   - `userfields.users.profile.tags.php` (теги для редактирования профиля).
   - `userfields.users.edit.tags.php` (теги для админского редактирования).
   - `userfields.users.profile.update.done.php` (сохранение профиля).
   - `userfields.users.edit.update.done.php` (сохранение в админке).
   - `userfields.users.loop.php` (вывод в списке пользователей).
   - `userfields.usertags.php` (интеграция с `usertags`).

### Структура файлов

```
/userfields/
├── inc/
│   └── userfields.functions.php         # Основные функции
├── lang/
│   ├── userfields.ru.lang.php           # Русская локализация
│   ├── userfields.en.lang.php           # Английская локализация
├── setup/
│   ├── userfields.install.sql           # SQL для создания таблиц
│   └── userfields.uninstall.sql         # SQL для удаления таблиц
├── tpl/
│   └── userfields.admin.tpl             # Шаблон для админ-панели
├── userfields.admin.php                 # Логика управления полями
├── userfields.global.php                # Подключение языковых файлов
├── userfields.setup.php                 # Конфигурация плагина
├── userfields.users.details.tags.php    # Теги для страницы профиля
├── userfields.users.edit.tags.php       # Теги для админского редактирования
├── userfields.users.edit.update.done.php # Сохранение изменений администратором
├── userfields.users.loop.php            # Вывод полей в списке пользователей
├── userfields.users.profile.tags.php     # Теги для редактирования профиля
├── userfields.users.profile.update.done.php # Сохранение изменений пользователем
└── userfields.usertags.php              # Теги для интеграции через cot_generate_usertags
```

4. **Деинсталляция**:
   - В админ-панели: **Администрирование > Расширения > Userfields > Деинсталлировать**.
   - Выполняется `userfields.uninstall.sql`, удаляющий таблицы.
   - Удалите папку `plugins/userfields` вручную.

5. **Устранение неполадок**:
   - **Плагин не отображается**: Проверьте наличие файлов в `plugins/userfields`.
   - **Проблемы с базой данных**: Убедитесь, что пользователь MySQL имеет права на создание таблиц и внешние ключи.

## Управление полями в админ-панели

Админ-панель: **Администрирование > Другие > Userfields** (требуются права администратора).

### Интерфейс
- **Заголовок**: "Управление дополнительными полями пользователей".
- **Список типов полей**: Таблица с колонками: Код, Название, Порядок сортировки, Редактировать, Удалить.
- **Формы**: Для добавления/редактирования типов полей.

### Добавление типа поля
- Нажмите **Добавить тип поля**.
- Форма:
  - **Код (code)**: Уникальный идентификатор (латинские буквы, цифры, нижнее подчеркивание; макс. 50 символов). Используется в тегах (например, `cell_number` → `USERFIELDS_CELL_NUMBER`). Обязательное, уникальное.
  - **Название (title)**: Отображаемое имя (например, "Номер мобильного телефона"; макс. 100 символов). Обязательное.
  - **Порядок сортировки (order_num)**: Целое число (1 — первый, 2 — второй). Определяет порядок вывода (меньше — выше). Обязательное, по умолчанию 0.
- Нажмите **Сохранить**. Ошибки (дубликат кода, пустые поля) будут отображены.

### Редактирование типа поля
- Нажмите **Редактировать** рядом с полем.
- Измените код, название или порядок (код должен быть уникальным).
- Нажмите **Сохранить**. Обновите теги в шаблонах, если код изменился.

### Удаление типа поля
- Нажмите **Удалить** и подтвердите.
- Удаляет тип поля и связанные значения в `cot_userfield_values` (через `ON DELETE CASCADE`).

### Определение полей
- **id**: Автоматический уникальный ID.
- **code**: Идентификатор для тегов (`USERFIELDS_CODE` — значение, `USERFIELDS_CODE_TITLE` — название).
- **title**: Название для форм и вывода.
- **order_num**: Порядок вывода.

### Заполнение полей
- **Пользователями**: В профиле (`users.profile.tpl`) поля отображаются как таблица с названием и полем ввода. Сохраняются при обновлении профиля.
- **Администраторами**: В редакторе (`users.edit.tpl`) — аналогичная таблица для любого пользователя. Сохраняется при обновлении.
- **Формат**: Текст (тип TEXT, без ограничения длины). Поля необязательные.

## Интеграция в шаблоны

Плагин предоставляет теги для модуля `users` и через `cot_generate_usertags` для других модулей (`mstore`, `page`, `forums`). Теги используют код поля в верхнем регистре (например, `cell_number` → `USERFIELDS_CELL_NUMBER`). Все теги оборачиваются в `<!-- IF {PHP|cot_plugin_active('userfields')} -->` для совместимости.

### 1. Шаблоны модуля `users`

#### users.profile.tpl (Редактирование профиля)

**Циклом (автоматический вывод всех полей)**:
- Внутри `<form>` (например, после `{USERS_PROFILE_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и полем ввода.

**Индивидуально (кастомная стилизация полей)**:
- Внутри `<form>` (например, после `{USERS_PROFILE_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией.

#### users.edit.tpl (Админское редактирование)

**Циклом (автоматический вывод всех полей)**:
- Внутри `<form>` (например, после `{USERS_EDIT_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-block">
      <!-- BEGIN: USERFIELDS -->
      <div>
          <label>{USERFIELDS_FIELD_TITLE}</label>
          {USERFIELDS_FIELD}
      </div>
      <!-- END: USERFIELDS -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и полем ввода.

**Индивидуально (кастомная стилизация полей)**:
- Внутри `<form>` (например, после `{USERS_EDIT_COUNTRY}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <label class="userfield-title text-primary">{USERFIELDS_CELL_NUMBER_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_CELL_NUMBER}</div>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield text-danger">
          <label class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_COMPANY_NAME}</div>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией.

#### users.details.tpl (Страница профиля)

**Циклом (автоматический вывод всех полей)**:
- После `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="userfields-details">
      <h3>Дополнительные поля</h3>
      <!-- BEGIN: USERFIELDS_DETAILS -->
      <div class="userfield">
          <label class="userfield-title text-success">{USERFIELDS_FIELD_TITLE}:</label>
          <div class="userfield-value">{USERFIELDS_FIELD}</div>
      </div>
      <!-- END: USERFIELDS_DETAILS -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и значением.

**Индивидуально (кастомная стилизация полей)**:
- После `{USERS_DETAILS_COUNTRY_FLAG} {USERS_DETAILS_COUNTRY}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией, например, кликабельный номер телефона.

#### users.tpl (Список пользователей)

**Циклом (автоматический вывод всех полей)**:
- Внутри `<!-- BEGIN: USERS_ROW -->` (например, после `{USERS_ROW_NAME}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="user-fields">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {USERS_ROW_FIELD_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и значением, плюс предформатированный HTML-блок.

**Индивидуально (кастомная стилизация полей)**:
- Внутри `<!-- BEGIN: USERS_ROW -->` (например, после `{USERS_ROW_NAME}`) добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="user-fields">
      <!-- IF {USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{USERFIELDS_CELL_NUMBER}" class="fw-semibold">{USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {USERS_ROW_FIELD_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией, плюс предформатированный HTML-блок.

### 2. Другие модули (через usertags)

Плагин поддерживает интеграцию с другими модулями через `cot_generate_usertags($data, 'PREFIX_')`, предоставляя теги `{PREFIX_USERFIELDS_CODE}`, `{PREFIX_USERFIELDS_CODE_TITLE}` и `{PREFIX_USERFIELDS_ROWS_HTML}`.

#### page.tpl (Страница статьи)

**Циклом (автоматический вывод всех полей)**:
- После `{PAGE_OWNER_NAME}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {PAGE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и значением, плюс предформатированный HTML-блок.
- Префикс: `PAGE_OWNER_`.

**Индивидуально (кастомная стилизация полей)**:
- После `{PAGE_OWNER_NAME}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {PAGE_OWNER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{PAGE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{PAGE_OWNER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{PAGE_OWNER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {PAGE_OWNER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{PAGE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{PAGE_OWNER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {PAGE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией, плюс предформатированный HTML-блок.
- Префикс: `PAGE_OWNER_`.

#### mstore.index.tpl / mstore.list.tpl (Списки товаров)

**Циклом (автоматический вывод всех полей)**:
- Внутри `<!-- BEGIN: MSTORE_ROW -->` или `<!-- BEGIN: LIST_ROW -->` после `{MSTORE_ROW_TITLE}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {MSTORE_ROW_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и значением, плюс предформатированный HTML-блок.
- Префикс: `MSTORE_ROW_OWNER_`.

**Индивидуально (кастомная стилизация полей)**:
- Внутри `<!-- BEGIN: MSTORE_ROW -->` или `<!-- BEGIN: LIST_ROW -->` после `{MSTORE_ROW_TITLE}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{MSTORE_ROW_OWNER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{MSTORE_ROW_OWNER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {MSTORE_ROW_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией, плюс предформатированный HTML-блок.
- Префикс: `MSTORE_ROW_OWNER_`.

#### mstore.tpl (Страница товара)

**Циклом (автоматический вывод всех полей)**:
- После `{MSTORE_OWNER_NAME}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {MSTORE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и значением, плюс предформатированный HTML-блок.
- Префикс: `MSTORE_OWNER_`.

**Индивидуально (кастомная стилизация полей)**:
- После `{MSTORE_OWNER_NAME}` добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {MSTORE_OWNER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_OWNER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{MSTORE_OWNER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{MSTORE_OWNER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {MSTORE_OWNER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{MSTORE_OWNER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{MSTORE_OWNER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {MSTORE_OWNER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией, плюс предформатированный HTML-блок.
- Префикс: `MSTORE_OWNER_`.

#### forums.posts.tpl (Посты форума)

**Циклом (автоматический вывод всех полей)**:
- После `{FORUMS_POSTS_ROW_USER_NAME}` в блоке поста добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- BEGIN: USERFIELDS -->
      <div class="userfield">
          <span class="userfield-title">{USERFIELDS_FIELD_TITLE}:</span>
          <span class="userfield-value">{USERFIELDS_FIELD}</span>
      </div>
      <!-- END: USERFIELDS -->
      <hr>
      {FORUMS_POSTS_ROW_USER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит все поля автоматически в виде цикла с названием и значением, плюс предформатированный HTML-блок.
- Префикс: `FORUMS_POSTS_ROW_USER_`.

**Индивидуально (кастомная стилизация полей)**:
- После `{FORUMS_POSTS_ROW_USER_NAME}` в блоке поста добавьте:
  ```html
  <!-- IF {PHP|cot_plugin_active('userfields')} -->
  <div class="row mb-3">
      <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER} -->
      <div class="userfield">
          <span class="userfield-title">{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER_TITLE}:</span>
          <span class="userfield-value">
              <a href="tel:{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER}" class="fw-semibold">{FORUMS_POSTS_ROW_USER_USERFIELDS_CELL_NUMBER}</a>
          </span>
      </div>
      <!-- ENDIF -->
      <!-- IF {FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME} -->
      <div class="userfield">
          <span class="userfield-title">{FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME_TITLE}:</span>
          <span class="userfield-value">{FORUMS_POSTS_ROW_USER_USERFIELDS_COMPANY_NAME}</span>
      </div>
      <!-- ENDIF -->
      <hr>
      {FORUMS_POSTS_ROW_USER_USERFIELDS_ROWS_HTML}
  </div>
  <!-- ENDIF -->
  ```
- Выводит конкретные поля с индивидуальной стилизацией, плюс предформатированный HTML-блок.
- Префикс: `FORUMS_POSTS_ROW_USER_`.

### Стили CSS
Добавьте в CSS вашей темы (например, `themes/yourtheme/yourtheme.css`):
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
Обсуждение плагина, вопросы и помощь в [отдельной теме на форуме](https://abuyfile.com/ru/forums/cotonti/custom/plugs/topic155).

## Лицензия
BSD License. Copyright (c) webitproff 2025.
