<?php
namespace app\extensions;

use yii\i18n\Formatter;

class MyFormatter extends Formatter
{
    public $implodeSign=', ';
 
    public function asArray($value)
    {
        if(is_array($value))
		{
            return implode($this->implodeSign, $value);
		}
		else
		{
			return "(not an array)";
		}
    }
	
	public function asVarExport($value)
	{
		$out = "<pre>";
		$out .= $this->var_dump_ret($value);
		$out .= "</pre>";
		
		return $out;
	}
	
	private function var_dump_ret($mixed = null)
	{
		ob_start();
		var_dump($mixed);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
?>