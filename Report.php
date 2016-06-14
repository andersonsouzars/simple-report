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

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/core/SRXmlLoader.php';
require_once dirname(__FILE__).'/core/SRCompileManager.php';
require_once dirname(__FILE__).'/core/SRFillManager.php';
require_once dirname(__FILE__).'/core/SRDataSource.php';


final class Report{

	private $design;
	private $report;
	private $print;

	public function __construct($sourceFileName, $dados = null){
		$fileName = substr($sourceFileName, 0, -6);
		
		if(file_exists($fileName.'.sr') && SR_COMPILE === true){
			$this->report = SRInstanceManager::getInstance(file_get_contents($fileName.'.sr'));
		}else{
			$load = new SRXmlLoader();
			$this->design = $load->load($sourceFileName);
			$this->report = SRCompileManager::compile($this->design, $fileName);	
		}
		 
		$this->fill($dados);
	}

	public function fill($dados = null){
		$fill = new SRFillManager();
		$this->print = $fill->fillReport($this->report, $dados);
		return $this;
	}

	public function outPut(){
		$this->print->outPut();
	}

	public function export($name = 'doc.pdf'){
		$this->print->export($name);
	}

	public function save($name = 'doc.pdf'){
		$this->print->save($name);
	}
	
	public static function from($file, $dados = null){
		return new Report($file, $dados);
	}

}
?>