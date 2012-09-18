<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>CodeIgniter Bootstrap</title>

   <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
   <link href="<?= base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
   <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
   <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">

   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
   <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/custom.js') ?>"></script>

   <script src="<?= base_url('assets/js/Modernizr-yepnope.js')?>"></script> 
   <script src="<?= base_url('assets/js/js-webshim/minified/polyfiller.js')?>"></script> 

   <?php if(isset($styles)): ?>
         <?php foreach($styles as $style) : ?>            
            <link href="<?php echo base_url($style) ?>" rel="stylesheet">
         <?php endforeach; ?>
   <?php endif;?>
   <?php if(isset($scripts)): ?>
         <?php foreach($scripts as $script) : ?>            
            <script src="<?php echo base_url($script) ?>"></script>
         <?php endforeach; ?>
   <?php endif;?>

</head>
<body>
