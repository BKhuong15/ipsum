<?php
function phrasesPage()
{
  echo menu();
  echo htmlWrap('p', ipsum(100)) . htmlSolo('input', array('type' => 'button', 'value' => 'Copy', array('class' => array('copy'))));
  echo htmlWrap('p', ipsum(500)) . htmlSolo('input', array('type' => 'button', 'value' => 'Copy', array('class' => array('copy'))));
  echo htmlWrap('p', ipsum(1000)) . htmlSolo('input', array('type' => 'button', 'value' => 'Copy', array('class' => array('copy'))));
  die();
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

/**
 * @param int $length
 *
 * @return string
 */
function ipsum($length)
{
  $sample = 'Under this head I reckon a monster which, by the various names of Fin-Back, Tall-Spout, and Long-John, has been seen almost in every sea and is commonly the whale whose distant jet is so often descried by passengers crossing the Atlantic, in the New York packet-tracks. In the length he attains, and in his baleen, the Fin-back resembles the right whale, but is of a less portly girth, and a lighter colour, approaching to olive. His great lips present a cable-like aspect, formed by the intertwisting, slanting folds of large wrinkles. His grand distinguishing feature, the fin, from which he derives his name, is often a conspicuous object. This fin is some three or four feet long, growing vertically from the hinder part of the back, of an angular shape, and with a very sharp pointed end. Even if not the slightest other part of the creature be visible, this isolated fin will, at times, be seen plainly projecting from the surface. When the sea is moderately calm, and slightly marked with spherical ripples, and this gnomon-like fin stands up and casts shadows upon the wrinkled surface, it may well be supposed that the watery circle surrounding it somewhat resembles a dial, with its style and wavy hour-lines graved on it. On that Ahaz-dial the shadow often goes back. The Fin-Back is not gregarious. He seems a whale-hater, as some men are man-haters. Very shy; always going solitary; unexpectedly rising to the surface in the remotest and most sullen waters; his straight and single lofty jet rising like a tall misanthropic spear upon a barren plain; gifted with such wondrous power and velocity in swimming, as to defy all present pursuit from man; this leviathan seems the banished and unconquerable Cain of his race, bearing for his mark that style upon his back. From having the baleen in his mouth, the Fin-Back is sometimes included with the right whale, among a theoretic species denominated Whalebone whales, that is, whales with baleen. Of these so called Whalebone whales, there would seem to be several varieties, most of which, however, are little known. Broad-nosed whales and beaked whales; pike-headed whales; bunched whales; under-jawed whales and rostrated whales, are the fishermen’s names for a few sorts.
In connection with this appellative of "Whalebone whales," it is of great importance to mention, that however such a nomenclature may be convenient in facilitating allusions to some kind of whales, yet it is in vain to attempt a clear classification of the Leviathan, founded upon either his baleen, or hump, or fin, or teeth; notwithstanding that those marked parts or features very obviously seem better adapted to afford the basis for a regular system of Cetology than any other detached bodily distinctions, which the whale, in his kinds, presents. How then? The baleen, hump, back-fin, and teeth; these are things whose peculiarities are indiscriminately dispersed among all sorts of whales, without any regard to what may be the nature of their structure in other and more essential particulars. Thus, the sperm whale and the humpbacked whale, each has a hump; but there the similitude ceases. Then, this same humpbacked whale and the Greenland whale, each of these has baleen; but there again the similitude ceases. And it is just the same with the other parts above mentioned. In various sorts of whales, they form such irregular combinations; or, in the case of any one of them detached, such an irregular isolation; as utterly to defy all general methodization formed upon such a basis. On this rock every one of the whale-naturalists has split.
But it may possibly be conceived that, in the internal parts of the whale, in his anatomy—there, at least, we shall be able to hit the right classification. Nay; what thing, for example, is there in the Greenland whale’s anatomy more striking than his baleen? Yet we have seen that by his baleen it is impossible correctly to classify the Greenland whale. And if you descend into the bowels of the various leviathans, why there you will not find distinctions a fiftieth part as available to the systematizer as those external ones already enumerated. What then remains? nothing but to take hold of the whales bodily, in their entire liberal volume, and boldly sort them that way. And this is the Bibliographical system here adopted; and it is the only one that can possibly succeed, for it alone is practicable. To proceed.';
  $sample .= ' Of the names in this list of whale authors, only those following Owen ever saw living whales; and but one of them was a real professional harpooneer and whaleman. I mean Captain Scoresby. On the separate subject of the Greenland or right-whale, he is the best existing authority. But Scoresby knew nothing and says nothing of the great sperm whale, compared with which the Greenland whale is almost unworthy mentioning. And here be it said, that the Greenland whale is an usurper upon the throne of the seas. He is not even by any means the largest of the whales. Yet, owing to the long priority of his claims, and the profound ignorance which, till some seventy years back, invested the then fabulous or utterly unknown sperm-whale, and which ignorance to this present day still reigns in all but some few scientific retreats and whale-ports; this usurpation has been every way complete. Reference to nearly all the leviathanic allusions in the great poets of past days, will satisfy you that the Greenland whale, without one rival, was to them the monarch of the seas. But the time has at last come for a new proclamation. This is Charing Cross; hear ye! good people all,—the Greenland whale is deposed,—the great sperm whale now reigneth!';
  $sample .= ' This whale, among the English of old vaguely known as the Trumpa whale, and the Physeter whale, and the Anvil Headed whale, is the present Cachalot of the French, and the Pottsfich of the Germans, and the Macrocephalus of the Long Words. He is, without doubt, the largest inhabitant of the globe; the most formidable of all whales to encounter; the most majestic in aspect; and lastly, by far the most valuable in commerce; he being the only creature from which that valuable substance, spermaceti, is obtained. All his peculiarities will, in many other places, be enlarged upon. It is chiefly with his name that I now have to do. Philologically considered, it is absurd. Some centuries ago, when the Sperm whale was almost wholly unknown in his own proper individuality, and when his oil was only accidentally obtained from the stranded fish; in those days spermaceti, it would seem, was popularly supposed to be derived from a creature identical with the one then known in England as the Greenland or Right Whale. It was the idea also, that this same spermaceti was that quickening humor of the Greenland Whale which the first syllable of the word literally expresses. In those times, also, spermaceti was exceedingly scarce, not being used for light, but only as an ointment and medicament. It was only to be had from the druggists as you nowadays buy an ounce of rhubarb. When, as I opine, in the course of time, the true nature of spermaceti became known, its original name was still retained by the dealers; no doubt to enhance its value by a notion so strangely significant of its scarcity. And so the appellation must at last have come to be bestowed upon the whale from which this spermaceti was really derived.';

  $sample_length = strlen($sample);
  $start = rand(0, $sample_length);
  do
  {
    if ($start === 0 || ($start > 2 && $sample[$start - 1] === ' ' && $sample[$start - 2] === '.'))
    {
      break;
    }
    $start++;
    if ($start > $sample_length)
    {
      $start = 0;
      break;
    }
  } while(TRUE);

  $string = substr($sample, $start, $length);
  if (strlen($string) < $length)
  {
    $string .= substr($sample, 0, $length - strlen($string));
  }
  return $string;
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

