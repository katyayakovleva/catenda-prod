<?php
/**
 * The template for displaying all single posts
 *
 * This template is used to display individual posts, including blog posts and custom post types.
 * It dynamically renders the post content, featured image, breadcrumbs, and social sharing links.
 *
 * Template Features:
 * - Displays breadcrumbs for navigation based on the post type.
 * - Includes social sharing links for Facebook, Twitter, LinkedIn, and a copy-to-clipboard option.
 * - Dynamically fetches and displays the post content and featured image.
 * - Includes reusable footer blocks for consistent design.
 * - Ensures proper sanitization and escaping for security.
 *
 * @package catenda
 */

get_header(); // Include the header template.
?>

<script>
/**
 * Copy the current page URL to the clipboard.
 * Displays a confirmation message when the URL is successfully copied.
 */
function copyURL(event) {
    event.preventDefault(); // Prevent default link behavior

    const url = window.location.href; // Get current page URL
    navigator.clipboard.writeText(url).then(() => {
        document.getElementById("copyMessage").style.display = "block";
        setTimeout(() => {
            document.getElementById("copyMessage").style.display = "none";
        }, 2000);
    }).catch(err => {
        console.error("Failed to copy: ", err);
    });
}
</script>
<main>
        <div class="wrapper wrapper_green">
            <div>
                <section class="<?php if(has_post_thumbnail()){echo 'blog-header_with-image';}else{ echo 'blog-header';}?>">
                    <div class="blog-header__top">
                        <?php
                        $current_post_type = get_post_type( get_the_ID() );
                        if($current_post_type == 'case'){
                            $page_template = get_pages( array(
                                'post_type' => 'page',
                                'meta_key' => '_wp_page_template',
                                'meta_value' => 'page-templates/case_studies.php'
                            ));
                            ?>
                            <a href="<?php echo get_permalink( $page_template[0]->ID ); ?>"><?php echo get_field('subtitle', $page_template[0]->ID); ?></a>

                            <?php
                        }else{ 
                            $page_for_posts = get_option( 'page_for_posts' );
                            ?>
                            <a href="<?php echo get_permalink( $page_for_posts ); ?>"><?php echo get_field('subtitle', $page_for_posts); ?></a>

                        <?php }
                        
                        ?>
                        <span>/</span>
                        <span><?php the_title(); ?></span>
                    </div>

                    <h1><?php the_title(); ?></h1>

            

                    <div class="blog-header__links">
                        <div>
                            <a href="/"><?php echo esc_html__( 'Share this post', 'catenda' ) ?></a>
                        </div>

                        <div>
                            <a href="<?php echo social_share_link($post->ID, "facebook");?>"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/facebook.svg" alt="facebook-icon"></a>
                            <a href="<?php echo social_share_link($post->ID, "twitter");?>"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/twitter.svg" alt="twitter-icon"></a>
                            <a href="<?php echo social_share_link($post->ID, "linkedin");?>"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/linkedin.svg" alt="linkedin-icon"></a>
                            <a href="#" onclick="copyURL(event)"><img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/copy.svg" alt="linkedin-icon" style="width:24px;"></a>

                        </div>
                    </div>
                    <?php if(has_post_thumbnail()){?>
                        <div class="blog-2__image">
                            <img loading="lazy" src="<?php echo get_the_post_thumbnail_url();?>" alt="<?php the_title(); ?>">
                        </div>
                    <?php } ?>
                </section>
            </div>
        </div>

        <div class="wrapper">
            <div>
                <div class="<?php if(has_post_thumbnail()){echo 'blog-content_with-image';}else{ echo 'blog-content';}?>">
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