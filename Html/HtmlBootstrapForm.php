<?php

namespace Core\Html;

use Button;

class HtmlBootstrapForm extends Html
{

  public function __construct()
  {
    $this->opentag = '<';
    $this->closetag = '>';
  }

  public function BootstrapFormGroup()
  {
    $this->prefix = "<div class=\"form-group\">";
    $this->suffix = "</div>";
  }

  public function FormBuilder()
  {

    if(!empty($this->prefix)) {
      $html = $this->prefix;
    }
    else {
      $html ='';
    }

    $html .= $this->opentag . $this->tag;
    $html .= $this->renderAttributes();
    $html .= $this->closetag;

    if(!empty($this->suffix)) {
      $html .= $this->suffix;
    }

    return $html;

  }

  public function __toString()
  {
    return $this->FormBuilder();
  }

  public function open($action=null, $method="POST")
  {
    $this->addMethod($method);
    $this->addAction($action);
    $this->tag = 'form';

    return $this;
  }

  public function close()
  {
    return '</form>';
  }

  public function label($label,$name)
  {
    $this->opentag = "<label for=\"$name\">$label</label><";

    return $this;
  }

  public function input($label,$name,$type)
  {
    $this->BootstrapFormGroup();

    $this->label($label,$name);

    $this->setAttribute('type',$type);
    $this->setAttribute('name',$name);
    $this->setAttribute('id', $name);
    $this->setAttribute('class', 'form-control');

    $this->tag = 'input';
    $this->closetag = "/>";

    return $this;
  }

  public function text($label,$name)
  {
    $this->input($label,$name,'text');
    return $this;
  }

  public function password($label,$name)
  {
    $this->input($label,$name,'password');
    return $this;
  }

  public function date($label,$name)
  {
    $this->input($label,$name,'date');
    return $this;
  }

  public function email($label,$name)
  {
    $this->input($label,$name,'email');
    return $this;
  }

  public function textarea($label, $name, $rows=3)
  {
    $this->BootstrapFormGroup();
    $this->closetag = "></textarea>";

    $this->label($label,$name);

    $this->setAttribute('name',$name);
    $this->setAttribute('id', $name);
    $this->setAttribute('class', 'form-control');
    $this->setAttribute('rows', $rows);

    $this->tag = 'textarea';

    return $this;
  }

  public function check($label,$name) {
    $this->prefix = '<div class="checkbox"><label>';
    $this->suffix = ' ' . $label . '</label></div>';

    $this->setAttribute('type','checkbox');
    $this->setAttribute('name',$name);
    $this->setAttribute('id', $name);

    $this->tag = 'input';

    return $this;
  }

  /**
   * Form Select
   *
   * @param  string $label
   * @param  string $name
   * @param  array $data
   * @param  mixed $defaultvalue
   * @return string
   */
  public function select($label,$name,$data, $defaultvalue=null)
  {
    $this->tag = 'select';

    $this->setAttribute('name',$name);
    $this->setAttribute('id', $name);
    $this->setAttribute('class','form-control');

    $options = '';

    foreach ($data as $key => $value) {
      if($key == $defaultvalue && !is_null($defaultvalue)) {
        $selected = 'selected';
      }
      else {
        $selected = '';
      }
      $options .= "<option value=\"$key\"$selected>$value</option>";
    }

    $this->prefix = "<div class=\"form-group\"><label for=\"$name\">$label</label>";
    $this->suffix = ">" . $options . "</select></div>";

    return $this;
  }

  /**
   * Button type submit
   *
   * @param  string $label
   * @return string
   */
  public function submit($label)
  {
    return Button::button($label,'save','submit');
  }

} // end of class
