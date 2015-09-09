/**
 * filterable
 * jQuery plugin that filters an HTML table based on column-specific values using x-editable
 *
 * @author Daniel White
 * @copyright Daniel White 2014
 * @license MIT <https://github.com/lightswitch05/filterable/blob/master/MIT-LICENSE>
 * @link http://lightswitch05.github.io/filterable
 * @module filterable
 * @version 0.3.0
 */
/**
* Filterable utilites
*/
(function ($) {
    "use strict";
    
    // utils
    $.fn.filterableutils = {
      
      isNull: function(value) {
        if(value === undefined || value === null) {
          return true;
        }
        return false;
      },
      
      notNull: function(value) {
        return !this.isNull(value);
      }
      
    };
}(jQuery));
(function($) {
  'use strict';
  
  var FilterableCell = function (cell, options) {
    this.$cell = $(cell);
    //data-* has more priority over js options: because dynamically created elements may change data-*
    this.options = $.extend({}, $.fn.filterableCell.defaults, options);
    this.match = null;
    this.init();
  };
  
  FilterableCell.prototype = {
    constructor: FilterableCell,
    
    value: function() {
      return this.$cell.text();
    },
    
    setMatch: function(match) {
      if(match){
        this.$cell.addClass('filterable-match');
        this.$cell.removeClass('filterable-mismatch');
      } else {
        this.$cell.addClass('filterable-mismatch');
        this.$cell.removeClass('filterable-match');
      }
    },
    
    isMatch: function(query) {
      if (typeof this.options.isMatch === 'function') {
        this.match = this.options.isMatch(this.$cell, query);
      } else {
        query = query.replace(/[\-\[\]\/\{\}\(\)\+\?\.\\\^\$\|]/g, '\\$&');
        query = query.replace(/\*/, '.*');
        query = '.*' + query + '.*';
        var options = this.options.ignoreCase ? 'i' : '';
        var regex = new RegExp(query, options);
        this.match = regex.test(this.value()) === true;
      }
      this.setMatch(this.match);
      return this.match;
    },
    
    init: function () {
        //add 'filterable-cell' class to every editable element
        this.$cell.addClass('filterable-cell');
        
        //finilize init
        $.proxy(function() {
           /**
           Fired when element was initialized by `$().filterable()` method.
           Please note that you should setup `init` handler **before** applying `filterable`.
                          
           @event init
           @param {Object} event event object
           @param {Object} editable filterable instance (as here it cannot accessed via data('editable'))
           **/
           this.$element.triggerHandler('init', this);
        }, this);
    },
    
    /**
    Removes filterableCell from element
    @method destroy()
    **/
    destroy: function() {
      this.$cell.removeClass('filterable-cell filterable-match filterable-mismatch');
      this.$cell.removeData('fitlerableCell');
    }
  };
  
  // Initilize each filterable cell
  $.fn.filterableCell = function (option) {
    var args = arguments, datakey = 'filterableCell';
    
    //return jquery object
    return this.each(function () {
      var $this = $(this),
        data = $this.data(datakey),
        options = typeof option === 'object' && option;

      if (!data) {
        $this.data(datakey, (data = new FilterableCell(this, options)));
      }

      if (typeof option === 'string') { //call method
        data[option].apply(data, Array.prototype.slice.call(args, 1));
      }
    });
  };
  
  $.fn.filterableCell.defaults = {
    /**
    Function to determine if the cell matches the user supplied filter.

    @property isMatch($cell, query)
    @type function
    @default null
    @example
    isMatch: function($cell, query) {
      var regex = RegExp('.*' + query + '.*');
      return regex.text( cell.text() );
    }
    **/
    isMatch: null
  };
})(jQuery);
(function($) {
  'use strict';
  
  var FilterableRow = function (row, options) {
    this.$row = $(row);
    this.cells = [];
    //data-* has more priority over js options: because dynamically created elements may change data-*
    this.options = $.extend({}, $.fn.filterableRow.defaults, options);
    this.init();
  };
  
  FilterableRow.prototype = {
    constructor: FilterableRow,
    
    cell: function(index) {
      return this.cells[index];
    },
    
    setMatch: function(match) {
      if(match){
        this.$row.addClass('filterable-match');
        this.$row.removeClass('filterable-mismatch');
      } else {
        this.$row.addClass('filterable-mismatch');
        this.$row.removeClass('filterable-match');
      }
    },
    
    hasMismatch: function() {
      var nonMatch = false;
      $.each(this.cells, $.proxy(function(index, cell) {
        if($.fn.filterableutils.notNull(cell) && cell.match === false){
          nonMatch = true;
          return;
        }
      }, this));
      return nonMatch;
    },
    
    filter: function(query, index) {
      this.cells[index].isMatch(query);
      this.setMatch( !this.hasMismatch() );
    },
    
    ignoredColumn: function(index) {
      if( $.fn.filterableutils.notNull(this.options.onlyColumns) ) {
        return $.inArray(index, this.options.onlyColumns) === -1;
      }
      return $.inArray(index, this.options.ignoreColumns) !== -1;
    },
    
    init: function () {
        //add 'filterable-row' class to every filterable row
        this.$row.addClass('filterable-row');
        
        // Init Cells
        var newCell;
        this.$row.children('td').each( $.proxy(function(index, cell) {
          if(!this.ignoredColumn(index)){
            $(cell).filterableCell(this.options);
            newCell = $(cell).data('filterableCell');
          } else {
            newCell = null;
          }
          this.cells.push( newCell );
        }, this));
        
        //finilize init
        $.proxy(function() {
           /**
           Fired when row was initialized by `$().filterableRow()` method.
           Please note that you should setup `init` handler **before** applying `filterable`.
                          
           @event init
           @param {Object} event event object
           @param {Object} editable filterable instance (as here it cannot accessed via data('editable'))
           **/
           this.$row.triggerHandler('init', this);
        }, this);
    },
    
    /**
    Removes filterable row from element
    @method destroy()
    **/
    destroy: function() {
      this.$row.removeClass('filterable-row filterable-match filterable-mismatch');
      this.$row.removeData('fitlerableRow');
    }
  };
  
  // Initilize each filterable table
  $.fn.filterableRow = function (option) {
    //special API methods returning non-jquery object
    var args = arguments, datakey = 'filterableRow';
    
    //return jquery object
    return this.each(function () {
      var $this = $(this),
        data = $this.data(datakey),
        options = typeof option === 'object' && option;

      if (!data) {
        $this.data(datakey, (data = new FilterableRow(this, options)));
      }

      if (typeof option === 'string') { //call method
        data[option].apply(data, Array.prototype.slice.call(args, 1));
      }
    });
  };
  
  $.fn.filterableRow.defaults = {};
})(jQuery);
(function($) {
  'use strict';
  
  var Filterable = function (element, options) {
    this.$element = $(element);
    this.rows = null;
    //data-* has more priority over js options: because dynamically created elements may change data-*
    this.options = $.extend({}, $.fn.filterable.defaults, options);
    this.init();
  };
  
  Filterable.prototype = {
    constructor: Filterable,
    
    ignoredColumn: function(index) {
      if( $.fn.filterableutils.notNull(this.options.onlyColumns) ) {
        return $.inArray(index, this.options.onlyColumns) === -1;
      }
      return $.inArray(index, this.options.ignoreColumns) !== -1;
    },
    
    initRows: function() {
      this.rows = [];
      this.$element.children('tbody,*').children('tr').each( $.proxy(function(rowIndex, row) {
        if(rowIndex !== 0){
          $(row).filterableRow(this.options);
          this.rows.push( $(row).data('filterableRow') );
        }
      }, this));
    },
    
    typeaheadValues: function(cellIndex) {
      var keys = {};
      if( $.fn.filterableutils.isNull(this.rows) ){
        this.initRows();
      }
      $.each(this.rows, $.proxy(function(rowIndex, row) {
        keys[ row.cell(cellIndex).value() ] = '';
      }, this));
      return $.map(keys, function(value, key) {
        return key;
      });
    },
    
    filter: function(query, cellIndex) {
      if (typeof this.options.beforeFilter === 'function') {
        this.options.beforeFilter(cellIndex, query);
      }
      if($.fn.filterableutils.isNull(this.rows)){
        this.initRows();
      }
      $.each(this.rows, $.proxy(function(rowIndex, row) {
        row.filter(query, cellIndex);
      }, this));
      if (typeof this.options.afterFilter === 'function') {
        this.options.afterFilter(cellIndex, query);
      }
    },
    
    initEditable: function(editableElement, index) {
      var self = this;
      $(editableElement).editable($.extend({
        send: 'never',
        type: 'typeahead',
        emptytext: '',
        value: '',
        title: 'Enter filter for ' + $(editableElement).text(),
        display: function() {},
        source: self.typeaheadValues(index)
      }, this.options.editableOptions));
      
      $(editableElement).on('save.editable', $.proxy(function(e, params) {
        if(params.newValue === ''){
          $(editableElement).removeClass('filterable-active');
        } else {
          $(editableElement).addClass('filterable-active');
        }
        this.filter(params.newValue, index);
      }, this));
    },
    
    init: function () {
        //add 'filterable' class to every editable element
        this.$element.addClass('filterable');
        
        // Init X-editable for each heading
        this.$element.find('tr:first').first().children('td,th').each( $.proxy(function(index, heading) {
          if( !this.ignoredColumn(index) ) {
            var editableElement;
            if($.fn.filterableutils.notNull(this.options.editableSelector)) {
              editableElement = $(heading).find(this.options.editableSelector);
            }
            else {
              // No editable element defined, wrap heading content for use as editable
              editableElement =  $(heading).wrapInner('<div />').children().first();
              // Copy any data-* attributes to new <div>
              $(editableElement).data( $(heading).data() );
            }
            this.initEditable(editableElement, index);
            
            // If there is an initial filter, go ahead and filter
            var initialFilter = String($(editableElement).editable('getValue', true));
            if( initialFilter !== '' ){
              this.filter(initialFilter, index);
            }
          }
        }, this));
        
        //finilize init
        $.proxy(function() {
           /**
           Fired when element was initialized by `$().filterable()` method.
           Please note that you should setup `init` handler **before** applying `filterable`.
                          
           @event init
           @param {Object} event event object
           @param {Object} editable filterable instance (as here it cannot accessed via data('editable'))
           **/
           this.$element.triggerHandler('init', this);
        }, this);
    },
    
    /**
    Removes filterable feature from element
    @method destroy()
    **/
    destroy: function() {
      this.$element.removeClass('filterable');
      this.$element.removeData('fitlerable');
    }
  };
  
  // Initilize each filterable table
  $.fn.filterable = function (option) {
    //special API methods returning non-jquery object
    var args = arguments, datakey = 'filterable';
    
    //return jquery object
    return this.each(function () {
      var $this = $(this),
        data = $this.data(datakey),
        options = typeof option === 'object' && option;

      if (!data) {
        $this.data(datakey, (data = new Filterable(this, options)));
      }

      if (typeof option === 'string') { //call method
        data[option].apply(data, Array.prototype.slice.call(args, 1));
      }
    });
  };
  
  $.fn.filterable.defaults = {
    /**
    Column indexes to not make filterable
    @property ignoreColumns
    @type array
    @default []
    **/
    ignoreColumns: [],
    
    /**
    Column indexes to make filterable, all other columns are left non-filterable.
    **Note**: This takes presidence over <code>ignoreColumns</code> when both are provided.
    @property onlyColumns
    @type array
    @default null
    **/
    onlyColumns: null,
    
    /**
    Sets case sensitivity
    @property ignoreCase
    @type boolean
    @default true
    **/
    ignoreCase: true,
    
    /**
    Additional options for X-editable
    @property editableOptions
    @type object
    @default null
    **/
    editableOptions: null,
    
    /**
    Selector to use when making the editable item
    @property editableSelector
    @type string
    @default null
    **/
    editableSelector: null,

    /**
    Function called before filtering is done.
    @property beforeFilter(cellIndex, query)
    @default null
    @example
    beforeFilter: function(cellIndex, query) {
      // Manipulate DOM here
    }
    **/
    beforeFilter: null,

    /**
    Function called after filtering is done.
    @property afterFilter(cellIndex, query)
    @default null
    @example
    afterFilter: function(cellIndex, query) {
      // Manipulate DOM here
    }
    **/
    afterFilter: null
  };
})(jQuery);