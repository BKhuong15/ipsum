<head>
  <style>
    h1
    {
      width: 100%;
      border-top: 1px solid black;
    }
    h2
    {
      color: darkblue;
    }
    h3
    {
    }
    h4
    {
      color: red;
    }
  </style>
</head>
<?php

define('SCRIPT_USERNAME','user'); // Admin Username
define('SCRIPT_PASSWORD','pass'); // Admin Password
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_USER'] !== SCRIPT_USERNAME ||$_SERVER['PHP_AUTH_PW'] !== SCRIPT_PASSWORD)
{
  header('WWW-Authenticate: Basic realm="Memcache Login"');
  header('HTTP/1.0 401 Unauthorized');
  echo '<html><head><title>Unauthorized!</title>
  </head
  ><body>
  <h1>Unauthorized!</h1>
  <p>You are not authorized to access this area!</p></body></html>';
  exit;
}

include '../../libraries/bootstrap.inc.php';

/*****************************************************************************
 *
 * File upload form
 *
 *****************************************************************************/
if (!isset($_SERVER['REQUEST_METHOD']) || ($_SERVER['REQUEST_METHOD'] != 'POST'))
{
  $output = htmlWrap('p', 'Retrieve documentation from: ' . a('https://quickemrweb.freshdesk.com', 'freshdesk', array('external' => TRUE, 'target' => '_blank')) . '. Document must be UTF-8 encoded csv file see ' . a('https://tools.ietf.org/html/rfc4180', 'RFC4180', array('external' => TRUE, 'target' => '_blank')) . ' header must be included. double quotes and double quote escapes allowed and expected.');

  // File field.
  $output .= htmlSolo('input', array('type' => 'file', 'name' => 'file'));

  // Submit Button.
  $output .= htmlSolo('input', array('type' => 'submit', 'value' => 'Payer Upload', 'name' => 'payer'));
  $output .= htmlSolo('input', array('type' => 'submit', 'value' => 'Physician Upload', 'name' => 'physician'));
  $output .= htmlSolo('input', array('type' => 'submit', 'value' => 'Patient Upload', 'name' => 'patient'));

  // Form.
  $output = htmlWrap('form', $output, array('action' => '/modules/phrase/generator.php', 'method' => 'post', 'enctype' => 'multipart/form-data'));
  echo $output;

  die();
}

/*****************************************************************************
 *
 * File verify
 *
 *****************************************************************************/

// Make sure file upload and client upgrade has enough time.
set_time_limit(SEC_MIN * 30);

// Save the file to the cache location.
if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
{
  // TODO: Connec tto Database here!!!!!

  // Validate the file uploaded correctly.
  $file = $_FILES['file'];
  switch ($file['error'])
  {
    case UPLOAD_ERR_OK:
      break;

    case UPLOAD_ERR_NO_FILE:
      die('No file sent.');
      break;

    // If file size exceeds php settings.
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      $message_args = array(
        '@given_size' => FormItemFile::formFormatFileSize($file['size']),
        '@max_size' => FormItemFile::formFormatFileSize($this->max_size),
      );
      die(f('File is too large. Given: @given_size, Max Size: @max_size', $message_args));
      break;

    case UPLOAD_ERR_NO_TMP_DIR:
      die('No temp directory to store file.');
      break;

    case UPLOAD_ERR_CANT_WRITE:
      die('Can\'t write file to temp directory.');
      break;

    default:
      die('Unknown file error');
      break;
  }

  if (isset($_POST['payer']))
  {
    $import_function = 'importInsurance'; /** @uses importInsurance() */
  }
  elseif (isset($_POST['physician']))
  {
    $import_function = 'importPhysician'; /** @uses importPhysician() */
  }
  else//if (isset($_POST['patient']))
  {
    $import_function = 'importPatient'; /** @uses importPatient() */
  }

  // Make sure the file can be opened.
  $file_handle = fopen($file['tmp_name'], 'r');
  if (!$file_handle)
  {
    die('Could not open file to read.');
  }

  // Make sure the first line matches expected format.
  $line = fgets($file_handle, 10000);

  // Todo: something with the file here.
  $phrase = array(
          'phrase_type_id' => PHRASE_TYPE_WORD,
    'text' => 'stuff',
  );
  createphrase($phrase);
  die('Done');
}
