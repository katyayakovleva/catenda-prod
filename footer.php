<?php
/**
 * The template for displaying the footer
 *
 * This template contains the closing of the #content div and all content after.
 * It dynamically renders the footer logo, social media links, copyright text, 
 * and footer menus using Secured Custom Fields (SCF) and WordPress functions.
 *
 * Template Features:
 * - Dynamically fetches and displays the footer logo and social media links.
 * - Supports multilingual functionality using Polylang.
 * - Displays footer menus with links grouped by categories.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

// Get the current language using Polylang.
$current_language = pll_current_language();
?>

<div class="wrapper">
        <div>
            <footer class="footer">
                <div>
                    <a
                    aria-label="Go to the main page of Catenda"
                    href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        $footer_logo = get_field('footer-logo', $current_language);
                        if( $footer_logo ):
                            $footer_logo_url = $footer_logo['url'];
                            $footer_logo_alt = $footer_logo['alt'];
                            ?>
                            <img src="<?php echo esc_url($footer_logo_url); ?>" alt="<?php echo esc_attr($footer_logo_alt); ?>">

                            <?php
                        endif; 
                        ?>
                    </a>

                    <div class="footer__media">

                    <?php

                        if( have_rows('socials', $current_language) ):

                            while( have_rows('socials', $current_language) ) : the_row();

                                $link = get_sub_field('link');
                                $icon = get_sub_field('icon');
                                if( $icon ):
                                    $url = $icon['url'];
                                    $alt = $icon['alt'];
                                endif;
                                ?>
                               
                                <a
                                aria-label="Go to Catenda social network"
                                href="<?php echo esc_attr( $link ); ?>"><img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>"></a>
                                <?php
                            endwhile;


                        endif; ?>
                   
                    </div>

                    <div class="footer__bottom-text">
                        <?php the_field('copyright', $current_language); ?>

                    </div>
                </div>

                <div class="footer__links">
                    <?php

                        if( have_rows('footer-menus', $current_language) ):

                            while( have_rows('footer-menus', $current_language) ) : the_row();

                                $menu_title = get_sub_field('menu_title');
                                ?>
                                <div>
                                    <p><?php echo $menu_title; ?></p>
                                    <?php
                                        if( have_rows('links') ):

                                            while( have_rows('links') ) : the_row(); 
                                                $link = get_sub_field('link');
                                                if( $link ): 
                                                    $link_url = $link['url'];
                                                    $link_title = $link['title'];
                                                    $link_target = $link['target'] ? "target='_blank' area-lable='".$link_title."'" : "target='_self'";
                                                    ?>
                                                    <a href="<?php echo esc_url( $link_url ); ?>" <?php echo esc_attr( $link_target ); ?>> <?php echo esc_html( $link_title ); ?></a>

                                                <?php endif;
                                            
                                        
                                              
                                          endwhile;
                                        
                                        endif;
                                    
                                    ?>
                                    
                                </div>
                                <?php
                            endwhile;

                        
                        endif; ?>

                </div>

                <div class="footer__logo_mobile">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo esc_url($footer_logo_url); ?>" alt="<?php echo esc_attr($footer_logo_alt); ?>">

                    </a>
                </div>
            </footer>
        </div>
    </div>
    <?php wp_footer(); // Hook for WordPress to include additional footer content. ?>

</body>
</html>
