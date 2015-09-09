/*global module, test, expect, strictEqual */

module('core');

/* Basic Usage */
test('basic usage', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('heading 1 row 20');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 matches');
  strictEqual(noMatch, 98, 'Finds 98 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Append wild card */
test('append wild card', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('heading 1 row 2');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 11, 'Finds 11 matches');
  strictEqual(noMatch, 88, 'Finds 88 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Prepend wild card */
test('prepend wild card', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('1 row 2');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 11, 'Finds 11 matches');
  strictEqual(noMatch, 88, 'Finds 88 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Filters multiple columns */
test('filters multiple columns', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + (i+1) + '</td>' +
              '<td>Heading 3 Row ' + (i+2) + '</td>' +
              '<td>Heading 4 Row ' + (i+3) + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out first filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('Heading 1 row 2');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Fill out second filter
  $('#heading2 > div').click();
  $('#heading2').find('input').val('Heading 2 row 2');
  $('#heading2').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 9, 'Finds 9 matches');
  strictEqual(noMatch, 90, 'Finds 90 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Clears Filter */
test('clears filters', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + (i+1) + '</td>' +
              '<td>Heading 3 Row ' + (i+2) + '</td>' +
              '<td>Heading 4 Row ' + (i+3) + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(8);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out first filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('Heading 1 row 2');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Fill out second filter
  $('#heading2 > div').click();
  $('#heading2').find('input').val('Heading 2 row 2');
  $('#heading2').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 9, 'Finds 9 matches');
  strictEqual(noMatch, 90, 'Finds 90 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
  
  // Clear Second Filter
  $('#heading2 > div').click();
  $('#heading2').find('input').val('');
  $('#heading2').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  match = $('#test-table > tbody > tr.filterable-match').length;
  noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 11, 'Finds 11 matches');
  strictEqual(noMatch, 88, 'Finds 88 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Uses * as wild card */
test('uses * as wild card', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out first filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('Heading 1 row *1');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 19, 'Finds 19 matches');
  strictEqual(noMatch, 80, 'Finds 80 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Uses column name as popup title */
test('uses column name as popup title', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(1);
  
  // Init
  $('#test-table').filterable();
  
  // Get value
  $('#heading1 > div').click();
  var actual = $('#heading1').find('.popover-title').text();

  // Validate
  strictEqual(actual, 'Enter filter for Heading 1', 'Title is "Enter filter for Heading 1"');
});

/* Initialize multiple filterables for a single selector */
test('initialize multiple filterables for a single selector', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table-1">' +
      '<tr>' +
        '<th id="heading1-1">Heading 1</th>' +
        '<th id="heading1-2">Heading 2</th>' +
        '<th id="heading1-3">Heading 3</th>' +
        '<th id="heading1-4">Heading 4</th>' +
      '</tr>' + rows + '</table>' +
      '<table id="test-table-2">' +
      '<tr>' +
        '<th id="heading2-1">Heading 1</th>' +
        '<th id="heading2-2">Heading 2</th>' +
        '<th id="heading2-3">Heading 3</th>' +
        '<th id="heading2-4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(8);
  
  // Init
  $('table').filterable();
  
  // Fill out filter for table 1
  $('#heading1-1 > div').click();
  $('#heading1-1').find('input').val('heading 1 row 20');
  $('#heading1-1').find('.editable-buttons > button[type="submit"]').click();
  
  // Fill out filter for table 2
  $('#heading2-1 > div').click();
  $('#heading2-1').find('input').val('heading 1 row 3');
  $('#heading2-1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate first table
  var match = $('#test-table-1 > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table-1 > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table-1 > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 matches');
  strictEqual(noMatch, 98, 'Finds 98 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
  
  // Validate second table
  match = $('#test-table-2 > tbody > tr.filterable-match').length;
  noMatch = $('#test-table-2 > tbody > tr.filterable-mismatch').length;
  allRows = $('#test-table-2 > tbody > tr').length;
  strictEqual(match, 11, 'Finds 11 matches');
  strictEqual(noMatch,88, 'Finds 89 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Escapes all wild card characters other than * (star) */
test('Escapes all wild card characters other than * (star)', function() {
  var rows = '<tr>' +
             '<td>Heading 1 Value .09</td>' +
             '<td>Heading 2 Value</td>' +
             '<td>Heading 3 Value</td>' +
           '</tr>' +
           '<tr>' +
             '<td>Heading 1 Value .9</td>' +
             '<td>Heading 2 Value</td>' +
             '<td>Heading 3 Value</td>' +
           '</tr>';
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(3);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out first filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('.9');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 match');
  strictEqual(noMatch, 1, 'Finds 1 non-match');
  strictEqual(allRows, 3, 'Finds the expected number of rows');
});

/* Filters based on the current cell contents.
 *
 * If cell contents is dynamically changed, then the filter
 * should use the most current value of the cell over the value
 * that existed when filterable was initialized.
 */
test('Filters are based on the current cell contents', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr id="row-' + i + '">' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(3);
  
  // Init
  $('#test-table').filterable();
  
  // Filter once to be sure rows are initialized
  $('#heading1 > div').click();
  $('#heading1').find('input').val('row 1');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Clear filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Change cell contents
  $('#row-50 > td').first().text('new contents');
  
  // Filter to include new contents
  $('#heading1 > div').click();
  $('#heading1').find('input').val('new contents');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 match');
  strictEqual(noMatch, 98, 'Finds 98 non-match');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
});

/* Autocomplete basic usage */
test('Autocomplete basic usage', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>Heading 1 Row ' + i + '</td>' +
              '<td>Heading 2 Row ' + i + '</td>' +
              '<td>Heading 3 Row ' + i + '</td>' +
              '<td>Heading 4 Row ' + i + '</td>' +
            '</tr>';
  }
  $('#qunit-fixture').html(
      '<table id="test-table">' +
      '<tr>' +
        '<th id="heading1">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(2);
  
  // Init
  $('#test-table').filterable();
  
  // Fill out filter
  $('#heading1 > div').click();
  var input = $('#heading1').find('input');
  $(input).focus();
  $(input).click();
  $(input).val('w 2');
  
  // Trigger keypress and keyup to start autotext
  var press = jQuery.Event('keypress');
  press.ctrlKey = false;
  press.which = 119;
  $(input).trigger(press);
  var up = jQuery.Event('keyup');
  up.ctrlKey = false;
  up.which = 87;
  $(input).trigger(up);
  
  // Store number of autotexts
  var firstListSize = $('#heading1').find('input').parent().find('ul > li').length;
  
  $(input).val('w 20');
  // Trigger keypress and keyup to start autotext
  press = jQuery.Event('keypress');
  press.ctrlKey = false;
  press.which = 119;
  $(input).trigger(press);
  up = jQuery.Event('keyup');
  up.ctrlKey = false;
  up.which = 87;
  $(input).trigger(up);
  
  // Validate
  var secondListSize = $('#heading1').find('input').parent().find('ul > li').length;
  strictEqual(secondListSize, 1, 'Finds 1 typeahead value');
  strictEqual(firstListSize, 8, 'Finds 8 typeahead values');
});