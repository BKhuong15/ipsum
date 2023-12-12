<?php
include 'libraries/bootstrap.inc.php';
set_time_limit(SEC_MIN * 10);

// Confirm this is a fresh install.
GLOBAL $db;
if (!file_exists(DB_PATH))
{
  if (!is_writable(dirname(DB_PATH)))
  {
    die(DB_PATH . ' is not writable. Unable to perform install.');
  }
  // Create the database and it's tables.
  $db = new SQLite(DB_PATH);
  installUser();
  installSession();

  // pbs
  installName();
  installPhrase();

  // Install and populate
  installAddress();

}

redirect('/');
