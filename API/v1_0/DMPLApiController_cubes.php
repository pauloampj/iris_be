<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: API Cubes Controller - Classe para manipulação dos cubos.	   **
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
** @Date	 	: 09/11/2019                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment	 	: Primeira versão.                                             **
********************************************************************************/


namespace Damaplan\Iris\API\v1_0;

Use Damaplan\Iris\API\DMPLApiController;
Use Damaplan\Iris\Core\Utils\DMPLErrors;
Use Damaplan\Iris\Core\DB\DMPLEntity;
Use Damaplan\Iris\Core\DB\DMPLEntityList;
Use Damaplan\Iris\Core\Utils\DMPLParams;
Use Damaplan\Iris\Core\Utils\DMPLHash;
Use Damaplan\Iris\Core\Entity\DMPLEntity_Mng_Cube;

class DMPLApiController_cubes extends DMPLApiController {
	
	private function _getCubeByKey($aKey = null){
		$entity = new DMPLEntity_Mng_Cube ();
		$entity->load(array ('Key' => $aKey));
		$cube = $entity->serialize();
		
		return $cube;
	}
	
	private function _getWhereClause($aFilters = []){
		$where = 'AND 1 = 1';
		
		return $where;
	}
	
	private function _formatWhereClause($aQuery = '', $aFilters = []){
		$where = $this->_getWhereClause($aFilters);
		
		return str_replace('$WHERE_VAR', $where, $aQuery);
	}
	
	public function list(){
		if(in_array($this->requestMethod(), array('GET'))){
			$data = $this->requestData();
			
			if(isset($data)){
				$cubesList = new DMPLEntityList('DMPLEntity_Mng_Cube');
				$cubesList->load();
				$cubes = $cubesList->get();
				$this->getResponse()->setContent($cubes);
				
				return true;
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	public function view(){
		if(in_array($this->requestMethod(), array('GET'))){
			$data = $this->requestData();
			
			if(isset($data)){
				$entity = new DMPLEntity_Mng_Cube ();
				$entity->load(array ('Id' => $data['Id']));
				$cube = $entity->serialize();
				$this->getResponse()->setContent( $cube );

				return true;
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	public function getFields(){
		if(in_array($this->requestMethod(), array('GET'))){
			$data = $this->requestData();
			
			if(isset($data)){
				$cube = $this->_getCubeByKey($data['Key']);
				$fieldsList = new DMPLEntityList('DMPLEntity_Mng_CubesFilterField');
				$fieldsList->load(array ('CubeId' => $cube['Id']));
				$fields = $fieldsList->get();
				$this->getResponse()->setContent(array_values($fields));
				
				return true;
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	public function load(){
		error_reporting(-1);
		ini_set('display_errors', 'On');

		if(in_array($this->requestMethod(), array('GET'))){
			$data = $this->requestData();
			
			if(isset($data)){
				$cube = $this->_getCubeByKey($data['cube']);
				$dbServer = DMPLEntity::getInstance('DMPLEntity_Cad_DBServer', array('Id' => $cube['DBServerId']));
				
				if(isset($dbServer['Password'])){
					$dbServer['Password'] = DMPLHash::decrypt($dbServer['Password']);
				}
				
				$className = DMPLParams::read ('DB_DRIVER_NAMESPACE') . '\\' . DMPLParams::read ('DATABASE_DRIVER_PREFIX') . '_DbSql';
				$dbDriver = new $className($this, array('DB' => array('Params' => $dbServer)));
				$items = $dbDriver->selectQuery($this->_formatWhereClause($cube['GroupQuery']));
				
				$eFields = new DMPLEntityList('DMPLEntity_Mng_CubesTableField');
				$eFields->load(array ('CubeId' => $cube['Id']));
				$fields = array_values($eFields->get());
				
				$d = array(
						'fields'	=> $fields,
						'keyColumn'	=> $cube['KeyColumn'],
						'items'		=> $items 
						
				);
				
				$this->getResponse()->setContent($d);

				return true;
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
}
