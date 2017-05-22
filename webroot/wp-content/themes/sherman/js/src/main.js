
//
// namespace - SK
//

(function(SK, $, undefined){

    var $window;


    /* --------------------------------------------
     * --util
     * -------------------------------------------- */


    /**
     * Creates and returns a new, throttled version of the passed
     *  function, that, when invoked repeatedly, will only actually
     *  call the original function at most once per every 'threshold'
     *  milliseconds. Useful for rate-limiting events that occur
     *  faster than you can keep up with.
     * @link - https://remysharp.com/2010/07/21/throttling-function-calls
     */
    function throttle(fn, threshhold, scope) {
      threshhold || (threshhold = 250);
      var last,
          deferTimer;
      return function () {
        var context = scope || this;

        var now = +new Date,
            args = arguments;
        if (last && now < last + threshhold) {
          // hold on to it
          clearTimeout(deferTimer);
          deferTimer = setTimeout(function () {
            last = now;
            fn.apply(context, args);
          }, threshhold);
        } else {
          last = now;
          fn.apply(context, args);
        }
      };
    }

    /* --------------------------------------------
     * --func
     * -------------------------------------------- */




    /* --------------------------------------------
     * --public
     * -------------------------------------------- */

    //
    // init the things
    //
    SK.init = function(){

        // initialize some globals
        $window = $(window);

    }


    // -------------------------------
    // DOM ready
    //
    $(document).ready(function(){
        SK.init();
    });

})(window.SK = window.SK || {}, jQuery);
