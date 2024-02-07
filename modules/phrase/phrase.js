$(document).ready(function ()
{
  let $phrases = $('#copy-phrase-generator');
  // Handle event for the copy-word button
  $phrases.find('input[name="copy-word"]').click(function ()
  {
    let word = $(this).closest('.group-phrases').find('#copy-phrase-word').text();
    copyToClipboard(word);
  });

  // Handle event for copy-sentence button
  $phrases.find('input[name="copy-sentence"]').click(function ()
  {
    let sentence = $(this).closest('.group-phrases').find('#copy-phrase-sentence').text();
    copyToClipboard(sentence);
  });

  // Handle event for the copy-paragraph button
  $phrases.find('input[name="copy-paragraph"]').click(function ()
  {
    let paragraph = $(this).closest('.group-phrases').find('#copy-phrase-paragraph').text();
    copyToClipboard(paragraph);
  });

  // Handle event for the copy-more-paragraph button
  $phrases.find('input[name="copy-more-paragraph"]').click(function ()
  {
    let moreParagraphs = $(this).closest('.group-phrases').find('#copy-phrase-more-paragraphs').text();
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