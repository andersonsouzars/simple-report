<?php

/**
 * Example to demonstrate the use of parameters of the report
 */

require_once dirname(__FILE__).'/../Report.php';

SRParameter::set("NAME2", "ANDERSON");
Report::from('example2.jrxml')->outPut();