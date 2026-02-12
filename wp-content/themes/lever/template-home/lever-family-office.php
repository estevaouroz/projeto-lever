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
    <h6>Valores orientadores</h6>
    <div data-aos="fade-up" data-aos-duration="1300" class="column">
        <img src="img/barbell.svg" alt="">
        <h3>Barbell</h3>
        <p>
            Equilibrando solidez com impacto. Expondo a maior parte do portfólio ao menor risco existente, protegemos o
            patrimônio. Já com a menor parcela, busca-se a convexidade para produzir alpha. Essa simbiose guia-nos em
            cenários imprevisíveis.
        </p>
    </div>

    <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="500" class="column">
        <img src="img/negativo.svg" alt="">
        <h3>Via Negativa</h3>
        <p>
            Simplicidade inteligente: eliminar o inútil. Ao invés de adicionar, subtraímos ações desnecessárias e ou
            prejudiciais. Clareza do que não fazer reduz complexidade, evita riscos e prioriza o essencial.
        </p>

    </div>

    <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="1000" class="column">
        <img src="img/opcionalidade.svg" alt="">
        <h3>Opcionalidade</h3>
        <p>
            Acumular escolhas e não obrigações permite explorar assimetrias e proteger-se da ruína. Em essência: a
            sobrevivência é a prioridade, as opções o motor para prosperar.
        </p>

    </div>

</section>


<section id="family-office">
    <div class="container">
        <div class="left">
            <h6 class="white">family office</h6>
            <!-- <h2>Atuação LEVER<br> Family Office</h2> -->
            <p>Com um espírito de alfaiataria e posicionamento boutique, dedicamo-nos a "costurar" cuidadosamente as
                melhores práticas para preservar a riqueza das famílias High Net Worth. Priorizamos o tempo necessário
                para oferecer soluções personalizadas e exclusivas, garantindo o crescimento sustentável do patrimônio
                às gerações seguintes.</p>
            <!-- <a href="" class="button">
            <span>Conheça</span>
            </a> -->
        </div>
        <div class="right">
            <div class="accordion">
                <div data-aos="fade-up" data-aos-duration="1300" class="accordion-item">
                    <div class="accordion-header">
                        <h3>Governança Patrimonial</h3>
                        <div class="circle">
                            <img src="img/arrow.svg" alt="">
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p>Elaboração e gestão da estratégia de governança, preservando e desenvolvendo o patrimônio de
                            acordo com as metas e restrições de cada família.</p>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="250" class="accordion-item">
                    <div class="accordion-header">
                        <h3>Alocação de Ativos</h3>
                        <div class="circle">
                            <img src="img/arrow.svg" alt="">
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p>Definição e implementação do portfólio de investimentos financeiros, imobiliários e
                            societários, tanto em território nacional quanto no exterior.</p>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="500" class="accordion-item">
                    <div class="accordion-header">
                        <h3>Planejamento societário, tributário e sucessório</h3>
                        <div class="circle">
                            <img src="img/arrow.svg" alt="">
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p>Coordenação e implementação de estruturas societárias nacionais e internacionais, com foco na
                            proteção, elisão fiscal e sucessão patrimonial.</p>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="750" class="accordion-item">
                    <div class="accordion-header">
                        <h3>Gerenciamento de riscos</h3>
                        <div class="circle">
                            <img src="img/arrow.svg" alt="">
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p>Desenho, implementação e monitoramento de estratégias para proteção contra riscos conhecidos
                            e desconhecidos.
                        </p>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="1000" class="accordion-item">
                    <div class="accordion-header">
                        <h3>Family Business</h3>
                        <div class="circle">
                            <img src="img/arrow.svg" alt="">
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p>Assessoramento em finanças corporativas e estratégia dos negócios familiares, incluindo
                            estruturação de capital, fusões e aquisições, análise de investimentos e gestão de riscos.
                            Participação de conselhos consultivos ou de administração para garantir crescimento
                            sustentável e preservação patrimonial.</p>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="1250" class="accordion-item">
                    <div class="accordion-header">
                        <h3>Coordenação de serviços</h3>
                        <div class="circle">
                            <img src="img/arrow.svg" alt="">
                        </div>
                    </div>
                    <div class="accordion-body">
                        <p>Gerenciamento de prestadores de serviços locais e internacionais, como advogados, contadores,
                            banqueiros e corretores, para implementar a estratégia planejada de forma eficiente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <img src="img/circle-02.svg" alt="" class="circle-secondary">
    </div>
