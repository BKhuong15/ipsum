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
    $template->addMessage(nameSubmit());
  }

  $name_id = getUrlID('id');

  $form = new Form('phrase_form');
  $title = 'Add New Phrase';
//  if ($name_id)
//  {
//    $name = getName($name_id);
//    $form->setValues($name);
//    $title = 'Edit name ' . htmlWrap('em', formatName($name));
//  }
  $form->setTitle($title);

  // ID.
  $field = new FieldHidden('id');
  $form->addField($field);

  // Name
  $field = new FieldText('phrase_text', 'Text');
  $form->addField($field);

  // Category.
  $text_elements = getTypeID();
  $field = new FieldSelect('type_id', 'Type', $text_elements);
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

function getTypeID($key = FALSE)
{
  $list = array(
    1 => 'Word',
    2 => 'Sentence',
    3 => 'Paragraph',
  );

  return getListItem($list, $key);
}

function phraseSubmit()
{
  $name = $_POST;

  if (isset($_POST['delete']))
  {
    deleteName($_POST['id']);
    redirect('/phrase');
  }

  // Update.
  if ($_POST['id'])
  {
    updatePhrase($name);
    return htmlWrap('h3', 'Name ' . htmlWrap('em', formatName($name)) . ' (' . $name['id'] . ') updated.');
  }
  // Create.
  else
  {
    unset($name['id']);
    $name['id'] = createPhrase($name);
    return htmlWrap('h3', 'Name ' . htmlWrap('em', formatName($name)) . ' (' . $name['id'] . ') created.');
  }
}