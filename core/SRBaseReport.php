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

class SRBaseReport{

	public $name = 'nameReport';

	// Page Size
	public $width = 595;
	public $heigth = 842;
	// Margins
	public $leftMargin = 20;
	public $rightMargin = 20;
	public $topMargin = 20;
	public $bottomMargin = 20;
	// More
	public $queryText = '';
	// Bands
	public $bandTitle;
	public $bandPageHeader;
	public $bandColumnHeader;
	public $bandDetail;
	public $bandColumnFooter;
	public $bandPageFooter;
	public $bandLastPageFooter;
	public $bandSummary;
	public $bandBackground;
	public $bandNoData;

	// Parameters
	public $parameters;
	public $variable;

	public function addVariable(SRVariable $sRVariable){
		$this->variable[] = $sRVariable;
	}

}
?>