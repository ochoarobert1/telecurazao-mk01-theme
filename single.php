<?php get_header(); ?>
<?php the_post(); ?>
<main class="container">
    <div class="row">
        <div class="single-main-container col-12" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
            <div class="container p-0">
                <div class="row">
                    <?php /* GET THE POST FORMAT */ ?>
                    <?php get_template_part( 'post-formats/format', get_post_format() ); ?>
                    <aside class="the-sidebar col-xl-3 col-md-3 col-sm-3 hidden-xs" role="complementary">
                        <?php get_sidebar(); ?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>
