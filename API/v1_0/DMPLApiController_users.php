<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: API Users Controller - Classe para manipulação dos usuários. **
** @Namespace	: Damaplan\Iris\API\v1_0									   **
** @Copyright	: Damaplan Consultoria LTDA (http://www.damaplan.com.br)       **
** @Link		: http://norman.damaplan.com.br/documentation                  **
** @Email		: sistemas@damaplan.com.br					                   **
** @Observation : Esta ferramenta e seu inteiro teor é de propriedade da	   **
**				  Damaplan Consultoria e Estratégia LTDA. Não é permitida sua  **
**				  edição, distribuição ou divulgação sem prévia autorização.   **
** --------------------------------------------------------------------------- **
** @Developer	:                                                              **
** @Date	 	:                                                     	       **
** @Version	 	:                                                     	       **
** @Comment	 	:                                                              **
** --------------------------------------------------------------------------- **
** @Developer	: @pauloampj                                                   **
** @Date	 	: 25/07/2018                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment	 	: Primeira versão.                                             **
********************************************************************************/


namespace Damaplan\Iris\API\v1_0;

Use Damaplan\Iris\API\DMPLApiController;
Use Damaplan\Iris\Core\Auth\DMPLAuth;
Use Damaplan\Iris\Core\Auth\DMPLSession;
Use Damaplan\Iris\Core\Utils\DMPLErrors;
Use Damaplan\Iris\Core\DB\DMPLEntityList;
Use Damaplan\Iris\Core\Entity\DMPLEntity_Cad_User;
Use Damaplan\Iris\Core\Entity\DMPLEntity_Gen_Session;

class DMPLApiController_users extends DMPLApiController {
	
	private function _login($aStartSession = true){
		if(in_array($this->requestMethod(), array('POST'))){
			$data = $this->requestData();

			if(isset($data) && isset($data['Login']) && isset($data['Password'])){
				if(DMPLAuth::authenticate($data['Login'], $data['Password'])){
					if($aStartSession){
						if(DMPLSession::start($data['Login'], $this->getRequest()->getUserAgent())){
							$this->getResponse()->setContent(DMPLErrors::get('SESSION_SUCCESS'));
							return true;
						}else{
							$this->getResponse()->setContent(DMPLErrors::get('SESSION_NOT_STARTED'));
							return false;
						}
					}else{
						$this->getResponse()->setContent(DMPLErrors::get('AUTH_SUCCESS'));
						return true;
					}					
				}else{
					$this->getResponse()->setContent(DMPLErrors::get('AUTH_WRONG_PASSWORD'));
					return false;
				}
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	private function _logout(){
		if(in_array($this->requestMethod(), array('POST', 'GET'))){
			$data = $this->requestData();
			
			if(isset($data) && isset($data['Login'])){
				if(DMPLSession::close($data['Login'])){
					$this->getResponse()->setContent(DMPLErrors::get('SESSION_CLOSE'));
					return true;
				}else{
					$this->getResponse()->setContent(DMPLErrors::get('SESSION_NOT_CLOSED'));
					return false;
				}
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	private function _loadChildrenMenu($aMenuId = null, $aMenus = null){
		if(isset($aMenuId) && isset($aMenus)){
			$menuChilds = array();
			
			foreach($aMenus as $k => $v){
				if(!isset($v['parent_id'])){
					$v['parent_id'] = '';
				}
				
				if($v['parent_id'] == $aMenuId){
					if(!isset($v['children'])){
						$v['children'] = $this->_loadChildrenMenu($v['id'], $aMenus);
					}
					
					$menuChilds[$v['id']] = $v;
				}
			}
			
			return $menuChilds;
		}else{
			return null;
		}
	}
	
	private function _loadPagesLinks(&$aMenus = null){
		if(isset($aMenus) && is_array($aMenus)){
			$pageKeys = array();
			
			foreach($aMenus as $k => $menu){
				if(isset($menu['page_key']) && strlen($menu['page_key']) > 0){
					$pageKeys[] = $menu['page_key'];
				}
			}
			
			$pageUniqueKeys = array_unique($pageKeys);
			
			//Aqui, carrego a Entidade das pages e verifico o link delas...
			$pagesList = new DMPLEntityList('DMPLEntity_Gen_Page');
			$pagesList->setFilters(array(
					'Key' => $pageUniqueKeys
			));
			$pagesList->load();
			$pages = $pagesList->get();
			
			foreach($aMenus as &$menu){
				if(isset($menu['page_key']) && strlen($menu['page_key']) > 0){
					if(isset($pages[$menu['page_key']])){
						$p = $pages[$menu['page_key']];
						$wl = $p->getAttr('WebLink');
						$ml = $p->getAttr('MobileLink');
						$menu['web_link'] = (isset($wl) ? $wl: '');
						$menu['mobile_link'] = (isset($ml) ? $ml : '');
					}
				}
			}
		}		
	}
	
	private function _organizeMenuTree($aMenus = null){
		if(isset($aMenus)){
			$menuTree = array('root' => array('children' => array()));
			$parent = null;
			
			if(is_array($aMenus)){
				$menuTree['root']['children'] = $this->_loadChildrenMenu('', $aMenus);
			}
			
			return $menuTree;
		}else{
			return false;
		}
	}
	
	public function login(){
		return $this->_login(true);		
	}
	
	public function logout(){
		return $this->_logout();
	}
	
	public function authenticate(){
		return $this->_login(false);
	}
	
	public function menu(){
		if(in_array($this->requestMethod(), array('GET'))){
			$data = array(
					'user' => array(),
					'menus' => array(
							array(
									'id' => '1',
									'name' => 'Gestão',
									'description' => 'Módulo de gestão do sistema',
									'module_id'		=> '1',
									'icon' => '',
									'type_id' => 'LBL',
									'page_key' => '',
									'level'		=> '1',
									'parent_id' => '',
									'class' => 'dmpl-module-gen'
							),array(
									'id' => '2',
									'name' => 'Cadastros',
									'description' => 'Módulo de cadastros do sistema',
									'module_id'		=> '2',
									'icon' => '',
									'type_id' => 'LBL',
									'page_key' => '',
									'level'		=> '1',
									'parent_id' => '',
									'class' => 'dmpl-module-cad'
									
							),array(
									'id' => '3',
									'name' => 'Configurações',
									'description' => 'Módulo de configurações do sistema',
									'module_id'		=> '3',
									'icon' => '',
									'type_id' => 'LBL',
									'page_key' => '',
									'level'		=> '1',
									'parent_id' => '',
									'class' => 'dmpl-module-nor'
									
							),array(
									'id' => '4',
									'name' => 'Cubos',
									'description' => 'Cubos para busca de informações',
									'module_id'		=> '1',
									'icon' => 'pli-structure',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS001T01',
									'level'		=> '2',
									'parent_id' => '1',
									'path' => '1_4',
									'class' => 'dmpl-module-gen'
									
							),array(
									'id' => '5',
									'name' => 'Lotes',
									'description' => 'Lotes para integração com outros sistemas',
									'module_id'		=> '1',
									'icon' => 'pli-files',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS002T01',
									'level'		=> '2',
									'parent_id' => '1',
									'path' => '1_5',
									'class' => 'dmpl-module-gen'
									
							),array(
									'id' => '6',
									'name' => 'Operações',
									'description' => 'Operação de integração',
									'module_id'		=> '1',
									'icon' => 'pli-data-stream',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS009T01',
									'level'		=> '2',
									'parent_id' => '1',
									'path' => '1_6',
									'class' => 'dmpl-module-gen'
									
							),array(
									'id' => '7',
									'name' => 'Processos',
									'description' => 'Workflow de integração',
									'module_id'		=> '1',
									'icon' => 'pli-shuffle',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS003T01',
									'level'		=> '2',
									'parent_id' => '2',
									'path' => '2_7',
									'class' => 'dmpl-module-cad'
									
							),array(
									'id' => '8',
									'name' => 'Layouts',
									'description' => 'Layouts de integração',
									'module_id'		=> '2',
									'icon' => 'pli-file-horizontal-text',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS004T01',
									'level'		=> '2',
									'parent_id' => '2',
									'path' => '2_8',
									'class' => 'dmpl-module-cad'
									
							),array(
									'id' => '9',
									'name' => 'Tabelas',
									'description' => 'Tabelas dinâmicas para carregamento das informações',
									'module_id'		=> '2',
									'icon' => 'pli-big-data',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS005T01',
									'level'		=> '2',
									'parent_id' => '2',
									'path' => '2_9',
									'class' => 'dmpl-module-cad'
									
							),array(
									'id' => '10',
									'name' => 'Pessoas',
									'description' => 'Pessoas físicas ou jurídicas',
									'module_id'		=> '3',
									'icon' => 'pli-people-on-cloud',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS006T01',
									'level'		=> '2',
									'parent_id' => '2',
									'path' => '2_10',
									'class' => 'dmpl-module-cad'
									
							),array(
									'id' => '11',
									'name' => 'Variáveis de Ambiente',
									'description' => 'Variáveis carregadas dinamicamente para os arquivos',
									'module_id'		=> '3',
									'icon' => 'pli-formula',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS007T01',
									'level'		=> '2',
									'parent_id' => '3',
									'path' => '3_11',
									'class' => 'dmpl-module-nor'
									
							),array(
									'id' => '12',
									'name' => 'Parâmetros',
									'description' => 'Parâmetros gerais do sistema',
									'module_id'		=> '3',
									'icon' => 'pli-ruler-2',
									'type_id' => 'MN_1',
									'page_key' => 'PIRIS008T01',
									'level'		=> '2',
									'parent_id' => '3',
									'path' => '3_12',
									'class' => 'dmpl-module-nor'
							)
							
					)
			);
			$this->_loadPagesLinks($data['menus']);
			$data['menu_tree'] = $this->_organizeMenuTree($data['menus']);
			unset($data['menus']);
			$this->getResponse()->setContent($data);
			
			return true;
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	public function data(){
		if(in_array($this->requestMethod(), array('GET'))){
			$data = $this->requestData();
			
			if(isset($data)){
				if(isset($data['SessionKey'])){
					$session = new DMPLEntity_Gen_Session(array(
							'filters' => array(
									'Hash' => $data['SessionKey']
							)
					));
					$session->load();
					$sessionData = $session->serialize();
					$userId = $sessionData['UserId'];
				}elseif(isset($data['UserId'])){
					$userId = $data['UserId'];
				}else{
					$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
					return false;
				}
				
				$entity = new DMPLEntity_Cad_User ( array (
						'filters' => array (
								'Id' => $userId
						) 
				) );
				$entity->load();
				$user = $entity->serialize();
				
				if (isset($user) && is_array($user)) {
					//Removendo o atributo de senha para evitar roubo de informações.
					if(isset($user['Password'])){
						unset($user['Password']);
					}
					
					$this->getResponse()->setContent( $user );
					return true;
				} else {
					$this->getResponse()->setContent(DMPLErrors::get('USER_EMPTY'));
					return false;
				}
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
}
