<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: API Batches Controller - Classe para manipulação dos cubos.  **
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
** @Date	 	: 11/11/2019                                           	       **
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
Use Damaplan\Iris\Core\Entity\DMPLEntity_Mng_Batch;
Use Damaplan\Iris\Core\Entity\DMPLEntity_Mng_Cube;

class DMPLApiController_batches extends DMPLApiController {
	
	private function _getCubeByKey($aKey = null){
		$entity = new DMPLEntity_Mng_Cube ();
		$entity->load(array ('Key' => $aKey));
		$cube = $entity->serialize();
		
		return $cube;
	}
	
	private function _getWhereClause($aFilters = []){
		$where = '';
		foreach($aFilters as $key => $val){
			$where .= "AND $key";
			$where .= is_array($val) ? " IN (".implode(", ", $val).")" : "= '$val'";
		}
		
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
				$batchesList = new DMPLEntityList('DMPLEntity_Mng_Batch');
				$batchesList->load();
				$batches = $batchesList->get();
				$this->getResponse()->setContent($batches);
				
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
				$entity = new DMPLEntity_Mng_Batch ();
				$entity->load(array ('Key' => $data['Key']));
				$batch = $entity->serialize();
				$this->getResponse()->setContent( $batch );

				return true;
			}else{
				$this->getResponse()->setContent(DMPLErrors::get('BAD_PARAMETERS'));
				return false;
			}
		}else{
			return $this->respondMethodNotAllowed();
		}
	}
	
	public function save(){
		if(in_array($this->requestMethod(), array('POST'))){
			$data = $this->requestData();
			
			if(isset($data)){
				$cube = $this->_getCubeByKey($data['data']['cube']);
				$dbServer = DMPLEntity::getInstance('DMPLEntity_Cad_DBServer', array('Id' => $cube['DBServerId']));
				
				if(isset($dbServer['Password'])){
					$dbServer['Password'] = DMPLHash::decrypt($dbServer['Password']);
				}
				
				$className = DMPLParams::read ('DB_DRIVER_NAMESPACE') . '\\' . DMPLParams::read ('DATABASE_DRIVER_PREFIX') . '_DbSql';
				$dbDriver = new $className($this, array('DB' => array('Params' => $dbServer)));
				$keyColumn = isset($data['keyColumn']) ? $data['keyColumn'] : 'ID';
				$items = $dbDriver->selectQuery($this->_formatWhereClause($cube['RawQuery'], array($keyColumn => $data['items'])));
				
				$this->getResponse()->setContent($items);
				
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
