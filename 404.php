<?php get_header(); ?>
<main class="container" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
    <div class="row justify-content-start align-items-start">
        <article id="post-404" class="page-container col-12">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-6">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/404.png" alt="Error 404 Imagen" class="img-fluid" />
                    </div>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <h1 class="text-center"><?php _e('Error 404', 'telecurazao'); ?></h1>
                        <hr>
                        <h4 class="text-center"><?php _e('No podemos encontrar la página que buscas. Dirígete nuevamente al', 'telecurazao'); ?> <a href="<?php echo home_url('/'); ?>" title="<?php _e('Volver al Inicio', 'telecurazao'); ?>"><?php _e('inicio', 'telecurazao'); ?></a>.</h4>
                    </div>
                    <div class="w-100"></div>
                </div>
            </div>

        </article>

    </div>
</main>
<?php get_footer(); ?>
