<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<p class="pagecontrols">
	<?php echo html::file_anchor('admin/users/register/', html::chars('Create new'), array('class'=>'btn')); ?>
</p>

<h1><?php echo html::chars($title) ?></h1>

<?php if ($message = cookie::get('message')): ?>
<p class="message"><?php echo $message ?></p>
<?php endif ?>

<?php if ( ! empty($data['list'])): ?>
	<table cellspacing="0">
		<thead>
			<tr>
				<?php
				foreach ($data['header'] as $name => $content):
					echo '<td>';
					echo (isset($content['link']) && ! empty($content['link'])) ?
						'<a href="'.$content['link'].'">'.$content['title'].'</a>' : $content['title'];
					echo '</td>';
				endforeach
				?>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data['list'] as $user): 
			?>
				<tr>
					<td><?php echo $user->id ?></td>
					<td><?php echo $user->details->first_name.' '.$user->details->last_name ?></td>
					<td><?php echo $user->email ?></td>
					<td><?php echo $user->details->city ?></td>
					<td><?php echo $user->details->company ?></td>
					<td><?php echo $user->details->phone_mobile ?></td>
					<td><?php echo $user->logins ?></td>
					<td><?php echo ($user->created_on) ? Date('Y-m-d', $user->created_on) : '--' ?></td>
					<td class="controls">
						<?php echo html::file_anchor('admin/users/edit/'.$user->id, '[E]', array('class'=>'btn')); ?>
						<?php echo html::file_anchor('admin/users/roles/'.$user->id, '[R]', array('class'=>'btn')); ?>
						<?php echo html::file_anchor('admin/properties/?u='.$user->id, '[L]', array('class'=>'btn')); ?>
						<?php echo html::file_anchor('admin/users/delete/'.$user->id, '[D]', array('class'=>'btn')); ?>
					</td>
				</tr>
			<?php
			endforeach
			?>
		</tbody>
	</table>
<?php
endif
?>

<?php echo $data['paging'] ?>
