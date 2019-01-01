<?php
namespace App\Twig;

use App\Twig\AppRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            // the logic of this filter is now implemented in a different class
            new TwigFilter('esc_iframe', array(AppRuntime::class, 'iframeFilter')),
        );
    }
}
