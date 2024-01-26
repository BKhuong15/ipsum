<?php
function phrases()
{
  $page = new HTMLTemplate();
  $page->setTitle('Phrases Generator');
  $page->addJsFilePath('/modules/phrase/phrase.js');

  $phrases = getPhraseText();

  $phraseWord = phraseWord($phrases);
  $phrasesSentence = phraseSentence($phrases);
  $phrasesParagraph = phraseParagraph($phrases);
  $phrasesMoreParagraph = phraseMoreParagraph($phrases);

  $output = menu();
  $output .= htmlWrap('h1', 'Phrases Generator');

  // Word Section
  $group = htmlWrap('h3', 'Word');
  $group .= htmlWrap('p', $phraseWord, array('id' => array('word')));
  $group .= new FieldSubmit('copy-word', 'Copy📋');
  $group .= htmlSolo('br');
  $output .= htmlWrap('div', $group, array('class' => array('group-phrases')));

  // Sentence Section
  $group = htmlWrap('h3', 'Sentence');
  $group .= htmlWrap('p', $phrasesSentence, array('class' => array('sentence')));
  $group .= new FieldSubmit('copy-sentence', 'Copy📋');
  $group .= htmlSolo('br');
  $output .= htmlWrap('div', $group, array('class' => array('group-phrases')));

// Paragraph Section
  $group = htmlWrap('h3', 'Paragraph');
  $group .= htmlWrap('p', $phrasesParagraph, array('id' => array('paragraph')));
  $group .= new FieldSubmit('copy-paragraph', 'Copy📋');
  $group .= htmlSolo('br');
  $output .= htmlWrap('div', $group, array('class' => array('group-phrases')));

// More Paragraphs Section
  $group = htmlWrap('h3', 'Paragraphs'); // Reset $group here
  $group .= htmlWrap('p', $phrasesMoreParagraph, array('id' => array('more-paragraphs')));
  $group .= new FieldSubmit('copy-more-paragraph', 'Copy📋');
  $output .= htmlWrap('div', $group, array('class' => array('group-phrases')));

  $page->setBody($output);
  return $page;
}

function phraseWord($phrases)
{
  // Pick a random phrase
  $randomPhraseKey = array_rand($phrases);
  $randomPhrase = $phrases[$randomPhraseKey];

  // Split the phrase into words
  $words = explode(' ', $randomPhrase);

  // Pick a random word from the phrase
  $randomWordKey = array_rand($words);
  return $words[$randomWordKey];
}

function phraseSentence($phrases)
{
  // Pick a random sentence (phrase) from the array
  $randomSentenceKey = array_rand($phrases);
  return $phrases[$randomSentenceKey];
}

function phraseParagraph($phrases)
{
  // Get 4-5 random keys from phrases array
  $randomKeys = array_rand($phrases, rand(4, 6));

  // Concatenating each random phrase
  $phrasesOutput = '';
  foreach ($randomKeys as $key)
  {
    $phrasesOutput .= $phrases[$key] . ' '; // Adding a space between phrases
  }

  // Wrapping the combined phrases in a paragraph tag
  return $phrasesOutput;
}

function phraseMoreParagraph($phrases)
{
  // Get 3-5 random keys from phrases array
  $randomKeys = array_rand($phrases, rand(10, 15));

  // Concatenating each random phrase
  $phrasesOutput = '';
  foreach ($randomKeys as $key)
  {
    $phrasesOutput .= $phrases[$key] . ' '; // Adding a space between phrases
  }

  // Wrapping the combined phrases in a paragraph tag
  return $phrasesOutput;
}

function phraseList()
{
  $page = getUrlID('page', 1);

  $template = new ListPageTemplate('Phrases', '/phrase', '/phrase');
  $template->setCreate('New Phrase');
  $template->setPage($page);

  // List
  $table = new TableTemplate();
  $table->setAttr('class', array('phrase-list'));
  $table->setHeader(array('ID', 'Text', 'Type'));

  $phrase_page = getPhrasePage($page);
  foreach ($phrase_page as $phrases)
  {
    $row = array();
    $row = array();
    $attr = array(
      'query' => array('id' => $phrases['id']),

    );
    $row[] = a($phrases['id'], '/phrase', $attr);
    $row[] = $phrases['text'];
    $row[] = $phrases['type_name'];
    $table->addRow($row);
  }
  $template->setList($table);
  return $template;
}

/**
 * @param int $length
 *
 * @return string
 */
function phraseUpsertForm()
{
  $template = new FormPageTemplate();

  // Submit.
  if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    $template->addMessage(phraseSubmit());
  }

  $phrase_id = getUrlID('id');

  $form = new Form('phrase_form');
  $title = 'Add New Phrase';
  if ($phrase_id)
  {
    $phrase = getPhrase($phrase_id);
    $form->setValues($phrase);
    $title = 'Edit Text ';
  }
  $form->setTitle($title);

  // ID.
  $field = new FieldHidden('id');
  $form->addField($field);

  // Text
  $field = new FieldText('text', 'Text');
  $form->addField($field);

  // Category.
  $phrase_types = getPhraseTypeList();
  $field = new FieldSelect('type_id', 'Type', $phrase_types);
  $form->addField($field);


  // Submit
  $value = 'Add';
  if ($phrase_id)
  {
    $value = 'Update';
  }
  $field = new FieldSubmit('submit', $value);
  $form->addField($field);

  // Delete.
  if ($phrase_id)
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
    redirect('/phrase/list');
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

function getPhrasePage($page = 1)
{
  global $db;
  $typeMapping = getPhraseTypeList();

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

  // Replace type_id with the type name
  foreach ($results as $key => $row)
  {
    if (array_key_exists($row['type_id'], $typeMapping))
    {
      $results[$key]['type_name'] = $typeMapping[$row['type_id']];
    }
    else
    {
      $results[$key]['type_name'] = 'Unknown Type';
    }
  }

  return $results;
}

