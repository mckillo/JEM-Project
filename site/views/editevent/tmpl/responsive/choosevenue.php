<?php
/**
 * @version 2.3.1
 * @package JEM
 * @copyright (C) 2013-2021 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

$function = JFactory::getApplication()->input->getCmd('function', 'jSelectVenue');
?>

<script type="text/javascript">
	function tableOrdering( order, dir, view )
	{
		var form = document.getElementById("adminForm");

		form.filter_order.value 	= order;
		form.filter_order_Dir.value	= dir;
		form.submit( view );
	}
</script>

<div id="jem" class="jem_select_venue">
	<h1 class='componentheading'>
		<?php echo JText::_('COM_JEM_SELECT_VENUE'); ?>
	</h1>

	<div class="clr"></div>

	<form action="<?php echo JRoute::_('index.php?option=com_jem&view=editevent&layout=choosevenue&tmpl=component&function='.$this->escape($function).'&'.JSession::getFormToken().'=1'); ?>" method="post" name="adminForm" id="adminForm">
		<div class="jem-row valign-baseline">
      <div id="jem_filter" class="jem-form jem-row jem-justify-start">
        <div>
          <?php
          echo '<label for="filter_type">'.JText::_('COM_JEM_FILTER').'</label>';
          ?>
        </div>
        <div class="jem-row jem-justify-start jem-nowrap">
          <?php echo $this->searchfilter; ?>
          <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->filter;?>" class="inputbox" onchange="document.adminForm.submit();" />
        </div>
        <div class="jem-row jem-justify-start jem-nowrap">
          <button type="submit" class="pointer btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
          <button type="button" class="pointer btn" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
          <button type="button" class="pointer btn" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('', '<?php echo JText::_('COM_JEM_SELECT_VENUE') ?>');"><?php echo JText::_('COM_JEM_NOVENUE')?></button>
        </div>
      </div>
      <div class="jem-row jem-justify-start jem-nowrap">
        <div>
          <?php echo '<label for="limit">'.JText::_('COM_JEM_DISPLAY_NUM').'</label>&nbsp;'; ?>
        </div>
        <div>&nbsp;</div>
        <div>
          <?php echo $this->pagination->getLimitBox(); ?>
        </div>
      </div>
    </div>

    <hr class="jem-hr"/>
    
    <div class="jem-sort jem-sort-small">
      <div class="jem-list-row jem-small-list">
        <div class="sectiontableheader jem-venue-number"><?php echo JText::_('COM_JEM_NUM'); ?></div>
        <div class="sectiontableheader jem-venue-name"><?php echo JHtml::_('grid.sort', 'COM_JEM_VENUE', 'l.venue', $this->lists['order_Dir'], $this->lists['order'], 'selectvenue' ); ?></div>
        <div class="sectiontableheader jem-venue-city"><?php echo JHtml::_('grid.sort', 'COM_JEM_CITY', 'l.city', $this->lists['order_Dir'], $this->lists['order'], 'selectvenue' ); ?></div>
        <div class="sectiontableheader jem-venue-state"><?php echo JHtml::_('grid.sort', 'COM_JEM_STATE', 'l.state', $this->lists['order_Dir'], $this->lists['order']); ?></div>
        <div class="sectiontableheader jem-venue-country"><?php echo JText::_('COM_JEM_COUNTRY'); ?></div>
      </div>
    </div>
    
    <ul class="eventlist eventtable">
      <?php if (empty($this->rows)) : ?>
        <li class="jem-event jem-list-row jem-small-list"><?php echo JText::_('COM_JEM_NOVENUES'); ?></li>
      <?php else :?>
        <?php foreach ($this->rows as $i => $row) : ?>
          <li class="jem-event jem-list-row jem-small-list row<?php echo $i % 2; ?>">
            <div class="jem-event-info-small jem-venue-number">
              <?php echo $this->pagination->getRowOffset( $i ); ?>
            </div>
            
            <div class="jem-event-info-small jem-venue-name">
              <span <?php echo JEMOutput::tooltip(JText::_('COM_JEM_SELECT'), $row->venue, 'editlinktip selectvenue'); ?>>
								<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $row->id; ?>', '<?php echo $this->escape(addslashes($row->venue)); ?>');"><?php echo $this->escape($row->venue); ?></a>
							</span>
            </div>
            
            <div class="jem-event-info-small jem-venue-city">
              <?php echo $this->escape($row->city); ?>
            </div>
            
            <div class="jem-event-info-small jem-venue-state">
              <?php echo $this->escape($row->state); ?>
            </div>
            
            <div class="jem-event-info-small jem-venue-country">
              <?php echo !empty($row->country) ? $this->escape($row->country) : '-'; ?>
            </div>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>

		<input type="hidden" name="task" value="selectvenue" />
		<input type="hidden" name="option" value="com_jem" />
		<input type="hidden" name="tmpl" value="component" />
		<input type="hidden" name="function" value="<?php echo $this->escape($function); ?>" />
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	</form>

	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
</div>
