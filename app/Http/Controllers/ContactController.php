<?php

namespace App\Http\Controllers;

use App\Models\ContactLead;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Simpan lead terlebih dahulu
        ContactLead::create($data);

        // Nomor WhatsApp dari settings (key: whatsapp), hanya digit, format 62xxxx
        $number = preg_replace('/\D/', '', (string) Setting::where('key', 'whatsapp')->value('value'));
        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        if ($number === '') {
            return back()->with('success', 'Pesan Anda sudah kami terima.');
        }

        $text = "Halo, saya {$data['name']}"
            .($data['company'] ? " dari {$data['company']}" : '')
            .".\n\n{$data['message']}";

        // Inertia::location memaksa redirect penuh ke domain eksternal (wa.me)
        return Inertia::location('https://wa.me/'.$number.'?text='.rawurlencode($text));
    }
}
