<?php 
namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{

    public function iframeFilter($text)
    {
    	/* detecter les balise iframe de type

    	<iframe width="560" height="315" src="https://www.youtube.com/embed/Jjq6e1LJHxw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

    	<iframe frameborder="0" width="480" height="270" src="https://www.dailymotion.com/embed/video/x4cd781" allowfullscreen allow="autoplay"></iframe>

    	*/
		$patternStart = '#^<iframe\s+#';
		$patternSrc = '#src=("|\'){1}(https?://(www\.)?(youtube|dailymotion){1}\.com/embed/(video/)?\w*)("|\'){1}#';
		$patternend = '#></iframe>\s*$#';
		if (!preg_match($patternStart, $text, $matches) || 
			!preg_match($patternSrc, $text, $matches) || 
			!preg_match($patternend, $text, $matches)) {
	        $text = "";
		};
		return $text;
    }
}
