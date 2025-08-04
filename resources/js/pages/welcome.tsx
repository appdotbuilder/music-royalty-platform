import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface Props {
    stats?: {
        total_labels: number;
        total_artists: number;
        total_works: number;
        total_streams: number;
    };
    [key: string]: unknown;
}

export default function Welcome({ stats }: Props) {
    const { auth } = usePage<SharedData>().props;

    const formatNumber = (num: number) => {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        }
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    };

    return (
        <>
            <Head title="MusicFlow - Multi-Tenant Music Aggregation Platform">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col bg-gradient-to-br from-purple-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900">
                {/* Header */}
                <header className="w-full px-4 py-6 sm:px-6 lg:px-8">
                    <nav className="mx-auto flex max-w-7xl items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="h-8 w-8 rounded-lg bg-gradient-to-r from-purple-600 to-blue-600 flex items-center justify-center">
                                <span className="text-white font-bold text-lg">🎵</span>
                            </div>
                            <span className="text-xl font-bold text-gray-900 dark:text-white">MusicFlow</span>
                        </div>
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white hover:bg-purple-700 transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white hover:bg-purple-700 transition-colors"
                                    >
                                        Get Started
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="flex-1 px-4 sm:px-6 lg:px-8">
                    <div className="mx-auto max-w-7xl">
                        <div className="text-center py-16 sm:py-20">
                            <div className="mb-8">
                                <h1 className="text-4xl sm:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                                    🎼 Multi-Tenant Music{' '}
                                    <span className="bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                                        Aggregation Platform
                                    </span>
                                </h1>
                                <p className="text-xl sm:text-2xl text-gray-600 dark:text-gray-300 max-w-4xl mx-auto">
                                    Distribute your music across all major streaming platforms, manage royalty splits, 
                                    and track your earnings with complete transparency.
                                </p>
                            </div>

                            {/* Platform Stats */}
                            {stats && (
                                <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 max-w-4xl mx-auto">
                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                        <div className="text-3xl font-bold text-purple-600 mb-2">
                                            {formatNumber(stats.total_labels)}
                                        </div>
                                        <div className="text-sm text-gray-600 dark:text-gray-400">Music Labels</div>
                                    </div>
                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                        <div className="text-3xl font-bold text-blue-600 mb-2">
                                            {formatNumber(stats.total_artists)}
                                        </div>
                                        <div className="text-sm text-gray-600 dark:text-gray-400">Active Artists</div>
                                    </div>
                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                        <div className="text-3xl font-bold text-green-600 mb-2">
                                            {formatNumber(stats.total_works)}
                                        </div>
                                        <div className="text-sm text-gray-600 dark:text-gray-400">Songs Distributed</div>
                                    </div>
                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                                        <div className="text-3xl font-bold text-red-600 mb-2">
                                            {formatNumber(stats.total_streams)}
                                        </div>
                                        <div className="text-sm text-gray-600 dark:text-gray-400">Total Streams</div>
                                    </div>
                                </div>
                            )}

                            {/* Key Features */}
                            <div className="grid md:grid-cols-3 gap-8 mb-12 max-w-6xl mx-auto">
                                <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                                    <div className="text-4xl mb-4">🎯</div>
                                    <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                        Multi-Platform Distribution
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Distribute your music to Spotify, Apple Music, YouTube Music, and 50+ other platforms with one click.
                                    </p>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                                    <div className="text-4xl mb-4">💰</div>
                                    <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                        Automatic Royalty Splits
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Fair and transparent payment distribution to artists, writers, producers, and collaborators.
                                    </p>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                                    <div className="text-4xl mb-4">📊</div>
                                    <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                        Advanced Analytics
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300">
                                        Track streaming performance, revenue analytics, and audience insights across all platforms.
                                    </p>
                                </div>
                            </div>

                            {/* User Roles */}
                            <div className="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-12">
                                <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                                    Built for Every Role in Music
                                </h2>
                                <div className="grid md:grid-cols-3 gap-6">
                                    <div className="text-center">
                                        <div className="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <span className="text-2xl">🏢</span>
                                        </div>
                                        <h3 className="font-bold text-gray-900 dark:text-white mb-2">Label Admins</h3>
                                        <p className="text-sm text-gray-600 dark:text-gray-300">
                                            Manage artists, catalog, distribution, and royalty tracking
                                        </p>
                                    </div>
                                    <div className="text-center">
                                        <div className="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <span className="text-2xl">🎤</span>
                                        </div>
                                        <h3 className="font-bold text-gray-900 dark:text-white mb-2">Artists</h3>
                                        <p className="text-sm text-gray-600 dark:text-gray-300">
                                            Track earnings, view analytics, and manage your music career
                                        </p>
                                    </div>
                                    <div className="text-center">
                                        <div className="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <span className="text-2xl">⚙️</span>
                                        </div>
                                        <h3 className="font-bold text-gray-900 dark:text-white mb-2">Super Admins</h3>
                                        <p className="text-sm text-gray-600 dark:text-gray-300">
                                            Platform management, tenant oversight, and global analytics
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* CTA Section */}
                            {!auth.user && (
                                <div className="text-center">
                                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                        Ready to Transform Your Music Business?
                                    </h2>
                                    <p className="text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                                        Join thousands of labels and artists already using MusicFlow to distribute their music 
                                        and maximize their revenue streams.
                                    </p>
                                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                        <Link
                                            href={route('register')}
                                            className="inline-flex items-center justify-center rounded-lg bg-purple-600 px-8 py-3 text-base font-medium text-white hover:bg-purple-700 transition-colors"
                                        >
                                            🚀 Start Free Trial
                                        </Link>
                                        <Link
                                            href={route('login')}
                                            className="inline-flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-8 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                        >
                                            💿 View Demo
                                        </Link>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="px-4 py-8 sm:px-6 lg:px-8">
                    <div className="mx-auto max-w-7xl text-center">
                        <p className="text-sm text-gray-500 dark:text-gray-400">
                            Built with ❤️ by{" "}
                            <a 
                                href="https://app.build" 
                                target="_blank" 
                                className="font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300"
                            >
                                app.build
                            </a>
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}