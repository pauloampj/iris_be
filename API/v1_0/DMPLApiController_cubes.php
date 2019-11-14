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
Use Damaplan\Iris\Core\DB\DMPLEntityList;
Use Damaplan\Iris\Core\Entity\DMPLEntity_Mng_Cube;

class DMPLApiController_cubes extends DMPLApiController {
	
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
				//$cubesList = new DMPLEntityList('DMPLEntity_Mng_Cube');
				//$cubesList->load();
				//$cubes = $cubesList->get();
				$cubes = [
					['field' => 'CPF_CLIENTE', 'type' => 'text'],
					['field' => 'NUMERO_CONTRATO', 'type' => 'int'],
					['field' => 'VALOR_CONTRATO', 'type' => 'decimal'],
					['field' => 'DATA_CONTRATO', 'type' => 'date'],
					['field' => 'QTDE_PARCELAS', 'type' => 'int'],
					['field' => 'VALOR_PARCELA', 'type' => 'decimal']
				];
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
	
}
