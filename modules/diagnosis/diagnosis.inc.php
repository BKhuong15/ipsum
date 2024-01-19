<?php

function getDiagnosisList()
{
  $list = array(
    // Neck.
    'M54.2' => 'Cervicalgia',

    // Lumbar Spine.
    'M54.5' => 'Low back pain.',
    'M54.10' => ' Radiculopathy, cervicothoracic region',
    'M53.2x2' => ' Spinal instabilities, cervical region',

    // Thoracic Spine
    'M54.6' => 'Pain in thoracic spine',

    // Hip.
    'M25.551' => 'Pain in right hip.',
    'M25.552' => 'Pain in left hip.',
    'M25.651' => 'Stiffness of right hip, not elsewhere classified.',
    'M25.652' => 'Stiffness of left hip, not elsewhere classified.',
    'M70.61' => 'Trochanteric bursitis, right hip.',

    // Upper leg.
    'M79.651' => 'Pain in right thigh',
    'M79.652' => 'Pain in left thigh',

    // Knee.
    'M25.561' => 'Pain in right knee.',
    'M25.562' => 'Pain in left knee.',
    'M25.569' => 'Pain in unspecified knee.',
    'M22.2X1' => 'Patellofemoral disorders, right knee.',
    'M22.2X2' => 'Patellofemoral disorders, left knee.',
    'M25.661' => 'Stiffness of right knee, not elsewhere classified.',
    'M25.662' => 'Stiffness of left knee, not elsewhere classified.',
    'M76.51' => 'Patellar tendinitis, right knee.',
    'M76.52' => 'Patellar tendinitis, left knee.',

    // Lower Leg.
    'M79.661' => 'Pain in right lower leg',
    'M79.662' => 'Pain in left lower leg',
//      'M79.604' => ' Pain in right leg.',
//      'M79.605' => ' Pain in left leg.',

    // Ankle.
    'M25.572' => 'Pain in left ankle and joints of left foot.',
    'M25.571' => 'Pain in right ankle and joints of right foot.',
    'M24.271' => 'Disorder of ligament, right ankle.',
    'M24.272' => 'Disorder of ligament, left ankle.',
    'M25.671' => 'Stiffness of right ankle, not elsewhere classified.',
    'M25.672' => 'Stiffness of left ankle, not elsewhere classified.',
//      'M76.61'	=> ' Achilles tendinitis, right leg.',
//      'M76.62'	=> ' Achilles tendinitis, left leg.',

    // Foot.
    'M79.671' => 'Pain in right foot.',
    'M79.672' => 'Pain in left foot.',
    'M79.673' => 'Pain in unspecified foot.',

    // Shoulder.
    'M25.511' => 'Pain in right shoulder.',
    'M25.512' => 'Pain in left shoulder.',
    'M75.41' => 'Impingement syndrome of right shoulder.',
    'M75.42' => 'Impingement syndrome of left shoulder.',
    'M25.611' => 'Stiffness of right shoulder, not elsewhere classified.',
    'M25.612' => 'Stiffness of left shoulder, not elsewhere classified.',

    // Upper Arm.
    'M79.621' => 'Pain in right upper arm.',
    'M79.622' => 'Pain in left upper arm.',
//      'M79.601' => ' Pain in right arm.',
//      'M79.602' => ' Pain in left arm.',

    // Elbow.
    'M25.521' => 'Pain in right elbow.',
    'M25.522' => 'Pain in left elbow.',

    // Wrist.
    'M25.531' => 'Pain in right wrist.',
    'M25.532' => 'Pain in left wrist.',

    // Hand.
    'M79.641' => 'Pain in right hand.',
    'M79.642' => 'Pain in left hand.',
    'M79.644' => 'Pain in right finger(s).',
    'M79.645' => 'Pain in left finger(s).  );',
  );
  return $list;
}

function getProcedurePTEvalList()
{
  $list = array(
    // Evaluation.
    '97161' => 'PT Eval: Low Complexity',
    '97162' => 'PT Eval: Moderate Complexity',
    '97163' => 'PT Eval: High Complexity',
  );
  return $list;
}

function getProcedurePTVisitList()
{
  $list = array(
    // Treatments
    '97140' => 'Manual Therapy',
    '97530' => 'Therapeutic/Functional Activities',
    '97110' => 'Therapeutic Exercises',
    '97112' => 'Neuromuscular Re-ed',
    '97014' => 'E-Stim unattended',
    '97026' => 'Laser Therapy',
    '97116' => 'Gait Training',
  );
  return $list;
}

function getProcedureChargeTime()
{
  // determine the unit based on the minute value
  function getUnit($minute)
  {
    if ($minute >= 1 && $minute <= 7)
    {
      return 0;
    }
    if ($minute >= 8 && $minute <= 22)
    {
      return 1;
    }
    if ($minute >= 23 && $minute <= 37)
    {
      return 2;
    }
    if ($minute >= 38 && $minute <= 52)
    {
      return 3;
    }
    else
    {
      return '0';
    }
  }

  // Create a list of times and then get the unit
  for ($minute = 1; $minute <= 52; $minute++)
  {
    $unit = getUnit($minute);

      // Combine minute and unit in a way that can be split later
      $chargeUnit[] = $minute . ' minutes ' . $unit . ' units';
  }
  return $chargeUnit;
}

?>
</body>