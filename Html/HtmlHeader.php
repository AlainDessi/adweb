<?php

/**
  * Fonction de gestion de Header HTML
  *
  * MySQL verion 5.5.43
  * PHP version 5.4.39-0
  *
  * @category  	Core MVC
  * @package   	CorePackage
  * @author    	DESSI Alain <alain.dessi@laposte.net>
  * @copyright 	2015 Dessi Alain
  * @license   	http://www.php.net/license/3_01.txt  PHP License 3.01
  * @link      	http://www.alain-dessi.com
  */

namespace html;

class HtmlHeader extends Html {

	/**
	 * [Script description]
	 * @param [type] $url_script [description]
	 */
	public function Script( $url_script )
  {
  		return "<script type=\"text/javascript\" src=\"" . $url_script . "\"></script>";
	}

	/**
	 * [Css description]
	 * @param [type] $url_css [description]
	 */
	public function Css( $url_css )
  {
	   	return "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url_css . "\" />";
	}

	public function Location($url, $root_url = ROOTURL)
  {
  		return header('Location:'.$root_url . '/' . $url );
	}

	/**
	 * [CacheControl description]
	 * @param string $type [description]
	 */
	public function CacheControl($type = 'must-revalidate')
  {
  		return header('Cache-Control: ' . $type );
	}

	/**
	 * [Expires description]
	 * @param INT $time  délai en secondes avant expiration
	 */
	public function Expires( $time )
  {
		$Expiration = "Expires: " . gmdate( "D, d M Y H:i:s",time() + $time ) . " GMT";
		return header( $Expiration );
	}




} // end class
