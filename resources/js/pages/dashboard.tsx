import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

interface Tenant {
    id: number;
    name: string;
    description?: string;
    logo_url?: string;
}

interface Artist {
    id: number;
    stage_name: string;
    real_name?: string;
    genres?: string[];
    works_count?: number;
}

interface Work {
    id: number;
    title: string;
    status: string;
    album_name?: string;
    artist?: Artist;
}

interface Stats {
    total_tenants?: number;
    active_tenants?: number;
    total_users?: number;
    total_artists?: number;
    total_works?: number;
    distributed_works?: number;
    pending_works?: number;
    total_streams?: number;
    total_revenue?: number;
    monthly_revenue?: number;
}

interface RecentTenant {
    id: number;
    name: string;
    created_at: string;
    subscription?: {
        plan: string;
    };
}

interface RevenuePlatform {
    platform: string;
    revenue: number;
}

interface EarningByWork {
    work?: Work;
    total_revenue: number;
}

interface Props {
    user_role?: string;
    tenant?: Tenant;
    artist?: Artist;
    stats?: Stats;
    recent_tenants?: RecentTenant[];
    recent_works?: Work[];
    top_artists?: Artist[];
    earnings_by_work?: EarningByWork[];
    revenue_by_platform?: RevenuePlatform[];
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ 
    user_role,
    tenant,
    artist,
    stats,
    recent_tenants,
    recent_works,
    top_artists,
    earnings_by_work,
    revenue_by_platform 
}: Props) {
    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        }).format(amount);
    };

    const formatNumber = (num: number) => {
        return new Intl.NumberFormat('en-US').format(num);
    };

    const renderSuperAdminDashboard = () => (
        <div className="space-y-6">
            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <span className="text-xl">🏢</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tenants</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats?.total_tenants || 0}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <span className="text-xl">✅</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Active Tenants</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats?.active_tenants || 0}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <span className="text-xl">👥</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats?.total_users || 0}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <span className="text-xl">💰</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{formatCurrency(stats?.total_revenue || 0)}</p>
                        </div>
                    </div>
                </div>
            </div>

            {/* Recent Tenants & Revenue Charts */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Tenants</h3>
                    <div className="space-y-3">
                        {recent_tenants?.slice(0, 5).map((tenant, index) => (
                            <div key={index} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p className="font-medium text-gray-900 dark:text-white">{tenant.name}</p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">{tenant.subscription?.plan || 'Free'}</p>
                                </div>
                                <div className="text-sm text-gray-500 dark:text-gray-400">
                                    {new Date(tenant.created_at).toLocaleDateString()}
                                </div>
                            </div>
                        )) || <p className="text-gray-500 dark:text-gray-400">No tenants found</p>}
                    </div>
                </div>

                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Revenue by Platform</h3>
                    <div className="space-y-3">
                        {revenue_by_platform?.slice(0, 5).map((platform, index) => (
                            <div key={index} className="flex items-center justify-between">
                                <div className="flex items-center">
                                    <div className="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                                    <span className="text-gray-900 dark:text-white">{platform.platform}</span>
                                </div>
                                <span className="font-medium text-gray-900 dark:text-white">
                                    {formatCurrency(platform.revenue)}
                                </span>
                            </div>
                        )) || <p className="text-gray-500 dark:text-gray-400">No revenue data found</p>}
                    </div>
                </div>
            </div>
        </div>
    );

    const renderLabelAdminDashboard = () => (
        <div className="space-y-6">
            {/* Label Info */}
            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div className="flex items-center space-x-4">
                    <div className="w-16 h-16 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center">
                        <span className="text-white font-bold text-xl">🎵</span>
                    </div>
                    <div>
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white">{tenant?.name}</h2>
                        <p className="text-gray-600 dark:text-gray-400">{tenant?.description}</p>
                    </div>
                </div>
            </div>

            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <span className="text-xl">🎤</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Artists</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats?.total_artists || 0}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <span className="text-xl">🎵</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Works</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats?.total_works || 0}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <span className="text-xl">💰</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{formatCurrency(stats?.total_revenue || 0)}</p>
                        </div>
                    </div>
                </div>
            </div>

            {/* Recent Works & Top Artists */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Works</h3>
                    <div className="space-y-3">
                        {recent_works?.slice(0, 5).map((work, index) => (
                            <div key={index} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p className="font-medium text-gray-900 dark:text-white">{work.title}</p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">{work.artist?.stage_name}</p>
                                </div>
                                <div className="text-right">
                                    <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                                        work.status === 'distributed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                        work.status === 'pending_review' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                                    }`}>
                                        {work.status}
                                    </span>
                                </div>
                            </div>
                        )) || <p className="text-gray-500 dark:text-gray-400">No works found</p>}
                    </div>
                </div>

                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Artists</h3>
                    <div className="space-y-3">
                        {top_artists?.slice(0, 5).map((artist, index) => (
                            <div key={index} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div className="flex items-center">
                                    <div className="w-10 h-10 bg-gradient-to-r from-purple-400 to-blue-400 rounded-full flex items-center justify-center mr-3">
                                        <span className="text-white font-medium text-sm">{artist.stage_name?.[0]}</span>
                                    </div>
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">{artist.stage_name}</p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">{artist.works_count} works</p>
                                    </div>
                                </div>
                            </div>
                        )) || <p className="text-gray-500 dark:text-gray-400">No artists found</p>}
                    </div>
                </div>
            </div>
        </div>
    );

    const renderArtistDashboard = () => (
        <div className="space-y-6">
            {/* Artist Info */}
            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div className="flex items-center space-x-4">
                    <div className="w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                        <span className="text-white font-bold text-xl">{artist?.stage_name?.[0] || '🎤'}</span>
                    </div>
                    <div>
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white">{artist?.stage_name}</h2>
                        <p className="text-gray-600 dark:text-gray-400">{artist?.real_name}</p>
                        {artist?.genres && (
                            <div className="flex flex-wrap gap-1 mt-2">
                                {artist.genres.slice(0, 3).map((genre: string, index: number) => (
                                    <span key={index} className="px-2 py-1 text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full">
                                        {genre}
                                    </span>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <span className="text-xl">🎵</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Works</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats?.total_works || 0}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <span className="text-xl">📊</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Streams</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{formatNumber(stats?.total_streams || 0)}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <span className="text-xl">💰</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{formatCurrency(stats?.total_revenue || 0)}</p>
                        </div>
                    </div>
                </div>
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div className="flex items-center">
                        <div className="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <span className="text-xl">📈</span>
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Revenue</p>
                            <p className="text-2xl font-bold text-gray-900 dark:text-white">{formatCurrency(stats?.monthly_revenue || 0)}</p>
                        </div>
                    </div>
                </div>
            </div>

            {/* Recent Works & Top Earning Works */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Works</h3>
                    <div className="space-y-3">
                        {recent_works?.slice(0, 5).map((work, index) => (
                            <div key={index} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p className="font-medium text-gray-900 dark:text-white">{work.title}</p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">{work.album_name || 'Single'}</p>
                                </div>
                                <div className="text-right">
                                    <span className={`inline-flex px-2 py-1 text-xs font-medium rounded-full ${
                                        work.status === 'distributed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                        work.status === 'pending_review' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                                    }`}>
                                        {work.status}
                                    </span>
                                </div>
                            </div>
                        )) || <p className="text-gray-500 dark:text-gray-400">No works found</p>}
                    </div>
                </div>

                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Earning Works</h3>
                    <div className="space-y-3">
                        {earnings_by_work?.slice(0, 5).map((earning, index) => (
                            <div key={index} className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <p className="font-medium text-gray-900 dark:text-white">{earning.work?.title}</p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">Total Earnings</p>
                                </div>
                                <div className="text-right font-medium text-gray-900 dark:text-white">
                                    {formatCurrency(earning.total_revenue)}
                                </div>
                            </div>
                        )) || <p className="text-gray-500 dark:text-gray-400">No earnings data found</p>}
                    </div>
                </div>
            </div>
        </div>
    );

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            {user_role === 'super_admin' && '🔧 Super Admin Dashboard'}
                            {user_role === 'label_admin' && '🏢 Label Dashboard'}
                            {user_role === 'artist' && '🎤 Artist Dashboard'}
                            {!user_role && '📊 Dashboard'}
                        </h1>
                        <p className="mt-2 text-gray-600 dark:text-gray-400">
                            {user_role === 'super_admin' && 'Manage all tenants, users, and platform-wide analytics'}
                            {user_role === 'label_admin' && 'Manage your artists, catalog, and distribution'}
                            {user_role === 'artist' && 'Track your music performance and earnings'}
                            {!user_role && 'Welcome to your dashboard'}
                        </p>
                    </div>

                    {user_role === 'super_admin' && renderSuperAdminDashboard()}
                    {user_role === 'label_admin' && renderLabelAdminDashboard()}
                    {user_role === 'artist' && renderArtistDashboard()}
                    {!user_role && (
                        <div className="text-center py-12">
                            <p className="text-gray-500 dark:text-gray-400">Please log in to view your dashboard.</p>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}