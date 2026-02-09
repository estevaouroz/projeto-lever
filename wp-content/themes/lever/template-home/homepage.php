<?php
//Template Name: home
get_header();

?>

<section class="home">
    <div class="box-esquerda">
        <div class="box-esquerda-text">
            <div class="box-svg">
                <?php $svg_file = get_field('logo_home');
                if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                    echo '<i class="element">';
                    echo file_get_contents($svg_file['url']);
                    echo '</i>';
                } ?>
            </div>
    
            <h1><?php echo get_field('texto_home'); ?></h1>
            <h2><?php echo get_field('footer_home'); ?></h2>
        </div>
    </div>

        <div class="box-direita">
            <?php 
            $img_cima = get_field('family_office_background'); 
            $img_baixo = get_field('real_state_background');
            ?>

            <div class="box-direita-cima" style="background-image: url('<?php echo esc_url($img_cima['url']); ?>');">
                <div class="box-svg">
                    <?php $svg_file = get_field('logo_1');
                    if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                        echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
                    } ?>
                </div>
                <?php
                $link1 = get_field('botao_1');
                if ($link1) : ?>
                    <a href="<?php echo esc_url($link1['url']); ?>" target="<?php echo esc_attr($link1['target'] ?: '_self'); ?>">
                        <p><?php echo esc_html($link1['title']); ?></p>
                    </a>
                <?php endif; ?>
            </div>

            <div class="box-direita-baixo" style="background-image: url('<?php echo esc_url($img_baixo['url']); ?>');">
                <div class="box-svg">
                    <?php $svg_file = get_field('logo_2');
                    if ($svg_file && pathinfo($svg_file['url'], PATHINFO_EXTENSION) === 'svg') {
                        echo '<i class="element">' . file_get_contents($svg_file['url']) . '</i>';
                    } ?>
                </div>
                <?php
                $link2 = get_field('botao_2');
                if ($link2) : ?>
                    <a href="<?php echo esc_url($link2['url']); ?>" target="<?php echo esc_attr($link2['target'] ?: '_self'); ?>">
                        <p><?php echo esc_html($link2['title']); ?></p>
                    </a>
                <?php endif; ?>
            </div>
        </div>
</section>


<?php get_footer() ?>