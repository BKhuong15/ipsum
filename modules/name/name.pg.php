<?php
/******************************************************************************
 *
 * Random Patient.
 *
 ******************************************************************************/
function namePatientPage()
{
  $page = new HTMLTemplate();
  $page->setTitle('Random Patient');
  $output = menu();
  $output .= htmlWrap('h1', 'Random Patient');

  $name_id = getUrlID('name_id');
  $name_category_id = getUrlID('name_category_id');
  if ($name_id)
  {
    $name = getName($name_id);
  }
  elseif($name_category_id)
  {
    $name = getNameRandom($name_category_id);
  }
  else
  {
    $name = getNameRandom();
  }

  // Name.
  $output .= lineItem('Name', formatName($name));
  $output .= htmlSolo('br');

  $output .= htmlWrap('strong', 'Address:') . htmlSolo('br');
  $output .= htmlWrap('div', buildAddress(), array('class' => array('address')));
  $output .= htmlSolo('br');

  $year_offset = rand(18, 99);
  $output .= lineItem('DOB', buildDate('-' . $year_offset) . ' (' . $year_offset . ')');
  $output .= lineItem('Gender', getNameGenderList($name['gender']));
  $output .= lineItem('Handedness', rand(0, 5) ? 'Right' : 'Left'); // 16.6% Chance of left hand.
  $output .= htmlSolo('br');

  $reminder_emails = !rand(0, 3); // 25% chance of reminder e-mail.
  $reminder_calls = !rand(0, 3); // 25% chance of reminder calls.
  $reminder_text = !rand(0, 3); // 25% chance of reminder text.
  if ($reminder_emails)
  {
    $output .= lineItem('Reminder E-Mail', 'daniel+' . stringToAttr($name['first_name'] . $name['last_name']) . '@danielphenry.com');
  }
  $output .= lineItem('E-Mail', stringToAttr($name['first_name']) . '.' . stringToAttr($name['last_name']) . '@example.com');
  $output .= lineItem('Reminder E-mail', boolFormatter($reminder_emails));
  $output .= lineItem('Reminder Calls', boolFormatter($reminder_calls));
  $output .= lineItem('Reminder Text', boolFormatter($reminder_text));

  if ($reminder_text)
  {
    $output .= lineItem('Mobile Phone', phoneFormat('9187989501'));
  }
  if ($reminder_calls)
  {
    $output .= lineItem('Home Phone', phoneFormat(getNotifyPhoneList(rand(0,3))));
  }
  $output .= lineItem('Work Phone', phoneFormat(buildFakePhone()));
  $output .= htmlSolo('br');

  // Case.
  $providers = getNamesStarTrek();
  $output .= lineItem('Assigned Provider', $providers[rand(0, count($providers) - 1)]);
  $referring = getNamesBigBang();
  $output .= lineItem('Referring Physician', $referring[rand(0, count($referring) - 1)]);
  $output .= lineItem('10-Digits (NPI)', rand(1000000000, 9999999999));
  $output .= lineItem('9-Digits (TIN)', rand(100000000, 999999999));

  $output .= lineItem('Onset Date', buildRecentDate(60));

  $diagnosis = getDiagnosisList();
  $output .= lineItem('Diagnosis', getRandomEntryWithKey($diagnosis));
  $output .= lineItem('Diagnosis', getRandomEntryWithKey($diagnosis));
  $output .= lineItem('Diagnosis', getRandomEntryWithKey($diagnosis));
  $output .= lineItem('Diagnosis', getRandomEntryWithKey($diagnosis));
  $output .= htmlSolo('br');

  // Note.
  $procedures_eval = getProcedurePTEvalList();
  $procedures_visit = getProcedurePTVisitList();
  $output .= lineItem('Eval', getRandomEntryWithKey($procedures_eval));
  $output .= lineItem('Visit', getRandomEntryWithKey($procedures_visit));
  $output .= lineItem('Visit', getRandomEntryWithKey($procedures_visit));
  $output .= lineItem('Visit', getRandomEntryWithKey($procedures_visit));



  $page->setBody($output);
  return $page;
}

/******************************************************************************
 *
 * Name Category List
 *
 ******************************************************************************/
