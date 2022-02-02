<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroIcons extends Model
{
    use HasFactory;

    public static function UsersIcon(String ...$classes) {
        return view('components.heroicons.users-icon');
    }

    public static function BellIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>';
    }

    public static function MailIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>';
    }

    public static function CollectionIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>';
    }

    public static function InformationCircleIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>';
    }

    public static function AcademicCapIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>';
    }

    public static function OfficeBuildingIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>';
    }

    public static function DotsHorizontalIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
            </svg>';
    }

    public static function MenuAlt2Icon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>';
    }

    public static function XIcon(String ...$classes) {
        return
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ' . implode(' ', $classes) . '" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>';
    }
}
