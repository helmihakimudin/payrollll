<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Currency;
use Validator;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencyidr = Currency::where('usd', 1)->first();
        $currencyidr->idr = round($currencyidr->idr,2);
        $currencyidr->usd = round($currencyidr->usd,2);
        $currencyidr->rupiah = number_format($currencyidr->idr,2);

        $currencyidr->dollar = $currencyidr->usd / $currencyidr->idr;
        $currencyidr->dollar = number_format($currencyidr->dollar,6);

        return view("admin.currency.index", compact( 'currencyidr'));
    }
    public function setting()
    {
        $currencyidr = Currency::where('usd', 1)->first();
        return view("admin.currency.edit", compact('currencyidr'));
    }

    public function store(Request $request)
    {
            $currencyidr = Currency::where('usd', 1)->first();
            $currencyidr->idr = $request->idr;
            $currencyidr->save();
            return redirect()->route('currency.converter')->with(['success'=>'Konversi Berhasil Diubah !']);
    }
}
