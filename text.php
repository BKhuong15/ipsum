<head>
  <title>Ipsum Text</title>
  <style>

  </style>
</head>
<body class="list-item-page">
<?php

echo '<h1>Ipsum Addresses</h1>';

function getParagraphText($key = FALSE)
{
  // Trees.
  $star_wars = array(
    'Acacia',
    'Alba',
    'Alder',
    'Almond',
    'Apple',
    'Ash',
    'Aspen',
    'Balsa',
    'Bamboo',
    'Basswood',
    'Beech',
    'Birch',
    'Buckeye',
    'Cacao',
    'Cedar',
    'Cherry',
    'Chestnut',
    'Cottonwood',
    'Cypress',
    'Ebony',
    'Elm',
    'Fig',
    'Fir',
    'Hawthorn',
    'Hazel',
    'Hemlock',
    'Hickory',
    'Honey',
    'Holly',
    'Juniper',
    'Larch',
    'Laurel',
    'Magnolia',
    'Mahogany',
    'Maple',
    'Oak',
    'Olive',
    'Orange',
    'Persimmon',
    'Pine',
    'Plum',
    'Poplar',
    'Rosewood',
    'Sassafras',
    'Sequoia',
    'Spruce',
    'Sycamore',
    'Teak',
    'Walnut',
    'Willow',
    'Yew',
  );

  // Numbers
  $declaration = array(
    'When in the Course of human events it becomes necessary for one people to dissolve the political bands which have connected them with another and to assume among the powers of the earth, the separate and equal station to which the Laws of Nature and of Nature\'s God entitle them, a decent respect to the opinions of mankind requires that they should declare the causes which impel them to the separation.',
    'We hold these truths to be self-evident, that all men are created equal, that they are endowed by their Creator with certain unalienable Rights, that among these are Life, Liberty and the pursuit of Happiness.',
    'That to secure these rights, Governments are instituted among Men, deriving their just powers from the consent of the governed',
    'That whenever any Form of Government becomes destructive of these ends, it is the Right of the People to alter or to abolish it, and to institute new Government, laying its foundation on such principles and organizing its powers in such form, as to them shall seem most likely to effect their Safety and Happiness.',
    'Prudence, indeed, will dictate that Governments long established should not be changed for light and transient causes; and accordingly all experience hath shewn that mankind are more disposed to suffer, while evils are sufferable than to right themselves by abolishing the forms to which they are accustomed.',
    'But when a long train of abuses and usurpations, pursuing invariably the same Object evinces a design to reduce them under absolute Despotism, it is their right, it is their duty, to throw off such Government, and to provide new Guards for their future security. ',
    'Such has been the patient sufferance of these Colonies; and such is now the necessity which constrains them to alter their former Systems of Government.',
    'The history of the present King of Great Britain is a history of repeated injuries and usurpations, all having in direct object the establishment of an absolute Tyranny over these States.',
  );

  // Presidents.
  $major_general = array(
    'I am the very model of a modern Major-General,',
    'I\'ve information vegetable, animal, and mineral, I know the kings of England, and I quote the fights historical From Marathon to Waterloo, in order categorical;',
    'I\'m very well acquainted, too, with matters mathematical, I understand equations, both the simple and quadratical, About binomial theorem I\'m teeming with a lot o\' news, With many cheerful facts about the square of the hypotenuse.',
    'I\'m very good at integral and differential calculus;',
    'I know the scientific names of beings animalculous:',
    'In short, in matters vegetable, animal, and mineral, I am the very model of a modern Major-General.',
    'I know our mythic history, King Arthur\'s and Sir Caradoc\'s;',
    'I answer hard acrostics, I\'ve a pretty taste for paradox,',
    'I quote in elegiacs all the crimes of Heliogabalus,',
    'In conics I can floor peculiarities parabolous;',
    'I can tell undoubted Raphaels from Gerard Dows and Zoffanies,',
    'Wilson',
    'Truman',
    'Eisenhower',
    'Kennedy',
    'Nixon',
    'Carter',
    'Reagan',
    'Bush',
  );

  // Birds.
  $birds = array(
    'Cardinal',
    'Jay',
    'Dove',
    'Crow',
    'Starling',
    'Sparrow',
    'Finch',
    'Goldfinch',
    'Woodpecker',
    'Warbler',
    'Robin',
    'Mallard',
    'Thrush',
    'Wren',
    'Mockingbird',
  );

  // Geographical features.
  $geo = array(
    'Ocean',
    'Cove',
    'River',
    'Hill',
    'Meadow',
    'Hillside',
    'Ridge',
    'Bay',
    'Lakeview',
    'Canyon',
    'Savanna',
    'Mount',
    'Swamp',
    'Valley',
    'Loc',
    'Garden',
    'Bayou',
    'Lake',
  );

  // Other common names.
  $common = array(
    'Main',
    'Park',
    'View',
    'Washington',
    'Sunset',
    'Evergreen',
    'Church',
    'County Line',
    'Ranch',
    'Broadway',
  );

  $street_names = array_merge($trees, $numbers, $presidents, $birds, $geo, $common);

  if ($key === FALSE)
  {
    return $street_names;
  }
  return $street_names[$key];
}

function getStreetSuffixList($offset = FALSE)
{
  // Suffixes.
  $street_suffix = array(
    'St' => 'Street',
    'Rd' => 'Road',
    'Ave' => 'Avenue',
    'Cr' => 'Circle',
    'Ct' => 'Court',
    'Blvd' => 'Boulevard',
    'Way' => 'Way',
    'Tr' => 'Terrace',
    'Pl' => 'Place',
    'Dr' => 'Drive',
    'Ln' => 'Lane',
    'Gr' => 'Garden',
  );

  if ($offset === FALSE)
  {
    return $street_suffix;
  }
  return array_keys($street_suffix)[$offset];
}

function diagnosisPT()
{
  $diagnosis = array(
    'M25.521' => 'Pain in right ankle and joints of right foot',
    'R26.2' => 'Difficulty in walking, not elsewhere classified',
  );
}
function buildStreetName()
{
  $street = '';

  // Leading number weighted to prefer 4 digits.
  $street += getStreetNumber();

  // Prefix 5% chance of having one.
  $weight = rand(1, 20);
  if ($weight <= 1)
  {
    $weight = rand(0, count(getStreetPrefixList()) - 1);
    $street .= ' ' . getStreetPrefixList($weight);
  }

  // Name.
  $weight = rand(0, count(getStreetNameList()) - 1);
  $street .= ' ' . getStreetNameList($weight);

  // Second name. 20% chance of having one.
  $weight = rand(1, 10);
  if ($weight <= 2)
  {
    $weight = rand(0, count(getStreetNameList()) - 1);
    $street .= ' ' . getStreetNameList($weight);
  }

  // Suffix.
  $weight = rand(0, count(getStreetSuffixList()) - 1);
  $street .= ' ' . getStreetSuffixList($weight);
  return $street;
}
?>
</body>