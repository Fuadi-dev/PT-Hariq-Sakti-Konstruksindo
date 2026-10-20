<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mencatat kunjungan halaman publik ke tabel visitors.
 */
class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $this->track($request, $response);
        } catch (\Throwable $e) {
            report($e); // pelacakan tidak boleh merusak halaman
        }

        return $response;
    }

    private function track(Request $request, Response $response): void
    {
        if (! $request->isMethod('GET') || $response->getStatusCode() >= 400) {
            return;
        }

        // Lewati panel admin, livewire, dan request JSON non-Inertia
        if ($request->is('admin', 'admin/*', 'livewire/*', 'filament/*', 'up', 'storage/*')) {
            return;
        }
        if ($request->expectsJson() && ! $request->header('X-Inertia')) {
            return;
        }

        $userAgent = (string) $request->userAgent();
        if ($userAgent === '' || preg_match('/bot|crawl|spider|slurp|curl|wget|python|headless/i', $userAgent)) {
            return;
        }

        $sessionId = $request->hasSession() ? $request->session()->getId() : null;
        $url = '/' . ltrim($request->path(), '/');

        // Hindari duplikat: halaman yang sama oleh sesi yang sama dalam 30 menit
        $exists = Visitor::where('session_id', $sessionId)
            ->where('visited_url', $url)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->exists();

        if ($exists) {
            return;
        }

        Visitor::create([
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'session_id' => $sessionId,
            'visited_url' => $url,
        ]);
    }
}
