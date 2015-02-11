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
 * Cart_Item Class
 *
 * @package     Eshop
 * @category	Cart
 */

class Cart_Item {

    public $name;
    public $code;
    public $price;
    public $count;
    public $vat;

    /**
     * Cart Item constructor
     * @param void|array $initValues set of named values in array
     */
    public function __construct($initValues = NULL) {
        if (!empty($initValues) && is_array($initValues)) {
            foreach ($initValues as $name=>$val) {
                $this->$name = $val;
            }
        }
    }

    /**
     * calculates price with vat
     * @return float price
     */
    public function get_price_withvat() {
        return $this->get_count() * ($this->price + $this->price * $this->vat / 100);
    }

    /**
     * calculates price without vat
     * @return float price
     */
    public function get_price_withoutvat() {
        return $this->get_count() * $this->price;
    }

    /**
     * calculates absolute vat price
     * @return float vat price
     */
    public function get_vat_price() {
        return $this->get_price_withvat() - $this->get_price_withoutvat();
    }

    /**
     * @return int vat in percent
     */
    public function get_vat() {
        return empty($this->vat) ? 0 : $this->vat;
    }

    /**
     * @return int item count
     */
    public function get_count() {
        return empty($this->count) ? 1 : $this->count;
    }

}