<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: Bootstrap - Inicializa alguns elementos da aplicação.		   **
** @Namespace	: Damaplan													   **
** @Copyright	: Damaplan Consultoria LTDA (http://www.damaplan.com.br)       **
** @Link		: http://iris.damaplan.com.br/documentation                  **
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
** @Date	 	: 28/06/2018                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment	 	: Primeira versão.                                             **
********************************************************************************/

require 'paths.php';
require UTILS_PATH . 'DMPLParams.php';

Use Damaplan\Iris\Core\Utils\DMPLParams;

DMPLParams::write ('EXTRACTOR_DRIVER_PREFIX', 'DMPLEDriver');
DMPLParams::write ('EXTRACTOR_PAGINATOR_PREFIX', 'DMPLPaginator');
DMPLParams::write ('TRANSFORMER_DRIVER_PREFIX', 'DMPLTDriver');
DMPLParams::write ('LOADER_DRIVER_PREFIX', 'DMPLLDriver');
DMPLParams::write ('DATABASE_DRIVER_PREFIX', 'DMPLDatabase');
DMPLParams::write ('API_CONTROLLER_PREFIX', 'DMPLApiController');
DMPLParams::write ('SCHEMA_DRIVER_PREFIX', 'DMPLSDriver');

DMPLParams::write ('DB_DRIVER_NAMESPACE', 'Damaplan\Iris\Core\DB\Drivers');
DMPLParams::write ('ETL_DRIVER_NAMESPACE', 'Damaplan\Iris\Core\ETL\Drivers');
DMPLParams::write ('ETL_PAGINATOR_NAMESPACE', 'Damaplan\Iris\Core\ETL\Drivers');
DMPLParams::write ('API_CONTROLLER_NAMESPACE', 'Damaplan\Iris\API');
DMPLParams::write ('ENTITY_NAMESPACE', 'Damaplan\Iris\Core\Entity');
DMPLParams::write ('SCHEMA_DRIVER_NAMESPACE', 'Damaplan\Iris\Core\Schema\Drivers');

DMPLParams::write ('DATABASE.TABLE_NAMESPACE', 'Is_');
DMPLParams::write ('ENTITY.OVERWRITE_EXISTING_ITEMS', true);
DMPLParams::write ('ENTITY.DEFAULT_DRIVER', 'DbSql');
DMPLParams::write ('ENTITY.DEFAULT_DB_PARAMS', array(
		'DBMS' 			=> 'mysql',
		'Host' 			=> '127.0.0.1',
		'Port' 			=> '3306',
		'Database'		=> 'iris',
		'User'			=> 'norman',
		'PasswordHash'	=> '9ATWnLn6hg0jXkEKnvg/v5ZsFwa0SEl/jxT7LdsEy/S2XNfnLpGXfA9qx1BCMCwl2ZxE2y/8cmBR'
));
DMPLParams::write ('CRAWLER_USER_ID', 1);
DMPLParams::write ('DEBUG', true);
DMPLParams::write ('API.DEFAULT_VERSION', '1.0');
DMPLParams::write ('HOME_URL', 'http://iris.damaplan.com.br/pages/home');
DMPLParams::write ('DEFAULT_DOMAIN', 'damaplan.com.br');


DMPLParams::write ('SECURITY.CIPHER', 'aes-128-gcm');
DMPLParams::write ('SECURITY.PASSWORD_HASH_METHOD', 'md5');
DMPLParams::write ('SECURITY.SALT_KEY', 'db4035bcbea091af7df8f3db6404a5cb');

DMPLParams::write ('SESSION.TIME_TO_EXPIRE', 60 * 120);
DMPLParams::write ('SESSION.KEY', 'DMPL_SID');

require CONFIG_PATH . 'functions.php';
require CONFIG_PATH . 'autoload.php';
require CONFIG_PATH . 'gateways.php';
require CONFIG_PATH . 'schemas.php';
require CONFIG_PATH . 'content_searcher_map.php';
require CONFIG_PATH . 'errors.php';
