<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Invitation;
use App\Models\RoyaltyReport;
use App\Models\RoyaltySplit;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkEarning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MusicPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@musicplatform.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'super_admin',
            'tenant_id' => null,
            'phone' => '+1-555-0001',
            'avatar_url' => 'https://ui-avatars.com/api/?name=Super+Admin&background=9333ea&color=fff',
            'preferences' => [
                'theme' => 'dark',
                'notifications' => true,
                'email_updates' => true,
            ],
            'last_active_at' => now(),
        ]);

        // Create Tenant 1: SoundWave Records (Pro Plan)
        $soundwaveTenant = Tenant::create([
            'name' => 'SoundWave Records',
            'slug' => 'soundwave-records',
            'domain' => 'soundwaverecords.com',
            'description' => 'Premier music label specializing in electronic and pop music',
            'logo_url' => 'https://ui-avatars.com/api/?name=SoundWave+Records&background=3b82f6&color=fff',
            'website' => 'https://soundwaverecords.com',
            'status' => 'active',
            'settings' => [
                'timezone' => 'America/New_York',
                'currency' => 'USD',
                'features' => ['analytics', 'distribution', 'royalties', 'white_label'],
            ],
        ]);

        // Create Subscription for SoundWave Records (Pro Plan)
        Subscription::create([
            'tenant_id' => $soundwaveTenant->id,
            'plan' => 'pro',
            'status' => 'active',
            'price' => 99.99,
            'billing_cycle' => 'monthly',
            'current_period_start' => now()->subMonth(),
            'current_period_end' => now()->addMonth(),
            'features' => ['premium_distribution', 'advanced_analytics', 'royalty_splits', 'unlimited_artists', 'white_label'],
        ]);

        // Create Label Admin for SoundWave Records
        $soundwaveAdmin = User::create([
            'name' => 'Sarah Wilson',
            'email' => 'admin@soundwaverecords.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'label_admin',
            'tenant_id' => $soundwaveTenant->id,
            'phone' => '+1-555-0002',
            'avatar_url' => 'https://ui-avatars.com/api/?name=Sarah+Wilson&background=3b82f6&color=fff',
            'preferences' => [
                'theme' => 'light',
                'notifications' => true,
                'email_updates' => true,
            ],
            'last_active_at' => now()->subHours(2),
        ]);

        // Create Tenant 2: Urban Beats Label (Standard Plan)
        $urbanBeatsTenant = Tenant::create([
            'name' => 'Urban Beats Label',
            'slug' => 'urban-beats-label',
            'domain' => 'urbanbeats.com',
            'description' => 'Hip-hop and R&B music label focused on emerging artists',
            'logo_url' => 'https://ui-avatars.com/api/?name=Urban+Beats&background=ef4444&color=fff',
            'website' => 'https://urbanbeats.com',
            'status' => 'active',
            'settings' => [
                'timezone' => 'America/Los_Angeles',
                'currency' => 'USD',
                'features' => ['analytics', 'distribution', 'royalties'],
            ],
        ]);

        // Create Subscription for Urban Beats Label (Standard Plan)
        Subscription::create([
            'tenant_id' => $urbanBeatsTenant->id,
            'plan' => 'standard',
            'status' => 'active',
            'price' => 29.99,
            'billing_cycle' => 'monthly',
            'current_period_start' => now()->subMonth(),
            'current_period_end' => now()->addMonth(),
            'features' => ['basic_distribution', 'advanced_analytics', 'royalty_splits', '10_artists'],
        ]);

        // Create Label Admin for Urban Beats Label
        $urbanBeatsAdmin = User::create([
            'name' => 'Marcus Johnson',
            'email' => 'admin@urbanbeats.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'label_admin',
            'tenant_id' => $urbanBeatsTenant->id,
            'phone' => '+1-555-0003',
            'avatar_url' => 'https://ui-avatars.com/api/?name=Marcus+Johnson&background=ef4444&color=fff',
            'preferences' => [
                'theme' => 'dark',
                'notifications' => true,
                'email_updates' => false,
            ],
            'last_active_at' => now()->subHours(5),
        ]);

        // Artist data for SoundWave Records
        $soundwaveArtists = [
            ['stage_name' => 'Alex Rivers', 'email' => 'alex.rivers@email.com', 'genres' => ['Electronic', 'Pop']],
            ['stage_name' => 'Maya Sound', 'email' => 'maya.sound@email.com', 'genres' => ['Pop', 'R&B']],
            ['stage_name' => 'Echo Beats', 'email' => 'echo.beats@email.com', 'genres' => ['Electronic', 'Ambient']],
            ['stage_name' => 'Luna Waves', 'email' => 'luna.waves@email.com', 'genres' => ['Pop', 'Electronic']],
            ['stage_name' => 'Neon Dreams', 'email' => 'neon.dreams@email.com', 'genres' => ['Electronic', 'Synthwave']],
        ];

        // Artist data for Urban Beats Label
        $urbanBeatsArtists = [
            ['stage_name' => 'MC Rhythm', 'email' => 'mc.rhythm@email.com', 'genres' => ['Hip Hop', 'Rap']],
            ['stage_name' => 'Velvet Voice', 'email' => 'velvet.voice@email.com', 'genres' => ['R&B', 'Soul']],
            ['stage_name' => 'Street Poet', 'email' => 'street.poet@email.com', 'genres' => ['Hip Hop', 'Conscious Rap']],
            ['stage_name' => 'Smooth Grooves', 'email' => 'smooth.grooves@email.com', 'genres' => ['R&B', 'Neo-Soul']],
            ['stage_name' => 'Bass Thunder', 'email' => 'bass.thunder@email.com', 'genres' => ['Hip Hop', 'Trap']],
        ];

        // Create artists and their works for SoundWave Records
        foreach ($soundwaveArtists as $artistData) {
            $user = User::create([
                'name' => $artistData['stage_name'],
                'email' => $artistData['email'],
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'artist',
                'tenant_id' => $soundwaveTenant->id,
                'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($artistData['stage_name']) . '&background=3b82f6&color=fff',
                'preferences' => [
                    'theme' => 'light',
                    'notifications' => true,
                    'email_updates' => true,
                ],
                'last_active_at' => now()->subDays(random_int(1, 7)),
            ]);

            $artist = Artist::create([
                'tenant_id' => $soundwaveTenant->id,
                'user_id' => $user->id,
                'stage_name' => $artistData['stage_name'],
                'real_name' => fake()->name(),
                'bio' => fake()->paragraph(2),
                'genres' => $artistData['genres'],
                'country' => 'US',
                'avatar_url' => $user->avatar_url,
                'social_links' => [
                    'instagram' => 'https://instagram.com/' . strtolower(str_replace(' ', '', $artistData['stage_name'])),
                    'twitter' => 'https://twitter.com/' . strtolower(str_replace(' ', '', $artistData['stage_name'])),
                    'spotify' => 'https://open.spotify.com/artist/' . fake()->regexify('[a-zA-Z0-9]{22}'),
                ],
                'status' => 'active',
                'contract_signed_at' => now()->subMonths(random_int(3, 12)),
            ]);

            // Create 3 works for each artist
            for ($i = 1; $i <= 3; $i++) {
                $work = Work::create([
                    'tenant_id' => $soundwaveTenant->id,
                    'artist_id' => $artist->id,
                    'title' => fake()->words(random_int(1, 3), true),
                    'isrc' => 'US' . fake()->numerify('SW##') . fake()->numerify('######'),
                    'upc' => fake()->numerify('############'),
                    'genres' => $artistData['genres'],
                    'language' => 'en',
                    'duration_seconds' => random_int(180, 300),
                    'release_date' => now()->subMonths(random_int(1, 24)),
                    'album_name' => $i === 1 ? fake()->words(2, true) : null,
                    'cover_art_url' => 'https://picsum.photos/600/600?random=' . random_int(1, 1000),
                    'metadata' => [
                        'producer' => fake()->name(),
                        'songwriter' => $artistData['stage_name'],
                        'label' => 'SoundWave Records',
                        'copyright' => '℗ ' . now()->year . ' SoundWave Records',
                    ],
                    'status' => 'distributed',
                    'distribution_platforms' => ['Spotify', 'Apple Music', 'YouTube Music', 'Amazon Music', 'Tidal'],
                    'distributed_at' => now()->subMonths(random_int(1, 12)),
                ]);

                // Create royalty splits for the work
                RoyaltySplit::create([
                    'work_id' => $work->id,
                    'user_id' => $user->id,
                    'role' => 'artist',
                    'percentage' => 60.00,
                    'split_type' => 'master',
                    'status' => 'active',
                ]);

                RoyaltySplit::create([
                    'work_id' => $work->id,
                    'user_id' => $soundwaveAdmin->id,
                    'role' => 'label',
                    'percentage' => 40.00,
                    'split_type' => 'master',
                    'status' => 'active',
                ]);
            }
        }

        // Create artists and their works for Urban Beats Label
        foreach ($urbanBeatsArtists as $artistData) {
            $user = User::create([
                'name' => $artistData['stage_name'],
                'email' => $artistData['email'],
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'artist',
                'tenant_id' => $urbanBeatsTenant->id,
                'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($artistData['stage_name']) . '&background=ef4444&color=fff',
                'preferences' => [
                    'theme' => 'dark',
                    'notifications' => true,
                    'email_updates' => true,
                ],
                'last_active_at' => now()->subDays(random_int(1, 10)),
            ]);

            $artist = Artist::create([
                'tenant_id' => $urbanBeatsTenant->id,
                'user_id' => $user->id,
                'stage_name' => $artistData['stage_name'],
                'real_name' => fake()->name(),
                'bio' => fake()->paragraph(2),
                'genres' => $artistData['genres'],
                'country' => 'US',
                'avatar_url' => $user->avatar_url,
                'social_links' => [
                    'instagram' => 'https://instagram.com/' . strtolower(str_replace(' ', '', $artistData['stage_name'])),
                    'twitter' => 'https://twitter.com/' . strtolower(str_replace(' ', '', $artistData['stage_name'])),
                    'spotify' => 'https://open.spotify.com/artist/' . fake()->regexify('[a-zA-Z0-9]{22}'),
                ],
                'status' => 'active',
                'contract_signed_at' => now()->subMonths(random_int(3, 12)),
            ]);

            // Create 3 works for each artist
            for ($i = 1; $i <= 3; $i++) {
                $work = Work::create([
                    'tenant_id' => $urbanBeatsTenant->id,
                    'artist_id' => $artist->id,
                    'title' => fake()->words(random_int(1, 3), true),
                    'isrc' => 'US' . fake()->numerify('UB##') . fake()->numerify('######'),
                    'upc' => fake()->numerify('############'),
                    'genres' => $artistData['genres'],
                    'language' => 'en',
                    'duration_seconds' => random_int(180, 360),
                    'release_date' => now()->subMonths(random_int(1, 24)),
                    'album_name' => $i === 1 ? fake()->words(2, true) : null,
                    'cover_art_url' => 'https://picsum.photos/600/600?random=' . random_int(1001, 2000),
                    'metadata' => [
                        'producer' => fake()->name(),
                        'songwriter' => $artistData['stage_name'],
                        'label' => 'Urban Beats Label',
                        'copyright' => '℗ ' . now()->year . ' Urban Beats Label',
                    ],
                    'status' => 'distributed',
                    'distribution_platforms' => ['Spotify', 'Apple Music', 'YouTube Music', 'Tidal', 'Deezer'],
                    'distributed_at' => now()->subMonths(random_int(1, 12)),
                ]);

                // Create royalty splits for the work
                RoyaltySplit::create([
                    'work_id' => $work->id,
                    'user_id' => $user->id,
                    'role' => 'artist',
                    'percentage' => 55.00,
                    'split_type' => 'master',
                    'status' => 'active',
                ]);

                RoyaltySplit::create([
                    'work_id' => $work->id,
                    'user_id' => $urbanBeatsAdmin->id,
                    'role' => 'label',
                    'percentage' => 45.00,
                    'split_type' => 'master',
                    'status' => 'active',
                ]);
            }
        }

        // Create royalty reports and earnings data
        $platforms = ['Spotify', 'Apple Music', 'YouTube Music', 'Amazon Music', 'Tidal'];
        $works = Work::all();

        foreach ([$soundwaveTenant, $urbanBeatsTenant] as $tenant) {
            foreach ($platforms as $platform) {
                // Create monthly reports for the last 6 months
                for ($month = 6; $month >= 1; $month--) {
                    $periodStart = now()->subMonths($month)->startOfMonth();
                    $periodEnd = now()->subMonths($month)->endOfMonth();
                    
                    $totalStreams = random_int(50000, 200000);
                    $ratePerStream = 0.004;
                    if ($platform === 'Apple Music') $ratePerStream = 0.007;
                    if ($platform === 'YouTube Music') $ratePerStream = 0.002;
                    if ($platform === 'Amazon Music') $ratePerStream = 0.005;
                    if ($platform === 'Tidal') $ratePerStream = 0.012;
                    
                    $report = RoyaltyReport::create([
                        'tenant_id' => $tenant->id,
                        'platform' => $platform,
                        'period_start' => $periodStart,
                        'period_end' => $periodEnd,
                        'total_streams' => $totalStreams,
                        'total_revenue' => $totalStreams * $ratePerStream,
                        'platform_data' => [
                            'territory' => 'WW',
                            'currency' => 'USD',
                            'report_id' => fake()->uuid(),
                            'generated_at' => $periodEnd->format('Y-m-d H:i:s'),
                        ],
                        'status' => 'processed',
                        'processed_at' => $periodEnd->addDays(5),
                    ]);

                    // Create work earnings for this report
                    $tenantWorks = $works->where('tenant_id', $tenant->id);
                    foreach ($tenantWorks as $work) {
                        $workStreams = random_int(1000, 15000);
                        WorkEarning::create([
                            'work_id' => $work->id,
                            'royalty_report_id' => $report->id,
                            'platform' => $platform,
                            'streams' => $workStreams,
                            'revenue' => $workStreams * $ratePerStream,
                            'rate_per_stream' => $ratePerStream,
                            'territory' => 'WW',
                            'period_start' => $periodStart,
                            'period_end' => $periodEnd,
                        ]);
                    }
                }
            }
        }

        // Create some pending invitations  
        $tenants = [$soundwaveTenant, $urbanBeatsTenant];
        foreach ($tenants as $tenant) {
            /** @var User|null $admin */
            $admin = $tenant->users()->where('role', 'label_admin')->first();
            if (!$admin) continue;
            
            for ($i = 1; $i <= 3; $i++) {
                Invitation::create([
                    'tenant_id' => $tenant->id,
                    'invited_by' => $admin->id,
                    'email' => fake()->unique()->safeEmail(),
                    'role' => 'artist',
                    'token' => \Str::random(32),
                    'status' => 'pending',
                    'metadata' => [
                        'invited_artist_name' => fake()->name(),
                        'message' => 'Welcome to ' . $tenant->name . '! We\'d love to have you join our roster.',
                    ],
                    'expires_at' => now()->addDays(14),
                ]);
            }
        }

        $this->command->info('Music platform seeded successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: admin@musicplatform.com / password123');
        $this->command->info('SoundWave Records Admin: admin@soundwaverecords.com / password123');
        $this->command->info('Urban Beats Admin: admin@urbanbeats.com / password123');
        $this->command->info('');
        $this->command->info('Sample Artists (all use password123):');
        foreach (array_merge($soundwaveArtists, $urbanBeatsArtists) as $artist) {
            $this->command->info($artist['stage_name'] . ': ' . $artist['email'] . ' / password123');
        }
    }
}