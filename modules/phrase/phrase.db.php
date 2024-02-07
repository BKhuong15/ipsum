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
  installDefaultPhrases();
}

function installDefaultPhrases()
{
  GLOBAL $db;

  $phrases = getPhrases();

  foreach ($phrases as $text)
  {
    $query = new InsertQuery('phrases');
    $query->addField('text', $text);
    $query->addField('type_id', PHRASE_TYPE_SENTANCE);
    $db->insert($query);
  }
}

function updatePhrase($phrase)
{
  GLOBAL $db;

  $query = new UpdateQuery('phrases');
  $query->addField('text', $phrase['text']);
  $query->addField('type_id', $phrase['type_id']);

  $query->addConditionSimple('id', $phrase['id']);

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

function getPhraseText()
{
  GLOBAL $db;

  $query = new SelectQuery('phrases');
  $query->addField('text');

  $result = $db->select($query);
  $phrases = array();

  foreach ($result as $row)
  {
    $phrases[] = $row['text'];
  }

  return $phrases;
}

function getPhrase($id)
{
  GLOBAL $db;

  $query = new SelectQuery('phrases');
  $query->addField('id');
  $query->addField('text');
  $query->addField('type_id');
  $query->addConditionSimple('id', $id);

  return $db->selectObject($query);
}
