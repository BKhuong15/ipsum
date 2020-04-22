<?php

function buildDates()
{

  echo '<h1>Random Dates</h1>';

  echo '<div class="group">';
  echo '<h3>Dob</h3>';
  for ($k = 1; $k <= 10; $k++)
  {
    $age = $k * 10;
    echo '<strong>' . $age . ':</strong> ' . buildDate('-' . $age) . '<br>';
  }
  echo '</div>';

  echo '<div class="group">';
  echo '<h3>This Year</h3>';
  for ($k = 1; $k <= 10; $k++)
  {
    echo buildDate() . '<br>';
  }
  echo '</div>';
}

function buildDate($year_offset = 0)
{
  $start = new DateTime('Jan 1');
  $end = new DateTime('Dec 31');

  $rand = mt_rand($start->format('U'), $end->format('U'));
  $date = DateTime::createFromFormat('U', $rand);
  if ($year_offset)
  {
    $date->modify($year_offset . ' Years');
  }

  return $date->format('m/d/Y'); //date('m/d/Y', $rand);
}

function buildRecentDate($day_offset)
{
  $start = new DateTime('-' . $day_offset . ' days');
  $end = new DateTime();

  $rand = mt_rand($start->format('U'), $end->format('U'));
  $date = DateTime::createFromFormat('U', $rand);

  return $date->format('m/d/Y'); //date('m/d/Y', $rand);
}
