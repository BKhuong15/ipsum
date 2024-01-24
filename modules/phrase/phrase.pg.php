<?php
function phraseGenerator()
{
  $page = new HTMLTemplate();
  $page->setTitle('Phrase Generator');

  // Fetching all phrases
  $phrases = getAllPhrases(); // This should return an array of phrases
  $phrasesOutput = '';

  // Get 3-5 random keys from phrases array
  $randomKeys = array_rand($phrases, rand(3, 5));

  // Processing each random phrase and appending it to $phrasesOutput
  foreach ($randomKeys as $key)
  {
    $phrasesOutput .= htmlWrap('p', $phrases[$key]); // Wrapping each phrase in a paragraph tag
  }

  $output = menu();
  $output .= htmlWrap('h1', 'Phrases Generator');
  $output .= $phrasesOutput; // Add the random phrases to the output

  $page->setBody($output);
  return $page;
}



