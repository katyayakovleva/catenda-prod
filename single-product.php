<?php
/**
 * Single Product Template
 *
 * This template is used to display individual product pages in the Catenda theme.
 * It dynamically renders content blocks such as hero sections, benefits, main content, 
 * partners, and case studies using Advanced Custom Fields (ACF).
 *
 * Template Features:
 * - Dynamically fetches and displays product-specific content using ACF fields.
 * - Supports multilingual functionality using Polylang.
 * - Includes reusable footer blocks for consistent design.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package Catenda
 */

get_header('white'); // Include the white header template.

// Get the current language using Polylang.
$current_language = pll_current_language();
?>

<main>
    <?php
    
        if( have_rows('product_content_blocks') ):

            while ( have_rows('product_content_blocks') ) : the_row();

                if( get_row_layout() == 'hero' ): 
                    $content = get_sub_field('content');
                    $subtitle = $content['subtitle'];
                    $title = $content['title'];
                    $text = $content['text'];
                    $link = $content['link'];
                    $image = get_sub_field('image');
                ?>
                <div class="wrapper">
                    <div>
                        <section class="hero hero_product">
                            <div class="hero__left">
                                <h4><?php if($subtitle){ echo esc_html( $subtitle ); }?></h4>
                                <h1 class="fade" style="transition-delay: 0.1s;"><?php if($title){ echo esc_html( $title ); }?></h1>
                                <p class="hero__left-description fade" style="transition-delay: 0.3s;"><?php if($text){ echo esc_html( $text ); }?></p>
                               <?php if( $link ){
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"> <span><?php echo esc_html( $link_title ); ?></span>
                                    <img src="<?php echo get_template_directory_uri();?>/img/arrow-right_white.svg" alt=""></a>

                                <?php } ?>
                                
                            </div>

                            <div>
                                <?php if( $image ){
                                $image_url = $image['url'];
                                $image_alt = $image['alt'];
                                ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="fade parallax show" data-direction="up" data-speed="0.1" style="transform: translateY(0px);">

                                <?php } ?>
                            </div>
                        </section>
                    </div>
                </div>

                <?php
                elseif( get_row_layout() == 'benefits_block' ): 
                    $subtitle = get_sub_field('subtitle');
                    $title = get_sub_field('title');
                    $benefits = get_sub_field('benefits'); 
                    ?>
                    <div class="wrapper">
                        <div>
                            <section class="openness">
                                <p class="PT-text PT-text_green fade"><?php if($subtitle){ echo esc_html( $subtitle ); }?></p>
                                <div class="main-heading fade">
                                    <h2 style="padding-bottom: 64px;"><?php if($title){ echo esc_html( $title ); }?></h2>
                                </div>
                                <div class="openness__items fade-container">

                                    <?php

                                    if( $benefits ){

                                        foreach( $benefits as $benefit ) {

                                            $icon = $benefit['icon'];
                                            $title = $benefit['title'];
                                            $text = $benefit['text'];
                                          
                                            ?>
                                            <div class="fade">
                                                <div>
                                                    <?php if( $icon ){
                                                    $image_url = $icon['url'];
                                                    $image_alt = $icon['alt'];
                                                    ?>
                                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">

                                                    <?php } ?>
                                                </div>
                                                <b role="heading" aria-level="3"><?php if($title){ echo esc_html( $title ); }?></b>
                                                <p><?php if($text){ echo esc_html( $text ); }?></p>
                                            </div>

                                            <?php
                                        }


                                    } ?>
                                    
                        
                                </div>
                            </section>
                        </div>
                    </div>

                <?php
                elseif( get_row_layout() == 'main_content' ): 
                    $subtitle = get_sub_field('subtitle');
                    $title = get_sub_field('title');
                    $blocks = get_sub_field('blocks');
                    $link = get_sub_field('link');
                ?>
                <div class="wrapper wrapper_green">
                    <div>
                        <section class="build">
                            <p class="PT-text fade"><?php if($subtitle){ echo esc_html( $subtitle ); }?></p>
                            <div class="main-heading fade">
                                <h2><?php if($title){ echo esc_html( $title ); }?></h2>
                            </div>
                            <?php

                                    if( $blocks ){
                                        $n = 1;
                                        foreach( $blocks as $block ) {

                                            $block_main = $block['block'];
                                            $content = $block_main['content'];
                                            $subtitle = $content['subtitle'];
                                            $title = $content['title'];
                                            $text = $content['text'];
                                            $list = $content['list'];
                                            $image = $block_main['image'];
                                          
                                            ?>
                                            
                                            <div class="build__item">
                                                <?php if($n%2 == 0){ ?>
                                                <div class="build__item-img fade">
                                                <?php if( $image ){
                                                    $image_url = $image['url'];
                                                    $image_alt = $image['alt'];
                                                    ?>
                                                        <img src="<?php echo esc_url($image_url); ?>" class="fade" alt="<?php echo esc_attr($image_alt); ?>">

                                                    <?php } ?>
                                                </div>
                                                <?php   } ?>
                                                <div class="build__item-text">
                                                    <p class="PT-text"><?php if($subtitle){ echo esc_html( $subtitle ); }?></p>

                                                    <h3 class="fade"><?php if($title){ echo esc_html( $title ); }?></h3>

                                                    <p class="build__item-description fade"><?php if($text){ echo esc_html( $text ); }?></p>
                                                    <?php if( $list ){
                                                        foreach( $list as $item ) {
                                                            $text = $item['item'] 
                                                            ?>
                                                        <p class="build__item-bold fade"><?php if($text){ echo esc_html( $text ); }?></p>
                                                    <?php
                                                        }
                                                    } 
                                                    ?>
                                                    
                                                </div>
                                                <?php if($n%2 == 1){ ?>
                                                <div class="build__item-img fade">
                                                <?php if( $image ){
                                                    $image_url = $image['url'];
                                                    $image_alt = $image['alt'];
                                                    ?>
                                                        <img src="<?php echo esc_url($image_url); ?>" class="fade" alt="<?php echo esc_attr($image_alt); ?>">

                                                    <?php } ?>
                                                </div>
                                                <?php   } ?>
                                            </div>
                                            
                    
                                        <?php $n++;
                                        }

                                    } ?>
                                <?php if( $link ){
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"  class="main-button" style="margin: 64px auto 0;"> 
                                        <span><?php echo esc_html( $link_title ); ?></span>
                                    <img src="<?php echo get_template_directory_uri();?>/img/arrow-right.svg" alt=""></a>

                                <?php } ?>
                           
                        </section>
                    </div>
                </div>
                <?php
                elseif( get_row_layout() == 'partners' ): 
                    $subtitle = get_sub_field('subtitle');
                    $title = get_sub_field('title');
                    $partners = get_sub_field('partners');
                ?>
                <div class="wrapper">
                    <div>
                        <div>

                            <section class="integrations">
                                <p class="PT-text PT-text_green fade"><?php if($subtitle){ echo esc_html( $subtitle ); }?></p>
                                <div class="main-heading fade">
                                    <h2><?php if($title){ echo esc_html( $title ); }?></h2>
                                </div>
                                <?php if( $partners ){
                                        $n = 0;
                                        $count = count($partners);
                                ?>        
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        <?php foreach( $partners as $partner ) { ?>
                                        <?php if($n%4 == 0): ?><div class="swiper-slide"><?php endif;?>
                                            
                                            <a href="
                                            <?php 
                                            $corresponding_link = get_field('corresponding_link', $partner->ID);  
                                            if( $corresponding_link ):
                                                echo esc_url($corresponding_link);
                                            endif; 
                                            ?>
                                            " class="card fade">
                                                <?php if ( has_post_thumbnail($partner->ID) ) : ?>
                                                    <img src="<?php echo get_the_post_thumbnail_url($partner->ID);?>" alt="<?php the_title($partner->ID); ?>">
                                                <?php endif;?>
                                                
                                            </a>
                            
                                        <?php $n++; if(($n)%4 == 0 || $n == $count): ?></div><?php endif;?>
                                        <?php } ?>
                                    
                                    </div>

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
                                <?php } ?>
                            </section>
                            </div>
                    </div>

                </div>
                <?php
                elseif( get_row_layout() == 'case_study' ): 
                    $subtitle = get_sub_field('subtitle');
                    $title = get_sub_field('title');
                    $case_study = get_sub_field('case_studies');
                    $link = get_sub_field('link');
                ?>
        
                    <div class="wrapper">
                        <div>
                            <div>
                                <section class="stories">
                                    <p class="PT-text PT-text_green fade"><?php if($subtitle){ echo esc_html( $subtitle ); }?></p>
                                    <div class="main-heading fade">
                                        <h2><?php if($title){ echo esc_html( $title ); }?></h2>
                                    </div>
                                    <?php if( $case_study ){ ?>  
                                    <div class="stories__items fade-container">
                                    <?php foreach( $case_study as $case_study_item ) { ?>
                                        <div class="fade">
                                            <?php if ( has_post_thumbnail($case_study_item->ID) ) : ?>
                                                <img src="<?php echo get_the_post_thumbnail_url($case_study_item->ID);?>" alt="<?php the_title($case_study_item->ID); ?>">
                                                <?php else:?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/default.jpg" alt="<?php the_title($case_study_item->ID); ?>">
                                        <?php endif;?>
                                            <p>
                                                <?php $company_name = get_field('company_name', $case_study_item->ID); 
                                            if( $company_name ):
                                                echo $company_name;
                                            endif; 
                                            ?>
                                            </p>
                                            <p><?php echo  get_the_title( $case_study_item->ID )?></p>
                                            <div class="learn-more-btn">
                                                <a href="<?php echo get_permalink($case_study_item->ID ); ?>"><?php the_field('learn_more', $current_language); ?></a>
                                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.10547 1.1123L5.94357 5.9504L1.10547 10.7885" stroke="#004A42"
                                                        stroke-width="1.5" />
                                                </svg>

                                            </div>
                                        </div>
                                        <?php } ?>    
                                    </div>
                                    <?php } ?>
                                    <?php if( $link ){
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"  class="main-button main-button_green-centre"> 
                                            <?php echo esc_html( $link_title ); ?></a>

                                    <?php } ?>
                                    
                                </section>
                                </div>
                        </div>

                    </div>
                <?php
                endif;

            endwhile;

        endif;
    ?>



        <div class="wrapper">
            <div>
                <div>

                <?php get_template_part( 'template-parts/content', 'footer-block' ); ?>
                </div>
            </div>

        </div>
    </main>

<?php
get_footer(); // Include the footer template.