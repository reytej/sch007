<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Html{
	var $code = "";
    function __construct(){
    }
    function paramitize($params=array()){
    	$str = "";
    	foreach ($params as $param => $val) {
    		if($param != 'return'){
    			if($val != "")
	 				$str .= ' '.$param.'="'.$val.'" ';
	 			else
		 			$str .= " ".$param." ";
    		}
    	}
    	return $str;
    }
    function classitize($params=array(),$class=null){
    	if(isset($params['class']))
    		$params['class'] .= " ".$params['class']." ".$class." ";
    	else{
    		$params['class'] = " ".$class." ";
    	}
    	return $params;
    }
    function tag($tag=null,$text=null,$params=array(),$standAlone=false){
    	$str = "<".$tag." ";
    		$str .= $this->paramitize($params);
    	$str .= ">";
    	$str .= $text;
    	if(!$standAlone)
    		$str .= "</".$tag.">";
    	return $str;
    }
    function sTag($tag=null,$params=array()){
    	$str = "<".$tag." ";
    		$str .= $this->paramitize($params);
    	$str .= ">";
    	return $str;
    }
    function eTag($tag=null){
    	$str = "</".$tag.">";
    	return $str;
    }
    function returnitize($tags=array()){
    	$return = false;
    	if(isset($tags['return']))
    		$return = $tags['return'];
    	return $return;
    }
 	function code(){
		$code = $this->code;
		$this->clear();
		return $code;
	}
	function append($text=null){
		$this->code .= $text;
	}
	function clear(){
		$this->code = "";
	}
    /////////////////////////////////////////////////////////////
    /////	MAKE HTML CONTAINERS ///////////////////////////////
    ///////////////////////////////////////////////////////////
	    function sDiv($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eDiv($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sDivRow($params=array()){
	  		$str = "";
	  		$params = $this->classitize($params,'row');
	  		$str .= $this->sTag('div',$params);
	  		if($this->returnitize($params))
	  			 return $str;
	  		else
	  			$this->code .= $str;
	    }
	    function eDivRow($return=false){
	    	$str = $this->eTag('div');
	    	if($return)
	  			 return $str;
	  		else
	  			$this->code .= $str;
	    }
	    function sDivCol($length="12",$align="left",$offset=0,$params=array(),$return=false){
			$str = "";
			$off = "";
			if($offset > 0)
				$off = 'col-md-offset-'.$offset;
			$params = $this->classitize($params,"col-md-".$length." ".$off." text-".$align);
	  		$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eDivCol($return=false){
	    	$str = $this->eTag('div');
	    	if($return)
	  			 return $str;
	  		else
	  			$this->code .= $str;
	    }
	    function sBox($type='default',$params=array(),$return=false){
			$str = "";
			$params = $this->classitize($params,"box box-".$type);
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eBox($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sBoxHead($params=array()){
			$str = "";
			$params = $this->classitize($params,"box-header");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function boxTitle($text=null,$params=array()){
			$str = "";
			$params = $this->classitize($params,"box-title");
			$parama = $params;
			$parama['return'] = true;
			$str .= $this->H(3,$text,$parama);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eBoxHead($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sBoxBody($params=array()){
			$str = "";
			$params = $this->classitize($params,"box-body");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eBoxBody($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sBoxFoot($params=array()){
			$str = "";
			$params = $this->classitize($params,"box-footer");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eBoxFoot($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sPaper($params=array(),$return=false){
			$str = "";
			$params = $this->classitize($params,"invoice");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function ePaper($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
		function listGroup($lists=array(),$params=array()){
			$str = "";
			$params = $this->classitize($params," list-group ");
			$str .= $this->sTag('div',$params);
				if(is_array($lists)){
					foreach ($lists as $text => $opts) {
						$listParams = $this->classitize($opts," list-group-item ");
						if(isset($opts['href']))
							$href = $opts['href'];
						else
							$href = "#";
						$str .= $this->tag('a',$text,$listParams);
					}
				}
			$str .= $this->eTag('div');
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function sTab($params=array()){
			$str = "";
			$params = $this->classitize($params," nav-tabs-custom ");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTab($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
        function tabHead($tabs=array(),$active=null,$params=array(),$position_right=false){
			$str = "";
			$pos = "";
			if($position_right)
				$pos = 'pull-right';
			$params = $this->classitize($params," nav nav-tabs ".$pos." ");
			$str .= $this->sTag('ul',$params);
				if(is_array($tabs)){
					$ctr = 1;
					foreach ($tabs as $text => $opts) {
						if($text == "tab-title"){
							$liParams = array();
							$titpos = "pull-right";
							if($position_right)
								$titpos = 'pull-left';
							$liParams = $this->classitize($liParams,$titpos." tab-header");
							$str .= $this->sTag('li',$liParams);
							$str .= $opts;
							$str .= $this->eTag('li');
						}
						else{
							$act = "";
							if($active == null){
								if($ctr == 1)
									$act = "active";
							}
							else{
								$act = $active;
							}
							$addDisbale = "";
							if(isset($opts['disabled']))
								$addDisbale='disabled';
							$liParams = array();
							$liParams = $this->classitize($liParams," ".$act." ".$addDisbale);
							$str .= $this->sTag('li',$liParams);
								if(!isset($opts['data-toggle']))
									$opts['data-toggle'] = "tab";
								if($addDisbale != "")
									unset($opts['data-toggle']);
								$str .= $this->tag('a',$text,$opts);
							$str .= $this->eTag('li');
							$ctr++;
						}
					}
				}
			$str .= $this->eTag('ul');
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function sTabBody($params=array()){
			$str = "";
			$params = $this->classitize($params," tab-content ");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTabBody($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sTabPane($params=array()){
			$str = "";
			$params = $this->classitize($params," tab-pane ");
			$str .= $this->sTag('div',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTabPane($return=false){
	    	$str = $this->eTag('div');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sUl($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('ul',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eUl($return=false){
	    	$str = $this->eTag('ul');
	    	if($return) return $str; else $this->code .= $str;
	    }
	  	function li($text=null,$params=array()){
			$str = "";
			$str .= $this->tag('li',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function sLi($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('li',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eLi($return=false){
	    	$str = $this->eTag('li');
	    	if($return) return $str; else $this->code .= $str;
	    }
		function sTable($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('table',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTable($return=false){
	    	$str = $this->eTag('table');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sTablehead($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('thead',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTableHead($return=false){
	    	$str = $this->eTag('thead');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sTableBody($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('tbody',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTableBody($return=false){
	    	$str = $this->eTag('tbody');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sRow($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('tr',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eRow($return=false){
	    	$str = $this->eTag('tr');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function sTd($params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('td',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eTd($return=false){
	    	$str = $this->eTag('td');
	    	if($return) return $str; else $this->code .= $str;
	    }
		function td($text=null,$params=array(),$return=false){
			$str = "";
			$str .= $this->tag('td',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function th($text=null,$params=array(),$return=false){
			$str = "";
			$str .= $this->tag('th',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function rBreak($text='&nbsp;',$params=array(),$return=false){
			$str = "";
			$str .= $this->sTag('tr',$params);
				$paramCell['colspan'] = "100%";
				$str .= $this->tag('td',$text,$paramCell);
			$str .= $this->eTag('tr');
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
	/////////////////////////////////////////////////////////////
    /////	MAKE HTML INPUTS     ///////////////////////////////
    ///////////////////////////////////////////////////////////
	    function sForm($action="",$nameID="",$params=array(),$method="POST"){
			$str = "";
			$params['method'] = $method;
			$params['action'] = $action;
			if(!isset($params['id']))
				$params['id'] = $nameID;
			
			$params['role'] = 'form';
			$str .= $this->sTag('form',$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function eForm($return=false){
	    	$str = $this->eTag('form');
	    	if($return) return $str; else $this->code .= $str;
	    }
	    function input($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1=null,$icon2=null,$container=null){
	    	$str = "";

	    	if($container != null)
	    		$str .= $this->sTag('div',array('class'=>$container['class']));
			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'text';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null)
						$str .= $this->tag('span',$icon1,array('class'=>'input-group-addon'));
				}

				$params = $this->classitize($params,"form-control");
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null)
						$str .= $this->tag('span',$icon2,array('class'=>'input-group-addon'));
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');
			if($container != null)
				$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function inputWithBtn($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1=null,$icon2=null,$container=null){
	    	$str = "";

	    	if($container != null)
	    		$str .= $this->sTag('div',array('class'=>$container['class']));
			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'text';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null){
						$str .= $this->sTag('div',array('class'=>'input-group-btn'));
							$str .= $icon1;
						$str .= $this->eTag('div');
					}
				}

				$params = $this->classitize($params,"form-control");
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null){
						$str .= $this->sTag('div',array('class'=>'input-group-btn'));
							$str .= $icon2;
						$str .= $this->eTag('div');
					}
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');
			if($container != null)
				$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function pwdWithBtn($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1=null,$icon2=null,$container=null){
	    	$str = "";

	    	if($container != null)
	    		$str .= $this->sTag('div',array('class'=>$container['class']));
			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'password';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null){
						$str .= $this->sTag('div',array('class'=>'input-group-btn'));
							$str .= $icon1;
						$str .= $this->eTag('div');
					}
				}

				$params = $this->classitize($params,"form-control");
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null){
						$str .= $this->sTag('div',array('class'=>'input-group-btn'));
							$str .= $icon2;
						$str .= $this->eTag('div');
					}
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');
			if($container != null)
				$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function number($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1=null,$icon2=null,$container=null){
	    	$str = "";

	    	if($container != null)
	    		$str .= $this->sTag('div',array('class'=>$container['class']));
			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'text';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null)
						$str .= $this->tag('span',$icon1,array('class'=>'input-group-addon'));
				}

				$params = $this->classitize($params,"form-control no-decimal");
				// $params['decimal'] = $decimal;
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null)
						$str .= $this->tag('span',$icon2,array('class'=>'input-group-addon'));
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');
			if($container != null)
				$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function decimal($label=null,$nameID=null,$value=null,$placeholder=null,$decimal=2,$params=array(),$icon1=null,$icon2=null,$container=null){
	    	$str = "";

	    	if($container != null)
	    		$str .= $this->sTag('div',array('class'=>$container['class']));
			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'text';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null)
						$str .= $this->tag('span',$icon1,array('class'=>'input-group-addon'));
				}

				$params = $this->classitize($params,"form-control numbers-only");
				$params['decimal'] = $decimal;
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null)
						$str .= $this->tag('span',$icon2,array('class'=>'input-group-addon'));
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');
			if($container != null)
				$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function pwd($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1=null,$icon2=null,$container=null){
	    	$str = "";

	    	if($container != null)
	    		$str .= $this->sTag('div',array('class'=>$container['class']));
			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'password';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null)
						$str .= $this->tag('span',$icon1,array('class'=>'input-group-addon'));
				}

				$params = $this->classitize($params,"form-control");
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null)
						$str .= $this->tag('span',$icon2,array('class'=>'input-group-addon'));
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');
			if($container != null)
				$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function textbox($nameID=null,$value=null,$placeholder=null,$params=array()){
	    	$str = "";
				if(!isset($params['type']))
					$params['type'] = 'text';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;
				$str .= $this->tag('input',null,$params,true);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function pwdbox($nameID=null,$value=null,$placeholder=null,$params=array()){
	    	$str = "";
				if(!isset($params['type']))
					$params['type'] = 'password';
				if($nameID != null){
					if(!isset($params['id']))
						$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;
				$str .= $this->tag('input',null,$params,true);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function time($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1="<i class='fa fa-clock-o'></i>",$icon2=null){
	    	$str = "";

	    	// $str .= $this->sTag('div',array('class'=>'bootstrap-timepicker'));
		    	// $str .= $this->sTag('div',array('class'=>'form-group'));
		    	// 	$str .= $this->sTag('div',array('class'=>'input-group'));
		    // 			$params = $this->classitize(null,"timepicker form-control");
		    // 			$params['type'] = "text";
						// $str .= $this->tag('input',null,$params,true);
			   //  		if($label != null){
						// 	$labelParam = array();
						// 	if($nameID != null)
						// 		$labelParam['for'] = $nameID;
						// 	// $str .= $this->tag('label',$label,$labelParam);
						// }
						$str .= $this->input($label,$nameID,$value,$placeholder,array('class'=>'timepicker'),$icon1,$icon2,array('class'=>'bootstrap-timepicker'));
		    	// 	$str .= $this->eTag('div');
		    	// $str .= $this->eTag('div');
	    	// $str .= $this->eTag('div');

	    	if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function date($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon1="<i class='fa fa-fw fa-calendar'></i>",$icon2=null){
	    	$str = "";

			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['type']))
					$params['type'] = 'text';
				if($nameID != null){
					$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;
				if($value != null)
					$params['value'] = $value;

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null)
						$str .= $this->tag('span',$icon1,array('class'=>'input-group-addon'));
				}
				// $params['data-mask'] = "";
				// $params['data-inputmask'] = "'alias': 'mm/dd/yyyy'";

				$params = $this->classitize($params,"form-control pick-date");
				$str .= $this->tag('input',null,$params,true);

				if($icon1 != null || $icon2 != null){
					if($icon2 != null)
						$str .= $this->tag('span',$icon2,array('class'=>'input-group-addon'));
					$str .= $this->eTag('div');
				}
			$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function textarea($label=null,$nameID=null,$value=null,$placeholder=null,$params=array()){
	    	$str = "";

			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if(!isset($params['rows']))
					$params['rows'] = '5';
				if($nameID != null){
					$params['id'] = $nameID;
					$params['name'] = $nameID;
				}
				if($placeholder != null)
					$params['placeholder'] = $placeholder;

				$params = $this->classitize($params,"form-control");
				$str .= $this->tag('textarea',$value,$params);

			$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }

	    function select($label=null,$nameID=null,$options=array(),$value=null,$params=array(),$icon1=null,$icon2=null){
	    	$str = "";

			$str .= $this->sTag('div',array('class'=>'form-group'));
				if($label != null){
					$labelParam = array();
					if($nameID != null)
						$labelParam['for'] = $nameID;
					$str .= $this->tag('label',$label,$labelParam);
				}

				if($nameID != null){
					$params['id'] = $nameID;
					$params['name'] = $nameID;
				}

				if($icon1 != null || $icon2 != null){
					$str .= $this->sTag('div',array('class'=>'input-group'));
					if($icon1 != null)
						$str .= $this->tag('span',$icon1,array('class'=>'input-group-addon'));
				}

				$params = $this->classitize($params,"form-control");
				$str .= $this->sTag('select',$params);
					if(count($options) > 0){
						foreach ($options as $text => $opt) {
							$optParam = array();
							if(is_array($opt)){
								$optParam = $opt;
								if(isset($optParam['value']) && $optParam['value'] == $value)
									$optParam['selected'] = "";
							}
							else{
								$optParam['value']=$opt;
								if($opt == $value)
									$optParam['selected'] = "";
							}

							$str .= $this->tag('option',$text,$optParam);
						}
					}
				$str .= $this->eTag('select');

				if($icon1 != null || $icon2 != null){
					if($icon2 != null)
						$str .= $this->tag('span',$icon2,array('class'=>'input-group-addon'));
					$str .= $this->eTag('div');
				}

			$str .= $this->eTag('div');

			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function checkbox($label=null,$nameID=null,$value=null,$params=array(),$checked=false){
	    	$str = "";
	    	if($label != null){
			$str .= $this->sTag('div',array('class'=>'form-group'));
				$str .= $this->sTag('div',array('class'=>'checkbox'));
					$str .= $this->sTag('label');
			}
						$params['type'] = 'checkbox';
						if($nameID != null){
							if(!isset($params['id']))
								$params['id'] = $nameID;
							$params['name'] = $nameID;
						}
						if($params != null)
	      	 				$params['value'] = $value;
	      	 			if($checked){
			            	$params['checked'] = "checked";
			            }
						$str .= $this->tag('input',$label,$params,true);

	    	if($label != null){
					$str .= $this->eTag('label');
				$str .= $this->eTag('div');
			$str .= $this->eTag('div');
			}
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function hidden($nameID=null,$value=null,$params=array()){
			if($nameID != null){
				$params['id'] = $nameID;
				$params['name'] = $nameID;
			}
			if($value != null)
				$params['value'] = $value;
			$params['type'] = 'hidden';
	    	$str = $this->tag('input',null,$params,true);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function file($nameID=null,$params=array()){
			if($nameID != null){
				$params['id'] = $nameID;
				$params['name'] = $nameID;
			}

			$params['type'] = 'file';
	    	$str = $this->tag('input',null,$params,true);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function button($text=null,$params=array(),$type='default'){
	    	$params = $this->classitize($params,"btn  btn-".$type);
	    	$str = $this->tag('button',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function unbutton($text=null,$params=array()){

	    	$str = $this->tag('button',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function dropBtn($text="",$opts=array(),$params=array(),$type='default'){
	    	$str = "";
	    	$str .= $this->sTag('div',array('class'=>'btn-group btn-block'));
	    		$params = $this->classitize($params,"btn btn-".$type." dropdown-toggle");
	    		$params['data-toggle'] = "dropdown";
	    		$params['aria-haspopup'] = "true";
	    		$params['aria-expanded'] = "false";
	    		$str .= $this->tag('button',$text,$params);


	    	$str .= $this->eTag('div');
	    	  // <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    	  //   Action <span class="caret"></span>
	    	  // </button>
	    	  
	    	//   <ul class="dropdown-menu">
	    	//     <li><a href="#">Action</a></li>
	    	//     <li><a href="#">Another action</a></li>
	    	//     <li><a href="#">Something else here</a></li>
	    	//     <li role="separator" class="divider"></li>
	    	//     <li><a href="#">Separated link</a></li>
	    	//   </ul>
	    	// </div>
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function img($src=null,$params=array()){
			if($src != null)
				$params['src'] = $src;
	    	$str = $this->tag('img',null,$params,true);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function inputPaper($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$feedback=null){
	    	$str = "";
	    	$str .= $this->sTag('div',array('class'=>'row div-under-no-spaces'));
	    		if($label != ""){
	    			$str .= $this->sTag('div',array('class'=>'col-sm-4 text-left'));
	    				$str .= $this->tag('H4',$label,array('class'=>'paper-label'));
	    			$str .= $this->eTag('div');
	    		}
	    		$wi = 'col-sm-12';
	    		if($label != ""){
	    			$wi = 'col-sm-8';
	    		}	
	    		$str .= $this->sTag('div',array('class'=>$wi.' text-left'));
	    			$addFeedBack = null;
	    			if($feedback != null){
	    				$addFeedBack = "has-feedback";
	    			}
	    			$str .= $this->sTag('div',array('class'=>'form-group '.$addFeedBack));
	    				if(!isset($params['type']))
	    					$params['type'] = 'text';
	    				if($nameID != null){
	    					if(!isset($params['id']))
	    						$params['id'] = $nameID;
	    					$params['name'] = $nameID;
	    				}
	    				if($placeholder != null)
	    					$params['placeholder'] = $placeholder;
	    				if($value != null)
	    					$params['value'] = $value;

	    				$params = $this->classitize($params,"form-control paper-input");
	    				$str .= $this->tag('input',null,$params,true);
	    				$str .= $this->tag('span',"",array('class'=>'fa '.$feedback.' form-control-feedback'));
	    			$str .= $this->eTag('div');
	    		$str .= $this->eTag('div');
	    	$str .= $this->eTag('div');
	    	if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function inputPwd($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$feedback=null){
	    	$str = "";
	    	$str .= $this->sTag('div',array('class'=>'row div-under-no-spaces'));
	    		if($label != ""){
	    			$str .= $this->sTag('div',array('class'=>'col-sm-4 text-left'));
	    				$str .= $this->tag('H4',$label,array('class'=>'paper-label'));
	    			$str .= $this->eTag('div');
	    		}
	    		$wi = 'col-sm-12';
	    		if($label != ""){
	    			$wi = 'col-sm-8';
	    		}	
	    		$str .= $this->sTag('div',array('class'=>$wi.' text-left'));
	    			$addFeedBack = null;
	    			if($feedback != null){
	    				$addFeedBack = "has-feedback";
	    			}
	    			$str .= $this->sTag('div',array('class'=>'form-group '.$addFeedBack));
	    				if(!isset($params['type']))
	    					$params['type'] = 'password';
	    				if($nameID != null){
	    					if(!isset($params['id']))
	    						$params['id'] = $nameID;
	    					$params['name'] = $nameID;
	    				}
	    				if($placeholder != null)
	    					$params['placeholder'] = $placeholder;
	    				if($value != null)
	    					$params['value'] = $value;

	    				$params = $this->classitize($params,"form-control paper-input");
	    				$str .= $this->tag('input',null,$params,true);
	    				$str .= $this->tag('span',"",array('class'=>'fa '.$feedback.' form-control-feedback'));
	    			$str .= $this->eTag('div');
	    		$str .= $this->eTag('div');
	    	$str .= $this->eTag('div');
	    	if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function selectPaper($label=null,$nameID=null,$options=array(),$value=null,$placeholder=null,$params=array(),$feedback=null){
	    	$str = "";
	    	$str .= $this->sTag('div',array('class'=>'row div-under-no-spaces'));
	    		if($label != ""){
	    			$str .= $this->sTag('div',array('class'=>'col-sm-4 text-left'));
	    				$str .= $this->tag('H4',$label,array('class'=>'paper-label'));
	    			$str .= $this->eTag('div');
	    		}
	    		$wi = 'col-sm-12';
	    		if($label != ""){
	    			$wi = 'col-sm-8';
	    		}	
	    		$str .= $this->sTag('div',array('class'=>$wi.' text-left'));
	    			if($nameID != null){
	    				$params['id'] = $nameID;
	    				$params['name'] = $nameID;
	    			}
	    			$params = $this->classitize($params,"form-control paper-select");
	    			$str .= $this->sTag('select',$params);
	    				if(count($options) > 0){
	    					foreach ($options as $text => $opt) {
	    						$optParam = array();
	    						if(is_array($opt)){
	    							$optParam = $opt;
	    							if(isset($optParam['value']) && $optParam['value'] == $value)
	    								$optParam['selected'] = "";
	    						}
	    						else{
	    							$optParam['value']=$opt;
	    							if($opt == $value)
	    								$optParam['selected'] = "";
	    						}

	    						$str .= $this->tag('option',$text,$optParam);
	    					}
	    				}
	    			$str .= $this->eTag('select');
	    		$str .= $this->eTag('div');
	    	$str .= $this->eTag('div');
	    	if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	/////////////////////////////////////////////////////////////
    /////	MAKE HTML TEXT       ///////////////////////////////
    ///////////////////////////////////////////////////////////
	    function P($text=null,$params=array()){
			$str = "";
			$str .= $this->tag('p',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function span($text=null,$params=array()){
			$str = "";
			$str .= $this->tag('span',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function small($text=null,$params=array()){
			$str = "";
			$str .= $this->tag('small',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
	    function H($num=1,$text=null,$params=array()){
			$str = "";
			$str .= $this->tag('h'.$num,$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
		function A($text=null,$href=null,$params=array()){
			$str = "";
			if($href != null)
				$params['href'] = $href;
			$str .= $this->tag('a',$text,$params);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
		}
	////////////////////////////////////////////////////////////
	/////	MAKE CUSTOM DROPDOWNS 	///////////////////////////
    //////////////////////////////////////////////////////////
	    function userDrop($label=null,$nameID=null,$value=null,$placeholder=null,$params=array(),$icon=null,$icon2=null){
	    	$CI =& get_instance();
	 		$CI->load->model('site/site_model');
	    	$str = "";
				$selectParams = $params;
				if(!isset($selectParams['return']))
					$selectParams['return'] = true;

				$results=$CI->site_model->get_custom_val('users',array('id,fname,lname'),'inactive',0,true);
				$opts  = array();
				$opts['- Select an User -'] = 0;
				if($placeholder != null)
					$opts[$placeholder] = '';
				foreach ($results as $res) {
					$opts[$res->fname.' '.$res->lname] = $res->id;
				}
				$str .= $this->select($label,$nameID,$opts,$value,$selectParams,$icon=null,$icon2=null);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function roleDrop($label=null,$nameID=null,$value=null,$placeholder=null,$params=array()){
	    	$CI =& get_instance();
	 		$CI->load->model('site/site_model');
	    	$str = "";
				$selectParams = $params;
				if(!isset($selectParams['return']))
					$selectParams['return'] = true;

				$results=$CI->site_model->get_custom_val('user_roles',array('id,role'),null,null,true);
				$opts  = array();
				$opts['- Select Role -']  = "";
				foreach ($results as $res) {
					$opts[$res->role] = $res->id;
				}
				$str .= $this->select($label,$nameID,$opts,$value,$selectParams);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
	    function roleDropPaper($label=null,$nameID=null,$value=null,$placeholder=null,$params=array()){
	    	$CI =& get_instance();
	 		$CI->load->model('site/site_model');
	    	$str = "";
				$selectParams = $params;
				if(!isset($selectParams['return']))
					$selectParams['return'] = true;

				$results=$CI->site_model->get_custom_val('user_roles',array('id,role'),null,null,true);
				$opts  = array();
				$opts['- Select Role -']  = "";
				foreach ($results as $res) {
					$opts[$res->role] = $res->id;
				}
				$str .= $this->selectPaper($label,$nameID,$opts,$value,$selectParams);
			if($this->returnitize($params)) return $str; else $this->code .= $str;
	    }
}
