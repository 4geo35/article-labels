### Установка

Добавить в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/article-labels/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/article-labels/src/resources/views/admin/**/*.blade.php",
    "./vendor/4geo35/article-labels/src/resources/views/livewire/admin/**/*.blade.php",

Запустить миграции для создания таблиц `php artisan migrate`

#### Views

Сокращение для представлений: `al`  

#### Livewire Components

Admin

- `al-label-index`: список меток в админке
