<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: ETLContext - Classe de armazenamento das configurações de    **
**				  contexto do ETL.											   **
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


class DMPLEtlContext {
	
	private $_EConfig = null;
	private $_TConfig = null;
	private $_LConfig = null;
	private $_entity = null;

	function __construct($aContext = array()) {
		$this->init($aContext);
	}
	
	public function setEConfig($aConfig = null){
		$this->_EConfig = $aConfig;
	}
	
	public function getEConfig(){
		return $this->_EConfig;
	}
	
	public function setTConfig($aConfig = null){
		$this->_TConfig = $aConfig;
	}
	
	public function getTConfig(){
		return $this->_TConfig;
	}
	
	public function setLConfig($aConfig = null){
		$this->_LConfig = $aConfig;
	}
	
	public function getLConfig(){
		return $this->_LConfig;
	}
	
	public function setEntity($aEntity = null){
		$this->_entity = $aEntity;
	}
	
	public function getEntity(){
		return $this->_entity;
	}
	
	public function setContext($aContext = array()){
		if(isset($aContext)){
			
			if(isset($aContext['Extractor'])){
				$this->setEConfig(new DMPLEConfig($aContext['Extractor']));
			}else{
				$this->setEConfig(null);
			}
			
			if(isset($aContext['Transformer'])){
				$this->setTConfig(new DMPLTConfig($aContext['Transformer']));
			}else{
				$this->setTConfig(null);
			}
			
			if(isset($aContext['Loader'])){
				$this->setLConfig(new DMPLLConfig($aContext['Loader']));
			}else{
				$this->setLConfig(null);
			}
			
			if(isset($aContext['Entity'])){
				$this->setEntity($aContext['Entity']);
			}else{
				$this->setEntity(null);
			}
		}
		return true;
	}
	
	
	public function init($aContext = array()){
		$this->setContext($aContext);
	}
	
	
	
}
