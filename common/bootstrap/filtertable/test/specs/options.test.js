/*global module, test, expect, strictEqual */

module('options');

/* Ignores specific columns */
test('ignores specific columns', function() {
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
  $('#test-table').filterable({
    ignoreColumns: [0]
  });
  
  // Click heading 1
  $('#heading1 > div').click();
  var heading1 = $('#heading1').find('input').length;
  
  // Click heading 2
  $('#heading2 > div').click();
  var heading2 = $('#heading2').find('input').length;
  
  // Validate
  strictEqual(heading1, 0, 'Heading 1 is ignored');
  strictEqual(heading2, 1, 'Heading 2 is not ignored');
});

/* Only filter specific columns */
test('only filter specific columns', function() {
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

  expect(3);
  
  // Init
  $('#test-table').filterable({
    onlyColumns: [1]
  });
  
  // Click heading 1
  $('#heading1 > div').click();
  var heading1 = $('#heading1').find('input').length;
  
  // Click heading 2
  $('#heading2 > div').click();
  var heading2 = $('#heading2').find('input').length;
  
   // Click heading 3
  $('#heading3 > div').click();
  var heading3 = $('#heading3').find('input').length;
  
  // Validate
  strictEqual(heading1, 0, 'Heading 1 is ignored');
  strictEqual(heading2, 1, 'Heading 2 is not ignored');
  strictEqual(heading3, 0, 'Heading 3 is ignored');
});

/* Case sensitive */
test('case sensitive', function() {
  var rows = '';
  for(var i=1; i<100; i++){
    rows += '<tr>' +
              '<td>HeAding 1 Row ' + i + '</td>' +
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
      '</tr>' +
      '<tr>' +
        '<td>Row 1</td>' +
        '<td>Row 1</td>' +
        '<td>Row 1</td>' +
        '<td>Row 1</td>' +
      '</tr>' +
      '<tr>' +
        '<td>ROW 2</td>' +
        '<td>Row 2</td>' +
        '<td>Row 2</td>' +
        '<td>Row 2</td>' +
      '</tr>' +
      '<tr>' +
        '<td>row 3</td>' +
        '<td>Row 3</td>' +
        '<td>Row 3</td>' +
        '<td>Row 3</td>' +
      '</tr>' +
      '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable({
    ignoreCase: false
  });
  
  // Fill out first filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('ROW');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 match');
  strictEqual(noMatch, 2, 'Finds 2 non-matches');
  strictEqual(allRows, 4, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 3, 'Every row is either a match or no-match');
});

/* Override isMatch function */
test('override isMatch function', function() {
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

  expect(6);
  
  // Init
  $('#test-table').filterable({
    isMatch: function(cell, query){
      return cell.text() === query;
    }
  });
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('Heading 1 Row 20');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 matches');
  strictEqual(noMatch, 98, 'Finds 98 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('heading 1');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  // Validate
  match = $('#test-table > tbody > tr.filterable-match').length;
  noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 0, 'Finds 0 matches');
  strictEqual(noMatch, 99, 'Finds 99 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
});

/* Editable element is limited using editableSelector */
test('editable element is limited using editableSelector', function() {
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
        '<th id="heading1">Heading 1 <i class="icon-filter"></i></th>' +
        '<th id="heading2">Heading 2 <i class="icon-filter"></i></th>' +
        '<th id="heading3">Heading 3 <i class="icon-filter"></i></th>' +
        '<th id="heading4">Heading 4 <i class="icon-filter"></i></th>' +
      '</tr>' + rows + '</table>'
  );

  expect(2);
  
  // Init
  $('#test-table').filterable({
    editableElement: 'i[class|=icon]'
  });
  
  // Click on heading - not editable element
  $('#heading1').click();
  var headingClick = $('#heading1').find('input').length;
  
  // Click on editable element
  $('#heading1 i[class|=icon]').click();
  var editableClick = $('#heading1').find('input').length;
  
  strictEqual(headingClick, 0, 'clicking on header (not editable element) does nothing');
  strictEqual(editableClick, 1, 'clicking on editable element shows window');
});

/* Filters on initialization when data-value is provided */
test('Filters on initialization when data-value is provided', function() {
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
        '<th id="heading1" data-value="Heading 1 Row 2">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 11, 'Finds 11 matches');
  strictEqual(noMatch, 88, 'Finds 88 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* Filters on initialization when data-value is provided */
test('Inital filter works with integers', function() {
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
        '<th id="heading1" data-value="2">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable();
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 19, 'Finds 19 matches');
  strictEqual(noMatch, 80, 'Finds 88 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* editableOptions are passed to x-editable elements */
test('editableOptions are passed to x-editable elements', function() {
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
        '<th id="heading1" data-value="2">Heading 1</th>' +
        '<th id="heading2">Heading 2</th>' +
        '<th id="heading3">Heading 3</th>' +
        '<th id="heading4">Heading 4</th>' +
      '</tr>' + rows + '</table>'
  );

  expect(4);
  
  // Init
  $('#test-table').filterable({
    editableOptions: {
      value: 'Row 20'
    }
  });
  
  // Validate
  var match = $('#test-table > tbody > tr.filterable-match').length;
  var noMatch = $('#test-table > tbody > tr.filterable-mismatch').length;
  var allRows = $('#test-table > tbody > tr').length;
  strictEqual(match, 1, 'Finds 1 match');
  strictEqual(noMatch, 98, 'Finds 98 non-matches');
  strictEqual(allRows, 100, 'Finds the expected number of rows');
  strictEqual(match + noMatch, 99, 'Every row is either a match or no-match');
});

/* beforeFilter is called before the filter is performed */
test('beforeFilter is called before the filter is performed', function() {
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
  var beforeFilterCalled = false;
  $('#test-table').filterable({
    beforeFilter: function(){
      beforeFilterCalled = true;
    }
  });
  
  strictEqual(beforeFilterCalled, false, 'Before filter has not been called yet');
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('heading 1 row 20');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  strictEqual(beforeFilterCalled, true, 'Before filter has been called');
});

/* afterFilter is called after the filter is performed */
test('afterFilter is called after the filter is performed', function() {
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
  var afterFilterCalled = false;
  $('#test-table').filterable({
    afterFilter: function(){
      afterFilterCalled = true;
    }
  });
  
  strictEqual(afterFilterCalled, false, 'After filter has not been called yet');
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('heading 1 row 20');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  strictEqual(afterFilterCalled, true, 'After filter has been called');
});

/* beforeFilter && afterFilter is called in order */
test('beforeFilter && afterFilter is called in order', function() {
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

  expect(6);
  
  // Init
  var afterFilterCalled = false;
  var beforeFilterCalled = false;
  $('#test-table').filterable({
    beforeFilter: function(){
      strictEqual(beforeFilterCalled, false, 'Before filter has not been called yet');
      strictEqual(afterFilterCalled, false, 'After filter has not been called yet');
      beforeFilterCalled = true;
    },
    afterFilter: function(){
      strictEqual(beforeFilterCalled, true, 'Before filter already been called');
      strictEqual(afterFilterCalled, false, 'After filter has not been called yet');
      afterFilterCalled = true;
    }
  });
  
  // Fill out filter
  $('#heading1 > div').click();
  $('#heading1').find('input').val('heading 1 row 20');
  $('#heading1').find('.editable-buttons > button[type="submit"]').click();
  
  strictEqual(beforeFilterCalled, true, 'Before filter has been called');
  strictEqual(afterFilterCalled, true, 'After filter has been called');
});