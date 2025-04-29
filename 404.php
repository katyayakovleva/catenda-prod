<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * This template is used to display a custom 404 error page when a user visits a non-existent page.
 * It dynamically renders content such as error messages and navigation links using Secured Custom Fields (SCF).
 *
 * Template Features:
 * - Displays custom error messages fetched using SCF fields.
 * - Supports multilingual functionality using Polylang.
 * - Includes navigation buttons to guide users back to the main site.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

get_header('white'); // Include the white header template.

// Get the current language using Polylang.
$current_language = pll_current_language();
?>

<main>
        <div class="wrapper">
            <div>
                <section class="error-page">
                    <p><?php the_field('404_first_text', $current_language); ?></p>
                    <p class="error-page__heading">404</p>
                    <p><?php the_field('404_second_text', $current_language); ?></p>

                    <div class="error-page__buttons">
                    <?php
                    $first_link = get_field('404_first_link', $current_language);
                    if( $first_link ): 
                        $first_link_url = $first_link['url'];
                        $first_link_title = $first_link['title'];
                        ?>
                        <a href="<?php echo esc_url( $first_link_url ); ?>">
                            <span><?php echo esc_html( $first_link_title ); ?></span>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/arrow-right.svg" alt="">
                        </a>

                    <?php endif;?>
                    <?php
                    $second_link = get_field('404_second_link', $current_language);
                    if( $second_link ): 
                        $second_link_url = $second_link['url'];
                        $second_link_title = $second_link['title'];
                        ?>

                        <a href="<?php echo esc_url( $second_link_url ); ?>">
                            <?php echo esc_html( $second_link_title ); ?>
                        </a>
                    <?php endif;?>
                    </div>
                </section>

                
            </div>
        </div>

    </main>
<?php
get_footer(); // Include the footer template.
