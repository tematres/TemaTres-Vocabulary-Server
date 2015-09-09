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