$= jQuery;
$(document).ready(function()
{
  var $table = $('table.print-list');
  $table.on('click', '.plus', function()
  {
    var $control = $(this).siblings('.button');
    var value = $control.val();
    if (!jQuery.isNumeric(value))
    {
      value = 0;
    }
    value++;
    $control.val(value);
  });

  $table.on('click', '.minus', function()
  {
    var $control = $(this).siblings('.button');
    var value = $control.val();
    if (!jQuery.isNumeric(value))
    {
      value = 0;
    }
    if (value > 0)
    {
      value--;
    }
    $control.val(value);
  });
});
