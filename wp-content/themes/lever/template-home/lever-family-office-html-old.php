<?php
/* 
Template Name: Lever Family Office 
*/
get_header();
?>


<div class="bg-secao-hero">
    <?php
    $image = get_field('hero_background');
    if ($image): ?>
        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="hero-bg-img">
    <?php endif; ?>

    <header class="hero-header">
    <a class="box-svg" href="<?php echo esc_url(home_url('/')); ?>">
        <?php $svg_file = get_field('hero_logo');
        if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
            echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
        } ?>
    </a>

        <nav class="hero-menu">
            <?php
            if (have_rows('hero_menu')):
                while (have_rows('hero_menu')):
                    the_row();
                    $link = get_sub_field('hero_menu_link');
                    if ($link):
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                            <?php echo esc_html($link_title); ?>
                        </a>
                    <?php endif;
                endwhile;
            endif; ?>
        </nav>
    </header>

    <section class="hero-content wrapper" id="home">
        <div class="hero-text-wrapper" data-aos="fade-left" data-aos-duration="2000">
            <h1><?php echo get_field('hero_titulo'); ?></h1>
            <p><?php echo get_field('hero_texto'); ?></p>
        </div>

        <div class="scroll-indicator">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M12 19L19 12M12 19L5 12" stroke="#070932" stroke-width="1" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
    </section>
</div>

<section class="foco">
    <div class="container-foco wrapper">
        <div class="content-esquerda">
            <h2><?php echo get_field('foco_titulo'); ?></h2>
            <h3><?php echo get_field('foco_texto'); ?></h3>
            <p><?php echo get_field('foco_texto_2'); ?></p>
        </div>

        <div class="content-direita">
            <div class="image-wrapper" data-aos="fade-up" data-aos-duration="2000">
                <?php
                $image = get_field('foco_imagem');
                if ($image): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                        class="img-principal">
                <?php endif; ?>

                <div class="elipse">
                    <?php
                    $icon = get_field('icon_flutuante');
                    if ($icon): ?>
                        <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="valores" id="sobre">
    <div class="bg-valores">
        <?php
        $image = get_field('fundo_secao_valores');
        if ($image): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                class="img-bottom">
        <?php endif; ?>
    </div>

    <div class="container-valores wrapper">
        <h2 data-aos="fade-up" data-aos-duration="1000"><?php echo get_field('valores_titulo'); ?></h2>

        <div class="grid-valores">
            <?php if (have_rows('valores_repetidor')): ?>
                <?php
                $delay = 0;
                ?>
                <?php while (have_rows('valores_repetidor')):
                    the_row(); ?>

                    <div class="item-valor" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="<?php echo $delay; ?>">

                        <div class="box-svg">
                            <?php
                            $svg_file = get_sub_field('valores_repetirodes_icon');
                            if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                                echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
                            } ?>
                        </div>

                        <h3><?php echo get_sub_field('valores_repetidor_titulo'); ?></h3>
                        <p><?php echo get_sub_field('valores_repetidor_texto'); ?></p>
                    </div>

                    <?php
                    $delay += 400;
                    ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="family-office" id="family-office">
    <div class="container-fo wrapper">
        <div class="fo-col-esquerda">
            <div class="fo-header">
                <h2><?php echo get_field('family_titulo'); ?></h2>
            </div>
            <div class="fo-content">
                <h3><?php echo get_field('family_texto'); ?></h3>
            </div>
        </div>

        <div class="fo-col-direita">
            <div class="accordion-container">
                <?php if (have_rows('family_acordeao')): ?>
                    <?php
                    $delay = 100;
                    ?>
                    <?php while (have_rows('family_acordeao')):
                        the_row(); ?>

                        <div class="accordion-item" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>"
                            data-aos-duration="1000">

                            <button class="accordion-header">
                                <h4><?php echo get_sub_field('family_repetidor_titulo'); ?></h4>
                                <span class="accordion-icon">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle opacity="0.15" cx="16" cy="16" r="15.5" stroke="white" />
                                        <path d="M10 14L16 20L22 14" stroke="white" stroke-width="1" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </button>

                            <div class="accordion-content">
                                <div class="content-inner">
                                    <h5><?php echo get_sub_field('family_repetidor_texto'); ?></h5>
                                </div>
                            </div>
                        </div>

                        <?php
                        $delay += 150;
                        ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div> <?php
    $image = get_field('icon_flutuante');
    if ($image): ?>
        <div class="fo-floating-icon">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
        </div>
    <?php endif; ?>
