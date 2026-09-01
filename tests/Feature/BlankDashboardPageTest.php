<?php

use App\Filament\Pages\BlankDashboard;
use Filament\Pages\Page;

test('blank dashboard page is defined and registered as a page', function () {
    expect(class_exists(BlankDashboard::class))->toBeTrue()
        ->and(is_subclass_of(BlankDashboard::class, Page::class))->toBeTrue();
});
