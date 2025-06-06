<?php
/**
 * Archive Page Template
 *
 * This template is used to display archive pages in the Catenda theme.
 * It dynamically renders content such as a glossary, search functionality, 
 * and footer blocks using Secured Custom Fields (SCF) and WordPress functions.
 *
 * Template Features:
 * - Displays a glossary with alphabetical navigation.
 * - Includes a search form for filtering posts.
 * - Dynamically fetches and displays footer blocks.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

get_header();

// Get the current language using Polylang.
$current_language = pll_current_language();

// Get the page assigned for posts in WordPress settings.
$page_for_posts = get_option('page_for_posts');

// Check if the glossary is enabled for the current language.
$allow_glossary = get_field('allow_glossary', $current_language);
if ($allow_glossary) {
    // Fetch sorted post IDs for the current language.
    $sorted_post_ids = get_sorted_post_ids_by_language($current_language);
} else {
    // Fetch sorted post IDs without language filtering.
    $sorted_post_ids = get_sorted_post_ids_by_language();
}

$subtitle = get_field('subtitle', $page_for_posts);
$title = get_field('title', $page_for_posts);
$description = get_field('text', $page_for_posts);


?>
<script>

</script>
<main>
        <div class="wrapper wrapper_green">
            <div>
                <section class="glossary-top">
                    <h4 class="PT-text"> <?php if($subtitle){ echo esc_html( $subtitle ); }?></h4>
                    <h1><?php if($title){ echo esc_html( $title ); }else{ the_title(); }?></h1>
                    <p class="glossary-top__description"><?php if($description){ echo esc_html( $description ); }?></p>
                    <div class="glossary-top__search">
                        <form>
                            <input type="text" id="search-text" name="s" placeholder="Search glossary">
                            <button type="submit" tabindex="0" >Search</button>
                        </form>
                    </div>

                    <div class="glossary-top__letters">
                        <a href="" class="available-letter all">All</a>
						<?php 
						$alphabet = range('a', 'z');
						array_unshift($alphabet, '0-9'); 

						foreach ($alphabet as $letter) {
							if (isset($sorted_post_ids[$letter])) {
								echo '<a class="available-letter" href="#'.strtoupper($letter).'">'.strtoupper($letter).'</a>';
							} else {
								echo '<a>'.strtoupper($letter).'</a>';
							}
						}
						
						?>
                        
                        
                    </div>
                </section>
            </div>
        </div>

        <div class="wrapper">
            <div>

                <section class="glossary-content">
					<?php 
					if($s){ 
                        
                        $args = array(
                            'post_type'      => 'post',
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                            's'              => $s,
                        );
                        
                        $posts_s=new WP_Query($args);
                        ?>
                        <div class="glossary-content__item" style="scroll-margin-top: 4em;">
							<div>
								<?php echo $s; ?>
							</div>

							<div id="digits-container">

							<?php while ($posts_s->have_posts()) : $posts_s->the_post();  ?>
								<div>
									<a href="<?php echo get_permalink(); ?>">
										<?php echo get_the_title();?>
									</a>
								</div>
								<?php endwhile; ?>
							</div>
						</div>
                   <?php } else { ?>
 					
                    <?php foreach ($sorted_post_ids as $letter => $ids) { ?>
						<div class="glossary-content__item" id="<?php echo strtoupper($letter); ?>" style="scroll-margin-top: 4em;">
							<div>
								<?php echo strtoupper($letter); ?>
							</div>

							<div id="digits-container">
								
							<?php foreach ($ids as $id) {  ?>
								<div>
									<a href="<?php echo get_permalink( $id ); ?>">
										<?php echo get_the_title($id);?>
									</a>
								</div>
								<?php } ?>
							</div>
						</div>
					
					<?php 
					}
                }
					?>
                    
                </section>

                <div>
                <?php
    
    if( have_rows('footer_block',$page_for_posts) ):

        while ( have_rows('footer_block', $page_for_posts) ) : the_row();

            if( get_row_layout() == 'bool_a_demo' ): 
                $book_a_demo_block = get_sub_field('book_a_demo_block', $page_for_posts);

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
				$subscribtion_block = get_sub_field('subscribtion_block', $page_for_posts);
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
                </div>
            </div>
        </div>
    </main>
<?php
get_footer(); // Include the footer template.