<?php include 'header.php';
echo '<h1>Fake Muscle Activities</h1>';

echo '<div class="group">';
echo '<h3>Exercises</h3>';
for ($k = 0; $k < 10; $k++)
{
  echo buildExercise() . '<br>';
}
echo '</div>';

echo '<div class="group">';
echo '<h3>Stretches</h3>';
for ($k = 0; $k < 10; $k++)
{
  echo buildStretch() . '<br>';
}
echo '</div>';

function getMuscleGroup()
{
  $list = array(
    'Flaktoid',
    'Basalis',
    'Cretorous',
    'Jamores Grapus',
    'Particulii',
    'Ventrilorial',
    'Tetrahemus',
  );
  return $list;
}

function getMuscleModifier()
{
  $list = array(
    'Primary',
    'Secondary',
    'Terciary',
    'Upper',
    'Lower',
    'Abdominal',
    'Fluberial',
    'Dominial',
    'Longus',
    'Shortus',
    'Internal',
    'External',
    'Tesseractal',
    'Posterior',
    'Anterior',
    'Laterior',
    'Dorsal',
    'Plantar',
  );
  return $list;
}

function getStretchPrefix()
{
  $list = array(
    'Standing',
    'Seated',
    'Lying',
    'Reclining',
    'Figure Four',
    '90 Degree',
    'Frog',
    'Butterfly',
    'Side',
    'Back',
    'Forward',
    'Pretzel',
    'Overhead',
    'Inverted',
    'Lateral',
  );
  return $list;
}

function getStretchSuffix()
{
  $list = array(
    'Stretch',
    'Twist',
    'Lunge',
    'Release',
    'Rotation',
    'Pose',
    'Flexion',
    'Extension',
    'Reach',
    'Raise',
  );
  return $list;
}

function getExercisePrefix()
{
  $list = array(
    'Single',
    'Double',
    'Diamond',
    'Dynamic',
    'Reverse',
    'Standing',
    'Lateral',
    'Chair',
    'Reaching',
  );
  return $list;
}

function getExerciseSuffix()
{
  $list = array(
    'Push',
    'Curl',
    'Lunge',
    'Lift',
    'Raise',
    'Dip',
    'Twist',
    'Crunch',
    'Rotation',
    'Press',
  );
  return $list;
}

function buildExercise()
{
  $prefixes = getExercisePrefix();
  $groups = getMuscleGroup();
  $modifiers = getMuscleModifier();
  $suffix = getExerciseSuffix();
  $exercise = '';
  if (rand(0,1) >= 1)
  {
    $rand = rand(0, count($prefixes) - 1);
    $exercise .=  $prefixes[$rand] . ' ';
  }

  $rand = rand(0, count($modifiers) - 1);
  $exercise .= $modifiers[$rand];

  $rand = rand(0, count($groups) - 1);
  $exercise .= ' ' . $groups[$rand];


  $rand = rand(0, count($suffix) - 1);
  $exercise .= ' ' . $suffix[$rand];

  return $exercise;
}

function buildStretch()
{
  $prefixes = getStretchPrefix();
  $groups = getMuscleGroup();
  $modifiers = getMuscleModifier();
  $suffix = getStretchSuffix();
  $stretch = '';
  if (rand(0,1) >= 1)
  {
    $rand = rand(0, count($prefixes) - 1);
    $stretch .=  $prefixes[$rand] . ' ';
  }

  $rand = rand(0, count($modifiers) - 1);
  $stretch .= $modifiers[$rand];

  $rand = rand(0, count($groups) - 1);
  $stretch .= ' ' . $groups[$rand];


  $rand = rand(0, count($suffix) - 1);
  $stretch .= ' ' . $suffix[$rand];

  return $stretch;
}
?>
</body>