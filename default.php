<?php

/**
 * default.php
 * 
 * Main markup template file for AdminThemeDefault
 * 
 * __('FOR TRANSLATORS: please translate the file /wire/templates-admin/default.php rather than this one.');
 * 
 * 
 */

if(!defined("PROCESSWIRE")) die();

if(!isset($content)) $content = '';
	
$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';

$config->styles->prepend($config->urls->adminTemplates . "styles/main.css");
$config->styles->append($config->urls->root . "wire/templates-admin/styles/font-awesome/css/font-awesome.min.css"); 
$config->scripts->append($config->urls->root . "wire/templates-admin/scripts/inputfields.js?v=5"); 
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js?v=5");
	
require_once(dirname(__FILE__) . "/AdminThemeApertusHelpers.php");
$helpers = new AdminThemeApertusHelpers();

?><!DOCTYPE html>
<html lang="<?php echo $helpers->_('en'); 
	/* this intentionally on a separate line */ ?>">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $helpers->renderBrowserTitle(); ?></title>

	<script type="text/javascript"><?php echo $helpers->renderJSConfig(); ?></script>
	<?php foreach($config->styles as $file) echo "\n\t<link type='text/css' href='$file' rel='stylesheet' />"; ?>
	<?php foreach($config->scripts as $file) echo "\n\t<script type='text/javascript' src='$file'></script>"; ?>

</head>
<body class='<?php echo $helpers->renderBodyClass(); ?>'>

	<?php
		$helpers->renderEnvironmentIndicator();
	?>

	<div class="header-main ui-helper-clearfix">
		<div class="container">

			<h1 class="logo-main">
				<a href='<?php echo $config->urls->admin?>'>
					<?php $helpers->renderSiteName(); ?>
				</a>
			</h1>

			<section class="module-pagetree">
			<h2>Administer Project</h2>
			<?php 
			if($user->isLoggedin()) {
				echo $searchForm;
				echo "\n\n<ul id='topnav'>" . $helpers->renderTopNavItems() . "</ul>";
			}
			?>
			</section>

			<?php if($config->debug && $this->user->isSuperuser())
				include($config->paths->root . '/wire/templates-admin/debug.inc'); ?>

			<section class="module-forumsearch">
			<h2>Search Forums</h2>
			<?php $helpers->renderForumSearch(); ?>
			</section>

			<section class="module-usefullinks">
			<h2>Useful links</h2>
			<?php $helpers->renderUsefulLinks(); ?>
			</section>

			<section class="module-apertus-meta">
			<?php
				$helpers->renderAdminThemeConfigLink();
			?>
			</section>

			<section class="module-processwire-meta">
				<?php if($user->isLoggedin()): ?>
					<span id='userinfo'>
					<i class='fa fa-user'></i>
						<?php if($user->hasPermission('profile-edit')): ?>
							<i class='fa fa-angle-right'></i>
							<a class='action' href='<?php echo $config->urls->admin; ?>profile/'>
								<?php echo $user->name; ?></a> <i class='fa fa-angle-right'></i>
						<?php endif; ?>
						<a class='action' href='<?php echo $config->urls->admin; ?>login/logout/'>
						<?php echo $helpers->_('Logout'); ?></a>
					</span>
				<?php endif; ?>
				ProcessWire
				<?php echo $config->version . ' <!--v' . $config->systemVersion; ?>--> &copy; <?php echo date("Y"); ?>
			</section>

		</div>
	</div>


	<div id="content" class="main-content fouc_fix">
		<?php echo $helpers->renderAdminNotices($notices); ?>

		<div class="module-breadcrumbs">
			<div class='container'>

				<?php
				if($page->process == 'ProcessPageList' || ($page->name == 'lister' && $page->parent->name == 'page')) {
					echo $helpers->renderAdminShortcuts();
				}
				?>

				<ul class='nav'><?php echo $helpers->renderBreadcrumbs(); ?></ul>

			</div>
		</div><!--/#breadcrumbs-->

		<div class="container">

			<?php 
			if(trim($page->summary)) echo "<h2>{$page->summary}</h2>"; 
			if($page->body) echo $page->body; 
			echo $content; 
			?>

		</div>
	</div><!--/#content-->


</body>
</html>
