<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: API People Controller - Classe para manipulação dos cubos.   **
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
** @Date	 	: 12/11/2019                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment	 	: Primeira versão.                                             **
********************************************************************************/


namespace Damaplan\Iris\API\v1_0;

Use Damaplan\Iris\API\DMPLApiController;
Use Damaplan\Iris\Core\Utils\DMPLErrors;
Use Damaplan\Iris\Core\DB\DMPLEntityList;
Use Damaplan\Iris\Core\Entity\DMPLEntity_Cad_Person;

class DMPLApiController_people extends DMPLApiController {
	
	public function list(){
		if(in_array($this->requestMethod(), array('GET'))){
			$data = $this->requestData();
			
			if(isset($data)){
				$peopleList = new DMPLEntityList('DMPLEntity_Cad_Person');
				$peopleList->load();
				$people = $peopleList->get();
				$this->getResponse()->setContent($people);
				
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
				$entity = new DMPLEntity_Cad_Person ();
				$entity->load(array ('CPFCNPJ' => $data['CPFCNPJ']));
				$person = $entity->serialize();
				$this->getResponse()->setContent( $person );

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
