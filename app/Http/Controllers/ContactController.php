<?php

namespace App\Http\Controllers;

use App\Models\ContactLead;
use App\Models\Service;
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
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
            'service' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $serviceId = $data['service_id'] ?? null;
        $serviceName = null;

        if ($serviceId) {
            $serviceName = Service::find($serviceId)?->title;
        } elseif (!empty($data['service'])) {
            $matchedService = Service::where('title', $data['service'])->first();
            if ($matchedService) {
                $serviceId = $matchedService->id;
                $serviceName = $matchedService->title;
            } else {
                $serviceName = $data['service'];
            }
        }

        $leadMessage = $data['message'];
        if ($serviceName) {
            $leadMessage = "[Jenis Layanan: {$serviceName}]\n\n" . $data['message'];
        }

        // Simpan lead terlebih dahulu dengan relasi service_id
        ContactLead::create([
            'name' => $data['name'],
            'company' => $data['company'] ?? null,
            'service_id' => $serviceId,
            'message' => $leadMessage,
        ]);

        // Nomor WhatsApp dari settings (key: whatsapp), hanya digit, format 62xxxx
        $number = preg_replace('/\D/', '', (string) Setting::where('key', 'whatsapp')->value('value'));
        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        if ($number === '') {
            $number = '6281288992026';
        }

        $text = "Halo PT Hariq Sakti Konstruksindo, saya {$data['name']}"
            .($data['company'] ? " dari {$data['company']}" : '')
            .($serviceName ? "\n*Jenis Layanan:* {$serviceName}" : '')
            .".\n\n*Pesan / Kebutuhan Proyek:*\n{$data['message']}";

        // Inertia::location memaksa redirect penuh ke domain eksternal (wa.me)
        return Inertia::location('https://wa.me/'.$number.'?text='.rawurlencode($text));
    }
}
