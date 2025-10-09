<?php

namespace Core\Debug;

class Errors
{
  protected string $message;
  protected string|array $content;
  protected string $file;
  protected string $line;
  protected string $error;
  protected string $code;

  /**
   * Affiche l'erreur
   */
  public function View()
  {
    $title = $this->message;
    include(__DIR__ . '/htmlmodel/default.php');
    die();
  }

  public function setContent(string|array $content): void
  {
    $this->content = $content;
  }

  public function getContent(): string
  {
    return is_string($this->content) ? $this->content : print_r($this->content, true);
  }
}
