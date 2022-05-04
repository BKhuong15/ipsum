<?php

function buildNameList()
{
  echo '<h1>Random Names</h1>';

  echo '<div class="group">';
  echo '<h3>Final Fantasy</h3>';
  $names = getNamesFinalFantasy();
  for ($k = 0; $k < 10; $k++)
  {
    $rand = rand(0, count($names) - 1);
    echo $names[$rand] . '<br>';
    unset($names[$rand]);
    $names = array_values($names);
  }
  echo '</div>';

  echo '<div class="group">';
  echo '<h3>Star Wars</h3>';
  $names = getNamesStarWars();
  for ($k = 0; $k < 10; $k++)
  {
    $rand = rand(0, count($names) - 1);
    echo $names[$rand] . '<br>';
    unset($names[$rand]);
    $names = array_values($names);
  }
  echo '</div>';

  echo '<div class="group">';
  echo '<h3>Harry Potter</h3>';
  $names = getNamesHarryPotter();
  for ($k = 0; $k < 10; $k++)
  {
    $rand = rand(0, count($names) - 1);
    echo $names[$rand] . '<br>';
    unset($names[$rand]);
    $names = array_values($names);
  }
  echo '</div>';

  echo '<div class="group">';
  echo '<h3>Star Trek</h3>';
  $names = getNamesStarTrek();
  for ($k = 0; $k < 10; $k++)
  {
    $rand = rand(0, count($names) - 1);
    echo $names[$rand] . '<br>';
    unset($names[$rand]);
    $names = array_values($names);
  }
  echo '</div>';

  echo '<div class="group">';
  echo '<h3>Marvel</h3>';
  $names = getNamesMarvel();
  for ($k = 0; $k < 10; $k++)
  {
    $rand = rand(0, count($names) - 1);
    echo $names[$rand] . '<br>';
    unset($names[$rand]);
    $names = array_values($names);
  }
  echo '</div>';
}

function getNamesFinalFantasy()
{
  // Trees.
  $list = array(
    'Terra Branford',
    'Lock Cole',
    'Celes Chere',
    'Edgar Figaro',
    'Sabin Figaro',
    'Cyan Garamonde',
    'Setzer Gabbiani',
    'Strago Magus',
    'Relm Arrowny',

    'Cloud Strife',
    'Tifa Lockheart',
    'Aerith Gainsborough',
    'Barret Wallace',
    'Yuffie Kisaragi',
    'Vincent Valentine',
    'Zack Fair',
    'Cid Highwind',
    'Cait Sith',

    'Squall Leonhart',
    'Riona Heartilly',
    'Laguna Loire',
    'Seifer Almasy',
    'Quistis Trepe',
    'Selphie Tilmitt',
    'Zell Dincht',
    'Irvine Kinneas',
    'Kiros Seagill',

    'Vaan Orph',
    'Ashelia Dalmasca',
    'Basch Fon Ronsenburg',
    'Penelo Road',
    'Balthier Strahl Bunansa',
    'Fran Viera',
    'Larsa Ferrinas Solidor',
    'Vossler York Azelas',
    'Vayne Carudas Solidor',
    'Cid Bunansa',

    'Louisoix Leveilleur',
    'Minfilia Warde',
    'Alphinaud Leveilleur',
    'Alisaie Leveilleur',
    'Y\'shtola Rhul',
    'Thancred Waters',
    'Yda Hext',
    'Papalymo Totolymo',
    'Uringet Augurelt',
    'Kan E. Senna',
    'Raubahn Aldynn',
  );

  return $list;
}
function getNamesStarWars()
{
  $list = array(
    'Anakin Skywalker',
    'Leia Organa',
    'Luke Skywalker',
    'Obi-Wan Kenobi',
    'Wilhuff Tarkin',
    'Wedge Antilles',
    'Biggs Darklighter',
    'Owen Lars',
    'Beru Lars',
    'Garven Dreis',
    'Han Solo',
    'Chewbacca Wookie',
    'Mon Mothma',

    'Ahsoka Tano',
    'Asajj Ventress',
    'Rex Clone',
    'Hondo Ohnakka',
    'Lux Bonteri',
    'Savage Opress',
    'Satine Kryze',
    'Cad Bane',
    'Aurra Sing',
    'Onaconda Farr',
    'Rako Hardeen',
    'Shahan Alama',
    'Embo Kyuzo',

    'Padme Amidala',
    'Darth Maul',
    'Qui-Gon Jinn',
    'Jar Jar Binks',
    'Mace Windu',
    'Watto Toydarian',
    'Shmi Skywalker',
    'Sebulba Dug',
    'Nut Gunray',
    'Finis Valorum',
    'Rugor Nass',
    'Gardola Hutt',
    'Mace Wendu',

    'Jengo Fett',
    'Bail Organa',
    'Zam Wessel',
    'Shaak Ti',
    'Luminara Uduli',
    'Plo Koon',
    'Ki-Adi Mundi',

    'Jyn Erso',
    'Cassian Andor',
    'Orson Krennic',
    'Saw Gerrera',
    'Chirrut Imwe',
    'Galen Erso',
    'Baze Malbus',

    'Rey Jakku',
    'Finn Storm',
    'Poe Dameron',
    'Benjamin Solo',
    'Snoke Lead',
    'Maz Kanata',
    'Tasu Leech',
  );
  return $list;
}

