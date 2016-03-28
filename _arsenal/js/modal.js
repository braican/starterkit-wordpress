//
// modal
//
(function(SK, $, undefined){


    /**
     * --modal
     */
    var modal = (function(){

        var ACTIVE_CLASS    = 'visible',
            MODAL_ID        = 'sk-modal',

            // the body
            $body,

            // the modal wrapper
            $modal,

            // the modal target, so where the content goes
            $target;


        /**
         * initialize the modal, including grabbing the modal div and
         *  setting up event listeners
         */
        function init(){

            // set up the body var
            $body = $('body');

            $modal = $('#' + MODAL_ID);
            
            $target = $modal.find('.modal-content');


            //
            // build
            //
            if( $modal.length === 0 ){
                $modal = $('<div id="' + MODAL_ID + '" />').appendTo( $body );
                $target = $( '<div class="modal-content" />' ).appendTo( $modal );
            }


            //
            // a modal can be launched from a trigger that defines a
            //  "data-modal" parameter, which references the id of
            //  some html already in the dom that contains the modal
            //  markup.
            //
            // @usage
            // <a href="#" data-modal="test-modal">Launch</a>
            // <div id="test-modal">
            //   This is some content for the modal
            // </div>
            //
            $('[data-modal]').on('click', function(event) {
                event.preventDefault();
                var modalName    = $(this).data('modal'),
                    modalContent = $('#' + modal).html();

                launch(modalName, modalContent);
            });

            //
            // close the modal
            //
            $body.on('click', '.js-close-modal', close);
        }

        /**
         * close the modal
         *
         * @param event (object)
         *   - if this function call comes from an event listener,
         *      prevent the default action
         */
        function close( event ){
            if(event)
                event.preventDefault();

            $modal.removeClass( ACTIVE_CLASS );            
        }


        /* --------------------------------------------
         * --the modal rendering
         * -------------------------------------------- */

        /**
         * load and launch
         *
         * @param name (string)
         *   - the filename of the modal content you're looking to
         *      load up
         *
         * @param content (string)
         *   - markup comtaining the modal content
         */
        function launch(name, content){

            close();

            var classes = 'modal--' + name;

            $target.empty().html( content );

            $modal.removeClass().addClass(classes);
            $modal.addClass( ACTIVE_CLASS );
        }


        return {
            // set up the modal jquery object and init event listeners
            init   : init, 

            // launches and enables the basic modal
            launch : launch,

            // close the regular modal
            close  : close
        };

    })(); // modal


    //
    // expose the modal object in the namespace for use elsewhere
    //
    SK.modal = modal;


    $(document).ready(function() {
        modal.init();
    });

})(window.SK = window.SK || {}, jQuery);