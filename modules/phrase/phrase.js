$(document).ready(function ()
{
  // Handle event for the copy-word button
  $('input[name="copy-word"]').click(function ()
  {
    let word = $(this).closest('.group-phrases').find('#word').text();
    copyToClipboard(word);
  });

  // Handle event for copy-sentence button
  $('input[name="copy-sentence"]').click(function ()
  {
    let sentence = $(this).closest('.group-phrases').find('.sentence').text();
    copyToClipboard(sentence);
  });

  // Handle event for the copy-paragraph button
  $('input[name="copy-paragraph"]').click(function ()
  {
    let paragraph = $(this).closest('.group-phrases').find('#paragraph').text();
    copyToClipboard(paragraph);
  });

  // Handle event for the copy-more-paragraph button
  $('input[name="copy-more-paragraph"]').click(function ()
  {
    let moreParagraphs = $(this).closest('.group-phrases').find('#more-paragraphs').text();
    copyToClipboard(moreParagraphs);
  });
});

function copyToClipboard(text)
{
  let tempTextArea = $('<textarea>');

  $('body').append(tempTextArea);

  tempTextArea.val(text).select();

  try
  {
    let successful = document.execCommand('copy');
    let msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err)
  {
    console.error('Error in copying text: ', err);
  }

  tempTextArea.remove();
}