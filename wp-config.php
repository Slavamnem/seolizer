<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'seolizer');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>MTQx^G~Pef_E60,kj/G(=)tk-e2:L>SakqbN|17oY#lr= yMb*!r$8&:PTt}^xK');
define('SECURE_AUTH_KEY',  'kgu*g@{j9ih^0=vY.],*8U,hRfJD)oG2kmG;a4JLk$N3cy_9`gC]Es*h-F~s$[3C');
define('LOGGED_IN_KEY',    'F&.Th~W0m}0U12)&:3Sh>OV>k}2u|eL#Xbt3K@5Ty(U*hvrAgK]w Zs$6ETN9fb6');
define('NONCE_KEY',        '}*{x:hIHDYSg]Xisy~6uB]wNuF?C=G3e8z.RoKk6J`}c}EtZ?|>VBH,c08(iF#Fb');
define('AUTH_SALT',        'BfL/G]s7i=3Q>w#M i`:2%1/3k#(;.!<Cupg7[F!+OdSy4_!kd$#>)vD/gwt+y%Z');
define('SECURE_AUTH_SALT', 'U8^Ei=|~{R w0kzRh_P_Ik^1?^v192&J}f(Q;x4Kj;6U;e1+oaQAT:N.j=_$vYoc');
define('LOGGED_IN_SALT',   'zI03Y(.*>.95CQB==f0GB=#m)yaU4~s/OeIbR>Nhz><uLVo0gPllUPl7~kn*a= l');
define('NONCE_SALT',       '!lz!28 ]Uc+}AEO9ezhJfq.x/3U6uz0iu&pwU[+S>WBGWn|2~YZ62o)d<,.77(|Y');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
