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
require_once dirname(__FILE__).'/../core/SRTextElement.php';
require_once dirname(__FILE__).'/../core/SRColor.php';

class StaticText extends SRTextElements{

	public $text;

	public function fill(SimpleXMLElement $xml){

		foreach ($xml as $elementName => $element){

			switch($elementName){
				case 'reportElement':
					$this->x = (String)$element['x'];
					$this->y = (String)$element['y'];
					$this->width = (String)$element['width'];
					$this->height = (String)$element['height'];
					if(isset($element['forecolor']))
						$this->forecolor = SRColor::obtemRGB((String)$element['forecolor']);
					if(isset($element['backcolor']))
						$this->backcolor = SRColor::obtemRGB((String)$element['backcolor']);
					$this->paintBackground = (String)$element['mode']=='Opaque';
					break;
					
				case 'textElement':
					$this->textAlignment = strtoupper((String)$element['textAlignment'])[0];
					$this->verticalAlignment = strtoupper((String)$element['verticalAlignment'])[0];
					$this->fontSize = (String)$element->font['size'];
					$this->isBold = (bool)$element->font['isBold'];
					$this->isItalic = (bool)$element->font['isItalic'];
					$this->isUnderline = (bool)$element->font['isUnderline'];
					$this->isStrikeThrough = (bool)$element->font['isStrikeThrough'];
					break;
					
				case 'text':
					$this->text = utf8_decode((String)$element);
					break;
					
				case 'box':
					$this->border['topPen'] = array(
						'lineWidth' => (String)$element->topPen['lineWidth'],
						'lineStyle' => (String)$element->topPen['lineStyle'],
						'lineColor' => SRColor::obtemRGB((String)$element->topPen['lineColor'])
					);
					$this->border['leftPen'] = array(
						'lineWidth' => (String)$element->leftPen['lineWidth'],
						'lineStyle' => (String)$element->leftPen['lineStyle'],
						'lineColor' => SRColor::obtemRGB((String)$element->leftPen['lineColor'])
					);
					$this->border['bottomPen'] = array(
						'lineWidth' => (String)$element->bottomPen['lineWidth'],
						'lineStyle' => (String)$element->bottomPen['lineStyle'],
						'lineColor' => SRColor::obtemRGB((String)$element->bottomPen['lineColor'])
					);
					$this->border['rightPen'] = array(
						'lineWidth' => (String)$element->rightPen['lineWidth'],
						'lineStyle' => (String)$element->rightPen['lineStyle'],
						'lineColor' => SRColor::obtemRGB((String)$element->rightPen['lineColor'])
					);
					break;
			}

		}
	}

	public function draw(&$pdf){

		$style = '';
		$style .=  $this->isBold? 'B' : '';
		$style .=  $this->isItalic? 'I' : '';
		$style .=  $this->isUnderline? 'U' : '';
		$pdf->SetFont('Arial', $style, $this->fontSize);

		if(!empty($this->forecolor)){
			$pdf->SetTextColor($this->forecolor[0],$this->forecolor[1],$this->forecolor[2]);
		}
		if(!empty($this->backcolor)){
			$pdf->SetFillColor($this->backcolor[0],$this->backcolor[1],$this->backcolor[2]);
		}

		/* PINTANDO O FUNDO*/
		$pdf->SetXY($this->x,$this->y);
		$pdf->Cell($this->width,$this->height,'', '', 0, '', $this->paintBackground);
				
		/* PINTANDO AS BORDAS */
		$pdf->SetXY($this->x,$this->y);
		foreach ($this->border as $chave => $borda){
			if($borda['lineWidth'] == 0.0){
				$pdf->SetXY($this->x,$this->y);
				continue;
			}
			$pdf->SetLineWidth($borda['lineWidth']);
			$pdf->SetDrawColor($borda['lineColor'][0],$borda['lineColor'][1],$borda['lineColor'][2]);
			$pdf->Cell($this->width,$this->height,'', strtoupper($chave[0]), 0, '', false);
			$pdf->SetXY($this->x,$this->y);
		}

		/* PINTANDO O TEXTO */
		$pdf->drawTextBox(
			$this->text,
			$this->width,
			$this->height,
			$this->textAlignment,
			$this->verticalAlignment,
			0
		);
		
	}

}

?>