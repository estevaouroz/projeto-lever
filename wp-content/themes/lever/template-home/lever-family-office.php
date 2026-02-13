<?php
/* 
Template Name: Lever Family Office 
*/

wp_enqueue_style('Lever Family Office', get_template_directory_uri() . '/assets/dist/css/lever-family-office.css', ['main'], ASSETS_VERSION);
get_header();
?>


<header>
    <div class="box-img">

        <?php
        $image = get_field('hero_background');
        if ($image):
            $image_url = $image['url'];
            $image_alt = $image['alt']; ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
        <?php endif; ?>

    </div>
    <nav>
        <div class="wrapper">
            <div class="logo" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">


                <a class="box-svg" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php $svg_file = get_field('hero_logo');
                    if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                        echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
                    } ?>
                </a>
            </div>
            <ul class="menu" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <?php
                if (have_rows('hero_menu')):
                    while (have_rows('hero_menu')):
                        the_row(); ?>
                        <li>
                            <?php

                            $link = get_sub_field('hero_menu_link');
                            if ($link):
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                                    <?php echo esc_html($link_title); ?>
                                </a>
                            <?php endif; ?>

                        </li>
                    <?php endwhile;
                endif; ?>
            </ul>

        </div>

    </nav>
    <!-- <img src="img/wechi-symbol.svg" alt="" class="symbol"> -->
    <!-- <img src="img/slogan.svg" alt="" class="slogan"> -->
    <div data-aos="fade-left" data-aos-duration="1300" class="content">
        <h1><?php echo get_field('hero_titulo'); ?></h1>
        <div class="line"></div>
        <h3><?php echo get_field('hero_texto'); ?></h3>
    </div>

    <div class="scroll-indicator">
        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 -1.74846e-07L4.5 14.2222M4.5 14.2222L8.5 10.1587M4.5 14.2222L0.499999 10.1587"
                stroke="#070932" />
        </svg>

    </div>
</header>

<section id="about">

    <div class="container">

        <div class="left">
            <div class="text-wrapper">
                <h2>
                    <?php echo get_field('foco_titulo'); ?>
                </h2>
                <h3><?php echo get_field('foco_texto'); ?></h3>
                <p><?php echo get_field('foco_texto_2'); ?></p>
            </div>
        </div>

        <div data-aos="fade-up" data-aos-duration="1300" class="right">
            <svg class="right-svg" width="120" height="149" viewBox="0 0 120 149" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="60" cy="60.3978" rx="60" ry="60" transform="rotate(-180 60 60.3978)"
                    fill="url(#paint0_linear_207_894)" />
                <circle cx="59.3545" cy="90.7205" r="57.5645" stroke="#070932" />
                <defs>
                    <linearGradient id="paint0_linear_207_894" x1="60" y1="0.397854" x2="60" y2="120.398"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#27EBDC" />
                        <stop offset="1" stop-color="#27EBDC" stop-opacity="0" />
                    </linearGradient>
                </defs>
            </svg>

            <?php
            $image = get_field('foco_imagem');
            if ($image):
                $image_url = $image['url'];
                $image_alt = $image['alt']; ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
            <?php endif; ?>
        </div>

    </div>
</section>

<section id="valores">
    <h6><?php echo get_field('valores_titulo'); ?></h6>
    <?php
    if (have_rows('valores_repetidor')):
        while (have_rows('valores_repetidor')):
            the_row(); ?>

            <div data-aos="fade-up" data-aos-duration="1300" class="column">
                <div class="box-svg">
                    <?php $svg_file = get_sub_field('valores_repetirodes_icon');
                    if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                        echo '<i class="element">';
                        echo file_get_contents($svg_file['url']);
                        echo '</i>';
                    } ?>
                </div>
                <h3><?php echo get_sub_field('valores_repetidor_titulo'); ?></h3>
                <p><?php echo get_sub_field('valores_repetidor_texto'); ?>
                </p>
            </div>
        <?php endwhile;
    endif; ?>

</section>


<section id="family-office">
    <div class="container">
        <div class="left">
            <h6 class="white"><?php echo get_field('family_titulo'); ?></h6>
            <!-- <h2>Atuação LEVER<br> Family Office</h2> -->
            <p><?php echo get_field('family_texto'); ?></p>
            <!-- <a href="" class="button">
            <span>Conheça</span>
            </a> -->
        </div>
        <div class="right">
            <div class="accordion">
                <?php
                if (have_rows('family_acordeao')):
                    while (have_rows('family_acordeao')):
                        the_row(); ?>

                        <div data-aos="fade-up" data-aos-duration="1300" class="accordion-item">
                            <div class="accordion-header">
                                <h3><?php echo get_sub_field('family_repetidor_titulo'); ?></h3>
                                <div class="circle">
                                    <svg width="12" height="7" viewBox="0 0 12 7" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L6 6L11 1" stroke="white" />
                                    </svg>

                                </div>
                            </div>
                            <div class="accordion-body">
                                <p><?php echo get_sub_field('family_repetidor_texto'); ?></p>
                            </div>
                        </div>
                    <?php endwhile;
                endif; ?>

            </div>
        </div>
    </div>
    <div class="container">
        <?php
        $image = get_field('icon_flutuante');
        if ($image):
            $image_url = $image['url'];
            $image_alt = $image['alt']; ?>
            <img class="circle-secondary" src="<?php echo esc_url($image_url); ?>"
                alt="<?php echo esc_attr($image_alt); ?>">
        <?php endif; ?>
    </div>
</section>


<section id="map">
    <div class="overflow">
        <div data-aos="fade-up" data-aos-duration="1300" class="left">
            <h6><?php echo get_field('expertise_titulo'); ?></h6>
            <h2><?php echo get_field('expertise_titulo_2'); ?></h2>
            <p><?php echo get_field('expertise_texto'); ?></p>
        </div>
        <div data-aos="fade-left" data-aos-duration="1300" data-aos-delay="500" class="right">
            <?php
            $image = get_field('expertise_imagem');
            if ($image):
                $image_url = $image['url'];
                $image_alt = $image['alt']; ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="map">
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="process">
    <h2><?php echo get_field('processo_titulo'); ?></h2>
    <div class="board container">
        <?php
        if (have_rows('processo_lever_repetidor')):
            while (have_rows('processo_lever_repetidor')):
                the_row();
                $etapa_index = get_row_index();
                $etapa_label = str_pad((string) $etapa_index, 2, '0', STR_PAD_LEFT);
                $etapa_delay = ($etapa_index - 1) * 500;
                ?>
                <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="<?php echo esc_attr($etapa_delay); ?>" class="column">

                    <div class="table-header">
                        
                        <div class="number"><?php echo esc_html($etapa_label); ?></div>
                        <div class="title-wrapper">
                            <p>Etapa</p>
                            <div class="title">
                                <?php echo get_sub_field('processo_titulo_rep'); ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (have_rows('processo_item_repetidor')):
                        while (have_rows('processo_item_repetidor')):
                            the_row();
                            $item_index = get_row_index();
                            ?>
                            <div class="table-item">
                                <div class="number"><?php echo esc_html($etapa_index . '.' . $item_index); ?></div>
                                <p><?php echo get_sub_field('processo_item'); ?></p>
                            </div>
                        <?php endwhile;
                    endif; ?>

                </div>
            <?php endwhile;
        endif; ?>
     

    </div>
</section>




<?php get_footer(); ?>