function getNamesHarryPotter()
{
  $list = array(
    'Harry Potter',
    'Hermione Granger',
    'Ron Weasley',
    'Tom Riddle',
    'Albus Dumbledore',
    'Severus Snape',
    'Drago Malfoy',
    'Rubeus Hagrid',
    'Neville Longbottom',
    'Minerva McGonagal',
    'Oliver Wood',

    'Dobby Elf',
    'Lucius Malfoy',
    'Molly Weasley',
    'Ginny Weasley',
    'Fred Weasley',
    'George Weasley',
    'Filius Flitwick',
    'Seamus Finnigan',
    'Colin Creevey',
    'Petunia Dursley',
    'Gilderoy Lockhart',

    'Marge Dursley',
    'Sirius Black',
    'Remus Lupin',
    'Peter Petigrew',
    'James Potter',
    'Sybill Trelawney',
    'Percy Weasley',
    'Cho Chang',
    'Poppy Pomfrey',
    'Vincent Crabbe',
    'Gregory Goyle',

    'Viktor Krum',
    'Fleur Delacour',
    'Barty Crouch',
    'Rita Skeeter',
    'Narcissa Malfoy',
    'Igor Karkaroff',
    'Cornelius Fudge',
    'Alastor Moody',
    'Cedric Diggory',

    'Arthur Weasley',
    'Dolores Umbridge',
    'Luna Lovegood',
    'Bellatrix Lestrange',
    'Nymphadora Lupin',
    'Kingsley Shacklebolt',
    'Arabella Figg',
    'Xenophilius Lovegood',
    'Dean Thomas',

    'Gellert Grindelwald',
    'Newt Scamander',
    'Queenie Goldstein',
    'Jacob Kowalski',
    'Porpentia Goldstein',
    'Seraphina Picquery',
    'Credence Barebone',
    'Henry Saw',
    'Mary Lou Barebone',

    'Horace Slughorn',

    'Godric Gryffindor',
    'Helga Hufflepuff',
    'Rowena Ravenclaw',
    'Salazar Slytherin',
  );
  return $list;
}

/** Physicians */
function getNamesStarTrek()
{
  $list = array(
    'James T. Kirk',
    'Leonard McKoy',
    'Spock Vulcan',
    'Montgomery Scott',
    'Hikaru Sulu',
    'Pavel Checkov',

    'Jean-Luc Picard',
    'William T. Riker',
    'Data Soong',
    'Geordi LaForge',
    'Worf Mogh',
    'Beverly Crusher',
    'Deanna Troi',
    'Natasha Yar',
    'Wesley Crusher',

    'Bejamin Sisko',
    'Kira Nerys',
    'Julian Bashir',
    'Miles O\'Brian',
    'Keiko O\'Brian',
  );
  return $list;
}

