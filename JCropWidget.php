<?php
namespace raoul2000\jcrop;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * JCropWidget is a wrapper for the [jQuery Image Cropping Plugin](http://deepliquid.com/content/Jcrop.html).
 *
 * ~~~
 * echo JCropWidget::widget([
 * 		'id' => 'image',
 * 		'aspectRatio' => 1,
 * 		'minSize' => [50,50],
 * 		'maxSize' => [200,200],
 * 		'setSelect' => [10,10,40,40],
 * 		'bgColor' => 'black',
 * 		'bgOpacity' => '0.5',
 * 		'onChange' => new yii\web\JsExpression('function(c){console.log(c.x);}')
 * ]);
 * ~~~
 *
 * @author Raoul <raoul.boulard@gmail.com>
 *
 */
class JCropWidget extends Widget
{
	/**
	 * @var string JQuery selector for the image element
	 */
	public $id;

	/**
	 * @var numeric Aspect ratio of w/h (e.g. 1 for square)
	 */
	public $aspectRatio;

	/**
	 * @var array Minimum width/height, use 0 for unbounded dimension
	 */
	public $minSize;

	/**
	 *
	 * @var array Maximum width/height, use 0 for unbounded dimension
	 */
	public $maxSize;

	/**
	 *
	 * @var array Set an initial selection area
	 */
	public $setSelect;

	/**
	 *
	 * @var string Set color of background container
	 */
	public $bgColor;

	/**
	 *
	 * @var decimal Opacity of outer image when cropping
	 */
	public $bgOpacity;

	/**
	 *
	 * @var string | yii\web\JsExpression Called when selection is completed
	 */
	public $onSelect;

	/**
	 *
	 * @var string | yii\web\JsExpression Called when the selection is moving
	 */
	public $onChange;

	/**
	 *
	 * @var string | yii\web\JsExpression Called when the selection is released
	 */
	public $onRelease;

	/**
	 * Initializes the widget.
	 *
	 * @throws InvalidConfigException if the "id" property is not set.
	 */
	public function init()
	{
		parent::init();
		if (empty($this->id)) {
			throw new InvalidConfigException('The "id" property must be set.');
		}
	}

	/**
	 * Runs the widget.
	 *
	 * @see \yii\base\Widget::run()
	 */
	public function run()
	{
		$this->registerClientScript();
	}

	/**
	 * Registers the needed JavaScript.
	 */
	public function registerClientScript()
	{
		$options = $this->getClientOptions();
		$options = empty($options) ? '' : Json::encode($options);

		$js = "jQuery(\"#{$this->id}\").Jcrop(" . $options . ");";

		$view = $this->getView();
		JCropAsset::register($view);
		$view->registerJs($js);
	}

	/**
	 *
	 * @return array the options for the text field
	 */
	protected function getClientOptions()
	{
		$options = [];
		if ($this->aspectRatio !== null) {
			$options['aspectRatio'] = $this->aspectRatio;
		}

		if ($this->minSize !== null) {
			$options['minSize'] = $this->minSize;
		}

		if ($this->maxSize !== null) {
			$options['maxSize'] = $this->maxSize;
		}

		if ($this->setSelect !== null) {
			$options['setSelect'] = $this->setSelect;
		}
		if ($this->bgColor !== null) {
			$options['bgColor'] = $this->bgColor;
		}
		if ($this->bgOpacity !== null) {
			$options['bgOpacity'] = $this->bgOpacity;
		}

		if ($this->onSelect !== null) {
			if ($this->onSelect instanceof JsExpression) {
				$options['onSelect'] = $this->onSelect;
			} else {
				$options['onSelect'] = new JsExpression($this->onSelect);
			}
		}

		if ($this->onChange !== null) {
			if ($this->onChange instanceof JsExpression) {
				$options['onChange'] = $this->onChange;
			} else {
				$options['onChange'] = new JsExpression($this->onChange);
			}
		}

		if ($this->onRelease !== null) {
			if ($this->onRelease instanceof JsExpression) {
				$options['onRelease'] = $this->onRelease;
			} else {
				$options['onRelease'] = new JsExpression($this->onRelease);
			}
		}

		return $options;
	}

	private function setJsOption(&$options, $attribute)
	{
		if ($this->$attribute !== null) {
			if ($this->$attribute instanceof JsExpression) {
				$options[$attribute] = $this->$attribute;
			} else {
				$options[$attribute] = new JsExpression($this->$attribute);
			}
		}
	}
}
