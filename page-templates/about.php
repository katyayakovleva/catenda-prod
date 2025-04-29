<?php
/**
 * Template Name: About
 *
 * This template is used to display the "About" page in the Catenda theme.
 * It dynamically renders sections such as the hero banner, metrics, benefits, locations, 
 * and events using Secured Custom Fields (SCF) and WordPress functions.
 *
 * Template Features:
 * - Dynamically fetches and displays content blocks using SCF fields.
 * - Supports multilingual functionality using Polylang.
 * - Includes reusable footer blocks for consistent design.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package Catenda
 */

get_header(); // Include the header template.
$current_language = pll_current_language(); // Get the current language using Polylang.
?>
    <main>
        
        <div class="wrapper wrapper_green">
            <div>
                <section class="about-hero">
                <?php $banner_block = get_field('hero_block'); ?>
                    <p class="PT-text fade"><?php echo esc_html($banner_block['subtitle']); ?></p>
                    <div class="about-hero__top fade-container">
                        <h1 class="fade"><?php echo $banner_block['title']; ?></h1>
                        <p class="fade"><?php echo $banner_block['text']; ?></p>
                    </div>
                    <?php if($banner_block['image']){?>
                    <img src="<?php echo esc_url($banner_block['image']['url']); ?>" class="fade" alt="<?php echo esc_url($banner_block['image']['title']); ?>">
                    <?php } ?>
                    <div class="about-hero__metrics fade-container">
                    <?php $countdown_block = get_field('countdown_block'); ?>
                    <?php 
                        $first_block = $countdown_block['first_block'];
                        $second_block = $countdown_block['second_block'];
                        $third_block = $countdown_block['third_block'];
                    ?>
                        <div class="fade">
                            <div>
                                <?php
                                    $countdown_value = $first_block['countdown_value'];
                                ?>
                                <h3 class="counter" data-suffix="<?php echo $countdown_value['suffix']; ?>" style="--initialValue: <?php echo $countdown_value['initial']?>; --finalValue: <?php echo $countdown_value['final']?>;"></h3>
                                <p><?php echo $first_block['text']; ?></p>
                            </div>
                        </div>

                        <div class="fade">
                            <div>
                                <?php
                                    $countdown_value = $second_block['countdown_value'];
                                ?>
                                <h3 class="counter" data-suffix="<?php echo $countdown_value['suffix']; ?>" style="--initialValue: <?php echo $countdown_value['initial']?>; --finalValue: <?php echo $countdown_value['final']?>;"></h3>
                                <p><?php echo $second_block['text']; ?></p>
                            </div>
                        </div>

                        <div class="fade">
                            <div>
                                <?php
                                    $countdown_value = $third_block['countdown_value'];
                                ?>
                                <h3 class="counter" data-suffix="<?php echo $countdown_value['suffix']; ?>" style="--initialValue: <?php echo $countdown_value['initial']?>; --finalValue: <?php echo $countdown_value['final']?>;"></h3>
                                <p><?php echo $third_block['text']; ?></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="wrapper">
            <div>
            <div>
            <section class="openness openness_pt-120">
                <?php $about_block = get_field('about_block'); ?>
                    <p class="PT-text PT-text_green fade"><?php echo $about_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2 style="padding-bottom: 64px;"><?php echo $about_block['title']; ?></h2>
                    </div>
                    <div class="openness__items fade-container">
                    <?php $benefits_about =  $about_block['benefits_about']; 
                        if( $benefits_about ){

                            foreach( $benefits_about as $benefit ) {

                                $icon = $benefit['icon'];
                                $title = $benefit['title'];
                                $description = $benefit['text'];

                            ?>

                        <div class="fade" style="transition-duration: 0.5s;">
                            <div>
                                <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_url($icon['title']); ?>">
                            </div>
                            <b role="heading" aria-level="3"><?php echo esc_html( $title ); ?></b>
                            <p><?php echo esc_html( $description ); ?></p>
                        </div>
                            <?php }
                        }?>
                    </div>
                </section>

                <section class="location">
                <?php $locations_block = get_field('locations_block'); ?>

                    <p class="PT-text PT-text_green fade"><?php echo $locations_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2><?php echo $locations_block['title']; ?></h2>
                    </div>
                    <div class="location__items fade-container">
                    <?php $locations =  $locations_block['locations']; 
                        if( $locations ){

                            foreach( $locations as $location ) {

                                $name = $location['name'];
                                $address = $location['address'];

                            ?>
                            <div class="fade">
                                <p><?php echo esc_html( $name ); ?></p>
                                <p><?php echo esc_html( $address ); ?></p>
                            </div>
                        
                            <?php }
                        }?>
                        
                    </div>
                </section>

                <section class="stories">
                <?php $events_block = get_field('events_block'); ?>
                    <p class="PT-text PT-text_green fade"><?php echo $events_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2><?php echo $events_block['title']; ?></h2>
                    </div>
                    <?php 

                    $args = array(
                        'post_type' => 'event',
                        'posts_per_page' => -1,
                    );              



                    $the_query = new WP_Query( $args );
                    
                    ?>
                        
                    <div class="stories__items fade-container">
                        <?php if($the_query->have_posts() ) : ?>

                        <?php  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="fade">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <img src="<?php echo get_the_post_thumbnail_url($post->ID);?>" alt="<?php the_title(); ?>">
                            <?php endif;?>
                            <p><?php the_title(); ?></p>
                            <div class="learn-more-btn"><?php if( get_field('active') ) { echo '<a  href="'.esc_attr( get_field('link')).'">'.get_field('learn_more', $current_language).'</a>';} else { echo '<a disabled>'.get_field('coming_soon', $current_language).'</a>';} ?>
                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.10547 1.1123L5.94357 5.9504L1.10547 10.7885" stroke="#004A42"
                                        stroke-width="1.5" />
                                </svg>

                            </div>
                        </div>

                        
                        <?php
                        
                            endwhile; 
                             wp_reset_postdata(); 
                            endif;
                        ?>  
                    </div>
                </section>
                

       
                    <?php get_template_part( 'template-parts/content', 'footer-block' ); ?>
                </div>
            </div>

        </div>
    </main>

<?php
get_footer(); // Include the footer template.