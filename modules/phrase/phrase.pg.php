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

  $name_categories = getPhrasePager($page);
  foreach ($name_categories as $name_category)
  {
    $row = array();
    $attr = array(
      'query' => array('id' => $name_category['id']),
    );
    $row[] = a($name_category['id'], '/phrase-category', $attr);
    $row[] = $name_category['text'];
    $row[] = $name_category['type_id'];
    $table->addRow($row);
  }
  $template->setList($table);
  return $template;
}

function phraseUpsertForm()
{
  $template = new FormPageTemplate();

  // Submit.
  if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    $template->addMessage(phraseSubmit());
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
  $phrase_types = getPhraseTypeList();
  $field = new FieldSelect('type_id', 'Type', $phrase_types);
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

define('PHRASE_TYPE_WORD', 1);
define('PHRASE_TYPE_SENTANCE', 2);
define('PHRASE_TYPE_PARAGRAPH', 3);
function getPhraseTypeList($key = FALSE)
{
  $list = array(
    PHRASE_TYPE_WORD => 'Word',
    PHRASE_TYPE_SENTANCE => 'Sentence',
    PHRASE_TYPE_PARAGRAPH => 'Paragraph',
  );

  return getListItem($list, $key);
}

function phraseSubmit()
{
  $phrase = $_POST;

  // Try not to delete original data, if I need to log it.
  if (isset($_POST['delete']))
  {
    deletePhrase($_POST['id']);
    redirect('/phrases');
  }

  // Update.
  if ($_POST['id'])
  {
    updatePhrase($phrase);
    return htmlWrap('h3', 'Name ' . htmlWrap('em', $phrase['text']) . ' (' . $phrase['id'] . ') updated.');
  }
  // Create.
  else
  {
    unset($phrase['id']);
    $phrase['id'] = createPhrase($phrase);
    return htmlWrap('h3', 'Phrase ' . htmlWrap('em', $phrase['text']) . ' (' . $phrase['id'] . ') created.');
  }
}

function getPhrasePager($page = 1)
{
  GLOBAL $db;

  $query = new SelectQuery('phrases');
  $query->addField('id');
  $query->addField('text');
  $query->addField('type_id');
  $query->addPager($page);

  $results = $db->select($query);

  if (!$results)
  {
    return array();
  }
  return $results;
}

