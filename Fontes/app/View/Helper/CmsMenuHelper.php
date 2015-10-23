<?php 
 /*
 * @copyright Copyright (c) 2014 BRASIL. (http://www.softwarepublico.gov.br/)
 *
 * This file is part of CMS Suindara.
 *
 * CMS Suindara is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * The CMS Suindara is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CMS Suindara.  If not, see the oficial website 
 * <http://www.gnu.org/licenses/> or the Brazilian Public Software
 * Portal <www.softwarepublico.gov.br>
 *
 * *********************
 *
 * Direitos Autorais Reservados (c) 2014 BRASIL. (http://www.softwarepublico.gov.br/)
 *
 * Este arquivo é parte do programa CMS Suindara.
 *
 * CMS Suindara é um software livre; você pode redistribui-lo e/ou
 * modifica-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 2 da
 * Licença, ou qualquer versão posterior
 *
 * O CMS Suindara é distribuido na esperança que possa ser útil,
 * porém, SEM NENHUMA GARANTIA; nem mesmo a garantia implicita de 
 * ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa, se não, acesse no website oficial
 * <http://www.gnu.org/licenses/> ou o Portal do Software Público 
 * Brasileiro <www.softwarepublico.gov.br>
 *
 */

App::uses('CmsAclMainSiteOnly', 'Cms');
App::uses('CmsMenuElement', 'View/Helper/Din');
App::uses('AuthComponent', 'Controller/Component');


class CmsMenuHelper extends AppHelper {
	public $helpers = array(
		'Html',
		'Inflector'
	);

	private $_items = array();

	private $Acl = null;

/**
 * Default Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		$this->_items = CmsMenu::items();
		$this->Acl = ClassRegistry::init('HabtmDbAcl');
		$this->Acl->settings = array('userModel' => 'Usuarios.Usuario', 'groupAlias' => 'Perfis.Perfil');
		parent::__construct($View, $settings);
	}

	public function adminMenus() {
		return $this->_adminMenus($this->_items);
	}
	private function _adminMenus($menus, $options = array(), $depth = 0) {
		$options = Hash::merge(array(
			'children' => true,
			'htmlAttributes' => array(
				
			),
		), $options);

		if($depth == 0)
			$options['htmlAttributes']['id'] = 'menu';

		$userId = AuthComponent::user('id');
		$sitePrincipal = AuthComponent::user('SiteAtual.Site.site_principal');
		
		if (empty($userId)) {
			return '';
		}

		$out = null;
		$sorted = Hash::sort($menus, '{s}.title', 'ASC');

		foreach ($sorted as $menu) {
			$htmlAttributes = $options['htmlAttributes'];

			$aco = '';
			if($menu['url'] != '#') {
				$plugin = $menu['url']['plugin'];
				$controller = $menu['url']['controller'];
				$action = $menu['url']['action'];

				$aco = 'controllers' . DS . $plugin . DS . $controller . DS . $action;
				$aro = array('model'=>'Usuario', 'foreign_key' => $userId);

				$check = $this->Acl->check($aro, $aco);

				if(!$sitePrincipal && !empty($plugin) && !empty($controller)) {
					if(!CmsAclMainSiteOnly::isAllowed(Inflector::camelize($plugin)))
						continue;

					if(!CmsAclMainSiteOnly::isAllowed(Inflector::camelize($plugin), Inflector::camelize($controller)))
						continue;

				}

				if(!$check)
					continue;
			}

			// if (empty($menu['htmlAttributes']['class'])) {
			// 	$menuClass = Inflector::slug(strtolower('menu-' . $menu['title']), '-');
			// 	$menu['htmlAttributes'] = Hash::merge(array(
			// 		'class' => $menuClass
			// 	), $menu['htmlAttributes']);
			// }

			$title = $menu['title'];
			$children = '';
			if (!empty($menu['children'])) {
				// $childClass = 'nav nav-stacked sub-nav ';
				// $childClass .= ' submenu-' . Inflector::slug(strtolower($menu['title']), '-');
				// if ($depth > 0) {
				// 	$childClass .= ' dropdown-menu';
				// }
				$children = $this->_adminMenus($menu['children'], array(
					'children' => true,
					//'htmlAttributes' => array('class' => $childClass),
				), $depth + 1);

				if(!$children)
					continue;
				
				//$menu['htmlAttributes']['class'] .= ' hasChild dropdown-close';
			}

			//$menu['htmlAttributes']['class'] .= ' sidebar-item';

			$menuUrl = $this->url($menu['url']);
			if ($menuUrl == env('REQUEST_URI')) {
				if (isset($menu['htmlAttributes']['class'])) {
					$menu['htmlAttributes']['class'] .= ' selecionado';
				} else {
					$menu['htmlAttributes']['class'] = 'selecionado';
				}
			}
			$liOptions = array();
			// if (!empty($children) && $depth > 0) {
			// 	//$liOptions['class'] = ' dropdown-submenu';
			// }
			$link = null;
			if($menu['url'] == '#') {
				$link = '<span>'.$menu['title'].'</span>';
			} else {
				$link = $this->Html->link($title, $menu['url'], $menu['htmlAttributes']);
			}

			$out .= $this->Html->tag('li', $link . $children, $liOptions);
		}
		if($out == null)
			return null;
		return $this->Html->tag('ul', $out, $htmlAttributes);
	}



	/**
	 * Retorna os menus de acordo com os requisitos de query informados em '$options'.
	 * @param $options requisitos da query no padrão CakePHP () 
	 * @return array Categorias  
	 */
	public function getMenus(array $options = array()) {
		$opt = urlencode(json_encode($options));
	
		$menus = $this->requestAction(array('ra' => true, 
											'plugin' => 'menus', 
				      				        'controller' => 'menus', 
				      				        'action' => 'ra_query', 'all', $opt));
		
		//pr($menus); die();
		
															
		$cmsMenus = array();
		foreach ($menus as $menu) {
			//print_r($menu);
			$m = new CmsMenuElement($menu['Menu'], $this->_View);
			$this->montarSubitens($m, $m, $menu['MenuItem']);
			$cmsMenus[] = $m;
		}
		
											
		return $cmsMenus;	
	}
	

