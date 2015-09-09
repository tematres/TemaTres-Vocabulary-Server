# Filterable

[![Build Status](https://travis-ci.org/lightswitch05/filterable.png?branch=master)](https://travis-ci.org/lightswitch05/filterable)

[Bootstrap](http://twitter.github.io/bootstrap/) and [X-editable](http://vitalets.github.io/x-editable/) themed [jQuery](http://jquery.com/) plugin that preforms per-column filtering for an HTML table.

## Demo
[http://lightswitch05.github.io/filterable](http://lightswitch05.github.io/filterable)

## Usage
- Filterable requires both [Bootstrap](http://twitter.github.io/bootstrap/) and [X-editable](http://vitalets.github.io/x-editable/). To be able to change the color of the bootstrap icons, use the [Font Awesome Icons](http://fortawesome.github.io/Font-Awesome/) inplace of the default ones.

  ```html
     <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
     <link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.min.css" rel="stylesheet">
     <link href="http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.5/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
     <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
     <script src="http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.4.5/bootstrap-editable/js/bootstrap-editable.min.js"></script>
  ```

- To use Filterable, just select the table that you want to use and call `filterable` on it.
  - `$('#exampleTable').filterable();`
- To override any default options, just pass a hash of options to Filterable. This example makes filterable case-sensitive.
  - `$('#exampleTable').filterable({ignoreCase: false});`

## Options
- `ignoreColumns`
  - Column indexes to not make filterable
  - Type: `Array`
  - Default: `[]`
- `onlyColumns`
  - Column indexes to make filterable, all other columns are left non-filterable.
  - Type: `Array`
  - This takes presidence over `ignoreColumns` when provided.
  - Default: `null` - all columns
- `ignoreCase`
  - If case should be ignored
  - Type: `Boolean`
  - Default: `true`
- `isMatch($cell, query)`
  - Custom function to determine if the cell matches the user supplied filter
  - Type: `Function`
  - Default: `null`
- `editableOptions`
  - Any custom options for X-editable
  - Type: `Object`
  - Defaults: `{}`
- `editableSelector`
  - Selector to use on each heading to define the x-editable object. If not supplied, the enire heading is used.
  - Type: `String`
  - Defaults: `null`
- `beforeFilter`
  - Function to call before filtering a column
  - Type: `Function`
  - Defaults: `null`
- `afterFilter`
  - Function to call after filtering a column
  - Type: `Function`
  - Defaults: `null`