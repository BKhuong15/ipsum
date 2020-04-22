<?php

function installSession()
{
  GLOBAL $db;

  $query = new CreateQuery('sessions');
  $query->addField('id', CreateQuery::TYPE_STRING, 128, array('P', 'U'));
  $query->addField('user_id', CreateQuery::TYPE_INTEGER, 0);
  $query->addField('ip', CreateQuery::TYPE_STRING, 128, array('N'));
  $query->addField('timestamp', CreateQuery::TYPE_INTEGER, 0, array('N'));
  $query->addField('data', CreateQuery::TYPE_STRING, 'max');

  $db->create($query);
}

function getSession($session_id)
{
  GLOBAL $db;

  $query = new SelectQuery('sessions');
  $query->addField('id');
  $query->addField('user_id');
  $query->addField('ip');
  $query->addField('timestamp');
  $query->addField('data');
  $query->addConditionSimple('id', $session_id);

  return $db->selectObject($query);
}

function createSession($session)
{
  GLOBAL $db;

  $query = new InsertQuery('sessions');
  $query->addField('id', $session['id']);
  $query->addField('user_id', $session['user_id']);
  $query->addField('ip', $session['ip']);
  $query->addField('timestamp', $session['timestamp']);
  $query->addField('data', $session['data']);

  $db->insert($query);
}

function updateSession($session)
{
  GLOBAL $db;

  $query = new UpdateQuery('sessions');
  $query->addField('user_id', $session['user_id']);
  $query->addField('data', $session['data']);
  $query->addConditionSimple('id', $session['id']);

  $db->update($query);
}

function deleteSession($session_id)
{
  GLOBAL $db;

  $query = new DeleteQuery('sessions');
  $query->addConditionSimple('id', $session_id);

  $db->delete($query);
}

function deleteSessionsExpired()
{
  GLOBAL $db;

  $query = new DeleteQuery('sessions');
  $query->addConditionSimple('timestamp', time() - SEC_WEEK, QueryCondition::COMPARE_GREATER_THAN);

  $db->delete($query);
}
