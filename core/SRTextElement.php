<?php
/*
 Copyright 2013 SimpleReport

Este arquivo é parte do SimpleReport

SimpleReport é uma biblioteca livre; você pode redistribui-lo e/ou
modifica-lo dentro dos termos da Licença Pública Geral GNU como
publicada pela Fundação do Software Livre (FSF); na versão 3 da
Licença, ou qualquer outra versão.

Este programa é distribuido na esperança que possa ser util,
mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a qualquer
MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
Licença Pública Geral GNU para maiores detalhes.

Você encontrará uma cópia da Licença Pública Geral GNU no diretório
license/COPYING.txt, se não, entre em <http://www.gnu.org/licenses/>
*/
require_once dirname(__FILE__).'/SRElements.php';

class SRTextElements extends SRElements{
	
	public $textAlignment = 'L';
	public $verticalAlignment = 'T';
	public $fontSize = 10;
	public $isBold = false;
	public $isItalic = false;
	public $isUnderline = false;
	public $isStrikeThrough = false;
	
	public $paintBackground;
	
	public $border = array();
	
	/*
	<box>
		<topPen lineWidth="0.0" lineStyle="Solid" lineColor="#000000"/>
		<leftPen lineWidth="1.0" lineStyle="Solid" lineColor="#F70905"/>
		<bottomPen lineWidth="0.0" lineStyle="Solid" lineColor="#000000"/>
		<rightPen lineWidth="1.0" lineStyle="Solid" lineColor="#F70905"/>
	</box>
	 * */

		
}

?>
