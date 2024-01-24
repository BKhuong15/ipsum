<?php
include 'libraries/bootstrap.inc.php';

// Database.
if (!file_exists(DB_PATH))
{
  die('Database file does not exist. Visit /install.php to create a new one.');
}
if (!is_writable(dirname(DB_PATH)))
{
  die('Database file is not writable. Edit the file permission to give apache read/write access.');
}
GLOBAL $db;
$db = new SQLite(DB_PATH);

// Path.
GLOBAL $url;
$url = new URL();
$path = $url->getPath();

// Login.
session_name('dphipsum');
session_start();

GLOBAL $logged_in_user;
if (!$logged_in_user && $path !== 'unknown')
{
  $path = 'login';
}

if ($path === '')
{
  $path = '/';
}

// Retrieve body.
$function = getRegistry($path);
echo $function();

/******************************************************************************
 *
 * Core functions.
 *
 ******************************************************************************/

/**
 * @param bool|FALSE $path
 * @return array|string
 */
function getRegistry($path = FALSE)
{
  $registry = array(
    // Global.
    '/' => 'home', /** @uses home() */
    'home' => 'home',
    'unknown' => 'unknown',

    'user' => 'userUpsertForm',
    'users' => 'userListPage',

    'login' => 'userLoginForm',
    'logout' => 'userLogout',

    // Ajax.

    // Modules.
    'patient' => 'namePatientPage', /** @uses namePatientPage() */
    'name' => 'nameUpsertForm', /** @uses nameUpsertForm() */
    'names' => 'nameListPage', /** @uses nameListPage() */
    'name-category' => 'nameCategoryUpsertForm', /** @uses nameCategoryUpsertForm() */
    'name-categories' => 'nameCategoryListPage', /** @uses nameCategoryListPage() */
    'phrases' => 'phraseGenerator', /** @uses phraseGenerator() */
    'phrase-category' => 'phraseUpsertForm', /** @uses phraseUpsertForm() */
    'customize-phrase' => 'customizePhrase', /** @uses customizePhrase() */
  );

  if ($path)
  {
    if (!isset($registry[$path]))
    {
      return $registry['unknown'];
    }
    return $registry[$path];
  }
  return $registry;
}

function menu()
{
  $output = '';

  // Home.
  $output .= a('Home', '/home');

  // Characters.
  $output .= a('Patients', '/patient');
  $submenu = new ListTemplate('ul');
  $submenu->addListItem(a('Names', '/names'));
  $submenu->addListItem(a('Name Categories', '/name-categories'));
  $output .= $submenu;

  // Items.
//  $output .= a('Lists', '/types');
//  $submenu = new ListTemplate('ul');
//  $submenu->addListItem(a('Types', '/types'));
//  $output .= $submenu;

  // Text.
  $output .= a('Text', '/phrases');
  $submenu = new ListTemplate('ul');
  $submenu->addListItem(a('Phrase Generator', '/phrases'));
  $submenu->addListItem(a('Customize Phrases', '/customize-phrase'));
  $output .= $submenu;

  // Users.
  GLOBAL $logged_in_user;
  $output .= a(sanitize($logged_in_user['username']), '/user', array('query' => array('user_id', $logged_in_user['id'])));
  $submenu = new ListTemplate('ul');
  $submenu->addListItem(a('Users', '/users'));
  $output .= $submenu;

  // Menu wrapper.
  $attr = array('id' => 'menu', 'class' => array('menu'));
  $output = htmlWrap('div', $output, $attr);
  return $output;
}

function home()
{
  $template = new HTMLTemplate();
  $template->setTitle('QuickEMR Lorim Ipsum Patient Generator');
  $output = menu();
  $output .= htmlWrap('h1', 'QuickEMR Lorim Ipsum Patient Generator');
  $output .= htmlWrap('h3', 'Name of the day.');

  $list = new ListTemplate('ul');
  $categories = getNameCategoryList();
  foreach($categories as $category_id => $category)
  {
    $link = a($category, '/patient', array('query' => array('name_category_id' => $category_id)));
    $list->addListItem($link);
  }
  $output .= $list;

  $list = new ListTemplate('ul');
  for ($i = 0; $i < 10; $i++)
  {
    $name = getNameRandom();
    $link = a(formatName($name), '/patient', array('query' => array('id' => $name['id'])));
    $list->addListItem($link);
  }
  $output .= $list;
  $template->setBody($output);

  echo $template;
}

function unknown()
{
  header("HTTP/1.1 404 Not Found");

  $template = new HTMLTemplate();
  $template->setTitle('pbs');
  $template->setBody(menu() . htmlWrap('h1', 'Page Not Found'));

  echo $template;
}
