<?php
/****************************************************************************
 *
 *  Install.
 *
 ****************************************************************************/
function installPhrase()
{
  GLOBAL $db;

  $query = new CreateQuery('phrases');
  $query->addField('id', CreateQuery::TYPE_INTEGER, 0, array('P', 'A'));
  $query->addField('text', CreateQuery::TYPE_STRING, 32, array('N'));
  $query->addField('type_id', CreateQuery::TYPE_STRING, 32, array('N'));
  $db->create($query);
}

function updatePhrase($name)
{
  GLOBAL $db;

  $query = new UpdateQuery('phrases');
  $query->addField('text', $name['text']);
  $query->addField('type_id', $name['type_id']);

  $query->addConditionSimple('id', $name['id']);

  $db->update($query);
}

function createPhrase($name)
{
  GLOBAL $db;

  $query = new InsertQuery('phrases');
  $query->addField('text', $name['text']);
  $query->addField('type_id', $name['type_id']);

  return $db->insert($query);
}

function deletePhrase($id)
{
  GLOBAL $db;

  $query = new DeleteQuery('phrases');
  $query->addConditionSimple('id', $id);

  $db->delete($query);
}