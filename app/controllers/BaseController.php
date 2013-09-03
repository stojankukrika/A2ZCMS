<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	public static $timestamps = true;
	public function timestamp()
    {
        $this->updated_at = time();

        if ( ! $this->exists) $this->created_at = $this->updated_at;
    }

}