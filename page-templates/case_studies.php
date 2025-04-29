<?php
/**
 * Template Name: Case Studies
 *
 * This template is used to display the "Case Studies" page in the Catenda theme.
 * It dynamically renders a hero section and a list of case studies using Secured Custom Fields (SCF) 
 * and WordPress functions.
 *
 * Template Features:
 * - Dynamically fetches and displays the hero section with a title, subtitle, and description.
 * - Displays a list of case studies with featured images, titles, and "Learn More" links.
 * - Includes a swiper slider for navigating through case studies.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package Catenda
 */

get_header('white'); // Include the white header template.
$current_language = pll_current_language(); // Get the current language using Polylang.

$subtitle = get_field('subtitle');
$title = get_field('title');
$description = get_field('text');
?>

<main>
        <div class="wrapper">
            <div>
                <section class="partner-hero">

                    <p class="PT-text PT-text_green"><?php if($subtitle){ echo esc_html( $subtitle ); }?></p>
                    <h1 class="fade" style="transition-delay: 0.1s;"><?php if($title){ echo esc_html( $title ); }else{ the_title(); }?></h1>
                    <p class="partner-hero__description fade" style="transition-delay: 0.3s;"><?php if($description){ echo esc_html( $description ); }?></p>

                    <div class="integrations">
                        <div class="swiper case-swiper swiper_partner">
                            <div class="swiper-wrapper">
                            <?php 

                            $args = array(
                                'post_type' => 'case',
                                //'order'    => 'ASC',
                                'posts_per_page' => -1,
                            );              



                            $the_query = new WP_Query( $args );
                            $n = 0;
                            $count = $the_query->found_posts;
                            ?>
                                <?php if($the_query->have_posts() ) : ?>

                                <?php  while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                <?php if(($n)%3 == 0): ?><div class="swiper-slide"><?php endif;?>
                                    <div class="fade">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($post->ID);?>" alt="<?php the_title(); ?>">
                                    <?php else:?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/default.jpg" alt="<?php the_title(); ?>">
                                    <?php endif;?>
                                        <p><?php the_title(); ?></p>
                                        <div class="learn-more-btn"><a href="<?php echo get_permalink($post->ID ); ?>"><?php the_field('learn_more', $current_language); ?></a>
                                            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.10547 1.1123L5.94357 5.9504L1.10547 10.7885" stroke="#004A42"
                                                    stroke-width="1.5" />
                                            </svg>
            
                                        </div>
                                    </div>
                                    <?php $n++; if(($n)%3 == 0 || $n == $count): ?></div><?php endif;?>
                                
                                <?php
                                
                                endwhile; 
                            wp_reset_postdata(); 
                            endif;
                            ?>    
                                                
                            </div>
                            <div class="pagination-wrapper">
                            <div class="swiper-pagination"></div>

                            <div class="swiper-button-prev">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16 6.99902H3.83L9.42 1.40902L8 -0.000976562L0 7.99902L8 15.999L9.41 14.589L3.83 8.99902H16V6.99902Z"
                                        fill="#F8F9F7" />
                                </svg>
                            </div>

                            <div class="swiper-button-next">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.29425e-05 6.414L11.5861 6.414L7.08606 1.914L8.50006 0.5L15.4141 7.414L8.50006 14.328L7.08606 12.914L11.5861 8.414H6.29425e-05V6.414Z"
                                        fill="white" />
                                </svg>
                            </div>
                        </div>
                        </div>
                    </div>


                </section>

            
                <div>
                <?php get_template_part( 'template-parts/content', 'footer-block' ); ?>
                </div>
            </div>
        </div>

    </main>

<?php
get_footer(); // Include the footer template.