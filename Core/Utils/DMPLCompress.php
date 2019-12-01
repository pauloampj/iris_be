<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: Compress - Classe estática para o fazer a compactação de     **
**				  strings.													   **
** @Namespace	: Damaplan\Iris\Core\Utils								   **
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

namespace Damaplan\Iris\Core\Utils;

class DMPLCompress {
	
	public static function zip($aPlainText = ''){
		//return ("\x1f\x8b\x08\x00" . gzcompress($aPlainText, 9));
		return (gzcompress($aPlainText, 9));
	}
	
	public static function unzip($aZipText = ''){
		//return gzuncompress(substr($aZipText, 4));
		return gzuncompress($aZipText);
	}
	
}