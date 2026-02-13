<?php
/* 
Template Name: Lever Real State 
*/
wp_enqueue_style('Lever Family Office', get_template_directory_uri() . '/assets/dist/css/lever-real-state.css', ['main'], ASSETS_VERSION);
get_header();
?>

<header class="header">
    <a class="box-svg" href="<?php echo esc_url(home_url('/')); ?>">
        <?php $svg_file = get_field('hero_logo');
        if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
            echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
        } ?>
    </a>

    <nav class="header-menu">
        <?php if (have_rows('hero_menu')):
            while (have_rows('hero_menu')):
                the_row();
                $link = get_sub_field('hero_menu_item');
                if ($link): ?>
                    <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                        <span><?php echo esc_html($link['title']); ?></span>
                    </a>
                <?php endif;
            endwhile;
        endif; ?>
    </nav>
</header>

    <div class="fundo">
        <div class="bg-fundo">
            <img class=""
                src="<?php echo get_template_directory_uri(); ?>/assets/dist/img/fundo-bg-02.webp"
                alt="" />
    </div>

    <section class="hero">
        <div class="hero-content wrapper">
            <div class="hero-text" data-aos="fade-up" data-aos-duration="1000">
                <h1><?php echo get_field('hero_titulo'); ?></h1>
                <p><?php echo get_field('hero_texto'); ?></p>
            </div>
        </div>
    </section>

    <section class="desenvolvemos" id="sobre">

        <div class="wrapper">
            <!-- <?php
            $bg_image = get_field('vocacao_fundo');
            if ($bg_image): ?>
                <img src="<?php echo esc_url($bg_image['url']); ?>" alt="<?php echo esc_attr($bg_image['alt']); ?>" class="bg-mapa">
        <?php endif; ?> -->

            <div class="desenvolvemos-content">

                <div class="dev-box-image">
                    <div class="dev-imagem">
                        <?php
                        $main_image = get_field('vocacao_imagem');
                        if ($main_image): ?>
                            <img src="<?php echo esc_url($main_image['url']); ?>"
                                alt="<?php echo esc_attr($main_image['alt']); ?>">
                        <?php endif; ?>
    
                        <div class="elipse">
                            <?php
                            $image = get_field('icon_flutuante');
                            if ($image):
                                $image_url = $image['url'];
                                $image_alt = $image['alt']; ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="dev-text" data-aos="fade-left" data-aos-duration="1000">
                    <h2><?php echo get_field('vocacao_texto'); ?></h2>
                    <p><?php echo get_field('vocacao_titulo'); ?></p>
                </div>

            </div>
        </div>
    </section>

</div>

<section class="valores">

        <div class="valores-header">
            <p>VALORES ORIENTADORES</p>
        </div>

            <?php
            if (have_rows('valores_repetidor')):
                $delay = 100;

                while (have_rows('valores_repetidor')):
                    the_row(); ?>

                    <div class="valores-orientadores-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>"
                        data-aos-duration="1000">

                        <div class="box-svg">
                            <?php
                            $svg_file = get_sub_field('valores_repetidor_icon');
                            if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                                $path = get_attached_file($svg_file['ID']);
                                if ($path) {
                                    echo '<i class="element">' . file_get_contents($path) . '</i>';
                                }
                            } ?>
                        </div>

                        <h2><?php echo get_sub_field('valores_titulo'); ?></h2>
                        <p><?php echo get_sub_field('valores_texto'); ?></p>
                    </div>

                    <?php
                    $delay += 500;
                    ?>
                <?php endwhile;
            endif; ?>

</section>

<section class="teses" id="teses">

    <div class="wrapper">

        <div class="teses-cima">
            <h3><?php echo get_field('tese_titulo'); ?></h3>
            <h2><?php echo get_field('teses_titulo_2'); ?></h2>
        </div>

        <div class="teses-content ">


            <div class="teses-esquerda">

                <p><?php echo get_field('teses_texto'); ?></p>
            </div>

            <div class="teses-direita">
                <?php if (have_rows('teses_repetidor')): ?>
                    <div class="accordion-container">
                        <?php
                        $delay = 100;
                        while (have_rows('teses_repetidor')):
                            the_row();
                            ?>
                            <div class="accordion-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>"
                                data-aos-duration="1000">

                                <button class="accordion-header">
                                    <h4><?php echo get_sub_field('repetidor_item_'); ?></h4>
                                    <span class="accordion-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                                            fill="none">
                                            <circle opacity="0.15" cx="16" cy="16" r="15.5" stroke="#111445" />
                                            <path d="M10 14L16 20L22 14" stroke="#111445" stroke-width="1"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </button>

                                <div class="accordion-content">
                                    <div class="content-inner">
                                        <h5><?php echo get_sub_field('repetidor_texto'); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $delay += 400;
                        endwhile;
                        ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</section>

<section class="produtos">

    <?php
    if (have_rows('produtos')):
        while (have_rows('produtos')):
            the_row();
            $image = get_sub_field('produtos_imagem');
            $titulo = get_sub_field('produtos_titulo');
            $link_text = get_sub_field('produtos_botao');
            ?>

            <div class="produto-item">
                <?php if ($image): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                <?php endif; ?>

                <div class="produto-overlay">
                    <div class="produto-info">
                        <h2><?php echo esc_html($titulo); ?></h2>
                        <?php
                        $link = get_sub_field('produtos_botao');
                        if ($link):
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                            <a class="#" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                                <p class=""><?php echo esc_html($link_title); ?></p>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endwhile;
    endif; ?>
</section>

<section class="porta">
    <div class="wrapper">

        <div class="porta-text">
            <?php echo get_field('porta_titulo'); ?>
        </div>

        <div class="porta-botao">
            <?php
            $link = get_field('porta_botao');
            if ($link):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                <a class="" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                    <p class=""><?php echo esc_html($link_title); ?></p>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>