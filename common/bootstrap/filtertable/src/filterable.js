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