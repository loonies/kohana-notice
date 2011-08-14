<div class="notice">
<?php foreach($notices as $type => $set): ?>
	<?php if ( ! empty($set)): ?>

	<?php foreach ($set as $notice): ?>
	<div class="<?php echo $type; ?>">
		<h6><?php echo UTF8::ucfirst($notice['type']); ?></h6>

		<?php if ($notice['message'] !== NULL): ?>
		<p><?php echo HTML::chars($notice['message']); ?></p>
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
</div>