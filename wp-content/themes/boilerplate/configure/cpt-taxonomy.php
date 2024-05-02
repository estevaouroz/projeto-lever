<?php


function cpt_case()
{
    $labels = array(
        'name'               => __('Cases'),
        'singular_name'      => __('Cases'),
        'add_new'            => __('Adicionar Novo Cases'),
        'add_new_item'       => __('Adicionar Novo Cases'),
        'edit_item'          => __('Editar Cases'),
        'new_item'           => __('Novo Cases'),
        'all_items'          => __('Todos os Cases'),
        'view_item'          => __('Ver Cases'),
        'search_items'       => __('Procurar Cases'),
        'featured_image'     => 'Imagem Destacada',
        'set_featured_image' => 'Adicionar Imagem Destacada'
    );

    $args = array(
        'labels'            => $labels,
        'description'       => 'Armazena nossos cases e dados específicos de cases',
        'public'            => true,
        'menu_position'     => 5,
        'supports'          => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields'),
        'has_archive'       => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'has_archive'       => true,
        'menu_icon' => 'dashicons-format-gallery',
        'query_var'         => 'case'
    );

    register_post_type('case', $args);

    // Registra a taxonomia "Tipo de case"
    register_taxonomy(
        'tipo_case',
        'case',
        array(
            'label' => __('Tipo de case'),
            'rewrite' => array('slug' => 'tipo-case'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'cpt_case');
