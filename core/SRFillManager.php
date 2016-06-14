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
require_once dirname(__FILE__).'/fpdf.php';
require_once dirname(__FILE__).'/SimplePrint.php';
require_once dirname(__FILE__).'/SRVariable.php';

class SRFillManager{

	public $pdf = null;
	public $report = null;
	public $dados = null;
	public $isFirstPage = true;
	public $islaSTPage = true;
	public $pageSizeFilled = 0;
	public $sizePage = 0;

	public function fillReport($args){
		$numP = func_num_args();
		$this->report = func_get_arg(0);

		if($numP >1)
			$this->dados = func_get_arg(1);

		if($this->dados === null && $this->report->queryText !== null){
			
			$con = new PDO(SR_DB_CONNECTION.":host=".SR_DB_HOST.";dbname=".SR_DB_DATABASE, SR_DB_USERNAME, SR_DB_PASSWORD);
			$rs = $con->query($this->report->queryText);
			$this->dados = SRDataSource::getInstance('SRPDO', $rs);
			
		}
		
		$this->sizePage = $this->report->heigth;
		$this->pdf = new FPDF('p', 'pt', 'A4');
		$this->pdf->SetAutoPageBreak(false);

		$this->addNewPage();

		if(empty($this->dados)){
			$this->rideReport();
		}else{
			$this->rideReportData();
		}

		return new SimplePrint($this->pdf);
	}

	private function rideReport(){
		
		$this->setBand($this->report->bandTitle);
		
		$this->setBand($this->report->bandPageHeader);
		$this->setBand($this->report->bandColumnHeader);
		$this->setBand($this->report->bandColumnFooter);
		$this->setBand($this->report->bandPageFooter);
		$this->setBand($this->report->bandLastPageFooter);
		$this->setBand($this->report->bandSummary);
		$this->setBand($this->report->bandBackground);
	}

	private function rideReportData(){

		$jaLeuTitleNessaPagina = false;
		$jaLeuPageHeaderNessaPagina = false;
		$jaLeuColumnHeaderNessaPagina = false;
		$jaPodeLerColumnFooter = false;
		$jaLeuDetail = false;

		while($r = $this->dados->next()){
			
			if($this->isFirstPage && !$jaLeuTitleNessaPagina){
				$this->setBand($this->report->bandTitle);
				$this->isFirstPage = false;
				$jaLeuTitleNessaPagina = true;
			}

			if(!$jaLeuPageHeaderNessaPagina){
				$this->setBand($this->report->bandPageHeader);
				$jaLeuPageHeaderNessaPagina = true;
			}

			if(!$jaLeuColumnHeaderNessaPagina){
				$this->setBand($this->report->bandColumnHeader);
				$jaLeuColumnHeaderNessaPagina = true;
			}

			$free = $this->findFreeSpace();
			$this->setBandDetail($this->report->bandDetail, $r);

			if(isset($this->report->bandDetail->height)){
				if(($free - $this->report->bandDetail->height) <= $this->report->bandDetail->height){
					$this->setBand($this->report->bandColumnFooter);
					$this->setBand($this->report->bandPageFooter);
					$this->addNewPage();
					$jaLeuPageHeaderNessaPagina = false;
					$jaLeuColumnHeaderNessaPagina = false;
				}
			}

		} // fim do while
		
		$this->setBand($this->report->bandSummary);
		$this->setBand($this->report->bandColumnFooter);
		$this->setBandPageFooter($this->report->bandLastPageFooter);
	}

	private function clearConfig(){
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFillColor(0,0,0);
		$this->pdf->SetFont('Arial', '', '10');
		
		$this->pdf->SetLineWidth(1);
		$this->pdf->SetDrawColor(0,0,0);
	}

	private function setBand($b){
		if(!empty($b)) $this->fillBand($b);
	}

	private function setBandPageFooter($b){
		if(!empty($b)) $this->fillBandPageFooter($b);
	}

	private function setBandDetail($b,$r){
		
		if(!empty($b)) $this->fillBandDetail($b, $r);
	}

	private function fillBandPageFooter(SRBand $band){
		if($band->isEmpty())
			return true;
		foreach ($band->getElements() as $element){
			$c = clone $element;
			$c->x += $this->report->leftMargin;
			$c->y -= $band->height+$this->report->bottomMargin;
			$c->draw($this->pdf, $this);
			unset($c);
			$this->clearConfig();
		}
	}

	private function fillBandDetail(SRBand $band, $record){

		if($band->isEmpty()){
			$this->pageSizeFilled += $band->height;
			return true;
		}
		
		foreach ($band->getElements() as $element){
			
			$c = clone $element;
			$c->x = $element->x + $this->report->leftMargin;
			$c->y = $element->y + $this->report->topMargin+$this->pageSizeFilled;

			$c->textFieldExpression = $record[@$element->textFieldExpression];
			$c->draw($this->pdf, $this);
			
			unset($c);
			$this->clearConfig();			
		}
		
		$this->pageSizeFilled += $band->height;
	}

	private function fillBand(SRBand $band){

		if($band->isEmpty()){
			$this->pageSizeFilled += $band->height;
			return true;
		}
			
		foreach ($band->getElements() as $element){

			$c = clone $element;
			$c->x += $this->report->leftMargin;
			$c->y += $this->report->topMargin+$this->pageSizeFilled;

			$c->draw($this->pdf, $this);
			unset($c);
			$this->clearConfig();
		}

		
		$this->pageSizeFilled += $band->height;
	}

	private function addNewPage(){
		$this->pdf->SetMargins($this->report->leftMargin, $this->report->topMargin, $this->report->rightMargin);
		$this->pdf->AddPage();
		$this->pdf->SetFont('Arial');
		$this->pageSizeFilled = 0;
	}

	private function findFreeSpace(){
		$totalSizeBands = 0;
		if(!is_null($this->report->bandColumnFooter))
			$totalSizeBands += $this->report->bandColumnFooter->height;
		if(!is_null($this->report->bandPageFooter))
			$totalSizeBands += $this->report->bandPageFooter->height;
		return $this->sizePage-($this->pageSizeFilled+$totalSizeBands+$this->report->bottomMargin);
	}

}
?>