</section>

<section class="experiencia" id="expertise">
    <div class="exp-content wrapper" data-aos="fade-left" data-aos-duration="2000">
        <h2><?php echo get_field('expertise_titulo'); ?></h2>
        <h3><?php echo get_field('expertise_titulo_2'); ?></h3>
        <p><?php echo get_field('expertise_texto'); ?></p>
    </div>
</section>

<section class="processos">
    <h2 data-aos="fade-up"><?php echo get_field('processo_titulo'); ?></h2>

    <div class="processos-container wrapper">
        <?php
        if (have_rows('processo_lever_repetidor')):
            $delay = 0;

            while (have_rows('processo_lever_repetidor')):
                the_row();
                $col_index = get_row_index();
                $display_col = str_pad($col_index, 2, '0', STR_PAD_LEFT);
                ?>

                <div class="processo-coluna" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="processo-header">
                        <span class="num-col"><?php echo $display_col; ?></span>
                        <div class="header-text">
                            <h3><?php echo get_sub_field('processo_titulo'); ?></h3>
                        </div>
                    </div>

                    <div class="processo-itens">
                        <?php
                        if (have_rows('processo_item_repetidor')):
                            while (have_rows('processo_item_repetidor')):
                                the_row();
                                $item_index = get_row_index();
                                ?>
                                <div class="processo-item-card">
                                    <span class="num-item"><?php echo $col_index . '.' . $item_index; ?></span>
                                    <h4><?php echo get_sub_field('processo_item'); ?></h4>
                                </div>
                            <?php endwhile;
                        endif; ?>
                    </div>
                </div>

                <?php
                $delay += 800;
            endwhile;
        endif; ?>
    </div>
</section>

<?php
$bg_footer = get_field('footer_background');
$bg_url = $bg_footer ? $bg_footer['url'] : '';
?>

<section class="footer" id="contato" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
    <div class="footer-container wrapper">

        <div class="footer-body" data-aos="fade-left" data-aos-duration="2000">



            <div class="footer-quote-wrapper">
                <div class="quote-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="93" height="62" viewBox="0 0 93 62" fill="none">
                        <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd"
                            d="M93 0L59.2904 62H41.6891L75.3987 0H93ZM51.3109 0L17.6013 62H0L33.7096 0H51.3109ZM91.8021 0.712964H75.8213L42.8869 61.287H58.8678L91.8021 0.712964ZM50.1131 0.712964H34.1322L1.19789 61.287H17.1787L50.1131 0.712964Z"
                            fill="#070932" />
                    </svg>
                </div>

                <div class="footer-content">
                    <h2><?php echo get_field('footer_texto'); ?></h2>
                    <div class="box-svg-assinatura">
                        <?php $svg_file = get_field('assinatura_footer');
                        if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                            echo file_get_contents($svg_file['url']);
                        } ?>
                    </div>
                </div>
            </div>

            <div class="footer-contact-info">
                <h3><?php echo get_field('footer_contato'); ?></h3>

                <div class="footer-repetidor">
                    <?php if (have_rows('footer_repetidor')):
                        while (have_rows('footer_repetidor')):
                            the_row(); ?>
                            <div class="repetidor-item">
                                <h4><?php echo get_sub_field('footer_repetidor_pais'); ?></h4>
                                <h5><?php echo get_sub_field('footer_repetidor_endereco'); ?></h5>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
            </div>

            <div class="rodape">
                <?php $ano_atual = date('Y'); ?>

                <h4>© lever <?php echo $ano_atual ?></h4>
                <div class="box-svg-logo">
                    <?php $svg_file = get_field('footer_logo');
                    if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                        echo file_get_contents($svg_file['url']);
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>