<footer class="container-fluid p-0" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
    <div class="row no-gutters">
        <div class="the-footer col-12">
            <div class="container">
                <div class="row">
                    <div class="footer-menu col-12">
                        <?php
                        wp_nav_menu( array(
                            'container_class' => 'menu-footer',
                            'theme_location' => 'footer_menu',
                            'items_wrap'     => '<ul class="nav">%3$s</ul>'
                        ) );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer() ?>
</body>
</html>
