<?php
/****************************************************************************
 *
 *  Install.
 *
 ****************************************************************************/
function installName()
{
  GLOBAL $db;

  $query = new CreateQuery('name_categories');
  $query->addField('id', CreateQuery::TYPE_INTEGER, 0, array('P', 'A'));
  $query->addField('name', CreateQuery::TYPE_STRING, 32, array('N'));
  $db->create($query);

  $query = new CreateQuery('names');
  $query->addField('id', CreateQuery::TYPE_INTEGER, 0, array('P', 'A'));
  $query->addField('first_name', CreateQuery::TYPE_STRING, 64, array('N'));
  $query->addField('middle_name', CreateQuery::TYPE_STRING, 64, array('N'));
  $query->addField('last_name', CreateQuery::TYPE_STRING, 64, array('N'));
  $query->addField('nickname', CreateQuery::TYPE_STRING, 64, array('N'));
  $query->addField('gender', CreateQuery::TYPE_INTEGER, 0, array('N'));
  $query->addField('name_category_id', CreateQuery::TYPE_INTEGER, 0, array('N'));
  $db->create($query);
}

/****************************************************************************
 *
 *  Name Category
 *
 ****************************************************************************/
function getNameCategoryPager($page = 1)
{
  GLOBAL $db;

  $query = new SelectQuery('name_categories');
  $query->addField('id');
  $query->addField('name');
  $query->addPager($page);

  $results = $db->select($query);

  if (!$results)
  {
    return array();
  }
  return $results;
}

function getNameCategoryList($key = FALSE)
{
  GLOBAL $db;
  static $list = array();

  if (empty($list))
  {
    $query = new SelectQuery('name_categories');
    $query->addField('id')->addField('name', 'value');

    $list = $db->selectList($query);
  }

  return getListItem($list, $key);
}

function getNameCategory($id)
{
  GLOBAL $db;

  $query = new SelectQuery('name_categories');
  $query->addField('id');
  $query->addField('name');
  $query->addConditionSimple('id', $id);

  return $db->selectObject($query);
}

function createNameCategory($ability)
{
  GLOBAL $db;

  $query = new InsertQuery('name_categories');
  $query->addField('name', $ability['name']);

  return $db->insert($query);
}

function updateNameCategory($ability)
{
  GLOBAL $db;

  $query = new UpdateQuery('name_categories');
  $query->addField('name', $ability['name']);
  $query->addConditionSimple('id', $ability['id']);

  $db->update($query);
}

function deleteNameCategory($id)
{
  GLOBAL $db;

  $query = new DeleteQuery('name_categories');
  $query->addConditionSimple('id', $id);

  $db->delete($query);
}

/****************************************************************************
 *
 * Names
 *
 ****************************************************************************/

/**
 * @param int  $page
 * @param int $name_category_id
 *
 * @return array
 */
function getNamePager($page = 1, $name_category_id = 0)
{
  GLOBAL $db;

  $query = new SelectQuery('names');
  $query->addField('id');
  $query->addField('first_name');
  $query->addField('middle_name');
  $query->addField('last_name');
  $query->addField('nickname');
  $query->addField('gender');
  $query->addField('name_category_id');
  $query->addPager($page);

  if ($name_category_id)
  {
    $query->addConditionSimple('name_category_id', $name_category_id);
  }

  return $db->select($query);
}

function getName($id)
{
  GLOBAL $db;

  $query = new SelectQuery('names');
  $query->addField('id');
  $query->addField('first_name');
  $query->addField('middle_name');
  $query->addField('last_name');
  $query->addField('nickname');
  $query->addField('gender');
  $query->addField('name_category_id');
  $query->addConditionSimple('id', $id);

  return $db->selectObject($query);
}

function getNameRandom($name_category_id = FALSE)
{
  GLOBAL $db;

  $query = new SelectQuery('names');
  $query->addField('id');
  $query->addField('first_name');
  $query->addField('middle_name');
  $query->addField('last_name');
  $query->addField('nickname');
  $query->addField('gender');
  $query->addField('name_category_id');
  $query->addLimit(1);
  $query->setOrderRandom();

  if ($name_category_id)
  {
    $query->addConditionSimple('name_category_id', $name_category_id);
  }

  return $db->selectObject($query);
}

function createName($name)
{
  GLOBAL $db;

  $query = new InsertQuery('names');
  $query->addField('first_name', $name['first_name']);
  $query->addField('middle_name', $name['middle_name']);
  $query->addField('last_name', $name['last_name']);
  $query->addField('nickname', $name['nickname']);
  $query->addField('gender', $name['gender']);
  $query->addField('name_category_id', $name['name_category_id']);

  return $db->insert($query);
}

function updateName($name)
{
  GLOBAL $db;

  $query = new UpdateQuery('names');
  $query->addField('first_name', $name['first_name']);
  $query->addField('middle_name', $name['middle_name']);
  $query->addField('last_name', $name['last_name']);
  $query->addField('nickname', $name['nickname']);
  $query->addField('gender', $name['gender']);
  $query->addField('name_category_id', $name['name_category_id']);
  $query->addConditionSimple('id', $name['id']);

  $db->update($query);
}

function deleteName($id)
{
  GLOBAL $db;

  $query = new DeleteQuery('names');
  $query->addConditionSimple('id', $id);

  $db->delete($query);
}
