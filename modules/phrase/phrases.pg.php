<?php
function phrasesPage()
{

  $page = getUrlID('page', 1);

  $template = new ListPageTemplate('Phrases', '/phrase-categories', '/phrase-category');
  $template->setCreate('New Phrase');
  $template->setPage($page);

  // List
  $table = new TableTemplate();
  $table->setAttr('class', array('phrase-list'));
  $table->setHeader(array('ID', 'Text', 'Type_ID'));

//  $name_categories = getNameCategoryPager($page);
//  foreach ($name_categories as $name_category)
//  {
//    $row = array();
//    $attr = array(
//      'query' => array('id' => $name_category['id']),
//    );
//    $row[] = a($name_category['name'], '/name-category', $attr);
//    $table->addRow($row);
//  }
  $template->setList($table);
  return $template;
}

function phraseUpsertForm()
{
  $template = new FormPageTemplate();

  // Submit.
  if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    $template->addMessage(nameCategorySubmit());
  }

  $name_category_id = getUrlID('id');

  $form = new Form('ability_form');
  $title = 'Add Phrase';
  if ($name_category_id)
  {
    $ability = getNameCategory($name_category_id);
    $form->setValues($ability);
    $title = 'Edit Name Category ' . htmlWrap('em', $ability['name']);
  }
  $form->setTitle($title);

  // ID.
  $field = new FieldHidden('id');
  $form->addField($field);

  // Name
  $field = new FieldText('name', 'Name');
  $form->addField($field);

  // Submit
  $value = 'Add';
  if ($name_category_id)
  {
    $value = 'Update';
  }
  $field = new FieldSubmit('submit', $value);
  $form->addField($field);

  // Delete.
  if ($name_category_id)
  {
    $field = new FieldSubmit('delete', 'Delete');
    $form->addField($field);
  }

  // Template.
  $template->setForm($form);
  return $template;
}
