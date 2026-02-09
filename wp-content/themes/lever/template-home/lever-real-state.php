<?php
/* 
Template Name: Lever Real State 
*/
get_header();
?>

<header class="header">
        <div class="box-svg">
            <?php $svg_file = get_field('hero_logo');
            if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
            } ?>
        </div>

        <nav class="header-menu">
            <?php if (have_rows('hero_menu')) :
                while (have_rows('hero_menu')) : the_row();
                    $link = get_sub_field('hero_menu_item');
                    if ($link) : ?>
                        <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                            <span><?php echo esc_html($link['title']); ?></span>
                        </a>
                    <?php endif;
                endwhile;
            endif; ?>
        </nav>
</header>

<section class="hero">

    <div class="hero-content">
        <!-- <?php $image = get_field('hero_imagem');
        if ($image) : ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="bg-hero">
        <?php endif; ?> -->
        
        <!-- <div class="overlay-gradient"></div> -->

        <div class="hero-text">
            <h1><?php echo get_field('hero_titulo'); ?></h1>
            <p><?php echo get_field('hero_texto'); ?></p>
        </div>
    </div>
</section>

<section class="desenvolvemos" id="sobre">

    <div class="wrapper">
        <!-- <?php
            $bg_image = get_field('vocacao_fundo');
            if ($bg_image) : ?>
                <img src="<?php echo esc_url($bg_image['url']); ?>" alt="<?php echo esc_attr($bg_image['alt']); ?>" class="bg-mapa">
        <?php endif; ?> -->

        <div class="desenvolvemos-content">
            <div class="dev-imagem">
                <?php
                    $main_image = get_field('vocacao_imagem');
                    if ($main_image) : ?>
                        <img src="<?php echo esc_url($main_image['url']); ?>" alt="<?php echo esc_attr($main_image['alt']); ?>">
                    <?php endif; ?>

                <div class="elipse">
                    <?php
                        $image = get_field('icon_flutuante');
                        if ($image) :
                            $image_url = $image['url'];
                            $image_alt = $image['alt']; ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        <?php endif; ?>
                </div>
            </div>

            <div class="dev-text">
                <h2><?php echo get_field('vocacao_texto'); ?></h2>
                <p><?php echo get_field('vocacao_titulo'); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="valores">

    <div class="wrapper">

        <div class="valores-header">
            <p>VALORES ORIENTADORES</p>
        </div>
    
        <div class="valores-orientadores-box">
            <?php
            if (have_rows('valores_repetidor')) :
                while (have_rows('valores_repetidor')) : the_row(); ?>
                    <div class="valores-orientadores-item">
                        <div class="box-svg">
                            <?php 
                            $svg_file = get_sub_field('valores_repetidor_icon');
                            if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
        
                                $path = get_attached_file($svg_file['ID']);
                                echo '<i class="element">' . file_get_contents($path) . '</i>';
                            } ?>
                        </div>
    
                        <h2><?php echo get_sub_field('valores_titulo'); ?></h2>
                        <p><?php echo get_sub_field('valores_texto'); ?></p>
                    </div>
                <?php endwhile;
            endif; ?>
        </div>

    </div>

</section>

<section class="teses" id="teses">

    <div class="wrapper">

        <div class="teses-cima">
            <h3><?php echo get_field('tese_titulo'); ?></h3>
            <h2><?php echo get_field('teses_titulo_2'); ?></h2>
        </div>

        <div class="teses-content">

            
            <div class="teses-esquerda">

                <p><?php echo get_field('teses_texto'); ?></p>
            </div>

            <div class="teses-direita">
                <?php if (have_rows('teses_repetidor')) : ?>
                    <div class="accordion-container">
                        <?php while (have_rows('teses_repetidor')) : the_row(); ?>
                            <div class="accordion-item">
                                <button class="accordion-header">
                                    <h4><?php echo get_sub_field('repetidor_item_'); ?></h4>
                                    <span class="accordion-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                            <circle opacity="0.15" cx="16" cy="16" r="15.5" stroke="#111445"/>
                                            <path d="M10 14L16 20L22 14" stroke="#111445" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </button>
                                <div class="accordion-content">
                                    <div class="content-inner">
                                        <h5><?php echo get_sub_field('repetidor_texto'); ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</section>

<section class="produtos">
    
    <?php
    if (have_rows('produtos')) :
        while (have_rows('produtos')) : the_row(); 
            $image = get_sub_field('produtos_imagem');
            $titulo = get_sub_field('produtos_titulo');
            $link_text = get_sub_field('produtos_botao');
            ?>
            
            <div class="produto-item">
                <?php if ($image) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                <?php endif; ?>

                <div class="produto-overlay">
                    <div class="produto-info">
                        <h2><?php echo esc_html($titulo); ?></h2>
                        <?php
                            $link = get_sub_field('produtos_botao');
                            if ($link) :
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
    
    <div class="porta-text">
        <?php echo get_field('porta_titulo'); ?>
    </div>

    <div class="porta-botao">
        <?php
            $link = get_field('porta_botao');
            if ($link) :
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                <a class="" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                    <p class=""><?php echo esc_html($link_title); ?></p>
                </a>
            <?php endif; ?>
    </div>
</section>

<section class="footer" id="contato">
    <?php if ($bg = get_field('footer_background')) : ?>
        <div class="footer-bg-image">
            <img src="<?php echo $bg['url']; ?>" alt="<?php echo $bg['alt']; ?>">
        </div>
    <?php endif; ?>

    <div class="container-footer">
        <div class="footer-content-wrapper">
            <div class="quote-wrapper">
                <div class="quote-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="93" height="62" viewBox="0 0 93 62" fill="none">
                        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M93 0L59.2904 62H41.6891L75.3987 0H93ZM51.3109 0L17.6013 62H0L33.7096 0H51.3109ZM91.8021 0.712964H75.8213L42.8869 61.287H58.8678L91.8021 0.712964ZM50.1131 0.712964H34.1322L1.19789 61.287H17.1787L50.1131 0.712964Z" fill="#070932"/>
                    </svg>
                </div>
                
                <h2><?php echo get_field('footer_texto'); ?></h2>

                <div class="signature-box">
                    <?php $svg_file = get_field('assinatura_real_state');
                    if ($svg_file) : ?>
                        <img src="<?php echo $svg_file['url']; ?>" alt="Assinatura">
                    <?php endif; ?>
                </div>
            </div>

            <div class="contact-box">
                <a href="mailto:<?php echo get_field('footer_contato'); ?>">
                    <?php echo get_field('footer_contato'); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="footer-brand-bottom">
        <h4><?php echo get_field('footer_marca'); ?></h4>
        <div class="footer-logo-svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="31" viewBox="0 0 22 31" fill="none">
                <g opacity="0.15">
                    <path d="M17.166 23.5503L17.166 4.90626L6.86787 4.90626L10.7929 -6.39223e-05L22 -6.29425e-05L22 17.6627L17.166 23.5503Z" fill="#070932"/>
                    <path d="M4.83402 6.86426L4.83402 25.5083L15.1321 25.5083L11.2071 30.4146L-4.14334e-06 30.4146L-1.03583e-06 12.7518L4.83402 6.86426Z" fill="#070932"/>
                </g>
            </svg>
        </div>
    </div>
</section>

<?php get_footer(); ?>