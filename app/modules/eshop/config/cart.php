<?php
/**
 * Eshop Module configuration file
 *
 * @package    Eshop
 * @version    1.0
 * @author     Leos Jedlicka <leos.jedlicka@post.cz>
 * @license    MIT License
 * @copyright  2015 Leos Jedlicka
 * @link       http://www.bvsarts.com
 */

return array(
    'driver' => 'session',
    'defaultVat' => 21,
    'defaultCurrency' => 'Kč',
    'format' => array(
        'precision' => 2,
        'thousandSeparator' => '&nbsp;',
        'decimalPoint' => ','
    )
);
