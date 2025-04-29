<?php
/**
 * The template for displaying all pages
 *
 * This template is used to display all standard WordPress pages by default.
 * It dynamically renders the page title, subtitle, and content using Secured Custom Fields (SCF) and WordPress functions.
 * Other 'pages' on your WordPress site may use a different template if specified.
 *
 * Template Features:
 * - Dynamically fetches and displays the page title and subtitle using SCF fields.
 * - Displays the main content of the page using the WordPress content editor.
 * - Includes reusable footer blocks using a template part.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

get_header(); // Include the header template.

$subtitle = get_field('subtitle');
$title = get_field('title');
?>
<main>
        <div class="wrapper wrapper_green">
            <div>
                <section class="blog-header">
                    <div class="blog-header__top">
                        <span><?php if($subtitle){ echo esc_html( $subtitle ); }?></span>
                    </div>

                    <h1 style="padding-bottom: 0;"><?php if($title){ echo esc_html( $title ); }else{ the_title(); }?></h1>
                </section>
            </div>
        </div>

        <div class="wrapper">
            <div>
                <div class="blog-content">
                    <div>
						<?php the_content(); ?>
                        
                    </div>
                </div>

                <div>
                <?php get_template_part( 'template-parts/content', 'footer-block' ); ?>
                </div>
            </div>
        </div>
    </main>

<?php
get_footer(); // Include the footer template.