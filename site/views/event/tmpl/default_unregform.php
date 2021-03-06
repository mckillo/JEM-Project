<?php
/**
 * @version 2.1.5
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 * @todo add Itemid parameter to action link
 */

defined('_JEXEC') or die;

// The user is already attending. Let's check if he can unregister from the event.


if ($this->print == 0) :

	if ($this->item->unregistra == 0) :

		// not allowed to unregister
		echo JText::_( 'COM_JEM_ALLREADY_REGISTERED' );

	else:

		// allowed to unregister -> display form
		?>
		<form id="JEM" action="<?php echo JRoute::_('index.php?option=com_jem&view=event&id=' . (int)$this->item->id); ?>" method="post">
			<p>
				<input type="checkbox" name="reg_check" onclick="check(this, document.getElementById('jem_send_attend'))" />
				<?php if ($this->isregistered == 2) : ?>
					<?php echo ' '.JText::_('COM_JEM_WAITINGLIST_UNREGISTER_BOX'); ?>
				<?php else : ?>
					<?php echo ' '.JText::_('COM_JEM_UNREGISTER_BOX'); ?>
				<?php endif;?>
			</p>
			<p>
				<input class="button1" type="submit" id="jem_send_attend" name="jem_send_attend" value="<?php echo JText::_('COM_JEM_UNREGISTER'); ?>" disabled="disabled" />
			</p>
			<br>
			<input type="hidden" name="rdid" value="<?php echo $this->item->did; ?>" />
			<input type="hidden" name="task" value="event.delreguser" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php
	endif;
endif; // not print