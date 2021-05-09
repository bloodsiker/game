<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

/**
 * Class MineController
 */
class MineController extends Controller
{

    public function create()
    {

    }

    public function edit(Request $request, $id)
    {
        $exchange = Exchange::findOrFail($id);
        $exchangeSource = ExchangeSource::all();

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'time_cron' => 'required',
            ]);

            $exchange->name = $request->get('name');
            $exchange->time_cron = $request->get('time_cron');
            $exchange->markup = $request->get('markup') ?: 0;
            $exchange->is_active = $request->get('is_active') == 1 ? 1 : 0;
            $exchange->save();

            return redirect()->route('admin.exchange')->with(['success' => 'Успешно обновлено']);
        }

        return view('admin.exchange.edit', compact('exchange', 'exchangeSource'));
    }

    public function add(Request $request)
    {
        $exchangeSource = ExchangeSource::all();

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'source_id' => 'required',
                'currency' => 'required',
                'time_cron' => 'required',
            ]);

            $exchange = new Exchange();
            $exchange->source_id = $request->get('source_id');
            $exchange->name = $request->get('name');
            $exchange->currency = $request->get('currency');
            $exchange->time_cron = $request->get('time_cron');
            $exchange->markup = $request->get('markup') ?: 0;
            $exchange->is_active = $request->get('is_active') == 1 ? 1 : 0;
            $exchange->save();

            return redirect()->route('admin.exchange')->with(['success' => 'Успешно создано']);
        }

        return view('admin.exchange.add', compact('exchangeSource'));
    }

    public function delete(Request $request, $id)
    {
        $exchange = Exchange::findOrFail($id);
        if ( $exchange->delete()) {
            return redirect()->route('admin.exchange')->with(['success' => 'Запись удалена']);
        }

        return redirect()->route('admin.exchange')->with(['error' => 'Запись удалена']);
    }

    public function ajax(Request $request)
    {
        if ($request->isMethod('post')) {

            if ($request->get('action') == 'get_currency') {
                $id = $request->get('id');
                $source = ExchangeSource::findOrFail($id);

                $dataJson = json_decode(file_get_contents($source->url));

                return response()->json(['status' => 1, 'data' => $dataJson]);
            }

            if ($request->get('action') == 'send_to_telegram') {
                Artisan::call('telegram:exchange', ['--without_time' => 'yes']);

                return response()->json(['status' => 1]);
            }
        }

        return response()->json(['error' => 'Bad request']);
    }
}
