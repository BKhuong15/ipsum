<?php

function getAddress($id)
{
  global $db;

  $query = new SelectQuery('addresses');
  $query->addField('zip');
  $query->addField('city');
  $query->addField('state_code');
  $query->addField('latitude');
  $query->addField('longitude');
  $query->addField('timezone');

  $query->addConditionSimple('id', $id);

  return $db->selectObject($query);
}

function getRandomAddress()
{
  global $db;

  $query = new SelectQuery('addresses');
  $query->addField('zip');
  $query->addField('city');
  $query->addField('state_code');
  $query->addField('latitude');
  $query->addField('longitude');
  $query->addField('timezone');

  $query->addOrderSimple('random', QueryOrder::DIRECTION_RAND);

  return $db->selectObject($query);
}

function createAddress($name)
{
  global $db;

  $query = new InsertQuery('addresses');
  $query->addField('zip', $name['zip']);
  $query->addField('city', $name['city']);
  $query->addField('state_code', $name['state_code']);
  $query->addField('latitude', $name['latitude']);
  $query->addField('longitude', $name['longitude']);
  $query->addField('timezone', $name['timezone']);

  return $db->insert($query);
}

function deleteAddress($id)
{
  global $db;

  $query = new DeleteQuery('addresses');
  $query->addConditionSimple('id', $id);

  $db->delete($query);
}

/****************************************************************************
 *
 *  Install.
 *
 ****************************************************************************/
function installAddress()
{
  global $db;

  $query = new CreateQuery('addresses');
  $query->addField('id', CreateQuery::TYPE_INTEGER, 0, array('P', 'A'));
  $query->addField('zip', CreateQuery::TYPE_STRING, 32, array('N'));
  $query->addField('city', CreateQuery::TYPE_STRING, 28, array('N'));
  $query->addField('state_code', CreateQuery::TYPE_STRING, 4, array('N'));
  $query->addField('latitude', CreateQuery::TYPE_STRING, 10, array('N'));
  $query->addField('longitude', CreateQuery::TYPE_STRING, 10, array('N'));
  $query->addField('timezone', CreateQuery::TYPE_STRING, 32, array('N'));
  $db->create($query);

  $handle = fopen(ROOT_PATH . '/modules/address/uszips.csv', 'r');
  if (!$handle)
  {
    die('Missing csv file.');
  }
  $header = fgetcsv($handle);
  if (!$header)
  {
    die('File types.csv is empty.');
  }

  while ($values = fgetcsv($handle))
  {
    $line = array_combine($header, $values);
    $line['latitude'] = $line['lat'];
    $line['longitude'] = $line['lng'];
    $line['state_code'] = $line['state_id'];
    createAddress($line);
  }
  return $header;

}

