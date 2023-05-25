<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

/*
|--------------------------------------------------------------------------
| CUSTOM CONSTANTS
|--------------------------------------------------------------------------
*/
defined('VARIENT_VERSION')     || define('VARIENT_VERSION', '2.1.1');
defined('IMG_PATH_BG_LG')      || define('IMG_PATH_BG_LG', 'assets/img/img_bg_lg.png');
defined('IMG_PATH_BG_MD')      || define('IMG_PATH_BG_MD', 'assets/img/img_bg_md.png');
defined('IMG_BASE64_1x1')      || define('IMG_BASE64_1x1', 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
defined('IMG_BASE64_283x217')  || define('IMG_BASE64_283x217', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARsAAADZAQMAAAAqtAZpAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAAB5JREFUGBntwYEAAAAAw6D7U8/gBNUAAAAAAAAAgC8fXQABZRtuDQAAAABJRU5ErkJggg==');
defined('IMG_BASE64_360x215')  || define('IMG_BASE64_360x215', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAWgAAADXAQMAAAANwFmCAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAACBJREFUGBntwTEBAAAAwiD7p14KP2AAAAAAAAAAAABwESaiAAGA8Fz0AAAAAElFTkSuQmCC');
defined('IMG_BASE64_380x226')  || define('IMG_BASE64_380x226', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAXwAAADiAQMAAAB3Mu4OAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAACBJREFUGBntwQEBAAAAgqD+r3ZIwAAAAAAAAAAAAADgSitCAAFPZQyzAAAAAElFTkSuQmCC');
defined('IMG_BASE64_450x280')  || define('IMG_BASE64_450x280', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAcIAAAEYAQMAAAD1c2RPAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAACVJREFUaN7twQEBAAAAgqD+r26IwAAAAAAAAAAAAAAAAAAAACDoP3AAASZRMyIAAAAASUVORK5CYII=');
defined('IMG_BASE64_600x460')  || define('IMG_BASE64_600x460', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAHMAQMAAAAzt0RXAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADhJREFUGBntwTEBAAAAwiD7p14MH2AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAXYiQAAEBSA5gAAAAAElFTkSuQmCC');
defined('IMG_BASE64_750x500')  || define('IMG_BASE64_750x500', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAH0AQMAAABYdjrpAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAAERJREFUGBntwIEAAAAAwrD8qTM4wTYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAcLmMAAGcrU8TAAAAAElFTkSuQmCC');
defined('POST_NUM_LOAD_MORE')  || define('POST_NUM_LOAD_MORE', 12);
defined('COMMENT_LIMIT')       || define('COMMENT_LIMIT', 5);