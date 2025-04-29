<?php
/**
 * Template Name: Book a Demo
 *
 * This template is used to display the "Book a Demo" page in the Catenda theme.
 * It dynamically renders the hero section with a title, subtitle, description, 
 * an image, and a form using Secured Custom Fields (SCF).
 *
 * Template Features:
 * - Dynamically fetches and displays content using SCF fields.
 * - Includes a form for users to book a demo, rendered using a shortcode.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package Catenda
 */

get_header(); // Include the header template.

$subtitle = get_field('subtitle');
$title = get_field('title');
$description = get_field('text');
$image = get_field('image');
$form = get_field('form');
?>
<main>
        <div class="wrapper wrapper_green">
            <div>
                <section class="demo-hero">
                    <div class="hero__left">
                        <h4><?php if($subtitle){ echo esc_html( $subtitle ); }?></h4>
                        <h1><?php if($title){ echo esc_html( $title ); }else{ the_title(); }?></h1>
                        <p class="hero__left-description"><?php if($description){ echo esc_html( $description ); }?></p>

						<div class="form">
							<?php echo do_shortcode($form);?>
							 
						</div>
                    </div>

                    <div style="padding: 0; margin: 0; max-height: unset;">
                        <?php if ( $image ) : 
                            $image_url = $image['url'];
                            $image_alt = $image['alt'];
                            ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        <?php endif;?>
                      
                    </div>
                </section>
            </div>
        </div>
    </main>

<?php
get_footer(); // Include the footer template.