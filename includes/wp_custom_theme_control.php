<?php
/* --------------------------------------------------------------
CUSTOM AREA FOR OPTIONS DATA - telecurazao
-------------------------------------------------------------- */

add_action( 'customize_register', 'telecuracao_customize_register' );

function telecuracao_customize_register( $wp_customize ) {
    $wp_customize->add_section('telecuracao_custom_script', array(
        'title'    => __('Footer Custom Script', 'activest'),
        'description' => '',
        'priority' => 120,
    ));

    $wp_customize->add_setting('telecuracao_custom_script[adsense]', array(
        'default'        => ' ',
        'capability'     => 'edit_theme_options',
    ));

    $wp_customize->add_control('telecuracao_adsense', array(
        'type' => 'textarea',
        'label'      => __('Adsense Script', 'activest'),
        'section'    => 'telecuracao_custom_script',
        'settings'   => 'telecuracao_custom_script[adsense]',
    ));
}
