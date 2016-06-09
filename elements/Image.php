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
require_once dirname(__FILE__).'/../core/SRElements.php';

class Image extends SRElements{

	public $imageExpression;
	public $extension;

	public function fill(SimpleXMLElement $xml){
		
		foreach ($xml as $elementName => $element){
			switch($elementName){
				case 'reportElement':
					$this->x = (String)$element['x'];
					$this->y = (String)$element['y'];
					$this->width = (String)$element['width'];
					$this->height = (String)$element['height'];
					break;

				case 'imageExpression':
					$nameFile = str_replace('"', '', (String)$element);
					$this->extension = substr($nameFile, -3);
					$this->imageExpression = $nameFile;
					break;
			}
		}
	}

	public function draw(&$pdf){		
		$init = substr($this->imageExpression, 0, 3);
		$fim = substr($this->imageExpression, -1);

		if($init == '$P{' && $fim == '}'){
			$this->imageExpression = SRParameter::get(substr($this->imageExpression, 3, -1));
			$this->extension = 'gif';
		}

		$pdf->Image($this->imageExpression,$this->x,$this->y,$this->width,$this->height,$this->extension);
	}

}
?>