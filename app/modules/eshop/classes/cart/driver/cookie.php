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
 * Cart_Driver_Cookie Class
 *
 * @package     Eshop
 * @category	Cart
 */

class Cart_Driver_Cookie extends Cart_Driver {

    const COOKIE_NAME = 'cart_content';

    /**
     * saves serialized content to cookie
     */
    protected function _set() {
        \Cookie::set(self::COOKIE_NAME, serialize($this->get_items()));
    }

    /**
     * reads content from cookie
     */
    protected function _get() {
        $this->content = unserialize(\Cookie::get(self::COOKIE_NAME, FALSE));
    }

    /**
     * deletes current content from cookie
     */
    protected function _delete() {
        \Cookie::delete(self::COOKIE_NAME);
    }

}