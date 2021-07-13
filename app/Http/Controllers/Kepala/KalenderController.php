<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Kalender;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kalender::whereDate('mulai', '>=', $request->start)
                ->whereDate('selesai', '<=', $request->end)
                ->get(['id', 'mulai', 'selesai', 'keterangan']);
            return response()->json($data);
        }
        echo view('pages.kepala.kalender.index');
    }

    public function event(Request $request)
    {
        switch ($request->type) {
            case 'create':
                $event = Kalender::create([
                    'mulai' => $request->event_start,
                    'selesai' => $request->event_end,
                    'keterangan' => $request->event_name,
                ]);
                break;
            case 'edit':
                $event = Kalender::find($request->id)->update([
                    'mulai' => $request->event_start,
                    'selesai' => $request->event_end,
                    'keterangan' => $request->event_name,
                ]);
                break;
            case 'delete':
                $event = Kalender::find($request->id)->delete();
                break;
            default:
                $event = null;
                return false;
        }
        return response()->json($event);
    }
}
