<?php

namespace App\Http\Controllers;

use App\Models\Notify;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    /**
     * Global Settings {loadSettings}
     * Method is private and not accessible via the web
     * Todo: This method Load all settings from database via the PreLoad Model:: getSettings()
     *
     * @param optional $view_name (string) Page Name (make sure to add $ThemePath/$MainFolder/$SubFolder/$page_name)
     *
     * @return \Illuminate\Http\Response
     */
    private function loadSettings($view_name = '')
    {
        // Load method
        $notify = Notify::notify();
        $data['notify'] = Notify::$notify();

        // Query Products
        $data['products'] = Product::where('flag', 1)->get();

        // Return all settings
        return $data;
    }

    /**
     * Todo: Main Landing Page
     */
    public function index()
    {

        // Load Settings
        $data = $this->loadSettings();

        //Load Page View
        return view("homepage", $data);
    }

    /**
     * Todo: add to Cart
     * @return \Illuminate\Http\Response
     */
    function add_to_cart(Request $request)
    {
        // Validate Form Data
        $validator = Validator::make($request->all(), [
            'p' => "required",
            'q' => "required|numeric",
        ]);

        // On Validation Fail
        if ($validator->fails()) {
            session()->flash('notification', 'valid');
            Notify::error('Product does not exist');

            // Return Error Message
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        // Get Shopper Id
        // Todo: sort shopper ID issue so it wont be unique on every session
        $shoppingId = \App\Models\Shopping::get_shopper_id(session('shopper'));

        // This Product
        $this_product = Product::where('id', (int) $request->get('p'))->first();

        // Quantity
        $quantity = (int) $request->get('q');

        // Item in cart
        $this_item = \App\Models\Cart::where('product', $this_product->id)->where('cartid', $shoppingId)->where('flag', 1)->first();
        if (!$this_item) {
            // Add To Cart
            $_cart = new \App\Models\Cart();
            $_cart->product = $this_product->id;
            $_cart->cartid = $shoppingId;
            $_cart->quantity = $quantity;
            $_cart->price = $this_product->price;
            $_cart->save();

            session()->flash('notification', 'success');
            $message = '<strong>Success!</strong> Item was added to the cart';

            // Return Error Message
            return redirect()->back()->withInput($request->input())->with('message', $message);
        } else {
            // Check For Quantity
            if ($this_item->quantity != $quantity) {
                // Actions
                $cart_actions = config('services.cart_actions');

                // Quantity State
                $_qty_status = ($quantity > $this_item->quantity) ? 'quantity_up' : 'quantity_down';
                $description = $cart_actions[$_qty_status] . " old-qty:{$this_item->quantity} [new-qty: $quantity ]";

                // Update Cart
                $this_item->quantity = $quantity;
                $this_item->save();

                // Status
                $_status = new \App\Models\CartStatus();
                $_status->cart = $this_item->id;
                $_status->action = $_qty_status;
                $_status->description = $description;
                $_status->save();

                session()->flash('notification', 'success');
                $message = '<strong>Success!</strong> Item was updated in the cart';

                // Return Error Message
                return redirect()->back()->withInput($request->input())->with('message', $message);
            } else {
                // Incase same item & same quantity
                session()->flash('notification', 'info');
                $message = '<strong>Informantion!</strong> Item is already in cart with the same quantity';

                // Return Error Message
                return redirect()->back()->withInput($request->input())->with('message', $message);
            }
        }
    }
}
