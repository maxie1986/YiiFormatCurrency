<?php

/**
 * JNotify class file.
 */

class FormatCurrency extends CWidget {

	private $baseUrl;
	private $clientScript;
	private $id;

	public $model;
	public $attribute;
	public $name;
	public $value;
	public $options;
	public $htmlOptions = array();
	private $defaultOptions = array();

	/**
	 * Publishes the assets
	 */
	public function publishAssets() {
		$dir = Yii::getPathOfAlias('application.extensions').'/formatCurrency';
		$this->baseUrl = Yii::app()->assetManager->publish($dir);
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function registerClientScripts() {

		if ($this->baseUrl === '')
			throw new CException(Yii::t('FormatCurrency', 'baseUrl must be set.'));

		$this->clientScript = Yii::app()->getClientScript();

		// JS
		$this->clientScript->registerScriptFile($this->baseUrl.'/jquery.formatCurrency-1.4.0.js',  CClientScript::POS_END);

		// CSS
		//$this->clientScript->registerCssFile($this->baseUrl.'/jquery.jnotify.css');
	}

	public function getOptions(){
		if(isset($this->options)){
			foreach ($this->defaultOptions as $key => $value) {
				if(!isset($this->options[$key]))
					$this->options[$key] = $value;
			}
			$this->options = array(
					"colorize"=>false,
					"negativeFormat"=>'-%s%n',
					"roundToDecimalPlace" => 2,
					"region"=> Yii::app()->getLocale()->getId(),
					"decimalSymbol" => Yii::app()->getLocale()->getNumberSymbol("decimal"),
					"digitGroupSymbol" => Yii::app()->getLocale()->getNumberSymbol("group")
				);
			return json_encode($this->options);
		}else{
			return json_encode($this->defaultOptions);

		}
	}

	public function createJsCode() {
		$res="
		$(document).ready(function() {
		".
			"var options = ".$this->getOptions().";
		    $('#".$this->id."_text').blur(function() {
		        $(this).formatCurrency(options);
		            }).keyup(function(e) {
		                        	var onblurOptions = options;
		                        	onblurOptions['roundToDecimalPlace'] = -1;
		                        	onblurOptions['eventOnDecimalsEntered'] = true;
		                        	$(this).formatCurrency(onblurOptions);
		                     $(this).parent().find('.currency_input').val($(this).asNumber());

		             });

			// initializing values
			$('#".$this->id."_text').formatCurrency(options);
		});
		";

		return $res;
	}

	public function jsOnKeyup(){
		$res = "
		        function onKeyup(obj) {
		                var e = window.event || e;
		                var keyUnicode = e.charCode || e.keyCode;
		                if (e !== undefined) {
		                    switch (keyUnicode) {
		                        case 16: break; // Shift
		                        case 17: break; // Ctrl
		                        case 18: break; // Alt
		                        case 27: this.value = ''; break; // Esc: clear entry
		                        case 35: break; // End
		                        case 36: break; // Home
		                        case 37: break; // cursor left
		                        case 38: break; // cursor up
		                        case 39: break; // cursor right
		                        case 40: break; // cursor down
		                        case 78: break; // N
		                        case 110: break; // .
		                        case 190: break; // .
		                        default:
		                        	var onblurOptions = options;
		                        	onblurOptions['roundToDecimalPlace'] = -1;
		                        	onblurOptions['eventOnDecimalsEntered'] = true;
		                        	$(this).formatCurrency(onblurOptions);
		                    }
		                    $(this).parent().find('.currency_input').val($(this).asNumber());
		";
	}

	public function renderInputField(){
		if(isset($this->model) && isset($this->attribute)){
			$this->id=$this->attribute;

			if(!isset($this->htmlOptions["id"])){
				$this->htmlOptions["id"] = $this->id."_text";
			}
			if(!isset($this->htmlOptions["class"])){
				$this->htmlOptions["class"] = "currency";
			} else
				$this->htmlOptions["class"].=" currency";
        	echo CHtml::activeHiddenField($this->model, $this->attribute, array('id'=>$this->id, "class" => "currency_input"));
        	echo CHtml::textField($this->name, $this->value, $this->htmlOptions);
        }else
        	if(isset($this->name)){
        		$this->id = $this->name;
        		echo CHtml::hiddenField($this->name, $this->value, array("class" => "currency_input"));
        		echo CHtml::textField($this->name."_text", $this->value, array("class"=>"currency","id"=>$this->id."_text"));
        	}
	}

	/**
	 * Run the widget
	 */
	public function run() {

		$this->renderInputField();
		$this->publishAssets();
		$this->registerClientScripts();

		$js = $this->createJsCode();
		$this->clientScript->registerScript('formatCurrency_init'.$this->id, $js, CClientScript::POS_HEAD);

		//parent::run();
	}


	public function init() {

		parent::init();
				$this->defaultOptions = array(
					"colorize"=>true,
					"negativeFormat"=>'-%s%n',
					"roundToDecimalPlace" => 2,
					"region"=> Yii::app()->getLocale()->getId(),
					"decimalSymbol" => Yii::app()->getLocale()->getNumberSymbol("decimal"),
					"digitGroupSymbol" => Yii::app()->getLocale()->getNumberSymbol("group")
				);
				$this->getOptions();
	}


}