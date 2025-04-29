<?php
/**
 * Template Name: Partner
 *
 * This template is used to display the "Partner" page in the Catenda theme.
 * It dynamically renders sections such as the hero banner, partner integrations, values, FAQs, 
 * and a contact form using Secured Custom Fields (SCF) and WordPress functions.
 *
 * Template Features:
 * - Dynamically fetches and displays content blocks using SCF fields.
 * - Includes a swiper slider for partner integrations.
 * - Displays FAQs with an accordion-style layout.
 * - Includes a contact form rendered using a shortcode.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package Catenda
 */

get_header('white'); // Include the white header template.
?>

<main>
        <div class="wrapper">
            <div>
                <section class="partner-hero">
                <?php $title_block = get_field('title_block'); ?>
                    <p class="PT-text PT-text_green"><?php if($title_block['subtitle']){  echo $title_block['subtitle']; } ?></p>
                    <h1 class="fade" style="transition-delay: 0.1s;"><?php if($title_block['title']){ echo $title_block['title'];} ?></h1>
                    <p class="partner-hero__description fade" style="transition-delay: 0.3s;"><?php if($title_block['text']){ echo $title_block['text']; } ?></p>
                    <a href="#cta__form-2">
                    <?php echo $title_block['contact_button_text']; ?>
                    </a>



                    <div class="integrations">
                        <div class="swiper mySwiper swiper_partner">
                            <div class="swiper-wrapper">
                            <?php 
                                $partners = get_field('partners');
                                      


                                
                              if( $partners ){
                                    $n = 0;
                                    $count = count($partners);
                                     foreach( $partners as $partner ) { ?>
                                        
                                     
                                <?php if($n%3 == 0): ?><div class="swiper-slide"><?php endif;?>
                                    
                                    <a href="
                                    <?php 
                                    $corresponding_link = get_field('corresponding_link', $partner->ID);  
                                    if( $corresponding_link ):
                                        echo esc_url($corresponding_link);
                                    endif; 
                                    ?>
                                    " class="card fade">
                                        <?php if ( has_post_thumbnail($partner->ID) ) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url($partner->ID);?>" alt="<?php the_title(); ?>">
                                        <?php endif;?>
                                        <?php 
                                        $partner_type = get_field('partner_type',$partner->ID);  
                                        if( $partner_type ):
                                        ?>
                                            <p><?php echo $partner_type;?></p>
                                        <?php endif; ?>
                                    </a>

                                    

                                <?php $n++; if(($n)%3 == 0 || $n == $count): ?></div><?php endif;?>
                                    
                                    <?php } ?> 
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
                    </div>


                </section>
                



                <section class="openness">
                <?php $values_block = get_field('values_block'); ?>
                    <p class="PT-text PT-text_green fade"><?php if($values_block['subtitle']){ echo $values_block['subtitle']; } ?></p>
                    <div class="main-heading fade">
                        <h2 style="padding-bottom: 64px;"><?php if($values_block['title']){  echo $values_block['title'];} ?></h2>
                    </div>
                    <div class="openness__items openness__items_grid fade-container">
                    <?php $values =  $values_block['values']; 
                        if( $values ){

                            foreach( $values as $value ) {

                                $icon = $value['icon'];
                                $title = $value['title'];
                                $description = $value['text'];

                            ?>

                            <div class="fade" style="transition-duration: 0.5s;">
                                <div>
                                    <?php if($icon){?>
                                    <img src=" <?php if($icon['url']){echo esc_url($icon['url']);} ?>" alt="<?php if($icon['title']){ echo esc_url($icon['title']); }?>">
                                    <?php } ?>
                                </div>
                                <b role="heading" aria-level="3"><?php if($title){ echo esc_html( $title ); } ?></b>
                                <p><?php if($description){ echo esc_html( $description ); }?></p>
                            </div>
                            <?php }
                        }?>
                     
                    </div>

                    <a href="#cta__form-2" class="main-button main-button_green-centre">
                    <?php if($values_block['contact_button_text']) { echo $values_block['contact_button_text'];} ?>
                    </a>
                </section>

                <?php
    
        if( have_rows('faqs_block') ):

            while ( have_rows('faqs_block') ) : the_row();

                if( get_row_layout() == 'steps' ): 
                    $tagline_block = get_sub_field('tagline_block');
                    
                ?>
                <section class="tagline">
                    <p class="PT-text PT-text_green fade"><?php if($tagline_block['subtitle']){ echo $tagline_block['subtitle']; } ?></p>
                    <div class="main-heading fade">
                        <h2 style="padding-bottom: 64px;"><?php if($tagline_block['title']){ echo $tagline_block['title']; } ?></h2>
                        <div class="tagline__inner fade-container">
                            <?php if($tagline_block['image']){?>
                            <img src="<?php if($tagline_block['image']['url']){ echo esc_url($tagline_block['image']['url']); } ?>" alt="<?php if($tagline_block['image']['title']){ echo esc_url($tagline_block['image']['title']); } ?>" class="fade">
                            <?php } ?>
                            <div class="fade">
                            <?php $steps =  $tagline_block['steps']; 
                                if( $steps ){

                                    foreach( $steps as $step ) {

                                        $title = $step['title'];
                                        $description = $step['text'];

                                    ?>
                                    <div class="fade">
                                    
                                        <h4><?php if($title){ echo esc_html( $title ); } ?></h4>
                                        <p><?php if($description){ echo esc_html( $description ); } ?></p>
                                    </div>
                                    <?php }
                                }?>
                                
                            </div>
                        </div>
                    </div>

                </section>
                <?php
                elseif( get_row_layout() == 'faqs' ): 
                    $faq_block = get_sub_field('faq_block');
                ?>
                <section class="pricing__questions">
                    <div>
                        <p class="PT-text PT-text_green"><?php echo $faq_block['subtitle']; ?></p>
                        <h3><?php echo $faq_block['title']; ?></h3>
                    </div>

                    <div>
                    <?php $faqs =  $faq_block['faqs']; 
                        if( $faqs ){

                            foreach( $faqs as $faq ) {

                                $question = $faq['question'];
                                $answer = $faq['answer'];

                            ?>
                            <div class="accordion">
                                <div class="accordion__header" role="button" >
                                    <span ><?php echo esc_html( $question ); ?></span>
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5684 0L7 5.28338L1.43159 0L0 1.35831L7 8L14 1.35831L12.5684 0Z" fill="#02171A"/>
                                        </svg>                                    
                                    </div>
                                
                                <div class="accordion__content">
                                    <p><?php echo esc_html( $answer ); ?></p>
                                </div>
                            </div>
                           
                            <?php }
                        }?>
                     
                    
                        </div>
                </section>
                
                <?php
                endif;

            endwhile;

        endif;
    ?>
                

                <div>
                    <section id="cta__form-2" class="cta" style="text-align: left;">
                    <?php $form_block = get_field('form_block'); ?>
                        <div>
                            <p class="PT-text"><?php if($form_block['subtitle']) { echo $form_block['subtitle']; } ?></p>
                            <h2 class="cta__heading"><?php if($form_block['title']) { echo $form_block['title']; }?></h2>
                            <div class="cta__description"><?php if($form_block['text']) { echo $form_block['text']; } ?></div>
                        </div>
                        <div class="form">
                            <?php echo do_shortcode($form_block['form']);?>
                        </div>
                        
                    </section>
                    
                </div>
            </div>
        </div>

    </main>
<?php
get_footer(); // Include the footer template.