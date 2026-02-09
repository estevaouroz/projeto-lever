<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<meta name="format-detection" content="telephone=no">
	<title><?php wp_title(); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Sansation:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>

</head>


<body <?php body_class(""); ?>>

    <!-- <header class="header">
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
    </header> -->
