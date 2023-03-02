<?php
/****************************************************************************
 *
 *  Install.
 *
 ****************************************************************************/
function installPhrases()
{
  GLOBAL $db;

  $query = new CreateQuery('phrases');
  $query->addField('id', CreateQuery::TYPE_INTEGER, 0, array('P', 'A'));
  $query->addField('text', CreateQuery::TYPE_STRING, 32, array('N'));
  $query->addField('type_id', CreateQuery::TYPE_STRING, 32, array('N'));
  $db->create($query);

}

function phraseUpsertForm()
{
  $template = new FormPageTemplate();

  // Submit.
  if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    $template->addMessage(nameSubmit());
  }

  $name_id = getUrlID('id');

  $form = new Form('phrase_form');
  $title = 'Add New Phrase';
  if ($name_id)
  {
    $name = getName($name_id);
    $form->setValues($name);
    $title = 'Edit name ' . htmlWrap('em', formatName($name));
  }
  $form->setTitle($title);

  // ID.
  $field = new FieldHidden('id');
  $form->addField($field);

  // Name
  $field = new FieldText('text', 'Text');
  $form->addField($field);


  // Category.
  $genders = getNameGenderList();
  $field = new FieldSelect('gender', 'Gender', $genders);
  $form->addField($field);


  // Submit
  $value = 'Add';
  if ($name_id)
  {
    $value = 'Update';
  }
  $field = new FieldSubmit('submit', $value);
  $form->addField($field);

  // Delete.
  if ($name_id)
  {
    $field = new FieldSubmit('delete', 'Delete');
    $form->addField($field);
  }

  // Template.
  $template->setForm($form);
  return $template;
}

function getTypeIDList($key = FALSE)
{
  $list = array(
    1 => 'Male',
    2 => 'Female',
  );

  return getListItem($list, $key);
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
