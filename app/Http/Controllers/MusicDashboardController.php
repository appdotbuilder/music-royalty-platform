<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\RoyaltyReport;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkEarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MusicDashboardController extends Controller
{
    /**
     * Display the music platform dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            // Show platform overview for non-authenticated users
            $stats = [
                'total_labels' => Tenant::where('status', 'active')->count(),
                'total_artists' => Artist::where('status', 'active')->count(),
                'total_works' => Work::where('status', 'distributed')->count(),
                'total_streams' => WorkEarning::sum('streams'),
            ];

            return Inertia::render('welcome', [
                'stats' => $stats,
            ]);
        }

        // Route authenticated users to their appropriate dashboard
        if ($user->role === 'super_admin') {
            return $this->show($user);
        }
        
        if ($user->role === 'label_admin') {
            return $this->create($user);
        }
        
        if ($user->role === 'artist') {
            return $this->store($user);
        }
        
        return Inertia::render('dashboard');
    }

    /**
     * Show super admin dashboard.
     */
    public function show($user)
    {
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('status', 'active')->count(),
            'total_users' => User::count(),
            'total_artists' => Artist::count(),
            'total_works' => Work::count(),
            'total_revenue' => RoyaltyReport::sum('total_revenue'),
            'monthly_revenue' => RoyaltyReport::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_revenue'),
        ];

        $recent_tenants = Tenant::with('subscription')
            ->latest()
            ->limit(5)
            ->get();

        $revenue_by_platform = RoyaltyReport::select('platform', DB::raw('SUM(total_revenue) as revenue'))
            ->groupBy('platform')
            ->orderByDesc('revenue')
            ->get();

        return Inertia::render('dashboard', [
            'user_role' => 'super_admin',
            'stats' => $stats,
            'recent_tenants' => $recent_tenants,
            'revenue_by_platform' => $revenue_by_platform,
        ]);
    }

    /**
     * Show label admin dashboard.
     */
    public function create($user)
    {
        $tenant = $user->tenant;
        
        if (!$tenant) {
            return redirect()->route('dashboard')->with('error', 'No label assigned to your account.');
        }

        $stats = [
            'total_artists' => $tenant->artists()->where('status', 'active')->count(),
            'total_works' => $tenant->works()->count(),
            'distributed_works' => $tenant->works()->where('status', 'distributed')->count(),
            'pending_works' => $tenant->works()->whereIn('status', ['draft', 'pending_review'])->count(),
            'total_revenue' => $tenant->royaltyReports()->sum('total_revenue'),
            'monthly_revenue' => $tenant->royaltyReports()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_revenue'),
        ];

        $recent_works = $tenant->works()
            ->with('artist')
            ->latest()
            ->limit(5)
            ->get();

        $top_artists = $tenant->artists()
            ->withCount('works')
            ->orderByDesc('works_count')
            ->limit(5)
            ->get()
            ->filter(function($artist) {
                return $artist->works_count > 0;
            });

        return Inertia::render('dashboard', [
            'user_role' => 'label_admin',
            'tenant' => $tenant,
            'stats' => $stats,
            'recent_works' => $recent_works,
            'top_artists' => $top_artists,
        ]);
    }

    /**
     * Show artist dashboard.
     */
    public function store($user)
    {
        $artist = $user->artist;
        
        if (!$artist) {
            return redirect()->route('dashboard')->with('error', 'Artist profile not found.');
        }

        $stats = [
            'total_works' => $artist->works()->count(),
            'distributed_works' => $artist->works()->where('status', 'distributed')->count(),
            'pending_works' => $artist->works()->whereIn('status', ['draft', 'pending_review'])->count(),
            'total_streams' => WorkEarning::whereIn('work_id', $artist->works()->pluck('id'))->sum('streams'),
            'total_revenue' => WorkEarning::whereIn('work_id', $artist->works()->pluck('id'))->sum('revenue'),
            'monthly_revenue' => WorkEarning::whereIn('work_id', $artist->works()->pluck('id'))
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('revenue'),
        ];

        $recent_works = $artist->works()
            ->latest()
            ->limit(5)
            ->get();

        $earnings_by_work = WorkEarning::select('work_id', DB::raw('SUM(revenue) as total_revenue'))
            ->whereIn('work_id', $artist->works()->pluck('id'))
            ->groupBy('work_id')
            ->with('work')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return Inertia::render('dashboard', [
            'user_role' => 'artist',
            'artist' => $artist,
            'stats' => $stats,
            'recent_works' => $recent_works,
            'earnings_by_work' => $earnings_by_work,
        ]);
    }
}