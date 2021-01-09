<?php

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Home extends ResourceController
{
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
