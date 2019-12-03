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
** @Date	 	: 01/12/2019                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment		: Primeira versão.                                             **
********************************************************************************/

 
namespace Damaplan\Iris\Core\Entity;

Use Damaplan\Iris\Core\DB\DMPLEntity;

class DMPLEntity_Cad_TableField extends DMPLEntity {
	
	protected $_tableName = 'CAD_TableFields';
	protected $_primaryKey = array('Id');
	public $Id = null;
	public $Name = null;
	public $Description = null;
	public $Field = null;
	public $TableId = null;
	public $Format = null;
	public $Size = null;
	public $CreateDate = null;
	public $EditDate = null;
	
	function __construct(){
		parent::__construct();
		$this->init();
	}
	
	public function init($aConfig = array()){

	}
	
	
}
