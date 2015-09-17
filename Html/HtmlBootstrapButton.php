<?php

namespace Core\Html;

use Core\Config;

class HtmlBootstrapButton extends Html {

  /**
   * Array of Icon
   * @var [type]
   */
  public $icons = [];

  public function __construct()
  {
    $this->opentag  = '<';
    $this->closetag = '>';
    $this->icons    = Config::get('button.icons');
  }

  /**
   * Button html <button...
   *
   * @param  string $label
   * @param  string $type
   * @param  string $class
   *
   * @return instance
   */
  public function button($label, $ico, $type)
  {
    if(!empty($label))
    {
      $label = '&nbsp;' . $label;
    }

    $this->closetag = '><i class="' . $this->icons[$ico][0] . '"></i>' . $label . '</button>';

    $this->setAttribute('type',$type);
    $this->addClass('btn btn-' . $this->icons[$ico][1]);

    $this->tag = 'button';

    return $this;
  }

  public function btnIco($label, $ico, $url)
  {
    if(!empty($label))
    {
      $label = '&nbsp;' . $label;
    }

    $this->closetag = '><i class="' . $this->icons[$ico][0] . '"></i>' . $label . '</a>';

    $this->setAttribute('class', 'btn btn-' . $this->icons[$ico][1]);
    $this->setAttribute('href', $url);

    $this->tag = 'a';

    return $this;
  }

  private function ahref($label,$icon,$class)
  {
    $this->closetag = '>' . $label . '</a>';

    $this->setAttribute('type',$type);
    $this->setAttribute('class', $class);

    $this->tag = 'button';

    return $this;
  }

  public function extra_small()
  {
    $this->addClass('btn-xs');
    return $this;
  }


  public function small()
  {
    $this->addClass('btn-sm');
    return $this;
  }

  public function large()
  {
    $this->addClass('btn-lg');
    return $this;
  }

  public function btnDelete($label, $url)
  {
    if(!empty($label))
    {
      $label = '&nbsp;' . $label;
    }

    $this->closetag = '><i class="' . $this->icons['delete'][0] . '"></i>' . $label . '</a>';

    $this->setAttribute('class', 'btn btn-' . $this->icons['delete'][1]);
    $this->setAttribute('href', 'javascript:deleteitem(\'' . $url .'\')');

    $this->tag = 'a';

    return $this;
  }

} // endclass
