<?php
	$this->Html->addCrumb('Listagem de Menus',  array('plugin' => 'menus', 'controller' => 'menus', 'action' => 'index'));
?>

<h2 class="row">Listagem de <span><?php echo $this->name; ?></span></h2>

<div class="row controlist">
	<?php echo $this->Html->link('Adicionar novo menu<span></span>', array('controller' => 'menus', 'action' => 'add', 'admin' => true), array('class' => 'threecol add', 'escape' => false)); ?>

	<div id="busca_simples" class="eightcol">
		<?php echo $this->Element('../Menus/_search'); ?>
	</div>
</div>

<?php if( empty($menuPaginate) ) { ?>
	<p class="noInfo">Nenhum registro encontrado. 
    <?php echo $this->Html->link('Voltar para a listagem de grupos.', 
                                 Router::url(array('plugin' => 'menus', 'controller' => 'menus', 'action' => 'index'), true)); ?>
    </p>
  	
<?php } else { ?>
	
	<?php $menuCount = count($menuPaginate); ?>

	<?php  if (!$this->request->isGet()) { ?>
        <p class="noInfo">
            <?php
                if ($menuCount > 1) {
             ?>
                Foram encontrados <?php echo $menuCount; ?> menus.
            
            <?php } else { ?>

                Foi encontrado 1 menu.

            <?php } ?>

            <?php echo $this->Html->link('Voltar para a listagem de menus.', 
                                     Router::url(array('plugin' => 'menus', 'controller' => 'menus', 'action' => 'index'), true)); ?>

            
        </p>
    <?php } ?>


	<table class="row" summary="Tabela de listagem de Menus.">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('nome', '<span class="bullet">Ordenar por </span><span class="texto">T&iacute;tulo do menu</span>', array('escape' => false) ); ?></th>
				<th>Identificador</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($menuPaginate as $menu): ?>
				<tr>
					<td><?php echo $this->CmsUtil->limitarTexto($menu['Menu']['nome'], 32, " ..."); ?></td>
					<td><?php echo $this->CmsUtil->limitarTexto($menu['Menu']['identificador'], 32, " ..."); ?></td>
					<td>
						<ul>
							<li><?php echo $this->Html->link('Itens do Menu <span class="oculto">menu: ' . $menu['Menu']['nome'] . '</span>', 
															 array('controller' => 'menu_itens', 'action' => 'index', 'admin' => true, $menu['Menu']['id']),
															 array('class'  => 'itensmenu',
														   	  	   'escape' => false)
															); ?></li>
	
							<li><?php echo $this->Html->link('Editar <span class="oculto">menu: ' . $menu['Menu']['nome'] . '</span>',
														   	 array('controller' => 'menus', 'action' => 'edit', 'admin' => true, $menu['Menu']['id']),
														   	 array('class'  => 'edit',
														   	  	   'escape' => false)
														   	); ?> </li>
	
							<li><?php echo $this->Html->link('Deletar <span class="oculto">menu: ' . $menu['Menu']['nome'] . '</span>', 
															 array('controller' => 'menus', 'action' => 'delete', 'admin' => true, $menu['Menu']['id']),
															 array('class'  => 'del',
															  	   'escape' => false),
															 'Você tem certeza que deseja deletar o menu ' . $menu['Menu']['nome'] . '?' 
															); ?> </li>
						</ul>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php } 

echo $this->Element('paginator');