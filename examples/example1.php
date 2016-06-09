<?php

/**
 * Simple example to show some elements implemented by simple Report
 */

require_once dirname(__FILE__).'/../Report.php';
Report::from('example1.jrxml')->outPut();