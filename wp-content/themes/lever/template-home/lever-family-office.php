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

    <a href="#about" class="scroll-indicator">
        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 -1.74846e-07L4.5 14.2222M4.5 14.2222L8.5 10.1587M4.5 14.2222L0.499999 10.1587"
                stroke="#070932" />
        </svg>
    </a>
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


<?php get_footer(); ?>