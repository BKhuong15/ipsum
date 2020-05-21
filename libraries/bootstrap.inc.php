<?php
DEFINE('ROOT_PATH', __DIR__ . '/..');

// Include the platform file.
$platform_path = ROOT_PATH . '/platform.inc.php';
if (!file_exists($platform_path))
{
  die('platform.inc.php is missing.');
}
include $platform_path;

date_default_timezone_set('America/Denver');

/*******************************
 * Environment settings.
 *******************************/
// Debug Flag. Set to FALSE for production. When true errorsPrint will display
// in the messages and debug statements will actually execute.
//if (DEBUG)
//{
//  assert_options(ASSERT_ACTIVE,   TRUE);
//  assert_options(ASSERT_BAIL,     TRUE);
//  assert_options(ASSERT_WARNING,  TRUE);
//  assert_options(ASSERT_CALLBACK, 'assertFailure');
//  function errorHandler($severity, $message, $file, $line)
//  {
//    assert(FALSE, $message);
//  }
//
//  set_error_handler('errorHandler');
//}
//else
//{
//  assert_options(ASSERT_ACTIVE,   FALSE);
//}

/****************
 * Libraries.
 ****************/

include ROOT_PATH . '/libraries/global.inc.php';
include ROOT_PATH . '/libraries/database/database.inc.php';
include ROOT_PATH . '/libraries/database/sqlite.inc.php';
include ROOT_PATH . '/libraries/form.inc.php';
include ROOT_PATH . '/libraries/template.inc.php';

include ROOT_PATH . '/libraries/session/session.inc.php';
include ROOT_PATH . '/libraries/session/session.db.php';

include ROOT_PATH . '/libraries/user/user.inc.php';
include ROOT_PATH . '/libraries/user/user.db.php';
include ROOT_PATH . '/libraries/user/user.pg.php';

/****************
 * Modules.
 ****************/

include ROOT_PATH . '/modules/name/name.db.php';
include ROOT_PATH . '/modules/name/name.pg.php';
include ROOT_PATH . '/modules/name/name.lib.php';

include ROOT_PATH . '/modules/date/date.lib.php';
include ROOT_PATH . '/modules/address/address.lib.php';
include ROOT_PATH . '/modules/number/number.inc.php';
include ROOT_PATH . '/modules/diagnosis/diagnosis.inc.php';

//include ROOT_PATH . '/modules/type/type.pg.php';
//include ROOT_PATH . '/modules/type/type.lib.php';
