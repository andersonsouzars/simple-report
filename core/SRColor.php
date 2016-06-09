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

class SRColor{
	
	public static function obtemRGB($color){
		if ($color[0] == '#')
			$color = substr($color, 1);
		
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
					$color[2].$color[3],
					$color[4].$color[5]);
		elseif (strlen($color) == 3)
		list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
		
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		
		return array($r, $g, $b);
	}
	
}
?>
