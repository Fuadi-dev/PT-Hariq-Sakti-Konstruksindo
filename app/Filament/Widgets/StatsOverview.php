<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Visitor;
use App\Models\Post;
use App\Models\Project;
use App\Models\ContactLead;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengunjung', Visitor::count())
                ->description('Seluruh pengunjung website')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            
            Stat::make('Total Artikel', Post::count())
                ->description('Artikel & Berita dipublikasi')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            
            Stat::make('Total Portofolio', Project::count())
                ->description('Proyek yang telah selesai')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('info'),
                
            Stat::make('Pesan Belum Dibaca', ContactLead::where('is_followed_up', false)->count())
                ->description('Pesan dari form kontak')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('danger'),
        ];
    }
}
