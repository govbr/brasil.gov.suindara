<?php 

	App::uses('CmsImagem', 'View/Helper/Din');
	App::uses('CmsVideo', 'View/Helper/Din');
	App::uses('CmsAudio', 'View/Helper/Din');
	App::uses('CmsArquivo', 'View/Helper/Din');

	define('TIMG_GRANDE', 'gd');
	define('TIMG_MEDIA' ,'md');
	define('TIMG_ORIGINAL','or');
	define('TIMG_PEQUENA', 'pq');
	define('TIMG_THUMB','th');	
			
	define('TC_NOTICIA', 'noticia');
	define('TC_PAGINA', 'pagina');


	class CmsMidiasHelper extends AppHelper {
		
		public function __construct(View $view, array $settings) {
			parent::__construct($view, $settings);
			
			
		}
		
		/**
		 * Retorna a imagem de destaque para a notícia ou página
		 * @param $noticia_id ID da notícia 
		 * @return array informações da imagem 
		 */
		public function getImagemDestaque($id, $tipo_conteudo = TC_NOTICIA) {
			if ($id) {
				$destaqueRaw = $this->requestAction(array('ra' => true,
												  'plugin' => 'Midias', 
					      				          'controller' => 'MidiasConteudos', 
					      				          'action' => 'ra_getImagemDestaque', $tipo_conteudo, $id));
				if (!empty($destaqueRaw)) {												  
					return new CmsImagem($destaqueRaw['Midia'], $this->_View);
				} else {
					return false;
				}
				
			} else {
				return null;
			}
		}
		
		/**
		 * Retorna as imagens relacionadas a notícia ou página
		 * @param $noticia_id ID da notícia
		 * @param $comImagemDestaque Se a imagem de destaque deve ser incluida(true) na listagem 
		 * @return array imagens 
		 */
		public function getImagens($id, $tipo_conteudo = TC_NOTICIA, $comImagemDestaque = false, $maximoDeImagens = null) {
			if ($id) {
				$imagensRaw = $this->requestAction(array('ra' => true,
												  'plugin' => 'Midias', 
					      				          'controller' => 'MidiasConteudos', 
					      				          'action' => 'ra_getImagens', $tipo_conteudo, 
					      				          							   $id, 
					      				          							   (int) $comImagemDestaque,
																			   $maximoDeImagens) );
																			   
				$imagens = array();
				foreach ($imagensRaw as $imgRaw) {
					 $imagens[] = new CmsImagem($imgRaw['Midia'], $this->_View); 
				}

				return $imagens;		
			} else {
				return null;
			}
		}
		
		
		/**
		 * Retorna os videos relacionadas a notícia ou página 
		 * @param $noticia_id ID da notícia 
		 * @return array imagens 
		 */
		public function getVideos($id, $tipo_conteudo = TC_NOTICIA) {
			if ($id) {
				$videosRaw = $this->requestAction(array('ra' => true,
												  'plugin' => 'Midias', 
					      				          'controller' => 'MidiasConteudos', 
					      				          'action' => 'ra_getVideos', $tipo_conteudo, 
					      				          							   $id) );
																			   
				$videos = array();
				foreach ($videosRaw as $vidRaw) {
					 $videos[] = new CmsVideo($vidRaw['Midia'], $this->_View); 
				}

				return $videos;		
			} else {
				return null;
			}
		}
		
		
		/**
		 * Retorna os audios relacionadas a notícia ou página 
		 * @param $id ID da notícia ou página 
		 * @return array audios 
		 */
		public function getAudios($id, $tipo_conteudo = TC_NOTICIA) {
			if ($id) {
				$audiosRaw = $this->requestAction(array('ra' => true,
												  'plugin' => 'Midias', 
					      				          'controller' => 'MidiasConteudos', 
					      				          'action' => 'ra_getAudios', $tipo_conteudo, 
					      				          							   $id) );
																			   
				$audios = array();
				foreach ($audiosRaw as $adRaw) {
					 $audios[] = new CmsAudio($adRaw['Midia'], $this->_View); 
				}

				return $audios;		
			} else {
				return null;
			}
		}


		/**
		 * Retorna os arquivos relacionadas a notícia ou página 
		 * @param $noticia_id ID da notícia  ou página
		 * @return array arquivos 
		 */
		public function getArquivos($id, $tipo_conteudo = TC_NOTICIA) {
			if ($id) {
				$arquivosRaw = $this->requestAction(array('ra' => true,
												  'plugin' => 'Midias', 
					      				          'controller' => 'MidiasConteudos', 
					      				          'action' => 'ra_getArquivos', $tipo_conteudo, 
					      				          							   $id) );
						
				$arquivos = array();
				foreach ($arquivosRaw as &$arq) {
					 $arquivos[] = new CmsArquivo($arq['Midia'], $this->_View); 
				}

				return $arquivos;		
			} else {
				return null;
			}
		}
		
		
		
	}
