<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no" />
  <meta name="description" content="Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI." />
  <meta name="keywords" content="Semantic-UI, Theme, Design, Template" />
  <meta name="author" content="PPType" />
  <meta name="theme-color" content="#ffffff" />
  <title>Accueil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
    type="text/css" />
  <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body id="root">
  <div class="ui large top fixed hidden menu">
    <div class="ui container">
      <a href="#" class="active item">Accueil</a> <a href="./map/index.php" class="item">Carte</a>
      <a href="graphs/graphs.php" class="item">Statistiques</a> <a href="#contactForm" class="item">Nous contacter</a>
    </div>
  </div>
  <!--Sidebar Menu-->
  <div class="ui vertical inverted sidebar menu">
    <a href="#" class="active item">Accueil</a> <a href="./map/index.php" class="item">Carte</a>
    <a href="graphs/graphs.php" class="item">Statistiques</a> <a href="#contactForm" class="item">Nous contacter</a>
  </div>
  <!--Page Contents-->
  <div class="pusher">
    <div class="ui inverted vertical masthead center aligned segment"
      style="background-image: url('./login-form-20/images/bg-blur.jpg')">
      <div class="ui container">
        <div class="ui large secondary inverted  menu">
          <a href="#" class="active item">Accueil</a> <a href="./map/index.php" class="item">Carte</a>
          <a href="graphs/graphs.php" class="item">Statistiques</a> <a href="#contactForm" class="item">Nous contacter</a>
        </div>
      </div>
      <div class="ui text container">
        <h1 class="ui inverted header">Albi Tourisme</h1>
        <h2>Découvrez une nouvelle manière de faire du tourisme</h2>
        <div onclick="window.location='./map/index.php'" class="ui huge primary button">
          Commencer <i class="right arrow icon"></i>
        </div>
      </div>
    </div>
    <div class="ui vertical stripe segment">
      <div class="ui middle aligned stackable grid container">
        <div class="row">
          <div class="eight wide column">
            <h3 class="ui header">Une manière innovante de faire du tourisme</h3>
            <p>
              Ce projet a pour objectif de proposer une façon innovante
              de faire du tourisme ou bien de simplement redécouvrir la ville
              d'Albi sous un nouvel angle.
            </p>
            <h3 class="ui header">Une carte intéractive</h3>
            <p>
              Vous pouvez intéragir avec plus d'une trentaine de lieux répertoriés
              tous plus emblématiques les uns que les autres. Que ça soit tout seul ou
              à plusieurs, partez à l'aventure dans les rues d'Albi.
            </p>
          </div>
          <div class="six wide right floated column">
            <img class="ui large bordered rounded image" src="./images/wireframe/carte.jpg" />
          </div>
        </div>

      </div>
    </div>

    <div id="contactForm" class="ui vertical stripe segment">
		<div class="ui two column centered grid">
          <div class="column">

            <form class="ui form success" action="sendMail.php" method="POST">

              <div class="field">
                <label>Email</label>
                <input type="email" name="mail" placeholder="exemple@gmail.com" required>
              </div>
              <div class="field">
                <label>Pseudo</label>
                <input type="text" name="name" required>
              </div>
              <div class="field">
                <label>Message</label>
                <textarea required name="message"></textarea>
              </div>
              <div class="field">
                <div class="ui checkbox">
                  <input type="checkbox" tabindex="0" required>
                  <label>J'accepte les termes et conditions générales</label>
                </div>
              </div>

              

              <button class="ui button" type="submit">Envoyer</button>
            </form>

          </div>
        </div>
    </div>
    <div class="ui inverted vertical footer segment">
      <div class="ui container">
        <div class="ui stackable inverted divided equal height stackable grid">
          <div class="three wide column">
            <h4 class="ui inverted header">À Propos</h4>
            <div class="ui inverted link list">
              <a class="item" href="https://github.com/UltraStars3000/projet-tw4">Github</a>
              <a class="item" href="#contactForm">Contactez-nous</a>
            </div>
          </div>
          <div class="seven wide column">
            <h4 class="ui inverted header">Réalisation</h4>
            <p>
              Données obtenues grâce à l'open-data mise à disposition par la ville d'Albi.
            </p>
            <p>
              Mise en place de la carte effectué avec OpenStreetMap.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
  <script>
    $(document).ready(function () {
      // fix menu when passed
      $(".masthead").visibility({
        once: false,
        onBottomPassed: function () {
          $(".fixed.menu").transition("fade in");
        },
        onBottomPassedReverse: function () {
          $(".fixed.menu").transition("fade out");
        }
      });

      // create sidebar and attach to menu open
      $(".ui.sidebar").sidebar("attach events", ".toc.item");
    });
  </script>
</body>

</html>