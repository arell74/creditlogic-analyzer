<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CreditController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function analyze(Request $request)
    {
        // Input validation
        $request->validate([
            'income'       => 'required|numeric|min:1',
            'has_debt'     => 'required|in:ya,tidak',
            'is_permanent' => 'required|in:ya,tidak'
        ]);

        // Parse input
        $income          = (int) $request->input('income');
        $hasDebt         = $request->input('has_debt') === 'ya';
        $isPermanent     = $request->input('is_permanent') === 'ya';

        // Rule checks
        $highIncome      = $income > 5_000_000;
        $noDebt          = !$hasDebt;
        $permanentJob    = $isPermanent;

        // Breakdown untuk ditampilkan di view
        $breakdown = [
            [
                'label' => 'Penghasilan > Rp 5.000.000',
                'pass'  => $highIncome
            ],
            [
                'label' => 'Tidak ada tunggakan',
                'pass'  => $noDebt
            ],
            [
                'label' => 'Status kerja tetap',
                'pass'  => $permanentJob
            ],
        ];

        // Decision logic (3-tier)
        if ($highIncome && $noDebt && $permanentJob) {
            // TIER 1: All conditions met
            $status      = '✓ SANGAT LAYAK (ACC)';
            $color       = 'text-[#16A34A]';
            $description = 'Semua persyaratan kredit terpenuhi dengan sempurna.';
            
        } elseif ($highIncome && (!$noDebt || !$permanentJob)) {
            // TIER 2: High income but missing other requirements
            $status      = '⚠ PERLU PENINJAUAN';
            $color       = 'text-[#CA8A04]';
            $description = 'Penghasilan memadai namun ada kondisi yang perlu ditinjau lebih lanjut.';
            
        } else {
            // TIER 3: Low income (immediate rejection)
            $status      = '✗ PENGAJUAN DITOLAK';
            $color       = 'text-[#DC2626]';
            $description = 'Penghasilan tidak memenuhi persyaratan minimum.';
        }

        Session::put('status',        $status);
        Session::put('color',         $color);
        Session::put('description',   $description);
        Session::put('breakdown',     $breakdown);
        return Redirect::back();
    }

    public function reset()
    {
        Session::forget(['status', 'color', 'description', 'breakdown', 'logic_formula']);

        return Redirect::to('/');
    }
}