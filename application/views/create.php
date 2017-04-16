<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>tinyUrl</title>

	<!-- Material Design fonts -->
 	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Bootstrap Material Design -->
  	<!--<link href="<?php echo base_url(); ?>assets/css/bootstrap-material-design.css" rel="stylesheet">
  	<link href="<?php echo base_url(); ?>assets/css/ripples.min.css" rel="stylesheet">-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    

  	<div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">TinyUrl</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="/">Create</a></li>
              <li><a href="list">List</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
	  <div class="page-header">
	  	<h1>Create URLs</h1>
	  </div>
		
		<?php if(validation_errors()): ?>
		<div class="alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
		<?php endif; ?>

		<?php echo form_open(''); ?>
		<div class="form-group">
			<label for="urls">Urls</label>
			<textarea name="urls" id="urls" class="form-control" rows="10"><?php if(!isset($table))echo set_value('urls'); ?></textarea>
			<span id="helpBlock" class="help-block">Enter up to 40 urls, one per line.</span>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
		<input type="hidden" name="_action" value="add-urls">
	</form>

	<?php if(isset($table) && count($table)): ?>
	<br><br>
	<h2>Created URLs</h2>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
				<th>TinyUrl</th>
				<th>URL</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($table as $r): ?>
				<tr>
				<td><a target="_blank" href="<?php echo $r[0] ?>"><?php echo $r[0] ?></a></td>
				<td><?php echo $r[1] ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>
	</div>
	<?php endif; ?>

    </div> <!-- /container -->




    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 
	<!-- Material Design for Bootstrap -->
	<!-- <script src="<?php echo base_url(); ?>assets/js/material.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/ripples.min.js"></script> -->
	<script>
	//$.material.init();
	</script>

  </body>
</html>