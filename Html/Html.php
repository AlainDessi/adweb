<?php

namespace Core\Html;

class Html
{

  /**
   * Attributes ( class, id, name )
   * @var array
   */
    protected $attributes = [];

    protected $prefix;

    protected $suffix;

    protected $tag;

    protected $opentag;

    protected $closetag;

    protected $icons;

    /**
     * Constructeur
     */
    public function __construct()
    {

    }

    /**
     * Create html
     * @return  string
     */
    public function HtmlBuilder()
    {

        if (!empty($this->prefix)) {
            $html = $this->prefix;
        } else {
            $html ='';
        }

        $html .= $this->opentag . $this->tag;
        $html .= $this->renderAttributes();
        $html .= $this->closetag;

        if (!empty($this->suffix)) {
            $html .= $this->suffix;
        }

        return $html;
    }

    /**
     * Affichage du tag html
     * @return method
     */
    public function __toString()
    {
        return $this->HtmlBuilder();
    }

    /**
     * Defini un attribut Html
     * @param string $type  type d'attribut
     * @param strung $value valeur de l'attribut
     */
    public function setAttribute($type, $value)
    {
        $this->attributes[$type] = $value;
    }

    /**
     * Renvoi la valeur d'un attribut
     * @param  string $type
     * @return string
     */
    public function getAttribute($type)
    {
        return $this->attributes[$type];
    }


    protected function renderAttributes()
    {

        $attributes = '';

        foreach ($this->attributes as $key => $value) {
            $attributes .= ' ' . $key . '="' . $value .'"';
        }

        return $attributes;
    }


    public function addClass($class)
    {
        if (isset($this->attributes['class'])) {
            $class = $this->attributes['class'] . ' ' . $class;
        }

        $this->setAttribute('class', $class);
        return $this;
    }

    public function addId($id)
    {
        if (isset($this->attributes['id'])) {
            $id = $this->attributes['id'] . ' ' . $id;
        }

        $this->setAttribute('id', $id);
        return $this;
    }

    public function addTitle($title)
    {
        $this->setAttribute('title', $title);
        return $this;
    }

    public function addAction($url)
    {
        $this->setAttribute('action', $url);
        return $this;
    }

    public function addMethod($method)
    {
        $this->setAttribute('method', $method);
        return $this;
    }

    public function defaultValue($value)
    {
        if ($this->tag === 'textarea') {
            $this->closetag = ">$value</textarea>";
        } elseif ($this->getAttribute('type') == 'checkbox') {
            if ($value == 1) {
                $this->closetag = " checked>";
            }
        } else {
            if (!empty($value) || $value == 0) {
                $this->setAttribute('value', $value);
            }
        }
        return $this;
    }

    public function placeholder($value)
    {
        $this->setAttribute('placeholder', $value);
        return $this;
    }

    public function readonly()
    {
        $this->closetag = 'readonly ' . $this->closetag;
        return $this;
    }

    public function disabled()
    {
        $this->closetag = 'disabled ' . $this->closetag;
        return $this;
    }
} // end class
