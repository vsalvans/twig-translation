<?php

use Symfony\Component\Yaml\Parser;

class TranslationTwigExtension extends Twig_Extension
{
	protected $lang;
	protected $trans;

	public function __construct($lang, $dir)
	{
		$this->lang = $lang;

		$yaml = new Parser();
		
		$this->trans = $yaml->parse(file_get_contents($dir.'/'.$lang.'.yml'));
	}

	public function getFilters()
	{
		return array(
				new Twig_SimpleFilter('trans', array($this, 'translateFilter'))
			);
	}


	public function translateFilter($str, $tokens = array())
	{
		$result = isset($this->trans[$str]) ? $this->trans[$str] : $str;
		
		if (!empty($tokens)) {
			foreach ($tokens as $key => $value) {
				$result = str_replace($key, $value, $result);
			}
		}

		return $result;

	}

    public function getName()
    {
        return 'translation';
    }
}