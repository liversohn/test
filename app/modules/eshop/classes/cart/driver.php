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
 * Cart_driver Abstract Class
 *
 * @package     Eshop
 * @category	Cart
 */

abstract class Cart_Driver {

    const PRICE_FORMAT_NONE = 0;
    const PRICE_FORMAT_PLAIN = 1;
    const PRICE_FORMAT_WITH_CURRENCY = 2;

    protected $content;
    protected $config;

    /**
     * driver constructor:
     * sets config, loads content, registers save on shutdown
     * @param array $config
     */
    public function __construct($config = NULL) {
        $this->config = $config;
        $this->_get();
        if (empty($this->content)) {
            $this->set_empty_content();
        }
        \Event::register('shutdown', array($this, 'save'));
    }

    /**
     * adds item or highers item count
     * @param \Eshop\Cart_Item $item
     */
    public function add(Cart_Item $item) {
        if (isset($this->content[$item->code])) {
            $this->content[$item->code]->count += $item->count;
        } else {
            $this->content[$item->code] = $item;
        }
    }

    /**
     * replaces item
     * @param \Eshop\Cart_Item $item
     */
    public function update(Cart_Item $item) {
        if (isset($this->content[$item->code])) {
            $this->content[$item->code] = $item;
        }
    }

    /**
     * deletes item by code
     * @param string $code
     */
    public function delete($code) {
        if (isset($this->content[$code])) {
            unset($this->content[$code]);
        }
    }

    /**
     * get current item list
     * @return array of Cart_Item
     */
    public function get_items() {
        return $this->content;
    }

    /**
     * calculates total price with vat
     * @param int $format const type of PRICE_FORMAT*
     * @return string price
     */
    public function get_total_price_withvat($format = self::PRICE_FORMAT_NONE) {
        $price = 0;
        foreach ($this->get_items() as $item) {
            $price += $item->get_price_withvat();
        }
        return $this->price_format($price, $format);
    }

    /**
     * calculates total price without vat
     * @param int $format const type of PRICE_FORMAT*
     * @return string price
     */
    public function get_total_price_withoutvat($format = self::PRICE_FORMAT_NONE) {
        $price = 0;
        foreach ($this->get_items() as $item) {
            $price += $item->get_price_withoutvat();
        }
        return $this->price_format($price, $format);
    }

    /**
     * creates vat overview: list of used vat and corresponding absolute price sum
     * @param int $format const type of PRICE_FORMAT*
     * @return string price
     */
    public function get_vat_price_overview() {
        $vatTable = array();
        foreach ($this->get_items() as $item) {
            $vat = $item->get_vat();
            if (!isset($vatTable[$vat])) {
                $vatTable[$vat] = 0;
            }
            $vatTable[$vat] += $item->get_vat_price();
        }
        return $vatTable;
    }

    /**
     * formats price according to format type
     * @param float $price
     * @param int $format const type of PRICE_FORMAT*
     * @return string|float or false on wrong type
     */
    private function price_format($price, $format = self::PRICE_FORMAT_PLAIN) {
        $output = '';
        switch($format) {
            case self::PRICE_FORMAT_WITH_CURRENCY:
                $output = '&nbsp;'.$this->config['defaultCurrency'];
            case self::PRICE_FORMAT_PLAIN:
                return number_format(
                    $price,
                    $this->config['format']['precision'],
                    $this->config['format']['decimalPoint'],
                    $this->config['format']['thousandSeparator']
                    ).$output;
                break;
            case self::PRICE_FORMAT_NONE:
                return $price;
        }
        return FALSE;
    }

    /**
     * completely resets cart
     */
    public function clear() {
        $this->set_empty_content();
        $this->_delete();
    }

    /**
     * saves cart
     */
    public function save() {
        $this->_set();
    }

    /**
     * reset content
     */
    private function set_empty_content() {
        $this->content = array();
    }

    /**
     * saves content to repository
     */
    protected abstract function _set();

    /**
     * reads content from repository
     */
    protected abstract function _get();

    /**
     * deletes whole content repository
     */
    protected abstract function _delete();

}
