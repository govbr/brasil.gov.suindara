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

	App::uses('CmsWrapper', 'View/Helper/Din');
	App::uses('BmTipo', 'Menus.Model.BmTipo');
	App::uses('CmsMontadorMenu', 'View/Helper/Util');
	
	define('MENU_ROOT', 0);
	define('MENU_SEMLINK', 1);
	define('MENU_LINK', 2);
	define('MENU_PAGINA', 3);
	define('MENU_CATEGORIA', 4);

	class CmsMenuElement extends CmsWrapper {
		/**
		 * Subitens do menu ou null caso não possua subitens.
		 */
		protected $itens;
		
		/**
		 * True se este é o nodo principal do menu.
		 */
		protected $root;
		
		/**
		 * Array com as propriedades das tags. ex: array('identificador'=>array('id'=>'nome'))
		 */
		protected $tagOpt;
		
		public function __construct(array $dbData, View $view) {
			parent::__construct($dbData, $view);
			
			$this->root = !isset($this->_dbData['bm_tipo_id']);
		}
	
		public function isRoot(){
			return $this->root;
		}


		public function addMenuItem(array $menuItem) {
			$item = new CmsMenuElement($menuItem, $this->_view);
			$this->itens[] = $item;
			
			return $item;
		}	
		
		public function addTagOptions(array $tagOptions) {
			foreach ($tagOptions as $name => $opt) {
				$this->tagOpt[$name] = $opt;
			}
		}

		public function getTagOptions(){
			return $this->tagOpt;
		}
		
		public function getTipo() {
			if ($this->root) {
				return MENU_ROOT;
			} else {
				return $this->bm_tipo_id;
			}
		}
		
		public function getItensDoTipo($tipo) {
			$itens = array();
			$this->_findItensDoTipo($tipo, $itens);
			return $itens;
		}
		
		protected function _findItensDoTipo($tipo, &$foundItens){
			if ($this->itens) {
				foreach ($this->itens as $item) {
					if ($item->getTipo() == $tipo) $foundItens[] = $item;
					
					$item->_findItensDoTipo($tipo, $foundItens);	
				}
			}	
		}
		
		public function getSubMenu($nome_ou_id) {
			if ($this->getItens()) {
				foreach ($this->getItens() as $m) {
					if ($m->identificador == $nome_ou_id || $m->id == (int)$nome_ou_id) return $m;
				}
			}
			
			throw new Exception("Nenhum sub-menu com identificador '{$nome_ou_id}' encontrado.");
			//return null;
		}
		
		public function getItens() {
			return $this->itens;
		}
		
		public function htmlMenu(CmsMontadorMenu $montador) {
			return $montador->htmlMenu($this);
			//return $this->_htmlFromType();	
		}
		
		public function getLink() {
			switch ($this->getTipo()) {
				case MENU_LINK : 
						$matches = array();
						if (preg_match("/^(www)|(.+?:\/\/).*$/", $this->link, $matches)){
							if ($matches[1]) return 'http://' . $this->link;
							//if ($matches[2]) return $this->link;
							return $this->link;
						} else {
							return Router::url($this->link , true);	
						}
				
				case MENU_PAGINA :
						$p = $this->_view->CmsPaginas->getPagina($this->pagina_id);
						return $p->getPath();
						
				case MENU_CATEGORIA :
						$c = $this->_view->CmsCategorias->getCategoria($this->categoria_id);
						return $c->getNoticiasPath();
						
				default :
						return '#';   	
			}
		}

		public function selectedMenu() {
			$itens = $this->getItens();
			if ($itens) {
				foreach ($this->getItens() as $lv2) { 				
					  $subLinks = array();	
					  if ($lv2->getItens()) {
					  		foreach ($lv2->getItens() as $it) {
					  			$subLinks[] = $it->getLink();
					  		}
					  }	
					
					$here = Router::url(null, true);

					if ($here != Router::url('/', true) 
						&& ($here == $lv2->getLink() || in_array($here, $subLinks))) {
						return $lv2;
					} else {
						return null;				
					}
				}
			}

			return null;

		}
		
		// Menu do site de acessibilidade
		// protected function _htmlFromType() {
		// 	$result = '';
			
		// 	$main = isset($this->tagOpt['main']) ? $this->tagOpt['main'] : array();
		// 	$second = isset($this->tagOpt['second']) ? $this->tagOpt['second'] : array();
			
		// 	if ($this->getTipo() == MENU_LINK && !empty($this->itens)) {
		// 		$result = $this->_view->Html->tag('li', null, $second);
		// 		$link = Router::url($this->link, true);
		// 		$result .= "<a href=\"{$link}\">{$this->nome}</a>";
		// 		$result .= "<p><a href=\"#\" class=\"expandir\">Expandir menu {$this->nome}</a></p>";
		// 		$result .= $this->_view->Html->tag('ul', null, $main);
		// 		if ($this->itens) {
		// 			foreach ($this->itens as $item) {
		// 				$result .= $item->htmlMenu();
		// 			}
		// 		} 
		// 		$result .= '</ul>';
		// 		$result .= '</li>';
		// 	} else if ($this->getTipo() == MENU_LINK) {
		// 		$result .= $this->_view->Html->tag('li', null, $second) . $this->_view->Html->link($this->nome, $this->link, $main) . '</li>';
		// 	} else if ($this->getTipo() == MENU_PAGINA) {
		// 		$p = $this->_view->CmsPaginas->getPagina($this->pagina_id);
		// 		$result .= $this->_view->Html->tag('li', null, $second) . $this->_view->Html->link($this->nome, $p->getPath()) . '</li>';
		// 	} else if ($this->getTipo() == MENU_CATEGORIA) {
		// 		$c = $this->_view->CmsCategorias->getCategoria($this->categoria_id);
		// 		$result .= $this->_view->Html->tag('li', null, $second) . $c->htmlNoticiasLink($main) . '</li>';
		// 	} else {
		// 		if ($this->root) { 
		// 			$result = $this->_view->Html->tag('ul', null, $main);
		// 		} else {
		// 			$result = $this->_view->Html->tag('li', null, $second);
		// 			$result .= "<a href=\"#\">{$this->nome}</a>";
  //   				$result .= "<p><a href=\"#\" class=\"expandir\">Expandir menu {$this->nome}</a></p>";
		// 			$result .= $this->_view->Html->tag('ul', null, $main);
		// 		}
		// 		//$result .= '(' . $this->nome . ')';
		// 		if ($this->itens) {
		// 			foreach ($this->itens as $item) {
		// 				$result .= $item->htmlMenu();
		// 			}
		// 		} 
				
		// 		$result .= '</ul>';
		// 		if (!isset($this->_dbData['site_id'])) {
		// 			$result .= '</li>';
		// 		}
		// 	}	
			
		// 	return $result;
		// }
	}