</section>


<section id="map">
    <div class="overflow">
        <div data-aos="fade-up" data-aos-duration="1300" class="left">
            <h6>nossa expertise</h6>
            <h2>Experiência e atuação internacional</h2>
            <p>Nossa experiência em atender famílias High Net Worth (HNW), levou-nos a escolher um caminho que prioriza
                a diversificação geográfica, cambial e econômica, tanto para os investimentos, quanto para as estruturas
                de proteção, elisão e sucessão patrimonial. A inteligência, o relacionamento de longo prazo, a ausência
                de conflito de interesse, a discrição e o sigilo serão ingredientes que sempre farão parte dessa longa
                jornada.</p>
        </div>
        <div data-aos="fade-left" data-aos-duration="1300" data-aos-delay="500" class="right">
            <img src="img/map.svg" alt="" class="map">
        </div>
    </div>
</section>

<section id="process">
    <h2>Processo LEVER Family Office</h2>
    <div class="board container">

        <div data-aos="fade-up" data-aos-duration="1300" class="column">
            <div class="table-header">
                <div class="number">01</div>
                <div class="title-wrapper">
                    <p>Etapa</p>
                    <div class="title">Diagnóstico</div>
                </div>
            </div>
            <div class="table-item">
                <div class="number">1.1</div>
                <p>NDA e recepção documental</p>
            </div>
            <div class="table-item">
                <div class="number">1.2</div>
                <p>Consolidação da estrutura patrimonial.</p>
            </div>
            <div class="table-item">
                <div class="number">1.3</div>
                <p>Análise e classificação através de metodologia proprietária.</p>
            </div>
        </div>

        <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="500" class="column">
            <div class="table-header">
                <div class="number">02</div>
                <div class="title-wrapper">
                    <p>Etapa</p>
                    <div class="title">Planejamento</div>
                </div>
            </div>
            <div class="table-item">
                <div class="number">2.1</div>
                <p>Mapeamento das alternativas estratégicas.</p>
            </div>
            <div class="table-item">
                <div class="number">2.2</div>
                <p>Definição do modelo, governança e mandato.</p>
            </div>
            <div class="table-item">
                <div class="number">2.3</div>
                <p>Elaboração do plano de ação.</p>
            </div>
        </div>

        <div data-aos="fade-up" data-aos-duration="1300" data-aos-delay="1000" class="column">
            <div class="table-header">
                <div class="number">03</div>
                <div class="title-wrapper">
                    <p>Etapa</p>
                    <div class="title">Operacionalização</div>
                </div>
            </div>
            <div class="table-item">
                <div class="number">3.1</div>
                <p>Implantação do plano de ação</p>
            </div>
            <div class="table-item">
                <div class="number">3.2</div>
                <p>Monitoramento contínuo da evolução das etapas.</p>
            </div>
            <div class="table-item">
                <div class="number">3.2</div>
                <p>Apresentação dos relatórios de resultado periodicamente.</p>
            </div>
        </div>

    </div>
</section>


<footer id="footer">

    <div class="left">
    </div>

    <div class="right">
        <div data-aos="fade-left" data-aos-duration="1300" class="quote">
            <h3>Saber o que não é possível controlar, entender como o desconhecido pode impactar suas decisões, buscar
                as
                assimetrias positivas e sempre possuir opcionalidade são alguns dos fatores essenciais à formação,
                proteção e
                perpetuação do patrimônio.</h3>
            <img src="img/signature.svg" alt="" class="signature">
        </div>
        <div class="contact">
            <div data-aos="fade-left" data-aos-duration="1300">
                <a href="mailto:contato@lever.global" class="mail">contato@lever.global</a>
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
            © LEVER Family Office
            <script>document.write(new Date().getFullYear())</script> – by Grisotti
        </span>
        <img src="img/symbol.svg" alt="" class="symbol">
    </div>


</footer>

<?php get_footer(); ?>