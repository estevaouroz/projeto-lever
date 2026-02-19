<?php
/* 
Template Name: Lever Real State 
*/
wp_enqueue_style('Lever Family Office', get_template_directory_uri() . '/assets/dist/css/lever-real-state.css', ['main'], ASSETS_VERSION);
get_header();
?>

<header>

    <nav>
        <div class="wrapper">
            <div class="logo" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                    <span class="logo-default">
                        <?php $svg_file = get_field('hero_logo');
                        if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                            echo file_get_contents($svg_file['url']);
                        } ?>
                    </span>

                    <span class="logo-dark">
                        <?php $svg_file = get_field('hero_logo_oculto');
                        if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                            echo file_get_contents($svg_file['url']);
                        } ?>
                    </span>
                </a>
            </div>
            <ul class="menu" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <?php
                if (have_rows('hero_menu')):
                    while (have_rows('hero_menu')):
                        the_row(); ?>
                        <li>
                            <?php

                            $link = get_sub_field('hero_menu_item');
                            if ($link):
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                $is_anchor = strpos($link_url, '#') === 0;
                                $link_class = $is_anchor ? 'link-hover' : ''; ?>
                                <a class="<?php echo esc_attr($link_class); ?>" href="<?php echo esc_url($link_url); ?>"
                                    target="<?php echo esc_attr($link_target); ?>">
                                    <?php echo esc_html($link_title); ?>
                                </a>
                            <?php endif; ?>

                        </li>
                    <?php endwhile;
                endif; ?>
            </ul>

        </div>

    </nav>

</header>

