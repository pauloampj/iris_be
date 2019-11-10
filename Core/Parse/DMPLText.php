<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: TEXT - Classe para manipular strings.		 				   **
** @Namespace	: Damaplan\Iris\Core\Parse								   **
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
** @Date	 	: 29/06/2018                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment	 	: Primeira versão.                                             **
********************************************************************************/

namespace Damaplan\Iris\Core\Parse;

class DMPLText {

	private $_rawData = '';
	private $_data = null;
	
	function __construct($aData = ''){
		$this->init($aData);
	}
	
	public function init($aData = ''){
		$this->_rawData= $aData;
	}
	
	
}