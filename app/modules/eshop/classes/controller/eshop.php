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
 * The Eshop Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  Eshop
 */
class Controller_Eshop
{

	var $require_login = false;

	/**
	 * Custom Constructor for Eshop
	 * @param Request  $request
	 * @param Response $response
	 */
	public function __construct(\Request $request, $response = NULL)
	{

	}

	/**
	 * functionality testing step by step
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
        // add test
        echo '<h1>Default driver (SESSION)</h1>';
        echo '<h2>add test</h2>';
        $cart = Cart::instance();
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 1",
            'code'=>"TST1",
            'price' => 100,
            'count' => 2,
            'vat'=>21)));
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 2",
            'code'=>"TST2",
            'price' => 300,
            'count' => 1,
            'vat'=>21)));
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 3",
            'code'=>"TST3",
            'price' => 200,
            'count' => 1,
            'vat'=>15)));
        \Debug::dump($cart->get_items());

        // update test
        echo '<h2>update test</h2>';
        $cart->clear();
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 2",
            'code'=>"TST2",
            'price' => 300,
            'count' => 1,
            'vat'=>21)));
        $cart->update(new Cart_Item(array(
            'name'=>"Test product 2",
            'code'=>"TST2",
            'price' => 300,
            'count' => 4,
            'vat'=>21)));
        \Debug::dump($cart->get_items());

        // delete test
        echo '<h2>default driver delete test</h2>';
        $cart->add(new Cart_Item(array(
            'name'=>"Test product",
            'code'=>"TST",
            'price' => 300,
            'count' => 1,
            'vat'=>21)));
        $cart->delete('TST2');
        \Debug::dump($cart->get_items());

        // delete test
        echo '<h1>COOKIE driver</h1>';
        echo '<h2>add test</h2>';
        $cart = Cart::forge('cookie');
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 1",
            'code'=>"TST1",
            'price' => 100,
            'count' => 2,
            'vat'=>21)));
        \Debug::dump($cart->get_items());

        echo '<h1>&quot;Challenge 1&quot;</h1>';
        echo '<h2>Item caluculations test</h1>';
        $item = new Cart_Item(array(
            'name'=>"Test product 1",
            'code'=>"TST1",
            'price' => 100,
            'count' => 2,
            'vat'=>21));
        \Debug::dump(
            $item->get_price_withoutvat(),
            $item->get_price_withvat(),
            $item->get_vat(),
            $item->get_vat_price());

        echo '<h2>Total caluculations test</h1>';
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 2",
            'code'=>"TST2",
            'price' => 300,
            'count' => 1,
            'vat'=>21)));
        $cart->add(new Cart_Item(array(
            'name'=>"Test product 3",
            'code'=>"TST3",
            'price' => 200,
            'count' => 1,
            'vat'=>15)));

        \Debug::dump(
            $cart->get_total_price_withoutvat(Cart_Driver::PRICE_FORMAT_WITH_CURRENCY),
            $cart->get_total_price_withvat(Cart_Driver::PRICE_FORMAT_PLAIN),
            $cart->get_vat_price_overview());

        return \Response::forge('', 200);

	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return \Response::forge(ViewModel::forge('eshop/404'), 404);
	}
}
