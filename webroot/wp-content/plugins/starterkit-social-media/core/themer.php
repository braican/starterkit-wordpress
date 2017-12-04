<?php
/**
 * Theming hooks for this plugin
 */

include_once('helper.php');


if(!function_exists('sk_social_themer')) :
/**
 * Render a menu containing the social links
 * 
 * @param array $args : An array of arguments
 *  - {string} $intro_text // any intro copy to appear before the list
 *  - {bool} $new_tab // whether or not to open the social link in a new window
 *  - {string} $list_class // the class to assign to the ul element
 * 
 * @usage
 */
function sk_social_themer($args){

    if( !sk_has_social_links() ) return false;
    
    $links = get_option('sk_social');

    if($args === ''){
        $args = array();
    }

    $defaults = array(
        'intro_text' => '',
        'new_tab'    => true,
        'list_class' => 'menu'
    );

    $options = array_merge($defaults, $args);
?>
    <div class="sk-social-media-menu">
        <?php if( $options['intro_text'] !== '' ) : ?>
            <span class="sk-social-media-intro"><?php echo $options['intro_text']; ?></span>
        <?php endif; ?>
        <ul class="menu">
            <?php foreach($links as $site => $link) : if($link) : ?>
                <li><a href="<?php echo $link; ?>"<?php if( $options['new_tab'] ) echo ' target="_blank"'; ?>><?php include_svg('social--' . $site); ?></a></li>
            <?php endif; endforeach; ?>
        </ul>
    </div>
<?php
}
add_action('sk_social/render', 'sk_social_themer', 10, 3);
endif; // sk_social_themer

