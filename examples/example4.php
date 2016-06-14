<?php 

/**
 * Example with relatrorio internal SQL using myslq
 */

require_once dirname(__FILE__).'/../Report.php';
Report::from('example4.jrxml')->outPut();