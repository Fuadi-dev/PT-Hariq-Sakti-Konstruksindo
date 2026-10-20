<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Service::query()->latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $services = $query->paginate(9)->withQueryString()->through(fn ($s) => [
            'id' => $s->id,
            'title' => $s->title,
            'slug' => $s->slug,
            'description' => $s->description,
            'image' => $s->icon_or_image ? $this->url($s->icon_or_image) : null,
        ]);

        $companySettings = Setting::pluck('value', 'key');

        return Inertia::render('Service/Index', [
            'company_settings' => $companySettings,
            'services' => $services,
            'filters' => $request->only(['q']),
        ]);
    }

    private function url(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
    }
}
