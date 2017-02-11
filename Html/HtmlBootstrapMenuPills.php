<?php

namespace Core\Html;

use Core\Config;

class HtmlBootstrapMenuPills extends Html
{

    /**
     * Contenu du menu
     * @var array
     */
    protected $menu;

    /**
     * Menu Html
     * @var string
     */
    protected $html;

    /**
     * return string html for menu bootstrap pills
     * @return string
     */
    public function __toString()
    {
        // add class for bootstrap menu pills
        $this->addClass('nav');
        $this->addClass('nav-pills');
        $this->addClass('nav-stacked');
        // build string html
        $this->MenuBuilder();
        return $this->html;
    }

    /**
     * Appel du constructeur de menu
     *
     * @param  string $menuname
     * @return string
     */
    public function get($menuname)
    {
        // récupération du menu
        $this->menu = Config::get('menu.' . $menuname);
        return $this;
    }

    /**
     * Constructeur de Menu
     */
    private function MenuBuilder()
    {
        $html = "<ul" . $this->RenderAttributes() . ">";
        $html .= $this->getContent($this->menu);
        $html .= "</ul>";
        $this->html = $html;
    }

    /**
     * Création du contenu du menu
     *
     * @param  array $menu
     * @return string
     */
    private function getContent($menu)
    {
        $html = "";
        foreach($menu as $elements)
        {
            $label   = $elements[0];
            $icon    = $elements[1];
            $route   = $elements[2];
            $rights  = $elements[3];
            $submenu = $elements[4];

            if (\Auth::getRight() < $rights) {
                $disabled = true;
            } else {
                $disabled = false;
            }

            if($label === 'separator')
            {
                  // $html .= "<li class=\"divider\" role=\"separator\"></li>\n";
            }
            else
            {
                if($submenu == null)
                {
                    if ($disabled) {
                        $html .= "<li class=\"disabled\" role=\"presentation\"><a href=\"#\"><i class=\"$icon\"></i> &nbsp;&nbsp;$label</a></li>\n";
                    } else {
                        $html .= "<li class=\"sub-menu\" role=\"presentation\"><a href=\"" . route($route) ."\"><i class=\"$icon\"></i>  &nbsp;&nbsp;$label</a></li>\n";
                    }
                }
                else
                {
                    // $html .= "<li class=\"head-menu\" role=\"presentation\">";
                    // $html .= "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\"expanded=\"false\">";
                    // $html .= "<i class=\"$icon\"></i> $label</span></a>\n";
                    // $html .= "<ul class=\"dropdown-menu\">";
                    // $html .= "</li>";
                    $html .= $this->getContent($submenu);
                }
            }
        }
        return $html;
    }
}
