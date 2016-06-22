<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////
/// SIDE BAR LINKS ///
////////////////////////////////////////////////
$nav = array();
///ADMIN CONTROL////////////////////////////////
// $nav['dashboard'] = array('title'=>'<i class="fa fa-dashboard"></i> <span>Dashboard</span>','path'=>'site','exclude'=>1);
$config['sideNav'] = $nav;
//////////////////////////////////////////////////
/// RIGHT SIDE BAR LINKS ///
////////////////////////////////////////////////
$rnav = array();
	$controlSettings['users'] = array('title'=>'Users','path'=>'users','exclude'=>0);
	$controlSettings['roles'] = array('title'=>'Roles','path'=>'admin/roles','exclude'=>0);
$rnav['control'] = array('title'=>'<i class="fa fa-cogs"></i> Admin ','path'=>$controlSettings,'exclude'=>0);
$rnav['logout'] = array('title'=>'<i class="fa fa-sign-out fa-lg"></i>','path'=>'site/logout','exclude'=>1);
$config['rightSideNav'] = $rnav;