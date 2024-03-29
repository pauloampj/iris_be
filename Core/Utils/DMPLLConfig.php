<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: LConfig - Classe de armazenamento das configurações da	   **
**				  etapa de carregamento do ETL.								   **
** @Namespace	: Damaplan\Iris\Utils										   **
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
** @Comment		:                                                              **
** --------------------------------------------------------------------------- **
** @Developer	: @pauloampj                                                   **
** @Date	 	: 28/06/2018                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment		: Primeira versão.                                             **
********************************************************************************/

 
namespace Damaplan\Iris\Core\Utils;


class DMPLLConfig extends DMPLConfig {
	
	private $_driverName = '';
	private $_params = array();
	
	function __construct($aConfig = array()) {
		$this->init($aConfig);
	}
	
	public function init($aConfig = array()){
		if(isset($aConfig) && is_array($aConfig)){
			if(isset($aConfig['Driver'])) $this->setDriverName($aConfig['Driver']);
			if(isset($aConfig['Params'])) $this->setParams($aConfig['Params']);
			
			return true;
		}else{
			return false;
		}
	}
	
	public function getDriverName(){
		return $this->_driverName;
	}
	
	public function setDriverName($aName){
		$this->_driverName = $aName;
	}
	
	public function getParams(){
		return $this->_params;
	}
	
	public function setParams($aParams){
		$this->_params = $aParams;
	}
		
}
