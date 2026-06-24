<?php
    // Load environment variables (Stripe keys, etc.) from the project-root .env
    require_once(__DIR__.'/env.php');

    switch($_SERVER['SERVER_NAME']) {

        case 'happyhuts.jackbarber.co.uk':
            include(__DIR__.'/config.happyhuts-jackbarber-co-uk.php');
            break;

        default:
            include('config.production.php');
            break;
    }

    define('PERCH_LICENSE_KEY', 'R32104-QGS068-JCE857-MEZ294-SQY023');
    define('PERCH_EMAIL_FROM', 'jack@jackbarber.co.uk');
    define('PERCH_EMAIL_FROM_NAME', 'Jack Barber');

    define('PERCH_LOGINPATH', '/perch');
    define('PERCH_PATH', str_replace(DIRECTORY_SEPARATOR.'config', '', __DIR__));
    define('PERCH_CORE', PERCH_PATH.DIRECTORY_SEPARATOR.'core');

    define('PERCH_RESFILEPATH', PERCH_PATH . DIRECTORY_SEPARATOR . 'resources');
    define('PERCH_RESPATH', PERCH_LOGINPATH . '/resources');
    
    define('PERCH_HTML5', true);
    define('PERCH_TZ', 'UTC');
    
//     define('PERCH_DEBUG', true);