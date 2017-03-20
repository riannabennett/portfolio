<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

if(count($checklists)): ?>
<div class="services row">
	<?php foreach($checklists as $checklist): $checklist_arr = explode(PHP_EOL, trim($checklist['checklist'])); ?>
	<div class="checklist-entry<?php echo $checklist['column_width'] == '1-2' ? ' col-sm-6' : ' col-sm-12'; ?>">
		<?php if($checklist['checklist_title']): ?>
		<h3><?php echo esc_html($checklist['checklist_title']); ?></h3>
		<?php endif; ?>

		<ul>
			<?php foreach($checklist_arr as $checklist_line): ?>
			<li><?php echo lab_esc_script($checklist_line); # escaped by get_field ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>