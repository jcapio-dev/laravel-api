<?php

namespace App\Http\Controllers;

use App\Models\Coins;
use Illuminate\Http\Request;
use \CoinMarketCap;

class CoinsController extends Controller
{
    public function index(Request $request)
    {
        $regex = '%' . $request->input('coin') . '%';
        $query = Coins::where('name', 'like', $regex)
                    ->orWhere('symbol', 'like',$regex);
        return $query->orderBy($request->input('sort'), $request->input('order'))->paginate(10, ['*'], 'page', $request->input('page'));
    }

    public function store(Request $request)
    {
        $coin = $request->input('coin');
        $response = CoinMarketCap::metadata(['symbol' => $coin]);
        $coinData = $response['data'][strtoupper($coin)][0];
        $coin = Coins::create([
            'name' => $coinData['name'],
            'symbol' => $coinData['symbol'],
            'description' => $coinData['description'],
            'logo' => $coinData['logo']
        ]);
        return $coin;
    }

    public function destroy(string $id)
    {
        return Coins::destroy($id);
    }

    public function getCurrentPrice(string $coin)
    {
        $response = CoinMarketCap::quotes(['symbol' => $coin]);
        return $response['data'][strtoupper($coin)]['quote']['USD']['price'];
    }

    public function refreshCoin(string $id)
    {
        $coin = Coins::find($id);
        $response = CoinMarketCap::quotes(['symbol' => strtolower($coin->symbol)]);
        $coinData = $response['data'][strtoupper($coin->symbol)];
        Coins::where('id',$id)->update([
            'totalSupply'=> $coinData['total_supply'],
            'price'=> $coinData['quote']['USD']['price'],
        ]);
        return Coins::find($id);
        // return $response['data'][strtoupper($coin->symbol)];
    }
}
