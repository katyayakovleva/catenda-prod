
<?php
/**
 * Front Page Template
 *
 * This template is used to display the front page of the Catenda theme.
 * It dynamically renders various sections such as the hero banner, trusted companies,
 * benefits, openness, metrics, and testimonials using Secured Custom Fields (SCF).
 *
 * Template Features:
 * - Displays dynamic content fetched using SCF fields.
 * - Includes reusable template parts like the footer block.
 * - Implements animations and transitions for a modern user experience.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

get_header(); // Include the header template.
?>

<main>
        <div class="wrapper wrapper_green">
            <div>
                <section class="hero">
                    <?php $banner_block = get_field('banner_block'); ?>
                    <div class="hero__left">
                        <h4><?php if($banner_block['subtitle']) { echo esc_html( $banner_block['subtitle']);} ?></h4>
                        <h1 class="fade" style="transition-delay: 0.1s;"><?php echo esc_html( $banner_block['title']); ?></h1>
                        <p class="hero__left-description fade" style="transition-delay: 0.3s;"><?php echo esc_html( $banner_block['text']); ?></p>
                        <?php $link =  $banner_block['link']; ?>
                        <a href="<?php echo esc_url($link['url']);?>">
                            <span><?php echo $link['title'];?></span>
                            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/img/arrow-right.svg" alt="">
                        </a>
                    </div>

                    
                    <div>
                    <?php 
                            $image =  $banner_block['image']; ?>
                        <img loading="lazy" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['title']); ?>" class="fade parallax" data-direction="up" data-speed="0.1" style="transform: translateY(0px);">
                    </div>
                </section>
                <section class="trusted-companies">
                <?php $partners_block = get_field('partners'); ?>
                    <p><?php echo $partners_block['title']; ?></p>

                    <div class="trusted-companies__marquee">
                        <div class="trusted-companies__track">
                        <?php 

                            $partners =  $partners_block['partners'];
                            if( $partners ){
                                foreach( $partners as $partner ) {
                                    ?>
                                    <?php if ( has_post_thumbnail($partner->ID) ) : ?>
                                        <img loading="lazy" src="<?php echo get_the_post_thumbnail_url($partner->ID);?>" alt="<?php the_title($partner->ID); ?>">
                                    <?php endif;?>
                                    <?php
                                }
                            }
                            ?>
                           
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="wrapper">
            <div>
                <?php $benefits_block = get_field('benefits_block'); ?>

                <section class="benefits">
                    <p class="PT-text PT-text_green fade"><?php echo $benefits_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2><?php echo $benefits_block['title']; ?></h2>
                    </div>
                    <div class="benefits__inner">
                        <div class="fade-container">
                        <?php
                        $benefits =  $benefits_block['benefits'];
                        if( $benefits ){
                            $desktop_first_img = $benefits[0]['subcategory'][0]['image']['url'];

                            foreach( $benefits as $benefit ) {

                                $category = $benefit['category'];

                            ?>
                            <div class="accordion fade">
                                <div class="accordion__header" role="button" tabindex="0">
                                    <span ><?php echo $category; ?></span>
                                    <div class="accordion__arrow">
                                        <svg width="14" height="8" viewBox="0 0 8 4" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.78421 0L4 2.64169L1.21579 0L0.5 0.679154L4 4L7.5 0.679154L6.78421 0Z"
                                                fill="#647273" />
                                        </svg>
                                    </div>
                                </div>
                       
                                <div class="accordion__content">
                                <?php
                                $subcategories = $benefit['subcategory'];
                                if( $subcategories ){
                                    $first_img = $subcategories[0]['image']['url'];
                                    foreach( $subcategories as $subcategory ) {
                                    
                                    $text = $subcategory['text'];
                                    $image = $subcategory['image'];
                                    
                                    ?>
                                    
                                    <a data-img="<?php echo esc_url( $image['url'] ); ?>" role="button"><?php echo esc_html( $text ); ?></a>

                                        <?php
                                    }
                                }
                                ?>
                                    <div class="benefits__graph_mobile">
                                        <img loading="lazy" src="<?php echo esc_url( $first_img ); ?>" alt="Catenda dashboard">
                                    </div>
                                </div>
               
                            </div>
                            <?php }; ?>

                        </div>

                        <div class="fade">
                            <img loading="lazy" src="<?php echo esc_url( $desktop_first_img ); ?>" class="fade" style="transition-duration: 1s;"
                                alt="Catenda dashboard" id="main-dashboard-image">
                        </div>
                        <?php }; ?>
                    </div>
                    <?php $link =  $benefits_block['link']; ?>
                    <a href="<?php echo esc_url( $link['url'] ); ?>" class="main-button main-button_green-centre">
                        <?php echo esc_html( $link['title'] ); ?>
                    </a>
                </section>

                <?php $about_block = get_field('about_block'); ?>
                <section class="openness">
                    <p class="PT-text PT-text_green fade"><?php echo $about_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2><?php echo $about_block['title']; ?></h2>
                    </div>
                    <p class="openness__description openness__description_pb fade"><?php echo $about_block['text']; ?></p>
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
                                 <img loading="lazy" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_url($icon['title']); ?>">
                             </div>
                             <b role="heading" aria-level="3"><?php echo esc_html( $title ); ?></b>
                             <p><?php echo esc_html( $description ); ?></p>
                         </div>
                             <?php }
                         }?>
                    </div>
                </section>
            </div>
        </div>
        <?php $countdown_block = get_field('results_block'); ?>
        <div class="wrapper wrapper_green">
            <div>
                <section class="metrics">
                    <p class="PT-text fade"><?php echo $countdown_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2><?php echo $countdown_block['title']; ?></h2>
                    </div>

                    <div class="metrics__items">
                    <?php 
                        $first_block = $countdown_block['first_block'];
                        $second_block = $countdown_block['second_block'];
                        $third_block = $countdown_block['third_block'];
                    ?>
                        <div>
                            <img loading="lazy" src="<?php echo esc_url($first_block['image']['url']); ?>" alt="<?php echo esc_html($first_block['image']['title']); ?>" class="fade"
                                style="transition-delay: 0.2s;">
                            <div class="fade" style="transition-delay: 0.3s;">
                                <?php
                                    $countdown_value = $first_block['countdown_value'];
                                ?>
                                <h3 class="counter" data-suffix="<?php echo $countdown_value['suffix']; ?>" style="--initialValue: <?php echo $countdown_value['initial']?>; --finalValue: <?php echo $countdown_value['final']?>;"></h3>
                                <p><?php echo $first_block['text']; ?></p>
                            </div>
                        </div>

                        <div>
                            <div class="fade" style="transition-delay: 0.2s;">
                            <?php
                                    $countdown_value = $second_block['countdown_value'];
                                ?>
                                <h3 class="counter" data-suffix="<?php echo $countdown_value['suffix']; ?>" style="--initialValue: <?php echo $countdown_value['initial']?>; --finalValue: <?php echo $countdown_value['final']?>;"></h3>
                                <p><?php echo $second_block['text']; ?></p>
                            </div>
                            <img loading="lazy" src="<?php echo esc_url($second_block['image']['url']); ?>" alt="<?php echo esc_html($second_block['image']['title']); ?>" class="fade"
                                style="transition-delay: 0.3s;">
                        </div>

                        <div>
                            <img loading="lazy" src="<?php echo esc_url($third_block['image']['url']); ?>" alt="<?php echo esc_html($third_block['image']['title']); ?>" class="fade"
                                style="transition-delay: 0.2s;">
                            <div class="fade" style="transition-delay: 0.3s;">
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
        <?php $testimonials_block = get_field('testimonials_block'); ?>
        <div class="wrapper">
            <div>
                <section class="testimonials">

                    <p class="PT-text PT-text_green fade"><?php echo $testimonials_block['subtitle']; ?></p>
                    <div class="main-heading fade">
                        <h2><?php echo $testimonials_block['title']; ?></h2>
                    </div>

                    <div class="testimonials__items fade-container">
                    <?php $testimonials =  $testimonials_block['testimonials']; 
                        if( $testimonials ){

                            foreach( $testimonials as $testimonial ) {

                                $image = $testimonial['image'];
                                $text = $testimonial['text'];
                                $name = $testimonial['full_name'];
                                $job_title = $testimonial['job_title'];

                            ?>
                            <div class="fade">
                                <div>
                                <img loading="lazy" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['title']); ?>">
                                </div>

                                <blockquote>
                                    <?php echo esc_html( $text ); ?>
                                </blockquote>

                                <div>
                                    <cite><?php echo esc_html( $name ); ?></cite>
                                    <div><?php echo esc_html( $job_title ); ?></div>
                                </div>
                            </div>
                            <?php
                            }
                        }
                        ?>
                        

                        
                        
                    </div>
                    <?php $link =  $testimonials_block['link']; ?>
                    <?php if($link):?>
                    <a href="<?php echo esc_url( $link['url'] ); ?>" class="main-button main-button_green-centre">
                        <?php echo esc_html( $link['title'] ); ?>
                    </a>
                    <?php endif;?>
                </section>

                <div>
       
                <?php 
                
                        get_template_part( 'template-parts/content', 'footer-block' ); 
                    
                    
                    ?>
                </div>
            </div>

        </div>
    </main>

<?php
get_footer(); // Include the footer template.