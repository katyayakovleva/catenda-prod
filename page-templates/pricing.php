<?php
/**
 * Template Name: Pricing
 *
 * This template is used to display the "Pricing" page in the Catenda theme.
 * It dynamically renders sections such as the hero banner, pricing blocks, FAQs, and a contact form 
 * using Secured Custom Fields (SCF) and WordPress functions.
 *
 * Template Features:
 * - Dynamically fetches and displays content blocks using SCF fields.
 * - Includes pricing blocks with titles, descriptions, and buttons.
 * - Displays FAQs with an accordion-style layout.
 * - Includes a contact form rendered using a shortcode.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package Catenda
 */

get_header(); // Include the header template.
?>


<main>
        <div class="wrapper wrapper_green">
            <div>
                <section class="pricing-top">
                <?php $title_block = get_field('title_block'); ?>
                        <h4 class="PT-text"><?php echo $title_block['subtitle']; ?></h4>
                        <h1><?php echo $title_block['title']; ?></h1>
                        <p class="pricing-top__description"><?php echo $title_block['text']; ?></p>
                </section>
            </div>
        </div>

        <div class="wrapper">
            <div>
                <section class="pricing__buttons">
                <?php $pricing_blocks =  get_field('pricing_block');  
                    if( $pricing_blocks ){

                        foreach( $pricing_blocks as $pricing_block ) {

                            $title = $pricing_block['title'];
                            $text = $pricing_block['text'];
                            $button_text = $pricing_block['button_text'];

                        ?>
                        <div>
                            <h3><?php echo esc_html( $title ); ?></h3>
                            <p><?php echo esc_html( $text ); ?></p>
<!--                             <a class="contact-sales-btn learn-more-btn"  data-popup-id="popup-<?php echo $title; ?>"><?php echo esc_html( $button_text ); ?></a> -->
			    <a class="contact-sales-btn learn-more-btn"  href="#cta__form-2"><?php echo esc_html( $button_text ); ?></a>
                        </div>

                        <?php }
                    }?>
                    
                </section>
                <?php               
                if( $pricing_blocks ){

                    foreach( $pricing_blocks as $pricing_block ) { 
                
                              $title = $pricing_block['title'];
                              $form_title = $pricing_block['form_title'];
                              $form = $pricing_block['form'];
                              ?>
                <div class="popup" id="popup-<?php echo $title; ?>">
                <div class="popup__overlay"></div>
                    <div class="popup__content popup__content_pricing">
                        <button class="popup__close"><img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/img/cross.svg" /></button>

                       

                        <div>
							<h4><?php echo $form_title; ?></h4>
							<div class="form">
								<?php echo do_shortcode($form);?>
						 	</div>
						</div>
                    </div>
                </div>
                <?php }
                    }?>
               
                <?php $faq_block = get_field('faq_block'); ?>
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
                                <div class="accordion__header" role="button">
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
                
<!--                 <div>
                <?php get_template_part( 'template-parts/content', 'footer-block' ); ?>
                </div> -->
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