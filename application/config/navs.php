<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////
/// SIDE BAR LINKS ///
////////////////////////////////////////////////
$nav = array();
///ADMIN CONTROL////////////////////////////////
// $nav['dashboard'] = array('title'=>'<i class="fa fa-dashboard"></i> <span>Dashboard</span>','path'=>'site','exclude'=>1);

	$enrollment['enr-transactions'] = array('title'=>'Transactions','path'=>null,'exclude'=>0);
		$enrollment['enroll'] = array('title'=>'Enroll Student','path'=>'enrollment/form','exclude'=>0);
	$enrollment['enr-maintenance'] = array('title'=>'Transactions','path'=>null,'exclude'=>0);
		$enrollment['fees'] = array('title'=>'Fees','path'=>'enrollment/form','exclude'=>0);
$nav['enrollment'] = array('title'=>'<i class="fa fa-bookmark"></i> <span>Enrollment</span>','path'=>$enrollment,'exclude'=>0);
$nav['students'] = array('title'=>'<i class="fa fa-mortar-board"></i> <span>Students</span>','path'=>'students','exclude'=>0);	
$config['sideNav'] = $nav;
//////////////////////////////////////////////////
/// RIGHT SIDE BAR LINKS ///
////////////////////////////////////////////////
$rnav = array();
	$academic['aca-maintenance'] = array('title'=>'Maintenance','path'=>null,'exclude'=>0);
		$academic['courses'] = array('title'=>'Courses','path'=>'academic/courses','exclude'=>0);
		$academic['batches'] = array('title'=>'Batch','path'=>'academic/batches','exclude'=>0);
		$academic['subjects'] = array('title'=>'Subjects','path'=>'academic/subjects','exclude'=>0);
		$academic['aca_years'] = array('title'=>'Academic Years','path'=>'academic/years','exclude'=>0);
$rnav['academic'] = array('title'=>'<i class="fa fa-university"></i> <span>Academic</span>','path'=>$academic,'exclude'=>0);
	$controlSettings['con-maintenance'] = array('title'=>'Maintenance','path'=>null,'exclude'=>0);
		$controlSettings['users'] = array('title'=>'Users','path'=>'users','exclude'=>0);
		$controlSettings['roles'] = array('title'=>'Roles','path'=>'admin/roles','exclude'=>0);
		$controlSettings['company'] = array('title'=>'Company','path'=>'admin/company','exclude'=>0);
$rnav['control'] = array('title'=>'<i class="fa fa-cogs"></i> Admin ','path'=>$controlSettings,'exclude'=>0);
$rnav['logout'] = array('title'=>'<i class="fa fa-sign-out fa-lg"></i>','path'=>'site/logout','exclude'=>1);
$config['rightSideNav'] = $rnav;