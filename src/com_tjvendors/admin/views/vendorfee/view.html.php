<?php
/**
 * @package     TJVendors
 * @subpackage  com_tjvendors
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2019 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 *
 * @since  1.6
 */
class TjvendorsViewVendorFee extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $form;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$input = JFactory::getApplication()->input;
		$this->vendor_id = $input->get('vendor_id', '', 'INT');
		$this->id = $input->get('id', '', 'INT');
		$this->state = $this->get('State');
		$this->item  = $this->get('Item');
		$this->form  = $this->get('Form');
		$this->input = JFactory::getApplication()->input;
		JText::script('COM_TJVENDORS_FEES_NEGATIVE_NUMBER_ERROR');
		JText::script('COM_TJVENDORS_FEES_PERCENT_ERROR');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user  = JFactory::getUser();
		$isNew = ($this->item->vendor_id == 0);

		$input = JFactory::getApplication()->input;
		$client = $input->get('client', '', 'STRING');

		if ($isNew)
		{
			$viewTitle = JText::_('COM_TJVENDOR_NEW_USER_SPECIFIC_COMMISSION');
		}
		else
		{
			$viewTitle = JText::_('COM_TJVENDOR_EDIT_USER_SPECIFIC_COMMISSION');
		}

		$clientTitle = TjvendorFrontHelper::getClientName($client);
		JToolbarHelper::title($clientTitle . '  ' . $viewTitle, 'pencil.png');

		JToolBarHelper::apply('vendorfee.apply', 'JTOOLBAR_APPLY');
		JToolBarHelper::save('vendorfee.save', 'JTOOLBAR_SAVE');

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('vendorfee.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('vendorfee.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
