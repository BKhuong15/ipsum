<?php

function buildNumber()
{
  $number = array(
    str_pad(mt_rand(0, 9), 1, 0, STR_PAD_LEFT),
    str_pad(mt_rand(0, 999), 3, 0, STR_PAD_LEFT),
    str_pad(mt_rand(0, 999), 3, 0, STR_PAD_LEFT),
    str_pad(mt_rand(0, 999), 3, 0, STR_PAD_LEFT),
  );

  return join(',', $number);
}

function buildFakeSSN()
{
  $number = array(
    str_pad(mt_rand(0, 999), 3, 0, STR_PAD_LEFT),
    '00',
    str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT),
  );

  return join('-', $number);
}

function buildFakePayment()
{
  $amount = mt_rand(0, 1000);
  $weight = mt_rand(1, 10);
  if ($weight <= 3)
  {
    $amount .= '.' . str_pad(mt_rand(1, 99), 2, 0, STR_PAD_LEFT);
  }

  $weight = mt_rand(1, 10);
  if ($weight <= 1)
  {
    $amount = '-' . $amount;
  }
  return '$' . number_format($amount, 2);
}

function buildFakePhone($real = FALSE)
{
  if ($real)
  {
    $weight = rand(0, count(getNotifyPhoneList()) - 1);
    $number = getNotifyPhoneList($weight);
  }
  else
  {
    $number = '200' . mt_rand(200, 999) . str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);
  }

  return phoneFormat($number);
}

function getNotifyPhoneList($key = FALSE)
{
  $phones = array(
    '2028029994',
    '2028380107',
    '2046743404',
    '3862182697',
  );

  if ($key === FALSE)
  {
    return $phones;
  }
  return $phones[$key];
}

function phoneFormat($value)
{
  if ($value === FALSE)
  {
    return FALSE;
  }
  if (strlen($value) == 10)
  {
    return substr($value,0,3) . '-' . substr($value,3,3) . '-' . substr($value,6,4);
  }
  if (strlen($value) == 7)
  {
    return substr($value,0,3) . '-' . substr($value,3,4);
  }
  return $value;
}
