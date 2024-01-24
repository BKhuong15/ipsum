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
  storeDefaultPhrases();
}
function storeDefaultPhrases() {
  GLOBAL $db;

  $phrases = getPhrases();


  foreach ($phrases as $text) {
    $query = new InsertQuery('phrases');
    $query->addField('text', $text);
    $query->addField('type_id', PHRASE_TYPE_SENTANCE); // Default type_id
    $db->insert($query);
  }
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
function getAllPhrases() {
  GLOBAL $db;

  $query = new SelectQuery('phrases');
  $query->addField('text');

  $result = $db->select($query);
  $phrases = array();

  foreach ($result as $row) {
    $phrases[] = $row['text'];
  }

  return $phrases;
}
