<?php
/**
 * @version 2.1.5
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

defined('_JEXEC') or die;

require_once (JPATH_COMPONENT_SITE.'/classes/controller.form.class.php');

/**
 * JEM Component Venue Controller
 *
*/
class JEMControllerVenue extends JemControllerForm
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 *
	 */
	protected $text_prefix = 'COM_JEM_VENUE';


	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 *
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	/**
	 * Function that allows child controller access to model data
	 * after the data has been saved.
	 * Here used to trigger the jem plugins, mainly the mailer.
	 *
	 * @param   JModel(Legacy)  $model      The data model object.
	 * @param   array           $validData  The validated data.
	 *
	 * @return  void
	 */
	protected function _postSaveHook($model, $validData = array())
	{
		$isNew = $model->getState('venue.new');
		$id    = $model->getState('venue.id');

		// trigger all jem plugins
		JPluginHelper::importPlugin('jem');
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger('onVenueEdited', array($id, $isNew));

		// but show warning if mailer is disabled
		if (!JPluginHelper::isEnabled('jem', 'mailer')) {
			JError::raiseNotice(100, JText::_('COM_JEM_GLOBAL_MAILERPLUGIN_DISABLED'));
		}
	}

}