<?php get_header();
/*
Template Name: tpl configuratore

*/
?>

<!-- Page Title -->
<div class="section section-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?php the_title() ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php //the_post_thumbnail('full', array(
        //  'class' => 'img-responsive'
  //) ); ?>

        <?php   $url_postthumbnail = null;
                $url_postthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                $url_postthumbnail = $url_postthumbnail[0];
        ?>
                <?php if (isset($url_postthumbnail)) { ?>

                <img style="margin: 0 auto;" class="img-responsive" src="<?php echo $url_postthumbnail ?>"
                    alt="Full Width Banner Image">

                <?php  }

      else { ?>
                <img class="img-responsive" src="<?php echo get_template_directory_uri() ?>/img/slides/2.jpg"
                    alt="Full Width Banner Image">
                <?php  }

      ?>

            </div>

        </div>
    </div>
</div>






<hr>

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<?php the_content(); ?>

<?php endwhile; ?>

<?php // Navigation ?>

<?php else : ?>

<?php // No Posts Found ?>

<?php endif; ?>






<hr>



<?php get_footer() ?>