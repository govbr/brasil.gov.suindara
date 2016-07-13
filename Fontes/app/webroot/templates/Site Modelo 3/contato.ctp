<?php echo $this->element('head'); ?>

    <div class="bg-content"> 
  
      <!-- content -->
      <a id="conteudo_ref" class="menu_access_ref" accesskey="1" href="#conteudo_ref" title="In&iacute;cio do Conte&uacute;do">In&iacute;cio do Conte&uacute;do</a>
      <div id="content">
        
        <!-- Topo -->
        <div class=" interno">
          <div class="center">
            <div class="block-slogan">
              <h2>Contato</h2>
              
              <div>
                <p>Entre em contato conosco se desejar esclarecer dúvidas ou colaborar com críticas e sugestões.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="ic"></div>
    
        <div class="container cinterno">
          <div class="row">
            
            <article class="span8">
              <h3>Formulário de contato</h3>
              <?php
                $this->Html->addCrumb('Contato');
                echo $this->element('breadcrumb');
              ?>
              
              <div class="inner-1">
                  <form id="contact-form">
                  
                  <div class="success"> Mensagem enviada com sucesso!<strong> Retornaremos em breve.</strong> </div>
                  <fieldset>
                    <div>
                      <label class="name">
                        <input type="text" value="Seu nome" name="nome">
                        <span class="error">Este campo é obrigátorio.</span> <span class="empty">Este campo é obrigátorio</span> 
                      </label>
                    </div>

                    <div>
                      <label class="email">
                        <input type="email" value="Seu e-mail" name="email">
                        <span class="error">Este não é um e-mail válido.</span> <span class="empty">Este não é um e-mail válido.</span> 
                      </label>
                    </div>

                    <div>
                      <label class="message">
                        <textarea name="msg">Mensagem</textarea>
                        <span class="error">Este campo é obrigátorio.</span> <span class="empty">Este campo é obrigátorio.</span> 
                      </label>
                    </div>

                    <div class="buttons-wrapper"> 
                      <a class="btn btn-1" data-type="reset">Limpar campos</a>
                      <a href="#" class="btn btn-1 send" data-type="submit">Enviar</a>
                    </div>
                  </fieldset>
                </form>
              </div>
            </article>

            <article class="span4">
              <h3>Endereços</h3>
              
              <address class="address-1">
                <h4>Núcleo Bento Gonçalves</h4>

                <strong>
                  IFRS - Campus Bento Gonçalves,<br>
                  Av, Osvaldo Aranha, 540, Juventude<br>
                  Bento Gonçalves, RS – CEP: 95700-000
                </strong>

                <p class="overflow"> 
                  <span>Telefone:</span>+55 3455 3219<br>
                  <span>FAX:</span>+55 3455 3219<br>
                  <span>E-mail:</span> <a href="#" class="mail-1">contato@bento.ifrs.edu.br</a>
                </p>
              </address>

              <address class="address-1">
                <h4>Núcleo Catu</h4>

                <strong>
                  IF Baiano - Campus Catu,<br>
                  Rua Barão de Camaçari, 118, Centro<br>
                  Catu, BH - CEP: 48.110-000
                </strong>

                <p class="overflow"> 
                  <span>Telefone:</span>+55 3641 7917<br>
                  <span>E-mail:</span> <a href="#" class="mail-1">contato@bento.ifrs.edu.br</a>
                </p>
              </address>

              <address class="address-1">
                <h4>Núcleo Fortaleza</h4>

                <strong>
                  IFCE – Campus Fortaleza,<br>
                  Av. Treze de Maio, 2081, Benfica<br>
                  Fortaleza, CE - CEP: 60040-531
                </strong>

                <p class="overflow"> 
                  <span>Telefone:</span>+55 3493 2100<br>
                  <span>E-mail:</span> <a href="#" class="mail-1">contato@bento.ifrs.edu.br</a>
                </p>
              </address>

          </div>
        </div>
      </div>
      <a href="#finalconteudo_ref" id="finalconteudo_ref" class="menu_access_ref">Final do Conte&uacute;do</a>

      <a href="#" class="bt_voltar_topo">Voltar ao topo</a>
    </div>

    <!-- footer -->
    <?php echo $this->element('footer'); ?>

  </body>
</html>