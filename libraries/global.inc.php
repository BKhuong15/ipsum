<?php

/******************************************************************************
 *
 * Constants
 *
 ******************************************************************************/
define('PAGER_SIZE_DEFAULT', 100);
define('PAGER_SIZE_MINIMUM', 20);

define('SEC_MIN', 60);
define('SEC_HOUR', 3600);
define('SEC_DAY', 86400);
define('SEC_WEEK', 604800);
define('SEC_MONTH', 2419200);
define('SEC_YEAR', 31449600);

define('EXCEPTION_NOT_FOUND', 1);
define('EXCEPTION_PERMISSION_DENIED', 2);
define('EXCEPTION_EXPIRED', 3);
define('EXCEPTION_REQUIRED_FIELD_MISSING', 4);
define('EXCEPTION_FIELD_INVALID', 5);
define('EXCEPTION_UNKNOWN_OPTION', 6);
define('EXCEPTION_BAD_ID', 7);

define('DATE_FORM', 'm/d/Y');

Class AjaxException extends Exception{};

/******************************************************************************
 *
 * DEBUG Helpers
 *
 ******************************************************************************/
function debugPrint($variable, $name = '', $die = TRUE)
{
  $output = '';
  $output .= htmlWrap('strong', $name);
  $output .= htmlWrap('pre', print_r($variable, TRUE));
  $output = htmlWrap('div', $output, array('class' => array('debug')));
  if ($die)
  {
    die($output);
  }
  echo $output;
}

/******************************************************************************
 *
 * URL Helpers
 *
 ******************************************************************************/
class URL
{
  protected $path = '';
  protected $query = array();
  protected $fragment = '';

  function __construct($url = FALSE)
  {
    if (!$url)
    {
      $url = $_SERVER['REQUEST_URI'];
    }
    
    if (FALSE)
	 {
  		$url = urldecode($this->query['q']);
  		$this->__construct($url);
	 }	
    // Home path.
    if ($url === '/')
    {     
      $this->path = '/';
      return;
    }
    elseif (strpos($url, '/5eTemplates/index.php') === 0)
    {
      $end = strpos($url, '?');
      if ($end === FALSE)
      {
        $this->path = '/';
        return;
      }

      $start = $end + 1;
      $query = substr($url, $start);
      $query = explode('&', $query);
      $this->path = '/';
      foreach ($query as $parameter)
      {
        $parts = explode('=', $parameter);
        if ($parts[0] === 'q')
        {
          $url = urldecode($parts[1]);
        }
      }    
    }

    $start = strpos($url, '/') + 1;
    $end = strpos($url, '?');

    // No query string. Only the path is defined.
    if ($end === FALSE)
    {
      $this->path = substr($url, $start);
      return;
    }
    $this->path = substr($url, $start, $end - 1);

    // Build the query string.
    $query = substr($url, $end + 1);
    $query = explode('&', $query);
    foreach ($query as $parameter)
    {
      $parts = explode('=', $parameter);
      $this->query[$parts[0]] = isset($parts[1]) ? urldecode($parts[1]) : FALSE;
    }
  }

  function getPath()
  {
    return urldecode($this->path);
  }

  function getQuery()
  {
    return $this->query;
  }
}

function getUrlID($name, $default = FALSE)
{
  if (!isset($_GET[$name]) || !is_numeric($_GET[$name]))
  {
    return $default;
  }

  return abs($_GET[$name]);
}

/******************
 *  Text
 ******************/
function getUrlText($name, $default = FALSE)
{
  if (!array_key_exists($name, $_GET) || $_GET[$name] === '')
  {
    return $default;
  }
  return rawurldecode($_GET[$name]);
}

/**
 * @param $name
 *
 * @return string
 * @throws AjaxException
 */
function getUrlTextRequired($name)
{
  if (!array_key_exists($name, $_GET) || $_GET[$name] === '')
  {
    throw new AjaxException('Missing required argument ' . $name);
  }
  return rawurldecode($_GET[$name]);
}

function getPostText($name, $default = FALSE)
{
  if (!array_key_exists($name, $_POST) || $_POST[$name] === '')
  {
    return $default;
  }
  return $_POST[$name];
}

/**
 * @param string $name
 * @param string $get_function
 * @param mixed $default
 *
 * @return array
 * @throws AjaxException
 */
function getUrlObject($name, $get_function)
{
  $id = getUrlID($name);
  if (!$id)
  {
    throw new AjaxException('Missing required parameter ' . $name, EXCEPTION_REQUIRED_FIELD_MISSING);
  }

  $object = $get_function($name);
  if (!$object)
  {
    throw new AjaxException('Given id ' . $name . ' does not correspond to an object.', EXCEPTION_BAD_ID);
  }

  return $object;
}

function getUrlOption($name, $options, $default = FALSE)
{
  if (!isset($_GET[$name]) || !array_key_exists($_GET[$name], $options))
  {
    return $default;
  }

  return $_GET[$name];
}

