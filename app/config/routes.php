<?php
return array(
	'_root_'  => 'eshop/index',  // The default route
	'_404_'   => 'eshop/404',    // The main 404 route

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);