<div class="fundo">
    <div class="bg-fundo">
        <div class="box-svg">
            <?php $svg_file = get_field('hero_imagem');
            if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                echo '<i class="element">';
                echo file_get_contents($svg_file['url']);
                echo '</i>';
            } ?>
        </div>
    </div>

    <section class="hero">
        <div class="hero-content wrapper">
            <div class="hero-text" data-aos="fade-up" data-aos-duration="1000">
                <h1><?php echo get_field('hero_titulo'); ?></h1>
                <p><?php echo get_field('hero_texto'); ?></p>
            </div>
            <a href="#sobre" class="scroll-indicator link-hover">
                <svg width="9" height="15" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.5 -1.74846e-07L4.5 14.2222M4.5 14.2222L8.5 10.1587M4.5 14.2222L0.499999 10.1587"
                        stroke="#fff" />
                </svg>
            </a>

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
                        $gallery_images = get_field('vocacao_imagens');
                        $images = [];

                        if (is_array($gallery_images) && !empty($gallery_images)) {
                            $images = $gallery_images;
                        }

                        if (!empty($images)):
                            $is_slideshow = count($images) > 1;
                            if ($is_slideshow): ?>
                                <div class="dev-slideshow" data-interval="5000">
                                <?php endif; ?>

                                <?php foreach ($images as $index => $image_item):
                                    $image_url = '';
                                    $image_alt = '';

                                    if (is_numeric($image_item)) {
                                        $image_url = wp_get_attachment_image_url((int) $image_item, 'full');
                                        $image_alt = get_post_meta((int) $image_item, '_wp_attachment_image_alt', true);
                                    } elseif (is_array($image_item)) {
                                        $image_url = isset($image_item['url']) ? $image_item['url'] : '';
                                        $image_alt = isset($image_item['alt']) ? $image_item['alt'] : '';
                                    }

                                    if (!$image_url) {
                                        continue;
                                    }

                                    $image_class = $is_slideshow ? 'dev-slide' . ($index === 0 ? ' is-active' : '') : 'dev-single';
                                    ?>
                                    <img class="<?php echo esc_attr($image_class); ?>" src="<?php echo esc_url($image_url); ?>"
                                        alt="<?php echo esc_attr($image_alt); ?>">
                                <?php endforeach; ?>

                                <?php if ($is_slideshow): ?>
                                </div>
                            <?php endif; ?>
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
                    <p class="description-dev-text"><?php echo get_field('vocacao_titulo'); ?></p>

                    <div class="box-big-numbers">
                        <?php
                        if (have_rows('big_numbers')) :
                            while (have_rows('big_numbers')) : the_row(); ?>

                            <p class="text-big-numbers">
                                <?php echo get_sub_field('text_big_numbers'); ?>
                            </p>
                            <?php endwhile;
                        endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<section class="valores">

    <div class="valores-header">
        <p>VALORES ORIENTADORES</p>
    </div>

    <div class="valores-orientadores-box">

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

    </div>

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
    <?php if (have_rows('produtos')):
        $i = 0;
        while (have_rows('produtos')):
            the_row();
            $i++;
            $image = get_sub_field('produtos_imagem');
            $titulo = get_sub_field('produtos_titulo');
            $botao = get_sub_field('produtos_botao'); // Link do ACF
            ?>

            <div class="produto-item">
                <?php if ($botao): ?>
                    <a href="javascript:void(0)" class="open-sidebar" data-target="side-<?php echo $i; ?>">
                    <?php endif; ?>

                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    <?php endif; ?>

                    <div class="produto-overlay">
                        <div class="produto-info">
                            <h2><?php echo esc_html($titulo); ?></h2>

                            <?php if ($botao): ?>
                                <div class="btn">

                                    <p><?php echo esc_html($botao['title']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($botao): ?>
                    </a>
                <?php endif; ?>

                <aside id="side-<?php echo $i; ?>" class="side-modal">
                    <div class="modal-content">
                        <button class="close-modal">
                            <svg width="14" height="14" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L10 10" stroke="#111445" stroke-width="1.2" stroke-linecap="round" />
                                <path d="M10 1L1 10" stroke="#111445" stroke-width="1.2" stroke-linecap="round" />
                            </svg>
                        </button>

                        <?php if (have_rows('side_bar')):
                            while (have_rows('side_bar')):
                                the_row(); ?>
                                <h3><?php the_sub_field('side_title'); ?></h3>
                                <p><?php the_sub_field('side_text'); ?></p>

                                <?php if (have_rows('side_itens')): ?>
                                    <ul class="side-list">
                                        <?php while (have_rows('side_itens')):
                                            the_row(); ?>
                                            <li>
                                                <h4><?php the_sub_field('side_item'); ?></h4>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php
                                $cta = get_sub_field('side_cta');
                                if ($cta): ?>
                                    <a href="<?php echo esc_url($cta['url']); ?>" class="btn-cta" target="<?php echo $cta['target']; ?>">
                                        <?php echo esc_html($cta['title']); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endwhile; endif; ?>
                    </div>
                    <div class="modal-overlay-bg"></div>
                </aside>
            </div>

        <?php endwhile; endif; ?>
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

<style>
    .page-template-lever-real-state .desenvolvemos .dev-box-image .dev-imagem .dev-slideshow {
        position: relative;
        width: 433px;
        height: 520px;
    }

    .page-template-lever-real-state .desenvolvemos .dev-box-image .dev-imagem .dev-slideshow .dev-slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease;
    }

    .page-template-lever-real-state .desenvolvemos .dev-box-image .dev-imagem .dev-slideshow .dev-slide.is-active {
        opacity: 1;
    }

    @media (min-width: 1440px) {
        .page-template-lever-real-state .desenvolvemos .dev-box-image .dev-imagem .dev-slideshow {
            width: 100%;
            height: 80dvh;
        }
    }

    @media (max-width: 1024px) {
        .page-template-lever-real-state .desenvolvemos .dev-box-image .dev-imagem .dev-slideshow {
            width: 100%;
            height: auto;
            aspect-ratio: 433 / 520;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sliders = document.querySelectorAll('.dev-imagem .dev-slideshow');

        sliders.forEach(function(slider) {
            var slides = slider.querySelectorAll('.dev-slide');

            if (slides.length <= 1) {
                return;
            }

            var currentIndex = 0;
            var intervalTime = parseInt(slider.getAttribute('data-interval'), 10) || 5000;

            setInterval(function() {
                slides[currentIndex].classList.remove('is-active');
                currentIndex = (currentIndex + 1) % slides.length;
                slides[currentIndex].classList.add('is-active');
            }, intervalTime);
        });
    });
</script>

<?php get_footer(); ?>