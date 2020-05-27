<?php
/**
 * @var \App\View\AppView $this
 */
?>
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="newsletter">
                        <label>newsletter</label>
                        <form class="subcribe-form">
                            <input type="email" placeholder="Digite o seu e-mail" class="subcribe-text"/>
                            <input type="submit" value="Assinar" class="submit"/>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <ul class="socials">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-title">SITE SEGURO</div>
                    <?= $this->Html->image('seguro.png', ['fullBase' => true, 'class' => 'img-responsive mar-bottom-25']) ?>
                    <div class="footer-title">FORMAS DE PAGAMENTO</div>
                    <?= $this->Html->image('formas.png', ['fullBase' => true, 'class' => 'img-responsive mar-bottom-25']) ?>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="footer-title">GUIA DE COMPRA</div>
                            <ul class="menu-footer">
                                <li><a href="entrega.html">Prazos de Entrega</a></li>
                                <li><a href="formas-pagamento.html">Formas de Pagamento</a></li>
                                <li><a href="privacidade.html">Política de Privacidade</a></li>
                                <li><a href="troca.html">Política de Trocas e Devoluções</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="footer-title">INFORMAÇÕES</div>
                            <ul class="menu-footer">
                                <li><a href="conta.html">Sua Conta</a></li>
                                <li><a href="pedidos.html">Seus Pedidos</a></li>
                                <li><a href="login.html">Cadastre-se</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="footer-title">INSTITUCIONAL</div>
                            <ul class="menu-footer">
                                <li><a href="sobre.html">Sobre</a></li>
                                <li><a href="revendedor.html">Seja um Revendedor</a></li>
                                <li><a href="franqueado.html">Seja um franqueado</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            © 2016 HardCore Training Roupas e Acessórios Esportivos Ltda ME, todos os direitos reservados. <br/>
            R. Conselheiro Araújo, 28 - Centro - Curitiba, PR - 80060-230 | CNPJ: 18.870.750/0001-80 | +55 (41)
            3029-4900 <br/>
            Desenvolvido por <a target="_blank" href="https://nerdweb.com.br/">NERDWEB</a>
        </div>
    </div>
</footer>