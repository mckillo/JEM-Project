<?php
/**
 * @version 2.1.5
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

// Base this model on the backend version.
require_once JPATH_ADMINISTRATOR . '/components/com_jem/models/venue.php';

/**
 * Editvenue Model
 */
class JemModelEditvenue extends JemModelVenue
{

	/**
	 * Model typeAlias string. Used for version history.
	 * @var        string
	 */
	public $typeAlias = 'com_jem.venue';


	/**
	 * Method to auto-populate the model state.
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Load state from the request.
		$pk = $app->input->getInt('a_id', 0);
		$this->setState('venue.id', $pk);

		$return = $app->input->get('return', '', 'base64');
		$this->setState('return_page', urldecode(base64_decode($return)));

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('layout', $app->input->getCmd('layout', ''));
	}

	/**
	 * Method to get venue data.
	 *
	 * @param integer	The id of the venue.
	 * @return mixed item data object on success, false on failure.
	 */
	public function getItem($itemId = null)
	{
		$jemsettings = JEMHelper::config();

		// Initialise variables.
		$itemId = (int) (!empty($itemId)) ? $itemId : $this->getState('venue.id');

		// Get a row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($itemId);

		// Check for a table object error.
		if ($return === false && $table->getError()) {
			$this->setError($table->getError());
			return false;
		}

		$properties = $table->getProperties(1);
		$value = JArrayHelper::toObject($properties, 'JObject');

		// Convert attrib field to Registry.
		//$registry = new JRegistry();
		//$registry->loadString($value->attribs);

		$globalregistry = JemHelper::globalattribs();

		$value->params = clone $globalregistry;
		//$value->params->merge($registry);

		// Compute selected asset permissions.
		$user = JemFactory::getUser();

		// Check edit permission.
		$value->params->set('access-edit', $user->can('edit', 'venue', $value->id, $value->created_by));

		// Check edit state permission.
		$value->params->set('access-change', $user->can('publish', 'venue', $value->id, $value->created_by));

		$value->author_ip = $jemsettings->storeip ? JemHelper::retrieveIP() : false;

		$files = JemAttachment::getAttachments('venue' . $itemId);
		$value->attachments = $files;

		if (empty($itemId)) {
			$value->country = $jemsettings->defaultCountry;
		}

		return $value;
	}

	protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false)
	{
	//	JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');

		return parent::loadForm($name, $source, $options, $clear, $xpath);
	}

	/**
	 * Get the return URL.
	 * @return string return URL.
	 */
	public function getReturnPage()
	{
		return base64_encode(urlencode($this->getState('return_page')));
	}

}