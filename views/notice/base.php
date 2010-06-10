
<div id="notice">
<?php foreach($notifications as $type => $notification): ?>
	<?php if ( ! empty($notification)): ?>

	<?php foreach ($notification as $notice): ?>
	<div class="<?php echo $type ?>">
		<h6><?php echo __(UTF8::ucfirst($type)) ?></h6>

		<?php if ($notice['message'] !== NULL): ?>
		<p><?php echo $notice['message'] ?></p>
		<?php endif; ?>

		<?php if ( ! empty($notice['items'])): ?>
		<ul>
			<?php foreach($notice['items'] as $item): ?>
			<li><?php echo __($item) ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>

	<?php endif; ?>
<?php endforeach; ?>
</div>
