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
require_once dirname(__FILE__).'/SimpleDesign.php';
require_once dirname(__FILE__).'/SRBand.php';
require_once dirname(__FILE__).'/SRParameter.php';
require_once dirname(__FILE__).'/SRColor.php';

require_once dirname(__FILE__).'/../elements/StaticText.php';
require_once dirname(__FILE__).'/../elements/TextField.php';
require_once dirname(__FILE__).'/../elements/Image.php';
require_once dirname(__FILE__).'/../elements/Rectangle.php';

/**
 *
 * @author anderson
 * @name SRXmlLoader
 * @version 1.0
 *
 * Essa classe é responsavel por converter o arquivo .jrxml em uma
 * instancia da classe SimpleReport
 */
class SRXmlLoader{

	private $sd = null;
	private $xml = null;

	private function fillBand($bandName, SimpleXMLElement $bandXML){

		if(!isset($bandXML['height']))
			return;

		$band = new SRBand();
		$band->height = (String)$bandXML['height'];
		$band->imprimir = false;
		
		foreach ($bandXML->children() as $element){
			
			if(file_exists(dirname(__FILE__).'/../elements/'.ucfirst($element->getName()).'.php')){
			
				$nameElement = $element->getName();

				$e = new $nameElement();
				$e->fill($element);
				$band->addElement($e);
			}

		}

		$a = 'band'.ucfirst($bandName);
		$this->sd->$a = $band;
	}

	public function load($sourceFileName){

		$xml = simplexml_load_file($sourceFileName);
		
		$this->sd = new SimpleDesign();
		$this->sd->name = (String)$xml['name'];
		$this->sd->width = (String)$xml['pageWidth'];
		$this->sd->heigth = (String)$xml['pageHeight'];
		$this->sd->topMargin = (String)$xml['topMargin'];
		$this->sd->rightMargin = (String)$xml['rightMargin'];
		$this->sd->leftMargin = (String)$xml['leftMargin'];
		$this->sd->bottomMargin = (String)$xml['bottomMargin'];

		foreach ($xml as $elementName => $element){
			
			switch ($elementName){
				
				case 'queryString':
					$this->sd->queryText = (String)$element; 
				case 'parameter':
					if(isset($element->defaultValueExpression))
						SRParameter::set((String)$element['name'], (String)$element->defaultValueExpression);
					break;

				case 'variable':
					$srVariable = new SRVariable();
					$srVariable->name = (String)$element['name'];
					$srVariable->variableExpression = (String)$element->variableExpression;
					$srVariable->value = 0;
					$this->sd->addVariable($srVariable);
					break;

				case 'title':
				case 'pageHeader':
				case 'columnHeader':
				case 'detail':
				case 'columnFooter':
				case 'pageFooter':
				case 'lastPageFooter':
				case 'summary':
					$this->fillBand($elementName, $element->band);
					break;
			}
		}
		return $this->sd;
	}

}
?>