<!DOCTYPE html>

<html lang="pt-BR">
  
  <?php echo $this->element('head'); ?>
  
  <body>
    <!-- barra de acessibilidade -->
    <div id="panel">
      <div class="navbar navbar-inverse navbar-fixed-top" id="advanced" style="margin-top: 0px; position: relative; ">
        <span class="trigger">
          <strong></strong>
          <em></em>
        </span>

        <?php echo $this->element('barra_acessibilidade'); ?>
      </div>
    </div>

    <!-- header -->
    <header>
      <div class="container clearfix">
        <div class="row">
          <div class="span12">
            <div class="navbar navbar_">
              <div class="container menor">

                <!-- Logo -->
                <?php echo $this->element('logo_preto'); ?>

                <!-- Menu -->
                <?php echo $this->element('menu'); ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="bg-content">  

      <!--  content  -->
      <a id="conteudo_ref" href="#conteudo_ref" class="menu_access_ref">In&iacute;cio do Conte&uacute;do</a>
      <div id="content"> 
       
         <!-- Topo -->
        <div class=" interno">
          <div class="center">
            <div class="block-slogan">
              <h2>Erro 404</h2>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row ">
            <div class="span12">
              <div class="block-404">  
                
                <img class="img-404" src="<?php echo $this->CmsTemplate->imagemPath('404.jpg') ?>" alt="">       
                
                <div class="box-404">
                  <h3>Página não encontrada</h3>          

                  <p>Descrição do erro congue nihil doming id quod mazim placerat facer possim assum orem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy euismod.</p>
                </div>

              </div>
            </div>
          </div>
        </div>  
      </div>
      <a id="finalconteudo_ref" href="#finalconteudo_ref" class="menu_access_ref">Final do Conte&uacute;do</a>

      <a href="#menu_ref" class="bt_voltar_topo">Voltar ao topo</a>
    </div>

    <!-- footer -->
    <?php echo $this->element('footer'); ?>

  </body>
</html>