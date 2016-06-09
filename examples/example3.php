<?php

/**
 * Example to demonstrate the use of the bands and interaction data using the Vector class
 */

require_once dirname(__FILE__).'/../Report.php';

$data[] = array('name' => 'Anderson Souza','age' => '27','address' => 'Rio Grande - Brasil');
$data[] = array('name' => 'Hank Chaitchy','age' => '48','address' => 'Istambul - Turquia');
$data[] = array('name' => 'Dolores Rombold','age' => '12','address' => 'Karachi - Paquistao');
$data[] = array('name' => 'Raynor Soulpattle','age' => '25','address' => 'Lagos - Nigeria');
$data[] = array('name' => 'Thelma Brodder  ','age' => '78','address' => 'Xangai - China');


Report::from('example3.jrxml', SRDataSource::getInstance('Vetor', $data))->outPut();