<?php
/**
 * Template part for displaying footer blocks
 *
 * This template dynamically renders footer blocks such as "Book a Demo" and "Subscription" 
 * using Secured Custom Fields (SCF). It supports multilingual functionality using Polylang.
 *
 * Template Features:
 * - Dynamically fetches and displays footer blocks using SCF fields.
 * - Includes a "Book a Demo" block with a title, description, button, and image.
 * - Includes a "Subscription" block with a title, description, form, and image.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

?>


<?php
    
    if( have_rows('footer_block') ):

        while ( have_rows('footer_block') ) : the_row();

            if( get_row_layout() == 'bool_a_demo' ): 
                $book_a_demo_block = get_sub_field('book_a_demo_block');

            ?>
			<section class="cta">

				<div>
					<p class="PT-text fade"><?php echo esc_html( $book_a_demo_block['subtitle'] ); ?></p>
					<h2 class="cta__heading fade"><?php echo esc_html( $book_a_demo_block['title'] ); ?></h2>
					<div class="cta__description fade"><?php echo esc_html( $book_a_demo_block['text'] ); ?></div>
					<a href="<?php echo esc_url( $book_a_demo_block['link']['url'] ); ?>" class="cta__button">
						<span><?php echo esc_html( $book_a_demo_block['link']['title'] ); ?></span>
						<img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/arrow-right.svg" alt="">
					</a>
				</div>
				<div>
					<img loading="lazy" class="fade" src="<?php echo esc_url($book_a_demo_block['image']['url']); ?>" alt="<?php echo esc_attr($book_a_demo_block['image']['alt']); ?>">
				</div>
			</section>

			<?php
			elseif( get_row_layout() == 'subscribtion' ): 
				$subscribtion_block = get_sub_field('subscribtion_block');
			?>
		<section class="cta" style="text-align: left;">
			<div>
			

				<p class="PT-text"><?php echo esc_html( $subscribtion_block['subtitle'] ); ?></p>
				<h2 class="cta__heading"><?php echo esc_html( $subscribtion_block['title'] ); ?></h2>
				<div class="cta__description"><?php echo esc_html( $subscribtion_block['text'] ); ?></div>
				<div class="subscribtion-form form">
					<?php echo do_shortcode($subscribtion_block['form']);?>

				</div>
			</div>
			<div>
				<img loading="lazy" src="<?php echo esc_url($subscribtion_block['image']['url']); ?>" alt="<?php echo esc_attr($subscribtion_block['image']['alt']); ?>">
			</div>
		</section>

            <?php
                endif;

            endwhile;

        endif;
    ?>
