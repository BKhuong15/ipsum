<?php
function buildAddress()
{
  $output = buildStreetName() . htmlSolo('br');
  $zip = getZip();
  $output .= $zip['city'] . ', ' . $zip['state_id'] . ' ' . $zip['zip'];
  return $output;
}

function getStreetNumber()
{
  $weight = rand(1, 10);
  if ($weight <= 1)
  {
    $street_number = rand(100, 1000);
  }
  elseif ($weight <= 9)
  {
    $street_number = rand(1000, 10000);
  }
  else
  {
    $street_number = rand(10000, 100000);
  }
  return $street_number;
}

// Prefix.
function getStreetPrefixList($key = FALSE)
{
  $street_prefix = array(
    'N',
    'S',
    'E',
    'W',
  );

  if ($key === FALSE)
  {
    return $street_prefix;
  }
  return $street_prefix[$key];
}

function getStreetNameList($key = FALSE)
{
  $street_names = array();

  // Trees.
  $street_names += array(
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
  $street_names += array(
    'First',
    '1st',
    'Second',
    '2nd',
    'Third',
    '3rd',
    'Fifth',
    '5th',
  );

  // Presidents.
  $street_names += array(
    'Washington',
    'Adams',
    'Jefferson',
    'Madison',
    'Jackson',
    'Lincoln',
    'Grant',
    'Hays',
    'Garfield',
    'Roosevelt',
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
  $street_names += array(
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
  $street_names += array(
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
    'Ridge',
    'Forest',
  );

  // Other common names.
  $street_names += array(
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

  // Common Buildings
  $street_names += array(
    'Collage',
    'Mint',
    'Town Hall',
    'Library',
  );

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

function buildStreetName()
{
  $street = '';

  // Leading number weighted to prefer 4 digits.
  $street .= getStreetNumber();

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

function getZip()
{
  $offset = rand(0, 33098);
  $handle = fopen(ROOT_PATH . '/modules/address/uszips.csv', 'r');
  if (!$handle)
  {
    die('Missing csv file.');
  }
  $header = fgetcsv($handle);
  if (!$header)
  {
    die('File types.csv is empty.');
  }
  $current_offset = 0;
  while ($values = fgetcsv($handle))
  {
    $line = array_combine($header, $values);
    if ($offset === $current_offset)
    {
      return $line;
    }
    $current_offset++;
  }
  return $header;
}
