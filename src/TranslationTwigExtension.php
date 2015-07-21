<?php

use Symfony\Component\Yaml\Parser;

class TranslationTwigExtension extends Twig_Extension
{
	protected $lang;
	protected $trans;
	protected $default;
	protected $defaultLanguage;
	protected $dfile;

	public function __construct($lang, $dir, $defaultLanguage = NULL, $dfile = NULL)
	{
		$this->lang = $lang;
		$this->defaultLanguage = $defaultLanguage;
		$this->dfile = $dfile;

		$yaml = new Parser();
		
		$filename = $dir.'/'.$lang.'.yml';

		if (file_exists($filename)) {
			$this->trans = $yaml->parse(file_get_contents($filename));
		} else {
			$this->trans = array();
		}

		if ($defaultLanguage) {

			$filename = $dir.'/'.$defaultLanguage.'.yml';

			if (file_exists($filename)) {
				$this->default = $yaml->parse(file_get_contents($filename));
			} else {
				$this->default = array();
			}	

		}
		
	}

	public function getFilters()
	{
		return array(
				new Twig_SimpleFilter('trans', array($this, 'translateFilter'))
			);
	}


	public function translateFilter($str, $tokens = array())
	{
		if (isset($this->trans[$str])) $result = $this->trans[$str];
		else {
			if ($this->defaultLanguage && isset($this->default[$str])) $result = $this->default[$str];
			else $result = $str;

			if ($this->dfile) {
				$log = fopen($this->dfile, 'a');
				fwrite($log, $this->lang .'|'.$str."\n");
				fclose($log);
			}
		}
		
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