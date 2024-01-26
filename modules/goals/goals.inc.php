<?php
function getShortTerm()
{
  $list = array(
    // Treatments
    'Patient will increase knee flexion from 50 degrees to 70 degrees within two weeks to improve walking ability.',
    'Patient will report a decrease in back pain from 7/10 to 4/10 on the pain scale within one week through targeted exercises and manual therapy.',
    'Patient will improve upper arm strength, being able to lift a 5-pound weight for 10 repetitions without fatigue within three weeks.',
    'Patient will be able to stand on one foot for 10 seconds without support within two weeks to decrease risk of falls.',
    'Patient will increase treadmill walking time from 5 minutes to 10 minutes without excessive fatigue within one week.',
    'Patient will demonstrate correct posture while sitting at a desk for 30 minutes without slouching within two weeks.',
    'Patient will increase walking distance from 100 meters to 200 meters without significant pain or fatigue within one week.',
    'Patient will achieve full range of motion in the shoulder, being able to reach overhead without discomfort within three weeks.',
  );
  return $list;
}

function getLongTerm()
{
  $list = array(
    // Treatments
    'Patient will achieve full, pain-free range of motion in the injured shoulder, enabling them to comfortably perform daily activities such as dressing and reaching overhead.',
    'Patient will fully recover from knee replacement surgery, regaining strength and mobility to pre-injury levels, allowing them to walk and climb stairs without assistance.',
    'Patient will regain sufficient balance and strength to perform daily living activities independently, reducing the risk of falls and the need for caregiver assistance.',
    'Patient with chronic back pain will develop effective pain management strategies, reducing reliance on pain medication, and improving overall quality of life.',
    'Patient with a history of heart disease will improve cardiovascular fitness, aiming to walk 30 minutes a day without undue fatigue, contributing to overall heart health.',
    'Patient recovering from a stroke will regain functional mobility to the extent that they can move around their home and community with minimal assistance.',
    'patient will achieve improved body strength and endurance, assisting in a weight loss program to reach a healthier body weight.',
    'Patient with chronic posture-related issues will achieve and maintain correct spinal alignment, significantly reducing the occurrence of neck and back pain during work hours.',
    'Patient with multiple sclerosis will maintain current levels of mobility and strength as long as possible, focusing on exercises that enhance overall quality of life and slow disease progression.',
  );
  return $list;
}

function getProblems()
{
  $list = array(
    'Decrease cervical ROM',
    'Decrease cervical Strength',
    'Limited walking, standing, and stair climbing.',
    'Patient unable to stand for a prolonged time',
    'Patient unable to perform ADLs > few minutes.',
    'Patient ambulates with altered gait pattern and c/o R ankle pain.',
    'Decreased tolerance to weight loading activities while performing household tasks and  standing activities.',
    'Increase pain limiting ADLs',
    'Increased swelling',
    'Decrease tolerance to  ambulation',
    'Decrease balance and coordination',
    'Limited functional ankle AROM',
    'Cervical ROM decreased',
    'Decreased strength to c-spine',
    'Decreased AROM elbow',
    'Limited AROM elbow',
    'Decreased wrist AROM',
  );
  return $list;
}