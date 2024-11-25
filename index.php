<?php include('./includes/header.php'); ?>

<div class="container-banner">

        <div class="center">

                <div>
                        <div class="container-list">
                                <ul class="styled-list">
                                        <li class="list-item">Monitoramento de Despesas em Tempo Real</li>
                                        <li class="list-item">Análise Personalizada de Investimentos</li>
                                        <li class="list-item">Planejamento de Metas Financeiras</li>
                                        <li class="list-item">Acompanhamento de Empréstimos e Financiamentos
                                        </li>
                                </ul>
                        </div>
                </div>
                <div>
                        <div class="form">
                                <h2>Preencha o formulário e inicie a sua jornada para uma vida financeira
                                        equilibrada!</h2>
                                <form action="processar_formulario.php" method="POST" id="contactForm">
                                        <div class="input-container">
                                                <span>Nome*</span>
                                                <input type="text" name="nome" required />
                                        </div>

                                        <div class="input-container">
                                                <span>E-mail*</span>
                                                <input type="email" name="email" required />
                                        </div>

                                        <div class="input-container">
                                                <span>Telefone*</span>
                                                <input type="text" name="telefone" required />
                                        </div>

                                        <div class="input-submit-container1">
                                                <input type="submit" name="acao" value="Enviar">
                                        </div>
                                </form>
                        </div>
                </div>
                <div class="clear"></div>
                <div class="modal fade show" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
                        aria-hidden="false">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                        <div class="modal-header">
                                                <h5 class="modal-title" id="successModalLabel">Mensagem de
                                                        Sucesso</h5>
                                                <button type="button" class="btn-close"
                                                        aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                                <p>Logo entraremos em contato!</p>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>


        <div class="container-2">
                <div class="center-2">
                        <h2>Gerencie suas Finanças com Facilidade</h2>
                        <p>Com nossa plataforma de gestão financeira, você pode controlar suas despesas,
                                investimentos e
                                orçamentos de maneira simples e eficiente. Acompanhe sua saúde financeira com
                                relatórios
                                detalhados, defina metas de poupança, e tome decisões mais informadas para o seu
                                futuro
                                financeiro.</p>
                        <p>Comece agora a organizar suas finanças pessoais e descubra o poder do controle
                                financeiro.
                                Nossa plataforma oferece ferramentas intuitivas para maximizar seus ganhos e
                                minimizar
                                seus gastos.</p>
                        <p>Confira nossos recursos abaixo e comece a sua jornada financeira hoje mesmo!</p>
                </div>

                <div class="arrow">
                        <a href="#section-1" class="scroll-down"></a>
                </div>
        </div>

        <div class="section-1">
                <div class="center-3">
                        <h2>Aprenda com quem está no mercado</h2>

                        <div class="container-section">
                                <div class="container-single">
                                        <div><img src="images/icon.png" /></div>
                                        <div class="text-container-single">
                                                <h3>Estratégias de Investimento</h3>
                                                <p>Descubra as melhores estratégias de investimento com base no
                                                        seu
                                                        perfil de risco. A análise personalizada ajuda você a
                                                        maximizar
                                                        seus retornos enquanto mantém o controle sobre seus
                                                        riscos
                                                        financeiros.</p>
                                        </div>
                                </div>

                                <div class="container-single">
                                        <div><img src="images/icon.png" /></div>
                                        <div class="text-container-single">
                                                <h3>Planejamento de Metas</h3>
                                                <p>Aprenda a definir e alcançar suas metas financeiras. Nossa
                                                        plataforma
                                                        permite que você crie orçamentos personalizados,
                                                        controle suas
                                                        economias e prepare seu futuro financeiro.</p>
                                        </div>
                                </div>

                                <div class="container-single">
                                        <div><img src="images/icon.png" /></div>
                                        <div class="text-container-single">
                                                <h3>Acompanhamento de Dívidas</h3>
                                                <p>Gerencie suas dívidas de forma eficiente. Acompanhe os prazos
                                                        de
                                                        pagamento e as taxas de juros para evitar surpresas e
                                                        garantir
                                                        uma melhor saúde financeira.</p>
                                        </div>
                                </div>
                                <div class="clear"></div>
                        </div>
                </div>
        </div>

        <div class="container-endividamento">
                <div class="center-4">
                        <h2>Calcular Endividamento</h2>
                        <div class="input-container-2">
                                <span>Receitas:</span>
                                <input type="number" id="receita" placeholder="Digite o valor das receitas" />
                        </div>
                        <div class="input-container-2">
                                <span>Despesas:</span>
                                <input type="number" id="despesa" placeholder="Digite o valor das despesas" />
                        </div>
                        <div class="input-submit-container">
                                <button type="button" onclick="calcularEndividamento()">Calcular</button>
                        </div>
                        <p id="resultado"></p>
                </div>
        </div>

        <h2 class="w3-center title-video">Assista alguns vídeos para melhorar sua gestão financeira</h2>

        <div class="w3-padding w3-display-container videos">
                <div class="w3-row-padding w3-margin slides">
                        <div class="w3-third w3-content">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/A_QrsZuZVKQ?si=UAy1TKrDFt4pJpA1"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                        </div>

                        <div class="w3-third w3-content">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/Zx75N_0lWE0?si=sC-JF2aS5bdnlh5l"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                        </div>

                        <div class="w3-third w3-content">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/m_-hO9vzB3I?si=8tl1lDLeXX7I0UNn"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                        </div>
                </div>

                <div class="w3-row-padding w3-padding slides">
                        <div class="w3-third w3-content">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/xe6WzN0Mu5E?si=-GnAMCSL2Yd6zGTZ"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                        </div>

                        <div class="w3-third w3-content">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/2fEIsohevkI?si=RtSMAa7JFvH5FLC2"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                        </div>

                        <div class="w3-third w3-content">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/qpTVQ616wok?si=kt6erXYg7ZZuHkxa"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen></iframe>
                        </div>
                </div>

                <?php include('./includes/footer.php'); ?>
        </div>