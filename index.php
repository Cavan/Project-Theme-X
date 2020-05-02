<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php // get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

			<?php
                    //Get the most recent post
                    $recent_posts = wp_get_recent_posts(array(
                        'numberposts' => 1, //Get the most recent post
                        'post_status' => 'publish' //Return only published posts

                    ));
                    foreach ($recent_posts as $post) : ?>
                       
                       <header class="entry-header most-recent-post"> 
                        <h2 class="entry-title">
                        <a href="<?php echo get_permalink($post['ID']) ?>"><?php echo $post['post_title'] ?></a>
                        </h2>
                        <?php if ( 'post' === get_post_type() ) : ?>

                            <div class="entry-meta">
                               <p><?php echo get_the_date('M dS Y', $post['ID']) ?></p>
                               <p><?php echo the_author(); ?></p>
                            </div><!-- .entry-meta -->

                            <?php endif; ?>
                        <?php echo get_the_post_thumbnail($post['ID'], 'full') ?>
                        </header>
                        <div class="entry-content">

                        
                        </div><!-- .entry-content -->
                    

                <?php endforeach; wp_reset_query(); ?>

				<?php
                $counter = 1; //Start counter
                $grids = 2; //Grids per row

                global $query_string; // This is needed to make pagination work
                //I want to show 6 posts per page 
                query_posts($query_string . '&caller_get_posts=1&posts_per_page=6');
                
                if(have_posts()) : while(have_posts()) : the_post();
				?>
                <?php
                //Show the left hand side column
                if($counter == 1):
                ?>
                    <div class="row">
                    <div class="col-sm">
                        <a href="<?php the_permalink(); ?>"
                        title="<?php the_title_attribute(); ?>"><?php
                        the_post_thumbnail('category-thumbnail'); ?></a>
                        <p><?php the_author(); ?></p>
                        <h2><a href="<?php the_permalink(); ?>"
                        title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <?php
                    //Show the right hand side column
                    elseif($counter == $grids) :
                    ?>
                    <div class="col-sm">
                        <a href="<?php the_permalink(); ?>"
                        title="<?php the_title_attribute(); ?>"><?php
                        the_post_thumbnail('category-thumbnail'); ?></a>
                        <p><?php the_author(); ?></p>
                        <h2><a href="<?php the_permalink(); ?>"
                        title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    </div>
                    <?php
                    $counter = 0;
                    endif;
                    ?>
                    <?php
                    $counter++;
                    endwhile;
                    //Pagination can go here if you wnat it.
                    endif;
                    ?>


			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
