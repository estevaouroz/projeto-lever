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
<footer id="footer">
    <div class="box-img">
        <?php
        $image = get_field('field_name');
        if ($image):
            $image_url = $image['url'];
            $image_alt = $image['alt']; ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
        <?php endif; ?>
    </div>
    <div class="left">
    </div>

    <div class="right">
        <div data-aos="fade-left" data-aos-duration="1300" class="quote">
            <h3><?php echo get_field('footer_texto'); ?></h3>
            <?php
            $image = get_field('assinatura_real_state');
            if ($image):
                $image_url = $image['url'];
                $image_alt = $image['alt']; ?>
                <img assinatura_real_state src="<?php echo esc_url($image_url); ?>"
                    alt="<?php echo esc_attr($image_alt); ?>">
            <?php endif; ?>
        </div>
        <div class="contact">
            <div data-aos="fade-left" data-aos-duration="1300">
                <a href="mailto:contato@lever.global"
                    class="mail"><?php echo get_field('footer_contato'); ?></a>
            </div>
            <!-- <div class="location">
            <div data-aos="fade-up" data-aos-duration="1300" class="location-item">
                <div class="country">Brasil</div>
                <div class="address">Av. Tancredo Neves, 909<br> Salvador</div>
            </div>
            <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="250" class="location-item">
                <div class="country">Portugal</div>
                <div class="address">Rua Castilho, n. 20<br> Lisboa</div>
            </div>
            <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="500" class="location-item">
                <div class="country">Estados Unidos</div>
                <div class="address">6965 Piazza Grande Ave<br> Orlando</div>
            </div>
            </div> -->
        </div>
    </div>

    <div class="copyright">
        <span>
            <?php echo get_field('footer_marca'); ?>
            <script>document.write(new Date().getFullYear())</script> –
            <a href="https://dzigual.com.br/" target="_blank" rel="noopener noreferrer" aria-label="Dzigual">
                <svg xmlns="http://www.w3.org/2000/svg" width="82" height="12" viewBox="0 0 82 12" fill="none">
                    <path
                        d="M5.23682 12H0L0 0.00171282L5.08439 0.00171282C5.98796 0.00171282 6.80176 0.153297 7.52496 0.455609C8.24816 0.758778 8.86634 1.17585 9.38122 1.70682C9.89525 2.2378 10.2907 2.87239 10.5676 3.60976C10.8445 4.34713 10.9826 5.15558 10.9826 6.03511C10.9826 6.91464 10.8437 7.72052 10.5676 8.4519C10.2907 9.18327 9.90117 9.81187 9.39815 10.3377C8.89514 10.8635 8.2905 11.2721 7.58424 11.5632C6.87798 11.8544 6.09551 12 5.23682 12ZM2.593 2.43563L2.593 9.56608H4.98277C5.5366 9.56608 6.01675 9.47787 6.42323 9.3006C6.82971 9.12332 7.16929 8.88096 7.44028 8.57179C7.71126 8.26349 7.91196 7.8918 8.04237 7.45761C8.17194 7.02341 8.23715 6.54896 8.23715 6.03511C8.23715 4.91493 7.9433 4.0354 7.35559 3.39566C6.76789 2.75592 5.92614 2.43563 4.83034 2.43563L2.593 2.43563ZM23.8129 0.00171282V5.02369L12.7457 9.58321L23.9823 9.56608L23.9823 12L12.6771 12V6.85812L23.7952 2.4185L12.8295 2.43563V0.00171282L23.8121 0.00171282L23.8129 0.00171282ZM26.5753 0.00171282L29.1683 0.00171282L29.1683 12L26.5753 12L26.5753 0.00171282ZM37.5706 2.38424C35.0166 2.38424 33.7404 3.62946 33.7404 6.12075C33.7404 7.35484 34.0766 8.24893 34.749 8.80302C35.4213 9.35712 36.3562 9.6346 37.5537 9.6346C37.9373 9.6346 38.3251 9.57722 38.7147 9.46331C39.1042 9.34941 39.4548 9.19183 39.7656 8.99229C40.0764 8.79275 40.3304 8.55552 40.5286 8.28061C40.7259 8.00656 40.825 7.7034 40.825 7.37196H37.3504V5.14359L43.1978 5.14359V11.8279H40.825V7.37111C40.825 7.80531 40.7801 8.29089 40.6895 8.82786C40.5989 9.36483 40.427 9.86754 40.1729 10.336C39.9189 10.8045 39.5573 11.1993 39.0881 11.5187C38.619 11.839 38.0008 11.9983 37.2319 11.9983C36.2716 11.9983 35.4095 11.8673 34.6473 11.6043C33.8843 11.3414 33.2374 10.9586 32.7064 10.4559C32.1754 9.95318 31.7715 9.33057 31.4946 8.58721C31.2177 7.8447 31.0796 6.99343 31.0796 6.0334C31.0796 4.98259 31.2431 4.07651 31.5708 3.31687C31.8985 2.55724 32.3558 1.9312 32.9435 1.43962C33.5312 0.948044 34.2231 0.585783 35.0199 0.351128C35.8168 0.117328 36.689 0 37.6383 0C38.3167 0 38.9713 0.0770768 39.6047 0.23123C40.2373 0.385384 40.808 0.628604 41.3161 0.960034C41.8242 1.29146 42.2451 1.71967 42.5788 2.2455C42.9116 2.77134 43.1182 3.40508 43.1978 4.14844L40.554 4.14844C40.4744 3.80588 40.3304 3.51984 40.1221 3.29118C39.9129 3.06252 39.6733 2.8801 39.4015 2.74308C39.1305 2.60605 38.8366 2.51185 38.5199 2.46046C38.2032 2.40908 37.8873 2.38339 37.5706 2.38339V2.38424ZM45.3471 7.37196V0.00171282L47.9401 0.00171282V7.20068C47.9401 7.72652 48.0273 8.14359 48.2026 8.4519C48.3779 8.7602 48.6175 8.99229 48.9232 9.14644C49.2281 9.3006 49.5812 9.39823 49.9826 9.43762C50.3832 9.47787 50.8049 9.49757 51.2453 9.49757C51.6856 9.49757 52.1065 9.47787 52.5079 9.43762C52.9084 9.39737 53.265 9.3006 53.5757 9.14644C53.8865 8.99229 54.1321 8.76106 54.3133 8.4519C54.4937 8.14359 54.5843 7.72652 54.5843 7.20068V0.00171282L57.1773 0.00171282V7.37196C57.1773 8.332 57.0164 9.11133 56.6946 9.71167C56.3728 10.3112 55.9376 10.7805 55.3897 11.117C54.8418 11.4545 54.2083 11.6857 53.4911 11.8116C52.7729 11.9375 52.0252 12 51.2453 12C50.4653 12 49.7201 11.9375 49.0079 11.8116C48.2957 11.6857 47.6691 11.4519 47.1263 11.1085C46.5843 10.7659 46.1516 10.294 45.8298 9.69455C45.508 9.09506 45.3471 8.32087 45.3471 7.37196ZM67.0582 0.00171282L70.9392 12H68.126L67.363 9.46331H61.5326L60.7357 12H57.9564L61.8552 0.00171282L64.4652 0.00171282L62.194 7.2692L66.6856 7.2692L64.4652 0.00171282L67.0582 0.00171282ZM75.0574 0.00171282V9.56608H81.6V12H72.4644V0.00171282L75.0574 0.00171282Z"
                        fill="#1D1B20" />
                </svg>
            </a>
        </span>
    </div>


</footer>

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