	/**
	 * Retorna o menu com id ou titulo $id_titulo. Caso exitam títulos iguais,
	 * o primeiro será retornado.
	 * @param $id_titulo ID ou título da menu 
	 * @return array Menu 
	 */	
	public function getMenu($id_titulo) {
		$menu = null;
		if (is_numeric($id_titulo)) {
			$menu = $this->getMenus(array('conditions' => array('Menu.id' => $id_titulo)));
		} else {
			$menu = $this->getMenus(array('conditions' => array('Menu.identificador' => $id_titulo)));
		}
		
		if (!empty($menu)) {
			return $menu[0];
		} else {
			return null;
			// menu não encontrado - gerar msg de erro
			//throw new Exception("Nenhum menu com identificador '{$id_titulo}' encontrado.");
		}		
	}
	
	protected function montarSubitens($menu, $parentMenuItem, array &$itensRepo, array &$usadas = array()) {
		foreach ($itensRepo as $k=>$item) {
			//print_r($usadas); print('</br>');
			if (($item['parent_id'] == null || $item['parent_id'] == 0) && !in_array($item['id'], $usadas)) {
				$newItem = $menu->addMenuItem($item);
				$usadas[] = $item['id'];
				$this->montarSubitens($menu, $newItem, $itensRepo, $usadas);
				
			} else if ($item['parent_id'] == $parentMenuItem->id && !in_array($item['id'], $usadas)) {
				$newItem = $parentMenuItem->addMenuItem($item);
				$usadas[] = $item['id'];
				$this->montarSubitens($menu, $newItem, $itensRepo, $usadas);
			}
		}		
	}

}