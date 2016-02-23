<?php 
/**
 * Plugin Name: Tank Social Links
 * Plugin URI: http://tankdesign.com
 * Description: Creates an admin page to edit the social links for this site, and provides a function to render the social links in a menu
 * Version: 1.0.0
 * Author: Tank Design
 * Author URI: http://tankdesign.com
 * License: GPL2
 */


/**
 * admin class -
 * TankSocialLinks
 */
class TankSocialLinks {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        $this->social_links_array = array(
            'facebook'  => array(
                'id'    => 'facebook',
                'title' => 'Facebook'
            ),
            'twitter'   => array(
                'id'    => 'twitter',
                'title' => 'Twitter'
            ),
            'instagram' => array(
                'id'    => 'instagram',
                'title' => 'Instagram'
            ),
            'linkedin'  => array(
                'id'    => 'linkedin',
                'title' => 'LinkedIn'
            )
        );

        add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
        add_action( 'admin_init', array( $this, 'init' ) );
    }

    /**
     * get the social links
     */
    public function get_social_links(){
        return $this->social_links_array;
    }

    /**
     * Add options page
     */
    public function add_admin_page() {
        add_menu_page(
            'Social Links', 
            'Social Links', 
            'manage_options', 
            'tank-social-links-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'tank_social_links' );
        ?>
        <div class="wrap">    
            <h2>Social links</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'tank_social_links_group' );   
                do_settings_sections( 'tank-social-links-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }


    /* --------------------------------------------
     * --init and setting up the sections
     * -------------------------------------------- */

    /**
     * Register and add settings
     */
    public function init() {
        register_setting(
            'tank_social_links_group', // Option group
            'tank_social_links', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'tank_social_block_setting_section', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'tank-social-links-admin' // Page
        );

        $social_links_array = $this->get_social_links();

        foreach($social_links_array as $social){
            add_settings_field(
                $social['id'],
                $social['title'],
                array($this, 'tank_social_setting_callback'),
                'tank-social-links-admin',
                'tank_social_block_setting_section',
                array( 'id' => $social['id'])
            );
        }     
    }


    /** 
     * Print the section helper text
     */
    public function print_section_info() {
        print '<p>Add links to your social media pages here.</p><p><em><strong>IMPORTANT:</strong> All links must start with a leading <code>http://</code> or <code>https://</code>.</em></p>';
    }


    /* --------------------------------------------
     * --sanitazion
     * -------------------------------------------- */

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        $new_input = array();

        $social_links_array = $this->get_social_links();

        foreach($social_links_array as $social){
            $id = $social['id'];

            if(isset($input[$id])){
                $new_input[$id] = sanitize_text_field($input[$id]);
            }
        }

        return $new_input;
    }



    /* --------------------------------------------
     * --callbacks
     * -------------------------------------------- */

    /**
     * callback function for the social links
     */
    public function tank_social_setting_callback($args){
        $id = $args['id'];

        printf(
            '<input type="text" id="' . $id . '" name="tank_social_links[' . $id . ']" value="%s" />',
            isset( $this->options[$id] ) ? esc_attr( $this->options[$id]) : ''
        );
    }
}

if( is_admin() ){
    $my_settings_page = new TankSocialLinks();
}


/* --------------------------------------------
 * --front-end rendering
 * -------------------------------------------- */



/**
 * render a menu containing the social links
 *
 * @param $args (array) // an array of arguments:
 *    - intro_text (string): any intro copy to appear before the list
 */
function tank_social_links__menu( $args = array() ){
    if( tank_social_links__has_social_links() ) :
        $links = get_option('tank_social_links');

        $defaults = array(
            'intro_text' => ''
        );

        $options = array_merge($defaults, $args);
    ?>
        <div class="tank-social-links--menu">
            <?php if( $options['intro_text'] !== '' ) : ?>
                <span class="tank-social-links--intro"><?php echo $options['intro_text']; ?></span>
            <?php endif; ?>
            <ul class="menu">
                <?php foreach($links as $site => $link) : if($link) : ?>
                    <li><a href="<?php echo $link; ?>"><?php include_svg('social--' . $site); ?></a></li>
                <?php endif; endforeach; ?>
            </ul>
        </div>
<?php 
    endif;
}

/**
 * helper function to check to see if there are any social links
 *  filled out
 */
function tank_social_links__has_social_links(){
    $links = get_option('tank_social_links');

    foreach($links as $l){
        if($l) return true;
    }

    return false;
}







