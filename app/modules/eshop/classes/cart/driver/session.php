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
 * Cart_Driver_Session Class
 *
 * @package     Eshop
 * @category	Cart
 */

class Cart_Driver_Session extends Cart_Driver {

    const SESSION_NAME = 'cart_content';

    /**
     * saves content to default session
     */
    protected function _set() {
        \Session::set(self::SESSION_NAME, $this->get_items());
    }

    /**
     * reads content from default session
     */
    protected function _get() {
        $this->content = \Session::get(self::SESSION_NAME, FALSE);
    }

    /**
     * deletes content from default session
     */
    protected function _delete() {
        \Session::delete(self::SESSION_NAME);
    }

}