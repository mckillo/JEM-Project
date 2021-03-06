<?php
/**
 * @version 2.1.5
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

// The user is not already attending -> display registration form.

if (($this->item->registra == 1) && ($this->print == 0)) :

	if (($this->item->maxplaces > 0) && ($this->item->booked >= $this->item->maxplaces) && !$this->item->waitinglist) :
	?>
	<p class="el-event-full">
		<?php echo JText::_( 'COM_JEM_EVENT_FULL_NOTICE' ); ?>
	</p>

	<?php else : ?>

	<form id="JEM" action="<?php echo JRoute::_('index.php?option=com_jem&view=event&id=' . (int)$this->item->id); ?>"  name="adminForm" id="adminForm" method="post">
		<p>
			<input type="checkbox" name="reg_check" onclick="check(this, document.getElementById('jem_send_attend'))" />
			<?php if ($this->item->maxplaces && ($this->item->booked >= $this->item->maxplaces)) : // full event ?>
				<?php echo ' '.JText::_('COM_JEM_EVENT_FULL_REGISTER_TO_WAITING_LIST'); ?>
			<?php else : ?>
				<?php echo ' '.JText::_('COM_JEM_I_WILL_GO'); ?>
			<?php endif; ?>
		</p>
		<p>
			<input class="button1" type="submit" id="jem_send_attend" name="jem_send_attend" value="<?php echo JText::_('COM_JEM_REGISTER'); ?>" disabled="disabled" />
		</p>
		<br>
		<input type="hidden" name="rdid" value="<?php echo $this->item->did; ?>" />
		<input type="hidden" name="task" value="event.userregister" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
	<?php
	endif; // full?

endif; // registra and not print
