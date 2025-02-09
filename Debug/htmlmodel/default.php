<!DOCTYPE html>
<html>
<head>
  <title><?= $title ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,700' rel='stylesheet' type='text/css'>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
  <style type="text/css">
    body { background-color: #f0f0f0; font-family: Roboto; }
    .error {
      font-size: 15px;
      text-align: left;
      white-space: inherit;
    }
    .panel h2 { font-size: 24px; padding: 0; margin: 0; }
    .panel-heading { font-size: 18px; }


  </style>
</head>
<body>
<br>
<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <h2>Oups, une erreur est survenue sur votre site</h2>
    </div>
  </div>
</div>
<?php if (Core\Config::get('dev')): ?>
  <div class="container">
    <div class="panel panel-primary">
    <div class="panel-heading">
      <h4><?= $this->error ?>&nbsp;<strong><?= $this->message ?></strong></h4>
      dans le fichier <abbr title="attribute"><i><?= $this->file ?></i></abbr> à la ligne <strong><?= $this->line ?></strong>
    </div>
    <?php if (!empty($this->content)): ?>
      <div class="panel-body">
        <?php if(gettype($this->content) === 'array'): ?>
          <pre><?= print_r($this->content) ?></pre>
        <?php else: ?>
          <?= nl2br($this->content) ?>
        <?php endif ?>

      </div>
    <?php endif ?>
  </div>
<?php endif ?>
</body>
</html>