<?php

  namespace Core\Html;

  use Core\Config;

  class HtmlBootstrapMenu extends Html
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

    public function __toString()
    {

        $this->addClass('nav');
        $this->addClass('navbar-nav');

        // constructtion html du menu
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

            if($submenu == null)
            {
                $html .= "<li><a href=\"" . route($route) ."\"><i class=\"$icon\"></i> $label</a></li>\n";
            }
            else
            {
                $html .= "<li class=\"dropdown\">";
                $html .= "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\"expanded=\"false\">";
                $html .= "<i class=\"$icon\"></i> $label <span class=\"caret\"></span></a>\n";
                $html .= "<ul class=\"dropdown-menu\">";
                $html .= $this->getContent($submenu);
                $html .= "</li></ul>";
            }
        }
        return $html;
    }

  } // End class
