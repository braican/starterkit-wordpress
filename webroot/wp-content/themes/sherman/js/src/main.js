//
// imports
//
import Modal from '../arsenal/modal';

//
// namespace - SK
//

(function (SK, $) {
    /* --------------------------------------------
     * --public
     * -------------------------------------------- */

    //
    // init the things
    //
    SK.init = function () {};


    // -------------------------------
    // DOM ready
    //
    $(document).ready(() => {
        SK.init();

        const t = new Modal();
    });
}(window.SK = window.SK || {}, jQuery));