function nameCategoryListPage()
{
  $page = getUrlID('page', 1);

  $template = new ListPageTemplate('Name Categories', '/name-categories', '/name-category');
  $template->setCreate('New Name Category');
  $template->setPage($page);

  // List
  $table = new TableTemplate();
  $table->setAttr('class', array('ability-list'));
  $table->setHeader(array('Name'));

  $name_categories = getNameCategoryPager($page);
  foreach ($name_categories as $name_category)
  {
    $row = array();
    $attr = array(
      'query' => array('id' => $name_category['id']),
    );
    $row[] = a($name_category['name'], '/name-category', $attr);
    $table->addRow($row);
  }
  $template->setList($table);
  return $template;
}

function nameCategoryUpsertForm()
{
  $template = new FormPageTemplate();

  // Submit.
  if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    $template->addMessage(nameCategorySubmit());
  }

  $name_category_id = getUrlID('id');

  $form = new Form('ability_form');
  $title = 'Add Name Category';
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

function nameCategorySubmit()
{
  $name_category = $_POST;

  if (isset($_POST['delete']))
  {
    deleteNameCategory($_POST['id']);
    redirect('/name-categories');
  }

  // Update.
  if ($_POST['id'])
  {
    updateNameCategory($name_category);
    return htmlWrap('h3', 'Name Category ' . htmlWrap('em', $name_category['name']) . ' (' . $name_category['id'] . ') updated.');
  }
  // Create.
  else
  {
    unset($name_category['id']);
    $name_category['id'] = createNameCategory($name_category);
    return htmlWrap('h3', 'Ability ' . htmlWrap('em', $name_category['name']) . ' (' . $name_category['id'] . ') created.');
  }
}

/******************************************************************************
 *
 * Names List
 *
 ******************************************************************************/
function nameListPage()
{
  $page = getUrlID('page', 1);
  $name_category_id = getUrlID('name_category_id');

  $template = new ListPageTemplate('Names', '/names', '/name');
  $template->setPage($page);
  $template->setCreate('New Name');

  // List
  $table = new TableTemplate();
  $table->setAttr('class', array('ability-list'));
  $table->setHeader(array('Name', 'Category'));

  $names = getNamePager($page, $name_category_id);
  foreach ($names as $name)
  {
    $row = array();
    $attr = array(
      'query' => array('id' => $name['id']),
    );
    $row[] = a(formatName($name), '/name', $attr);
    $row[] = getNameCategoryList($name['name_category_id']);
    $table->addRow($row);
  }
  $template->setList($table);
  return $template;
}

/******************************************************************************
 *
 * Name Upsert
 *
 ******************************************************************************/
function nameUpsertForm()
{
  $template = new FormPageTemplate();

  // Submit.
  if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST'))
  {
    $template->addMessage(nameSubmit());
  }

  $name_id = getUrlID('id');

  $form = new Form('name_form');
  $title = 'Add New Name';
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
  $field = new FieldText('first_name', 'First Name');
  $form->addField($field);

  // Name
  $field = new FieldText('middle_name', 'Middle Name');
  $form->addField($field);

  // Name
  $field = new FieldText('last_name', 'Last Name');
  $form->addField($field);

  // Name
  $field = new FieldText('nickname', 'Nickname');
  $form->addField($field);

  // Category.
  $genders = getNameGenderList();
  $field = new FieldSelect('gender', 'Gender', $genders);
  $form->addField($field);

  // Category.
  $categories = getNameCategoryList();
  $field = new FieldSelect('name_category_id', 'Category', $categories);
  $field->setValue(getUrlID('name_category_id'));
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

function nameSubmit()
{
  $name = $_POST;

  if (isset($_POST['delete']))
  {
    deleteName($_POST['id']);
    redirect('/name');
  }

  // Update.
  if ($_POST['id'])
  {
    updateName($name);
    return htmlWrap('h3', 'Name ' . htmlWrap('em', formatName($name)) . ' (' . $name['id'] . ') updated.');
  }
  // Create.
  else
  {
    unset($name['id']);
    $name['id'] = createName($name);
    return htmlWrap('h3', 'Name ' . htmlWrap('em', formatName($name)) . ' (' . $name['id'] . ') created.');
  }
}
