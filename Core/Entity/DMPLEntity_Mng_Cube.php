<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: Entity - Classe pai para manipulação das entidades           **
** @Namespace	: Damaplan\Iris\ETL										   **
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
** @Date	 	: 04/07/2018                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment		: Primeira versão.                                             **
********************************************************************************/

 
namespace Damaplan\Iris\Core\Entity;

Use Damaplan\Iris\Core\DB\DMPLEntity;

class DMPLEntity_Mng_Cube extends DMPLEntity {
	
	protected $_tableName = 'MNG_Cubes';
	protected $_primaryKey = array('Id');
	public $Id = null;
	public $Name = null;
	public $Description = null;
	public $Key = null;
	public $Query = null;
	public $CreateDate = null;
	public $EditDate = null;
	
	function __construct(){
		parent::__construct();
		$this->init();
	}
	
	public function init($aConfig = array()){

	}
	
	
}
