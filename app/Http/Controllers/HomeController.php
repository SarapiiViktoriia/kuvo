<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    protected $item_api;
    public function __construct()
    {
        $this->middleware('auth');
        $this->item_api = new \App\Http\Controllers\Api\ApiItemController;
    }
    public function index()
    {
        $data['item_count'] = $this->item_api->index()->count();
        return view('home', $data)->with(['page_title' => 'dashboard']);
    }
}
