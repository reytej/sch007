<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////
/// SIDE BAR LINKS ///
////////////////////////////////////////////////
$nav = array();
///ADMIN CONTROL////////////////////////////////
// $nav['dashboard'] = array('title'=>'<i class="fa fa-dashboard"></i> <span>Dashboard</span>','path'=>'site','exclude'=>1);

	$academic['courses'] = array('title'=>'Courses','path'=>'academic/courses','exclude'=>0);
	$academic['batches'] = array('title'=>'Batch','path'=>'academic/batches','exclude'=>0);
	$academic['subjects'] = array('title'=>'Subjects','path'=>'academic/subjects','exclude'=>0);
	$academic['aca_years'] = array('title'=>'Academic Years','path'=>'academic/years','exclude'=>0);
$nav['academic'] = array('title'=>'<i class="fa fa-university"></i> <span>Academic</span>','path'=>$academic,'exclude'=>1);
$nav['students'] = array('title'=>'<i class="fa fa-mortar-board"></i> <span>Students</span>','path'=>'students','exclude'=>1);
$config['sideNav'] = $nav;
//////////////////////////////////////////////////
/// RIGHT SIDE BAR LINKS ///
////////////////////////////////////////////////
$rnav = array();
	$controlSettings['users'] = array('title'=>'Users','path'=>'users','exclude'=>0);
	$controlSettings['roles'] = array('title'=>'Roles','path'=>'admin/roles','exclude'=>0);
	$controlSettings['company'] = array('title'=>'Company','path'=>'admin/company','exclude'=>0);
$rnav['control'] = array('title'=>'<i class="fa fa-cogs"></i> Admin ','path'=>$controlSettings,'exclude'=>0);
$rnav['logout'] = array('title'=>'<i class="fa fa-sign-out fa-lg"></i>','path'=>'site/logout','exclude'=>1);
$config['rightSideNav'] = $rnav;