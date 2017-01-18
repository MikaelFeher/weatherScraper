<?php

	$output = '';

	if ($_GET['city']) {
		// City names with spaces eg. San Francisco can't be used unless the space is replaced with either a '-', version 1 or stripping the space, version 2...

		// version 1
		// $input = explode(' ', $_GET['city']);
		// $city = implode('-', $input);

		// version 2
		$city = str_replace(' ', '', $_GET['city']);  // replace a space with no-space in the string $_GET['city'].


		$forecastPage = file_get_contents('http://www.weather-forecast.com/locations/'.$city.'/forecasts/latest');

		$firstDelimiter = '3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">';

		$secondDelimiter = '</span></span></span></p><div class="forecast-cont"><div class="units-cont"><a class="units metric active">&deg;C</a><a class="units imperial">&deg;F</a></div>';

		// To only get the information needed, everything before $firstDelimiter(included) and after $secondDelimiter(included) has to be stripped away.
		$strOne = explode($firstDelimiter, $forecastPage);

		$strTwo = explode($secondDelimiter, $strOne[1]);
		$forecast = $strTwo[0];

		if ($forecast) {
			$output = '<div class="alert alert-success">'.$forecast.'</div>';
		} else {
			$output = '<div class="alert alert-danger"><strong>Oops, something went wrong :(</strong><br>If your spelling is correct then the city isn\'t in the system. </div>';
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<style rel="stylesheet" type="text/css" media="screen">
		body{
			padding: 0;
			margin: 0;
			height:100vh;
			background-image: url('bg2.jpg');
			background-repeat: no-repeat;
			background-size:cover;
		}
		.jumbotron {
			text-align: center;
			padding-top: 100px;
			background: transparent;
		}
		form {
			margin-bottom: 40px;
		}
	</style>
  </head>
  <body>

	<div class="jumbotron jumbotron-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 offset-sm-2">
					<h1 class="display-4">What's The Weather?</h1>
					<p class="lead pb-3">Enter the name of a city. <br> <span><small>(English names only...)</small></span></p>

					<form>
						<input type="text" class="form-control form-control-lg col-xs-6 offset-xs-3 my-3" name="city" placeholder="Eg. London, Malmo" value="<?php echo $_GET['city']; ?>">

						<button type="submit" class="btn btn-primary btn-lg mt-4">Submit</button>

					</form>

					<div id="message">
						<?php echo $output; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<script type="text/javascript">
		$('form').on('keypress',function(event) {
			if (event.keyCode === 13) {
				$('button').click();
			}
		})
	</script>

  </body>
</html>
