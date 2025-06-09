<?php
/**
 * The header for the Catenda theme
 *
 * This template displays the <head> section and everything up until <div id="content">.
 * It includes the site logo, navigation menus, language switcher, and other header elements.
 *
 * Template Features:
 * - Dynamically fetches the site logo and navigation menus using WordPress functions.
 * - Supports multilingual functionality using Polylang.
 * - Includes a responsive burger menu for mobile navigation.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

// Get the current language using Polylang.
$current_language = pll_current_language();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
  rel="preload"
  as="style"
  href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
  onload="this.onload=null;this.rel='stylesheet'"
/>
<noscript>
  <link
    href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet"
  />
</noscript>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); // Add dynamic body classes. ?>>
<?php wp_body_open(); // Hook for WordPress to include content immediately after the opening <body> tag. ?>

	<div class="wrapper wrapper_header">
        <div>
            <header class="header">
                <a
                href="<?php echo esc_url( home_url( '/' ) ); ?>"
                aria-label="Go to the main page of Catenda"
                class="header__logo">
                <?php
                $header_logo = get_field('header_logo_white', $current_language);
                if( $header_logo ):
                    $header_logo_url = $header_logo['url'];
                    $header_logo_alt = $header_logo['alt'];
                    ?>
                    <img loading="lazy" src="<?php echo esc_url($header_logo_url); ?>" alt="<?php echo esc_attr($header_logo_alt); ?>">

                    <?php
                endif; 
                ?>
                </a>

                
                <nav class="header__nav">
                    <?php 
                    wp_nav_menu(
                    array(
                        'theme_location' => 'menu-primary',
                        'menu_id'        => 'menu-primary',
                        'container'            => ' ',
                        'container_class'      => '',
                        'container_id'         => '',
                        'container_aria_label' => '',
                        'menu_class'           => '',
                        'menu_id'              => '',
                        'echo'                 => true,
                        'fallback_cb'          => 'wp_page_menu',
                        'before'               => '',
                        'after'                => '',
                        'link_before'          => '',
                        'link_after'           => '',
                        'items_wrap'           => '<ul class="%2$s">%3$s</ul>',
                        'item_spacing'         => 'preserve',
                        'depth'                => 0,
                        'walker'               => new Catenda_Menu_Walker_Desktop(),
                    )
                    );
                    ?>
                 
                </nav>

                <div class="header__right">
                    <?php
                    $log_in = get_field('log_in', $current_language);
                    if( $log_in ): 
                        $log_in_url = $log_in['url'];
                        $log_in_title = $log_in['title'];
                        $log_in_target = $log_in['target'] ? $log_in['target'] : '_self';
                        ?>
                        <a href="<?php echo esc_url( $log_in_url ); ?>" target="<?php echo esc_attr( $log_in_target ); ?>"> <?php echo esc_html( $log_in_title ); ?></a>
                        <!-- <span><?php echo esc_html( $log_in_title ); ?></span> -->

                    <?php endif;?>
                    <?php
                    $button = get_field('button', $current_language);
                    if( $button ): 
                        $button_url = $button['url'];
                        $button_title = $button['title'];
                        $button_target = $button['target'] ? $button['target'] : '_self';
                      
			        ?>
                        <a href ="<?php echo esc_url( $button_url ); ?>" class="header__right-button header__right-button_green"><?php echo esc_html( $button_title ); ?></a>
                    <?php endif;?>
                    <div class="header__languages">
                        <a role="button">
                            <span><?php echo strtoupper( $current_language ) ?></span>
                            <button aria-label="expand the menu">
                                <img loading="lazy"
                                src="<?php echo get_template_directory_uri(); ?>/img/arrow-bottom.svg"
                                alt=""
                                aria-hidden="true">
                            </button>
                        </a>
                        <?php 
                         $languages =  pll_the_languages( array( 'raw' => 1 , 'hide_current' => 1 )  );
                        ?>
                        <div>
                            <div>
                                <?php foreach ( $languages as $lang ) { ?>
                                <a href="<?php echo $lang['url']; ?>"><?php echo strtoupper($lang['slug']); ?></a>
                                <?php } ?>
                             
                            </div>
                        </div>
                    </div>

                    <div class="burger">
                        <div class="burger__icon">
                            <div class="line1"></div>
                            <div class="line2"></div>
                            <div class="line3"></div>
                        </div>
                        <div class="burger__menu">
                            <div class="wrapper">
                            <?php 
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'menu-primary-mobile',
                                        'menu_id'        => 'menu-primary-mobile',
                                        'container'            => ' ',
                                        'container_class'      => '',
                                        'container_id'         => '',
                                        'container_aria_label' => '',
                                        'menu_class'           => '',
                                        'menu_id'              => '',
                                        'echo'                 => true,
                                        'fallback_cb'          => 'wp_page_menu',
                                        'before'               => '',
                                        'after'                => '',
                                        'link_before'          => '',
                                        'link_after'           => '',
                                        'items_wrap'           => '<ul class="%2$s">%3$s</ul>',
                                        'item_spacing'         => 'preserve',
                                        'depth'                => 0,
                                        'walker'               => new Catenda_Menu_Walker_Mobile(),
                                    )
                                );
                            ?>

                                
                                       

                     
                            </div>
                        </div>
                    </div>

            </header>
        </div>
    </div>
    
    <style>
        .wrapper_header-white .burger__menu.active::before {
            content: "";
            position: absolute;
            width: 127px;
            height: 26px;
            left: 24px;
            top: 19px;
            background: url("<?php echo esc_url($header_logo_url); ?>");
            z-index: 99999;
        }
     </style> 
