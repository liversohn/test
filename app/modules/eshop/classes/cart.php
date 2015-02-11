<?php
/**
 * Part of the Eshop Module
 *
 * @package    Eshop
 * @version    1.0
 * @author     Leos Jedlicka <leos.jedlicka@post.cz>
 * @license    MIT License
 * @copyright  2015 Leos Jedlicka
 * @link       http://www.bvsarts.com
 */

namespace Eshop;

/**
 * Cart Class
 *
 * @package     Eshop
 * @category	Cart
 */

class Cart {
	/**
	 * loaded cart driver instance
	 */
	protected static $_instance = null;

	/**
	 * array of loaded instances
	 */
	protected static $_instances = array();

	/**
	 * array of global config defaults
	 */
	protected static $_defaults = array(
		'driver'                    => 'session',
	);

	/**
	 * create or return the driver instance
	 *
	 * @param	void|string $instance driver name
	 * @access	public
	 * @return	Cart_Driver object
	 */
	public static function instance($instance = null)
	{
		if ($instance !== null)
		{
			if ( ! array_key_exists($instance, static::$_instances))
			{
				static::$_instances[$instance] = static::forge($instance);
			}

			return static::$_instances[$instance];
		}

		if (static::$_instance === null)
		{
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}

	/**
	 * Factory
	 *
	 * Produces fully configured cart driver instances
	 *
	 * @param	void|string $driver driver name
     * @return  Cart_driver instance
	 */
	public static function forge($driver = NULL)
	{
        \Config::load('Eshop::cart', 'cart');
        $config = \Config::get('cart', array());
        if (empty($driver)) {
            $driver = \Config::get('cart.driver', FALSE);
            if ($driver === FALSE) {
                $driver = static::$_defaults['driver'];
            }
        }

		// determine the driver to load
		$class = '\\Eshop\\Cart_Driver_'.ucfirst($driver);

		$instance = new $class($config);

    	return static::$_instances[$driver] = $instance;
	}

}