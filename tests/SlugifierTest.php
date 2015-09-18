<?php

class SlugifierTest extends PHPUnit_Framework_TestCase
{

  public function testFrenchSlug()
  {
    $slug = \Slug::make('titre écris en français !, vérification du slug');
    $good_slug = 'titre-ecris-en-francais-verification-du-slug';

    $this->assertEquals($good_slug, $slug);
  }

  public function testEnglishSlug()
  {
    $slug = \Slug::make('Hello Good Worlds');
    $good_slug = 'hello-good-worlds';

    $this->assertEquals($good_slug, $slug);
  }

  public function testWithReplacements()
  {
    $slug = Slug::make('Hello Good Worlds')->setReplacements(['/Good/i' => '', '/Worlds/i' => 'Flowers']);
    $good_slug = 'hello-flowers';

    $this->assertEquals($good_slug, $slug);
  }

  public function testWithNoLowercase()
  {
    $slug = Slug::make('Hello Good Worlds')->setLowercase(false);
    $good_slug = 'Hello-Good-Worlds';

    $this->assertEquals($good_slug, $slug);
  }

  public function testWithOtherDelimiter()
  {
    $slug = Slug::make('Hello Good Worlds')->setDelimiter('_');
    $good_slug = 'hello_good_worlds';

    $this->assertEquals($good_slug, $slug);
  }

  public function testWithNoTransliterate()
  {
    $slug = Slug::make('essai Français')->setTransliterate(false);
    $good_slug = 'essai-français';

    $this->assertEquals($good_slug, $slug);
  }



}