<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<?php
$css_class_map = array(
	Notice::ERROR      => 'alert-error',
	Notice::WARNING    => 'alert-danger',
	Notice::VALIDATION => 'alert-danger',
	Notice::INFO       => 'alert-info',
	Notice::SUCCESS    => 'alert-success',
);
?>

<?php foreach($notices as $type => $set): ?>
	<?php if ( ! empty($set)): ?>
		<?php foreach ($set as $notice): ?>
		<div class="alert <?php echo $css_class_map[$type]; ?>">
			<a class="close" data-dismiss="alert" href="#">&times;</a>

			<?php if ($notice['message'] !== NULL): ?>
			<?php echo HTML::chars($notice['message']); ?>
			<?php endif; ?>

			<?php if ( ! empty($notice['items'])): ?>
			<ul>
				<?php foreach($notice['items'] as $item): ?>
				<li><?php echo HTML::chars($item); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endforeach; ?>