function getNamesMarvel()
{
  $list = array(
    'Tony Stark',
    'Thor Odinson',
    'Steven Rogers',
    'Bruce Banner',
    'Henry Pym',
    'Janet Van Dyne',
    'Clinton Barton',
    'Pietro Maximoff',
    'Wanda Maximoff',
    'T\'Challa T\'Chaka',
    'James Rupert Rhodes',
    'Stephen Strange',
    'Nick Fury',
    'Timothy Dugan',
    'Maria Hill',
    'Natasha Romanova',
    'Phillip Coulson',
    'Pepper Pots',
    'Loki Frost',
    'Eric Lehnsherr',

    'Peter Parker',
    'Otto Octavious',

    'Reed Richards',
    'Susan Storm',
    'Benjamin Grimm',
    'Jonathan Storm',
    'Victor Von Doom',

    'Peter Quill',
    'Mantis Brandt',
    'Rocket Raccoon',
    'Groot Elm',
    'Gamora Titan',
    'Arthur Drax Douglas',

    'Victor Von Doom',
    'Namor McKenzie',
    'Ulysses Kaue',
    'Ultron Robo',
    'Nathanial Richards',

//    'Charles Xavier',
    'Scott Summers',
    'Robert Drake',
    'Warren Worthington',
    'Henry McCoy',
    'Jean Grey',
    'Kurt Wagner',
    'James Howlett',
    'Ororo Munroe',
    'Remy Etienne LeBeau',
    'Juilation Lee',
    'Lucas Bishop',
    'Carol Jane Danvers',
  );

  return $list;
}

function getNamesTheOffice()
{
  return array(
    'Jim Halpert',
    'Dwight Schrut',
  );
}

/** Physicians */
function getNamesBigBang()
{
  return array(
    'Sheldon Cooper',
    'Amy Farrah Fowler',
    'Eric Gablehauser',
    'Leonard Hofstadter',
    'Bert Kibbler',
    'Raj Koothrappali',
    'Barry Kripke',
    'Bernadette Rostenkowski',
    'Emily Sweeney',
    'Howard Wolowitz',
    'Janine Davis',
  );
}

/** Guarantors & Emergency Contacts */
function getNamesDisney()
{
  return array(
    'Alice Kingsley',
    'Anna Airendale',
    'Olaf Snow',
    'Mickey Mouse',
    'Donald Duck',
    'Minnie Mouse',
    'Snow White',
    'Danielle de Barbarac',
    'Jiminy Cricket',
    'Clarabelle Cow',
    'Ludwig Von Drake',
    'Peter Pan',
    'Edna Mode',
    'Helen Par',
    'Jack Sparrow',
    'Judy Hopps',
    'Nick Wild',
  );
}

function getNamesInsuranceCompanies()
{
  return array(
    'Abstergo',
    'AIM',
    'Aperture (Medicare)',
    'Atlas',
    'Blue Sun (BCBS)',
    'Cyberdyne (Medicare)',
    'Dunwich',
    'Fontaine',
    'Hydra',
    'Hyperion',
    'Initech',
    'Ingen',
    'LexCorp',
    'OsCorp',
    'Rocket',
    'Shinra (Medicare)',
    'Umbrella Inc (Medicare)',
    'Vault Tec',
    'Weyland Corp (Medicare)',
    'Zorg Industries',
  );
}

function getNameGenderList($key = FALSE)
{
  $list = array(
    1 => 'Male',
    2 => 'Female',
  );

  return getListItem($list, $key);
}

function formatName($name)
{
  $output = $name['first_name'];
  if ($name['middle_name'])
  {
    $output .= ' ' . $name['middle_name'];
  }
  if ($name['nickname'])
  {
    $output .= ' "' . $name['nickname'] . '"';
  }
  $output .= ' ' . $name['last_name'];
  return $output;
}

function randomCode($length = 12)
{
  $values = array_merge(
    range('A', 'Z'), // 26
//    range('a', 'z'), // 26
    range('0', '9') // 10
  );

  // -5 ambiguous characters.
//  unset($values[array_search('i', $values)]);
  unset($values[array_search('I', $values)]);
//  unset($values[array_search('l', $values)]);
  unset($values[array_search('L', $values)]);
//  unset($values[array_search('o', $values)]);
  unset($values[array_search('O', $values)]);
  unset($values[array_search('1', $values)]);
  unset($values[array_search('0', $values)]);

  $values = array_values($values);
  $high_offset = count($values) - 1;

  // Total 33.
  $code = '';
  for ($k = 0; $k < $length; $k++)
  {
    $code .= $values[rand(0, $high_offset)];
  }

  //31^8 = 1/0.85*10^12 (Trillion)
  return $code;
}