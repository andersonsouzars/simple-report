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
require_once dirname(__FILE__).'/ISRElements.php';

class SRElements implements ISRElements{
	
	//<reportElement mode="Opaque" x="60" y="24" width="100" height="30" forecolor="#F70905" backcolor="#0D0303" uuid="e1b4a014-9e79-48cf-b38b-3a4c3edd85b8"/>
	public $x;
	public $y;
	public $width;
	public $height;
	public $forecolor;
	public $backcolor;
	public $paintBackground;
	
	public function fill(SimpleXMLElement $xml){}
	public function draw(&$pdf){}
}
?>