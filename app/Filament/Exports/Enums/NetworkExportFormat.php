<?php

namespace App\Filament\Exports\Enums;

use Filament\Actions\Action;
use Filament\Actions\Exports\Downloaders\Contracts\Downloader;
use Filament\Actions\Exports\Downloaders\XlsxDownloader;
use Filament\Actions\Exports\Enums\Contracts\ExportFormat as ExportFormatContract;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\URL;

enum NetworkExportFormat: string implements ExportFormatContract
{
    case Xlsx = 'xlsx';

    public function getDownloader(): Downloader
    {
        return app(XlsxDownloader::class);
    }

    public function getDownloadNotificationAction(Export $export, string $authGuard): Action
    {
        $downloadUrl = URL::signedRoute('filament.exports.download', [
            'authGuard' => $authGuard,
            'export' => $export,
            'format' => $this,
        ], absolute: false);
        $appPath = parse_url((string) config('app.url'), PHP_URL_PATH) ?: '';
        $downloadUrl = '/'.trim($appPath.'/'.ltrim($downloadUrl, '/'), '/');

        return Action::make("download_{$this->value}")
            ->label(__("filament-actions::export.notifications.completed.actions.download_{$this->value}.label"))
            ->url($downloadUrl, shouldOpenInNewTab: true)
            ->markAsRead();
    }
}
