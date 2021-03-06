<?php

/**
 * Sticky Notes
 *
 * An open source lightweight pastebin application
 *
 * @package     StickyNotes
 * @author      Sayak Banerjee
 * @copyright   (c) 2013 Sayak Banerjee <mail@sayakbanerjee.com>
 * @license     http://www.opensource.org/licenses/bsd-license.php
 * @link        http://sayakbanerjee.com/sticky-notes
 * @since       Version 1.0
 * @filesource
 */

/**
 * SetupController
 *
 * This controller handles app install and updates
 *
 * @package     StickyNotes
 * @subpackage  Controllers
 * @author      Sayak Banerjee
 */
class SetupController extends BaseController {

	/**
	 * The constructor sets the maximum execution time.
	 *
	 * This is needed as the script will take more time, especially when
	 * running the updater.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		set_time_limit(3600);
	}

	/**
	 * Shows the installation screen
	 *
	 * @param  string  $method
	 * @param  string  $action
	 * @return \Illuminate\Support\Facades\View
	 */
	public function getInstall($method = 'web', $action = '')
	{
		// Installation stage
		$stage = Session::has('setup.stage') ? Session::get('setup.stage') : 1;

		// Output based on request method
		switch ($method)
		{
			case 'web':
				$data = array(
					'error'       => Session::get('messages.error'),
					'success'     => Session::get('messages.success'),
				);

				return View::make("setup/install/stage{$stage}", $data);

			case 'ajax':
				return Setup::install($action);

			case 'error':
				return View::make('setup/error');

			default:
				App::abort(404); // Not found
		}
	}

	/**
	 * Handles POST requests for the install page
	 *
	 * @return \Illuminate\Support\Facades\Redirect
	 */
	public function postInstall()
	{
		// Stage 1 submitted
		if (Input::has('_test'))
		{
			$status = Setup::testConnection();

			if ($status === TRUE)
			{
				Session::put('setup.stage', 2);

				return Redirect::to('setup/install');
			}
		}

		// Stage 2 submitted
		if (Input::has('_install'))
		{
			Session::put('setup.stage', 3);

			return Redirect::to('setup/install');
		}
	}

	/**
	 * Shows the update screen
	 *
	 * @param  string  $method
	 * @param  string  $action
	 * @return \Illuminate\Support\Facades\View
	 */
	public function getUpdate($method = 'web', $action = '')
	{
		// Updater stage
		$stage = Session::has('setup.stage') ? Session::get('setup.stage') : 1;

		// Output based on request method
		switch ($method)
		{
			case 'web':
				$data = array(
					'error'       => Session::get('messages.error'),
					'success'     => Session::get('messages.success'),
					'version'     => Session::get('setup.version'),
					'versions'    => Setup::updateVersions(),
					'messages'    => Setup::messages(),
				);

				return View::make("setup/update/stage{$stage}", $data);

			case 'ajax':
				return Setup::update($action);

			case 'error':
				return View::make('setup/error');

			default:
				App::abort(404); // Not found
		}
	}

	/**
	 * Handles POST requests for the update page
	 *
	 * @return \Illuminate\Support\Facades\Redirect
	 */
	public function postUpdate()
	{
		// Define validation rules
		$validator = Validator::make(Input::all(), array(
			'version' => 'required|in:'.Setup::updateVersions(TRUE),
		));

		// Run the validator
		if ($validator->passes())
		{
			Session::put('setup.version', Input::get('version'));

			Session::put('setup.stage', 2);

			return Redirect::to('setup/update');
		}
		else
		{
			Session::flash('messages.error', $validator->messages()->all('<p>:message</p>'));

			return Redirect::to('setup/update')->withInput();
		}
	}

}
