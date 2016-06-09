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
class SimplePrint{

	private $pdf = '';
	
	public function __construct(FPDF $pdf){
		$this->pdf = $pdf;
	}
	
	public function outPut(){
		$this->pdf->Output();	
	}
	
	/**
	 * 
	 * @param String $name Nome do arquivo que será enviado para download
	 */
	public function export($name = 'doc.pdf'){
		$ext = substr($name, -4);
		if($ext != '.pdf')
			$name .= '.pdf';
		$this->pdf->Output($name, 'D');
	}
	
	public function save($name = 'doc.pdf'){
		$ext = substr($name, -4);
		if($ext != '.pdf')
			$name .= '.pdf';
		$this->pdf->Output($name, 'F');
	}
	
}
?>