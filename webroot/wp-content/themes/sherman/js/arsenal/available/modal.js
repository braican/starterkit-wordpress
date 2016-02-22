//
// modal
//
(function(SK, $, undefined){


    /**
     * --modal
     */
    SK.modal = (function(){

        var ACTIVE_CLASS    = 'visible',
            MODAL_ID        = 'l-modal',

            // jquery objects
            $body,
            $modal;


        /**
         * initialize the modal, including grabbing the modal div and
         *  setting up event listeners
         */
        function init(){
            $modal = $('#' + MODAL_ID);
            $body = $('body');

            //
            // trigger the launch of a modal
            //
            $('.js-launch-modal').on('click', function(event) {
                event.preventDefault();
                var modal        = $(this).data('modal'),
                    modalContent = $('#' + modal).html();

                create(modalName, modalContent);
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
         * load and create
         *
         * @param name (string)
         *   - the filename of the modal content you're looking to
         *      load up
         *
         * @param content (string)
         *   - markup comtaining the modal content
         */
        function create(name, content){

            close();

            var classes = 'modal--' + name;

            if( $modal.length === 0 ){
                $modal = $('<div id="' + MODAL_ID + '" class="' + classes + '" />').appendTo( $body );
                $modal.append( '<div class="modal-content">' + content + '</div>' );
            } else {
                $modal.removeClass().addClass(classes).empty().html( content );
            }

        }


        return {
            // set up the modal jquery object and init event listeners
            init   : init, 

            // creates and enables the basic modal
            create : create,

            // close the regular modal
            close  : close
        };
    })(); // modal

})(window.SK = window.SK || {}, jQuery);