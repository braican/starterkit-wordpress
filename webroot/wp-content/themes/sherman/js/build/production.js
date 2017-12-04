(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Modal = function Modal() {
    _classCallCheck(this, Modal);

    this.modal_id = 'sk-modal';
    this.active_class = 'visible';

    this.body = document.body;

    console.log('test');
};

exports.default = Modal;

// var modal = (function () {

//     var ACTIVE_CLASS = 'visible',
//         MODAL_ID = 'sk-modal',

//         // the body
//         $body,

//         // the modal wrapper
//         $modal,

//         // the modal target, so where the content goes
//         $target;


//     /**
//      * initialize the modal, including grabbing the modal div and
//      *  setting up event listeners
//      */
//     function init() {

//         // set up the body var
//         $body = $('body');

//         $modal = $('#' + MODAL_ID);

//         $target = $modal.find('.modal-content');


//         //
//         // build
//         //
//         if ($modal.length === 0) {
//             $modal = $('<div id="' + MODAL_ID + '" />').appendTo($body);
//             $target = $('<div class="modal-content" />').appendTo($modal);
//         }


//         //
//         // a modal can be launched from a trigger that defines a
//         //  "data-modal" parameter, which references the id of
//         //  some html already in the dom that contains the modal
//         //  markup.
//         //
//         // @usage
//         //
//         // <a href="#" data-modal="test-modal">Launch</a>
//         // <div id="test-modal">
//         //   This is some content for the modal
//         // </div>
//         //
//         $('[data-modal]').on('click', function (event) {
//             event.preventDefault();
//             var modalName = $(this).data('modal'),
//                 modalContent = $('#' + modal).html();

//             launch(modalName, modalContent);
//         });

//         //
//         // close the modal
//         //
//         $body.on('click', '.js-close-modal', close);
//     }

//     /**
//      * close the modal
//      *
//      * @param event (object)
//      *   - if this function call comes from an event listener,
//      *      prevent the default action
//      */
//     function close(event) {
//         if (event)
//             event.preventDefault();

//         $modal.removeClass(ACTIVE_CLASS);
//     }


//     /* --------------------------------------------
//      * --the modal rendering
//      * -------------------------------------------- */

//     /**
//      * load and launch
//      *
//      * @param string name    : The name of the modal
//      * @param string content : Markup comtaining the modal content
//      */
//     function launch(name, content) {

//         close();

//         var classes = 'modal--' + name;

//         $target.empty().html(content);

//         $modal.removeClass().addClass(classes);
//         $modal.addClass(ACTIVE_CLASS);
//     }


//     return {
//         // set up the modal jquery object and init event listeners
//         init: init,

//         // launches and enables the basic modal
//         launch: launch,

//         // close the regular modal
//         close: close
//     };

// })(); // modal

},{}],2:[function(require,module,exports){
'use strict';

var _modal = require('../arsenal/modal');

var _modal2 = _interopRequireDefault(_modal);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
    $(document).ready(function () {
        SK.init();

        var t = new _modal2.default();
    });
})(window.SK = window.SK || {}, jQuery); //
// imports
//

},{"../arsenal/modal":1}]},{},[2])

//# sourceMappingURL=production.js.map