function getUrlOperation()
{
  $operations = array(
    'list' => 'List',
    'create' => 'Create',
    'update' => 'Update',
    'delete' => 'Delete',
  );
  return getUrlOption('operation', $operations, FALSE);
}

function redirect($path, $statusCode = '303', $attr = array())
{
  header('Location: ' . u($path, $attr), TRUE, $statusCode);
  die();
}

function getAjaxDefaultResponse()
{
  return array(
    'status' => TRUE,
    'data' => 'Generic Response',
    'message' => FALSE,
  );
}

/**
 * @param array|bool $response
 */
function jsonResponseDie($response)
{
  if (is_string($response))
  {
    $response = getAjaxDefaultResponse();
    $response['data'] = $response;
  }

  header('Content-Type: application/json');
  echo json_encode($response);
  die();
}

/******************************************************************************
 *
 * HTML Helpers
 *
 ******************************************************************************/
function buildAttr($attr)
{
  assert(is_array($attr), 'abilities passed to buildAttr should be an array().');
  $attr_string = '';
  foreach ($attr as $name => $value)
  {
    if (is_numeric($name))
    {
      continue;
    }
    if (is_array($value))
    {
      $value = implode(' ', $value);
    }
    $attr_string .= ' ' . $name . '="' . $value . '"';
  }

  return $attr_string;
}

function htmlWrap($tag, $content, $attr = array())
{
  return '<' . $tag . buildAttr($attr) . '>' . $content . '</' . $tag . '>';
}

function htmlSolo($tag, $attr = array())
{
  return '<' . $tag . buildAttr($attr) . '>';
}

function stringToAttr($string)
{
  $replace = array(' ', '_');
  return strtolower(str_replace($replace, '-', $string));
}

function optionList($list, $selected = FALSE)
{
  $output = '';
  foreach ($list as $key => $value)
  {
    $attr = array(
      'value' => $key,
    );
    if ($key == $selected)
    {
      $attr['selected'] = 'selected';
    }
    $output .= htmlWrap('option', $value, $attr);
  }
  return $output;
}

function lineItem($label, $value)
{
  $output = '';
  $output .= htmlWrap('strong', $label . ': ', array('class' => array('label')));
  $output .= htmlWrap('span', $value, array('class' => array('value')));
  $output = htmlWrap('span', $output, array('class' => 'line-item'));
  $output .= '<br>';

  return $output;
}
/*****************************************************************************
 *
 * Other Helpers
 *
 ******************************************************************************/

/**
 * @param int $length
 *
 * @return string
 */
function generateRandomString($length = 32)
{
  return base64_encode(openssl_random_pseudo_bytes($length));
}

/******************************************************************************
 *
 *     Sanitation and string processing functions.
 *
 ******************************************************************************/

function boolFormatter($value)
{
  return $value ? 'Yes' : 'No';
}
/**
 * Converts the given string to a machine name.
 *
 * @param string $string
 * @return string
 */
function toMachine($string, $placeholder = '_')
{
  $string = str_replace(' ', $placeholder, $string);
  $string = strtolower($string);
  return $string;
}

function newLineToHtml($string)
{
  return str_replace("\n", '<br>', $string);
}

/**
 * Sanitizes a string for html output.
 *
 * @param string $data
 * @return string
 */
function sanitize($data)
{
  if (is_null($data))
  {
    return '';
  }
  assert(is_string($data) || is_numeric($data) || is_bool($data), 'Non-string passed to sanitize!');

  $data = dewordify($data);
  $data = trim($data);
  $data = htmlspecialchars($data, ENT_IGNORE | ENT_QUOTES);
  return $data;
}

function dewordify($string)
{
  $search = [                 // www.fileformat.info/info/unicode/<NUM>/ <NUM> = 2018
    "\xC2\xAB",     // « (U+00AB) in UTF-8
    "\xC2\xBB",     // » (U+00BB) in UTF-8
    "\xE2\x80\x98", //  (U+2018) in UTF-8
    "\xE2\x80\x99", //  (U+2019) in UTF-8
    "\xE2\x80\x9A", //  (U+201A) in UTF-8
    "\xE2\x80\x9B", // ? (U+201B) in UTF-8
    "\xE2\x80\x9C", //  (U+201C) in UTF-8
    "\xE2\x80\x9D", //  (U+201D) in UTF-8
    "\xE2\x80\x9E", //  (U+201E) in UTF-8
    "\xE2\x80\x9F", // ? (U+201F) in UTF-8
    "\xE2\x80\xB9", //  (U+2039) in UTF-8
    "\xE2\x80\xBA", //  (U+203A) in UTF-8
    "\xE2\x80\x93", //  (U+2013) in UTF-8
    "\xE2\x80\x94", //  (U+2014) in UTF-8
    "\xE2\x80\xA6", //  (U+2026) in UTF-8
  ];

  $replacements = [
    '<<',
    '>>',
    "'",
    "'",
    "'",
    "'",
    '"',
    '"',
    '"',
    '"',
    '<',
    '>',
    '-',
    '-',
    '...'
  ];

  return str_replace($search, $replacements, $string);
}

