<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Espace Membre</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
	<div class="ui large top fixed hidden menu">
		<div class="ui container">
			<a href="#" class="active item">Accueil</a> <a href="./map/index.php" class="item">Carte</a>
			<a href="#" class="item">Statistiques</a> <a href="#contactForm" class="item">Nous contacter</a>
		</div>
	</div>
	<!--Sidebar Menu-->
	<div class="ui vertical inverted sidebar menu">
		<a href="#" class="active item">Accueil</a> <a href="./map/index.php" class="item">Carte</a>
		<a href="#" class="item">Statistiques</a> <a href="#contactForm" class="item">Nous contacter</a>
	</div>
	<!--Page Contents-->
	<div class="pusher">
		<div class="ui inverted vertical masthead center aligned segment" style="background-image: url('./login-form-20/images/bg-blur.jpg')">
			<div class="ui container">
				<div class="ui large secondary inverted  menu">
					<a href="#" class="active item">Accueil</a> <a href="./map/index.php" class="item">Carte</a>
					<a href="#" class="item">Statistiques</a> <a href="#contactForm" class="item">Nous contacter</a>
				</div>
			</div>
			<section class="ftco-section">
				<div class="container">

					<?php
					if (isset($_SESSION['mdp'])) {
						if ($_SESSION['mdp'] == "false") {


					?>
							<div class="row justify-content-center">
								<div class="col-md-6 col-lg-4 text-center">
									<div class="login-wrap p-0">
										<h2 class="heading-section">Veuillez vous connecter</h2>
										<form action="login.php" class="signin-form" method="POST">
											<div class="form-group">
												<input name="pseudo" type="text" class="form-control" placeholder="Pseudo" required>
											</div>
											<div class="form-group">
												<input name="password" id="password-field" type="password" class="form-control" placeholder="Mot de passe" required>
												<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
											</div>
											<p style="color:red"><b>Mot de passe incorrect</b></p>
											<div class="form-group">
												<button type="submit" name="submit" class="form-control btn btn-primary submit px-3">Se connecter</button>
											</div>

										</form>
										<a style="color:#FFFFFF" class="w-100 text-center" href="accounte.php">&mdash; Créer un compte &mdash;</a>

									</div>
								</div>
							</div>
						<?php
						}
					} else {
						?>
						<div class="row justify-content-center">
							<div class="col-md-6 col-lg-4 text-center">
								<div class="login-wrap p-0">
									<h2 class="heading-section">Avez-vous un compte ?</h2>
									<form action="login.php" class="signin-form" method="POST">
										<div class="form-group">
											<input name="pseudo" type="text" class="form-control" placeholder="Pseudo" required>
										</div>
										<div class="form-group">
											<input name="password" id="password-field" type="password" class="form-control" placeholder="Mot de passe" required>
											<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
										</div>
										<div class="form-group">
											<button type="submit" name="submit" class="form-control btn btn-primary submit px-3">Se connecter</button>
										</div>

									</form>
									<a style="color:#FFFFFF" class="w-100 text-center" href="accounte.php">&mdash; Créer un compte &mdash;</a>

								</div>
							</div>
						</div>
					<?php
					}
					?>


				</div>
			</section>

			<script src="js/jquery.min.js"></script>
			<script src="js/popper.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/main.js"></script>

</body>

</html>