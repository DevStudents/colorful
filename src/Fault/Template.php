<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="data:image/png;base64,<?php echo $icon; ?>">
	<title>COLORFUL Error</title>
	<style>
		* { box-sizing: border-box; }
		html, body { margin: 0; padding: 0; }
		body { background-color: #fff; font-family: Tahoma, Arial; color: #1b1b1b; font-size: 17px; }
		section { padding: 15px; }
		header { text-align: center; background-color: black; padding: 30px; }
		section h3 { margin: 0; margin-top: 29px; }
		section .reports { margin-top: -1px; }
		header .version { width: 198px; font-size: 12px; position: absolute; top: 0; left: 50%; text-align: right; margin: 60px 0 0 -36px; color: #fff; }
		h4 { width: 100%; border: 0; border-bottom: 2px solid #1b1b1b; padding-bottom: 5px; text-transform: uppercase; }
		pre { font-family: Tahoma; }
	</style>
</head>
<body>
	<header>
		<a href="https://github.com/sintloer/COLORFUL-framework" target="_blank"><img src="data:image/png;base64,<?php echo $logo; ?>" alt="COLORFULframework"></a>
		<div class="version">ver. <?php echo $version; ?></div>
	</header>
	<section class="error">
		<h3>An error occured <?php echo (!empty($exampleNumber) ? ': #' . $exampleNumber : ''); ?></h3>
		<div class="reports">Reports: <?php echo $reports; ?></div>
	</section>

	<section class="m">
		<h4>Message</h4>
		<p><?php echo $msg; ?></p>
	</section>

	<?php

		if($example !== false)
		{
			$match = preg_match_all('/!\[(.*?)\]/', $example, $matches, PREG_SET_ORDER);
			if($match && isset($matches))
			{
				foreach($matches as $match)
				{
					$toReplace = $match[0];
					$value = $match[1];

					$value = strtoupper(str_replace(' ', '_', $value));
					$example = str_replace($toReplace, $value, $example);
				}

			}

	?>

	<section class="e">
		<h4>Example</h4>
		<pre><?php echo $example; ?></pre>
	</section>

	<?php

		}

	?>

</body>
</html>