function sanitizeFileName($name)
{
  $new_name = strtolower($name);
  return preg_replace("/[^a-z-_0-9]+/i", "_", $new_name);
}

// Heavily borrowed from Drupal 7.
function sanitizeXss($string, $allowed_tags = array('a', 'em', 'strong', 'cite', 'blockquote', 'code', 'ul', 'ol', 'li', 'dl', 'dt', 'dd', 'span', 'h1', 'br'))
{
  // Store the text format.
  _sanitizeXssHelper($allowed_tags, TRUE);
  // Remove NULL characters (ignored by some browsers).
  $string = str_replace(chr(0), '', $string);
  // Remove Netscape 4 JS entities.
  $string = preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%', '', $string);

  // Defuse all HTML entities.
  $string = str_replace('&', '&amp;', $string);
  // Change back only well-formed entities in our whitelist:
  // Decimal numeric entities.
  $string = preg_replace('/&amp;#([0-9]+;)/', '&#\1', $string);
  // Hexadecimal numeric entities.
  $string = preg_replace('/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/', '&#x\1', $string);
  // Named entities.
  $string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]*;)/', '&\1', $string);

  return preg_replace_callback('%
    (
    <(?=[^a-zA-Z!/])  # a lone <
    |                 # or
    <!--.*?-->        # a comment
    |                 # or
    <[^>]*(>|$)       # a string that starts with a <, up until the > or the end of the string
    |                 # or
    >                 # just a >
    )%x', '_sanitizeXssHelper', $string);
}

function _sanitizeXssHelper($m, $store = FALSE) 
{
  static $allowed_html;

  if ($store) {
    $allowed_html = array_flip($m);
    return;
  }

  $string = $m [1];

  if (substr($string, 0, 1) != '<') {
    // We matched a lone ">" character.
    return '&gt;';
  }
  elseif (strlen($string) == 1) {
    // We matched a lone "<" character.
    return '&lt;';
  }

  if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9\-]+)([^>]*)>?|(<!--.*?-->)$%', $string, $matches)) {
    // Seriously malformed.
    return '';
  }

  $slash = trim($matches [1]);
  $elem = &$matches [2];
  $attrlist = &$matches [3];
  $comment = &$matches [4];

  if ($comment) {
    $elem = '!--';
  }

  if (!isset($allowed_html [strtolower($elem)])) {
    // Disallowed HTML element.
    return '';
  }

  if ($comment) {
    return $comment;
  }

  if ($slash != '') {
    return "</$elem>";
  }

  // Is there a closing XHTML slash at the end of the ability?
  $attrlist = preg_replace('%(\s?)/\s*$%', '\1', $attrlist, -1, $count);
  $xhtml_slash = $count ? ' /' : '';

  // Clean up ability.
//  $attr2 = implode(' ', $attrlist); //_filter_xss_abilities($attrlist));
  $attr2 = preg_replace('/[<>]/', '', $attrlist);
  $attr2 = strlen($attr2) ? ' ' . $attr2 : '';

  return "<$elem$attr2$xhtml_slash>";
}

/******************************************************************************
 *
 * Global Lists.
 *
 ******************************************************************************/

function u($path, $attr = array())
{
  if (!CLEAN_URLS)
  {
    $attr['query']['q'] = $path;
    $path = '/5eTemplates/index.php';
  }
  
  $url = $path;
  
  $first = TRUE;
  if (array_key_exists('query', $attr))
  {
    foreach ($attr['query'] as $name => $value)
    {
      if ($first)
      {
        $url .= '?';
        $first = FALSE;
      }
      else
      {
        $url .= '&';
      }

      $url .= $name . '=' . urlencode($value);
    }
  }
  return $url;
}

function a($name, $path, $attr = array())
{ 
  $attr['href'] = u($path, $attr);
  unset($attr['query']);
  unset($attr['fragment']);
  return htmlWrap('a', $name, $attr);
}

function iis($array, $key, $default = '')
{
  if (is_array($array) && isset($array[$key]))
  {
    return $array[$key];
  }
  return $default;
}

function getListItem($list, $id = FALSE, $default = FALSE)
{
  if (!$id)
  {
    return $list;
  }

  if (array_key_exists($id, $list))
  {
    return $list[$id];
  }

  return $default;
}

function csvImport($file, $create_function)
{
  $handle = fopen(ROOT_PATH . $file, 'r');
  if (!$handle)
  {
    die('Missing ' . $file);
  }
  $header = fgetcsv($handle);
  if (!$header)
  {
    die('File types.csv is empty.');
  }
  while ($values = fgetcsv($handle))
  {
    $line = array_combine($header, $values);
    $create_function($line);
  }
}