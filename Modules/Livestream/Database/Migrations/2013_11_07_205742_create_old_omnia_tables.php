<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOldOmniaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id');
            $table->text('body');
            $table->string('action_text')->nullable();
            $table->text('action_url')->nullable();
            $table->timestamps();
        });

        Schema::create('api_tokens', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id');
            $table->string('name');
            $table->string('token', 100)->unique();
            $table->text('metadata');
            $table->tinyInteger('transient')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'expires_at']);
        });

        Schema::create('bans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bannable_id');
            $table->string('bannable_type');
            $table->unsignedInteger('created_by_id')->nullable();
            $table->string('created_by_type')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('expired_at')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['bannable_id', 'bannable_type']);
            $table->index(['created_by_id', 'created_by_type']);
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');
        });

        Schema::create('cms_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('team_id')->index('cms_accounts_team_id_foreign');
        });

        Schema::create('cms_group_person', function (Blueprint $table) {
            $table->unsignedInteger('group_id')->index();
            $table->unsignedInteger('person_id')->index();
            $table->timestamps();
        });

        Schema::create('cms_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('cms_ministries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('leader_id');
            $table->timestamps();
        });

        Schema::create('discover_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('parent_id');
            $table->timestamps();
        });

        Schema::create('discover_event_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_number')->unique();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->unsignedInteger('event_id')->nullable()->index('discover_event_tickets_event_id_foreign');
        });

        Schema::create('discover_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->timestamp('date_time')->useCurrentOnUpdate()->useCurrent();
            $table->timestamps();
            $table->unsignedInteger('discover_team_id')->index('discover_events_discover_team_id_foreign');
        });

        Schema::create('discover_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('meeting_interval');
            $table->timestamp('meeting_date')->nullable();
            $table->integer('member_limit');
            $table->timestamps();
            $table->unsignedInteger('discover_team_id')->nullable()->index('discover_groups_discover_team_id_foreign');
        });

        Schema::create('discover_job_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('discover_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('description');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->decimal('pay_amount')->nullable();
            $table->decimal('pay_type')->nullable();
            $table->timestamps();
            $table->unsignedInteger('event_id')->nullable()->index('discover_jobs_event_id_foreign');
            $table->unsignedInteger('discover_team_id')->index('discover_jobs_discover_team_id_foreign');
            $table->timestamp('assigned_at')->nullable();
            $table->unsignedInteger('assigned_to')->nullable()->index('discover_jobs_assigned_to_foreign');
        });

        Schema::create('discover_jobs_departments', function (Blueprint $table) {
            $table->unsignedInteger('job_id')->index('discover_jobs_departments_job_id_foreign');
            $table->unsignedInteger('department_id')->index('discover_jobs_departments_department_id_foreign');
            $table->timestamps();
        });

        Schema::create('discover_jobs_job_requirements', function (Blueprint $table) {
            $table->unsignedInteger('job_id')->index('discover_jobs_job_requirements_job_id_foreign');
            $table->unsignedInteger('job_requirement_id')->index('discover_jobs_job_requirements_job_requirement_id_foreign');
            $table->timestamps();
        });

        Schema::create('discover_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('team_id')->index('discover_teams_team_id_foreign');
        });

        Schema::create('discover_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id')->index('discover_users_user_id_foreign');
            $table->unsignedInteger('discover_group_id')->nullable()->index('discover_users_discover_group_id_foreign');
        });

        Schema::create('episode_downloads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('livestream_account_id')->index();
            $table->string('status')->default('pending');
            $table->dateTime('expires_at');
            $table->text('failed_reason')->nullable();
            $table->text('download_path')->nullable();
            $table->timestamps();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_type')->nullable();
            $table->string('storage_source')->nullable();
            $table->string('file_name')->unique();
            $table->string('file_type');
            $table->string('file_path');
            $table->timestamps();
        });

        Schema::create('invitations', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('team_id')->index();
            $table->integer('user_id')->nullable()->index();
            $table->string('email');
            $table->string('token', 40)->unique();
            $table->timestamps();
            $table->string('role')->nullable();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->index();
            $table->integer('team_id')->nullable()->index();
            $table->string('provider_id');
            $table->decimal('total')->nullable();
            $table->decimal('tax')->nullable();
            $table->string('card_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('vat_id', 50)->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue');
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');

            $table->index(['queue', 'reserved_at']);
        });

        Schema::create('livestream_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admin_email');
            $table->string('name');
            $table->string('account_slug')->unique();
            $table->string('technical_email')->nullable();
            $table->string('s3_bucket')->nullable();
            $table->timestamps();
            $table->unsignedInteger('team_id')->index('livestream_accounts_team_id_foreign');
            $table->unsignedInteger('default_episode_template_id')->nullable()->index('livestream_accounts_default_episode_template_id_foreign');
            $table->string('cdn_playback_url')->nullable()->default('');
            $table->string('not_live_image')->nullable();
            $table->string('before_live_image')->nullable();
            $table->string('mux_livestream_active')->nullable();
            $table->string('mux_vod_active')->nullable();
            $table->string('mux_stream_targets_active')->nullable();
        });

        Schema::create('livestream_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('app_type');
            $table->string('timezone')->nullable();
            $table->string('app_slug')->unique();
            $table->timestamps();
            $table->unsignedInteger('livestream_account_id')->index('livestream_applications_livestream_account_id_foreign');
        });

        Schema::create('livestream_dashboard_account', function (Blueprint $table) {
            $table->unsignedInteger('livestream_dashboard_id')->index();
            $table->unsignedInteger('livestream_account_id')->index();
            $table->timestamps();
        });

        Schema::create('livestream_dashboards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('livestream_episode_current_recordings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stream_name');
            $table->timestamps();
            $table->unsignedInteger('episode_id')->index('livestream_episode_current_recordings_episode_id_foreign');
            $table->unsignedInteger('account_id')->index('livestream_episode_current_recordings_account_id_foreign');
        });

        Schema::create('livestream_episode_person', function (Blueprint $table) {
            $table->unsignedInteger('episode_id')->index('livestream_episode_person_episode_id_foreign');
            $table->unsignedInteger('person_id')->index('livestream_episode_person_person_id_foreign');
            $table->timestamps();
        });

        Schema::create('livestream_episode_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('template');
            $table->timestamps();
            $table->unsignedInteger('livestream_account_id')->index('livestream_episode_templates_livestream_account_id_foreign');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('default_thumbnail')->nullable();
        });

        Schema::create('livestream_episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_dateTime')->nullable();
            $table->timestamp('date_recorded')->nullable();
            $table->timestamps();
            $table->unsignedInteger('main_speaker_id')->nullable()->index('livestream_episodes_main_speaker_id_foreign');
            $table->unsignedInteger('livestream_account_id')->index('livestream_episodes_livestream_account_id_foreign');
            $table->unsignedInteger('thumbnail_image_id')->nullable()->index('livestream_episodes_thumbnail_image_id_foreign');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_published')->nullable()->default(true);
            $table->unsignedInteger('main_video_id')->nullable()->index('livestream_episodes_main_video_id_foreign');
            $table->timestamp('planned_start_time')->nullable();
            $table->string('mux_asset_id')->nullable();
            $table->string('max_resolution')->nullable();
            $table->unsignedInteger('default_playback_id')->nullable()->index('livestream_episodes_default_playback_id_foreign');
            $table->boolean('is_live_now')->nullable();
            $table->string('duration')->nullable();
            $table->softDeletes();
            $table->string('upload_id')->nullable();
        });

        Schema::create('livestream_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('timezone')->nullable();
            $table->string('event_slug');
            $table->char('recurring_f', 1)->default('N');
            $table->string('recurring_type')->nullable();
            $table->dateTime('recurring_dateTime')->nullable();
            $table->text('recurring_statement')->nullable();
            $table->timestamps();
            $table->unsignedInteger('livestream_app_id')->index('livestream_events_livestream_app_id_foreign');
        });

        Schema::create('livestream_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_name');
            $table->timestamps();
        });

        Schema::create('livestream_playback_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('playback_id');
            $table->string('policy');
            $table->string('playbackable_type')->nullable();
            $table->integer('playbackable_id')->nullable();
            $table->timestamps();
        });

        Schema::create('livestream_players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->unsignedInteger('livestream_account_id')->nullable()->index('livestream_players_livestream_account_id_foreign');
            $table->string('not_live_image')->nullable();
            $table->string('before_live_image')->nullable();
        });

        Schema::create('livestream_playlist_player', function (Blueprint $table) {
            $table->unsignedInteger('playlist_id')->index('livestream_playlist_player_playlist_id_foreign');
            $table->unsignedInteger('player_id')->index('livestream_playlist_player_player_id_foreign');
            $table->timestamps();
        });

        Schema::create('livestream_playlists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('type', ['dynamic', 'static']);
            $table->timestamps();
            $table->unsignedInteger('account_id')->nullable()->index('livestream_playlists_account_id_foreign');
        });

        Schema::create('livestream_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recurrence_type');
            $table->string('name')->nullable();
            $table->timestamps();
            $table->unsignedInteger('livestream_account_id')->index('livestream_schedules_livestream_account_id_foreign');
            $table->unsignedInteger('episode_template_id')->nullable()->index('livestream_schedules_episode_template_id_foreign');
        });

        Schema::create('livestream_stream_integrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enabled');
            $table->string('provider');
            $table->string('access_token');
            $table->mediumText('provider_team_object')->nullable();
            $table->timestamps();
            $table->unsignedInteger('livestream_account_id')->index('livestream_stream_integrations_livestream_account_id_foreign');
            $table->unsignedInteger('episode_template_id')->nullable()->index('livestream_stream_integrations_episode_template_id_foreign');
        });

        Schema::create('livestream_stream_targets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('idle');
            $table->boolean('enabled');
            $table->string('url');
            $table->string('stream_key')->nullable();
            $table->string('passthrough')->nullable();
            $table->string('status')->default('idle');
            $table->string('mux_simulcast_target_id')->nullable();
            $table->unsignedInteger('stream_id')->nullable()->index('livestream_stream_targets_stream_id_foreign');
            $table->unsignedInteger('stream_integration_id')->nullable()->index('livestream_stream_targets_stream_integration_id_foreign');
            $table->timestamps();
        });

        Schema::create('livestream_streams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->nullable();
            $table->string('stream_id')->nullable();
            $table->string('stream_key')->nullable();
            $table->string('rtmp_url')->nullable();
            $table->unsignedInteger('reconnect_window')->nullable();
            $table->string('status')->nullable();
            $table->unsignedInteger('active_episode_id')->nullable()->index('livestream_streams_active_episode_id_foreign');
            $table->unsignedInteger('livestream_account_id')->index('livestream_streams_livestream_account_id_foreign');
            $table->timestamps();
        });

        Schema::create('livestream_video_source_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
            $table->string('playback_prefix')->nullable();
            $table->string('playback_suffix')->nullable();
        });

        Schema::create('livestream_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_name')->nullable()->unique();
            $table->string('file_type')->nullable();
            $table->string('full_file_path')->nullable();
            $table->timestamps();
            $table->unsignedInteger('episode_id')->nullable()->index('livestream_videos_episode_id_foreign');
            $table->string('playback_url')->nullable();
            $table->string('stream_url')->nullable();
            $table->string('video_source_id')->nullable();
            $table->unsignedInteger('video_source_type_id')->nullable();
            $table->string('video_source_account_id')->nullable();
            $table->unsignedInteger('max_width')->nullable();
            $table->unsignedInteger('max_height')->nullable();
            $table->unsignedInteger('max_frame_rate')->nullable();
        });

        Schema::create('livestream_videos_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resolution');
            $table->timestamps();
            $table->unsignedInteger('source_video_id')->nullable()->index('livestream_videos_trans_source_video_id_foreign');
        });

        Schema::create('livestream_wowza_media_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('wowza_server_name');
            $table->integer('version');
            $table->mediumText('description');
            $table->string('default_stream_prefix');
            $table->string('ip');
            $table->integer('port');
            $table->string('handler_thread_pool');
            $table->string('handler_thread_pool_auto_value');
            $table->string('transport_thread_pool');
            $table->string('transport_handler_thread_pool_auto_value');
            $table->string('rtp_data_port_sharing');
            $table->string('rtp_data_port_sharing_port');
            $table->string('server_listener_order');
            $table->string('server_listener_base_class');
            $table->timestamps();
        });

        Schema::create('livestream_wowza_vhost_host_ports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->integer('port');
            $table->string('ip');
            $table->string('ssl');
            $table->timestamps();
            $table->unsignedInteger('wowza_vhost_id')->index('livestream_wowza_vhost_host_ports_wowza_vhost_id_foreign');
        });

        Schema::create('livestream_wowza_vhosts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vhost_name');
            $table->integer('version');
            $table->integer('running');
            $table->string('config_directory');
            $table->integer('connection_limit');
            $table->integer('test_player_ip');
            $table->integer('test_player_port');
            $table->integer('test_player_ssl');
            $table->integer('maximum_concurrent_transcodes');
            $table->string('security_publish_valid_encoders');
            $table->timestamps();
            $table->unsignedInteger('wowza_media_server_id')->index('livestream_wowza_vhosts_wowza_media_server_id_foreign');
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('module_slug')->unique();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id');
            $table->integer('created_by')->nullable();
            $table->string('icon', 50)->nullable();
            $table->text('body');
            $table->string('action_text')->nullable();
            $table->text('action_url')->nullable();
            $table->tinyInteger('read')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->integer('phone_id')->nullable();
            $table->string('cell_carrier')->nullable();
            $table->integer('address_id')->nullable();
            $table->string('photo')->nullable();
            $table->date('dob')->nullable();
            $table->date('dos')->nullable();
            $table->date('anniversary')->nullable();
            $table->string('facebook')->nullable();
            $table->timestamps();
            $table->string('phone')->nullable();
        });

        Schema::create('performance_indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monthly_recurring_revenue');
            $table->decimal('yearly_recurring_revenue');
            $table->decimal('daily_volume');
            $table->integer('new_users');
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id')->index('permission_role_role_id_foreign');

            $table->primary(['permission_id', 'role_id']);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->integer('level');
            $table->unsignedInteger('team_id')->index('roles_team_id_foreign');
            $table->unsignedInteger('module_id')->index('roles_module_id_foreign');
            $table->timestamps();
        });

        Schema::create('social_accounts', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('provider_user_id');
            $table->string('provider');
            $table->text('avatar')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->text('token')->nullable();
            $table->text('team_token')->nullable();
            $table->text('expires_in')->nullable();
            $table->text('refresh_token')->nullable();
            $table->boolean('verified')->nullable();
            $table->timestamps();
            $table->increments('id');
        });

        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('stripe_id');
            $table->string('stripe_plan');
            $table->integer('quantity');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('stripe_id');
            $table->string('stripe_plan');
            $table->integer('quantity');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('team_person', function (Blueprint $table) {
            $table->unsignedInteger('team_id')->index();
            $table->unsignedInteger('person_id')->index();
            $table->timestamps();
        });

        Schema::create('team_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->string('name');
            $table->string('stripe_id');
            $table->string('stripe_plan');
            $table->integer('quantity');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->index();
            $table->string('name');
            $table->string('timezone')->nullable();
            $table->string('team_slug')->unique();
            $table->text('photo_url')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('current_billing_plan')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->string('card_country')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip', 25)->nullable();
            $table->string('billing_country', 2)->nullable();
            $table->string('vat_id', 50)->nullable();
            $table->text('extra_billing_information')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamps();
            $table->text('default_bible')->nullable();
            $table->timestamp('banned_at')->nullable();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('role_id')->index();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('photo_url')->nullable();
            $table->tinyInteger('uses_two_factor_auth')->default(0);
            $table->string('authy_id')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('two_factor_reset_code', 100)->nullable();
            $table->integer('current_team_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('current_billing_plan')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->string('card_country')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip', 25)->nullable();
            $table->string('billing_country', 2)->nullable();
            $table->string('vat_id', 50)->nullable();
            $table->text('extra_billing_information')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('last_read_announcements_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedInteger('person_id')->unique();
            $table->integer('default_team_id')->nullable();
            $table->string('slack_webhook_url')->nullable();
            $table->unsignedInteger('discover_group_id')->nullable()->index('users_discover_group_id_foreign');
            $table->timestamp('banned_at')->nullable();
            $table->string('timezone')->nullable();
        });

        Schema::table('cms_accounts', function (Blueprint $table) {
            $table->foreign(['team_id'])->references(['id'])->on('teams')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('cms_group_person', function (Blueprint $table) {
            $table->foreign(['group_id'])->references(['id'])->on('cms_groups')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['person_id'])->references(['id'])->on('people')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_event_tickets', function (Blueprint $table) {
            $table->foreign(['event_id'])->references(['id'])->on('discover_events')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_events', function (Blueprint $table) {
            $table->foreign(['discover_team_id'])->references(['id'])->on('discover_teams')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_groups', function (Blueprint $table) {
            $table->foreign(['discover_team_id'])->references(['id'])->on('discover_teams')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_jobs', function (Blueprint $table) {
            $table->foreign(['assigned_to'])->references(['id'])->on('discover_users')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['discover_team_id'])->references(['id'])->on('discover_teams')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['event_id'])->references(['id'])->on('discover_events')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_jobs_departments', function (Blueprint $table) {
            $table->foreign(['department_id'])->references(['id'])->on('discover_departments')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['job_id'])->references(['id'])->on('discover_jobs')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_jobs_job_requirements', function (Blueprint $table) {
            $table->foreign(['job_id'])->references(['id'])->on('discover_jobs')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['job_requirement_id'])->references(['id'])->on('discover_job_requirements')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('discover_teams', function (Blueprint $table) {
            $table->foreign(['team_id'])->references(['id'])->on('teams')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('discover_users', function (Blueprint $table) {
            $table->foreign(['discover_group_id'])->references(['id'])->on('discover_groups')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_accounts', function (Blueprint $table) {
            $table->foreign(['default_episode_template_id'])->references(['id'])->on('livestream_episode_templates')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['team_id'])->references(['id'])->on('teams')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_applications', function (Blueprint $table) {
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_dashboard_account', function (Blueprint $table) {
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['livestream_dashboard_id'])->references(['id'])->on('livestream_dashboards')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_episode_current_recordings', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['episode_id'])->references(['id'])->on('livestream_episodes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_episode_person', function (Blueprint $table) {
            $table->foreign(['episode_id'])->references(['id'])->on('livestream_episodes')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['person_id'])->references(['id'])->on('people')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('livestream_episode_templates', function (Blueprint $table) {
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->foreign(['default_playback_id'])->references(['id'])->on('livestream_playback_ids')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['main_speaker_id'])->references(['id'])->on('people')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['main_video_id'])->references(['id'])->on('livestream_videos')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['thumbnail_image_id'])->references(['id'])->on('images')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('livestream_events', function (Blueprint $table) {
            $table->foreign(['livestream_app_id'])->references(['id'])->on('livestream_applications')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_players', function (Blueprint $table) {
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_playlist_player', function (Blueprint $table) {
            $table->foreign(['player_id'])->references(['id'])->on('livestream_players')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['playlist_id'])->references(['id'])->on('livestream_playlists')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_playlists', function (Blueprint $table) {
            $table->foreign(['account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_schedules', function (Blueprint $table) {
            $table->foreign(['episode_template_id'])->references(['id'])->on('livestream_episode_templates')->onUpdate('CASCADE')->onDelete('NO ACTION');
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('livestream_stream_integrations', function (Blueprint $table) {
            $table->foreign(['episode_template_id'])->references(['id'])->on('livestream_episode_templates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_stream_targets', function (Blueprint $table) {
            $table->foreign(['stream_id'])->references(['id'])->on('livestream_streams')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['stream_integration_id'])->references(['id'])->on('livestream_stream_integrations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_streams', function (Blueprint $table) {
            $table->foreign(['active_episode_id'])->references(['id'])->on('livestream_episodes')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['livestream_account_id'])->references(['id'])->on('livestream_accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_videos', function (Blueprint $table) {
            $table->foreign(['episode_id'])->references(['id'])->on('livestream_episodes')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });

        Schema::table('livestream_videos_trans', function (Blueprint $table) {
            $table->foreign(['source_video_id'])->references(['id'])->on('livestream_videos')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('livestream_wowza_vhost_host_ports', function (Blueprint $table) {
            $table->foreign(['wowza_vhost_id'])->references(['id'])->on('livestream_wowza_vhosts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('livestream_wowza_vhosts', function (Blueprint $table) {
            $table->foreign(['wowza_media_server_id'])->references(['id'])->on('livestream_wowza_media_servers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreign(['permission_id'])->references(['id'])->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->foreign(['module_id'])->references(['id'])->on('modules')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['team_id'])->references(['id'])->on('teams')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('team_person', function (Blueprint $table) {
            $table->foreign(['person_id'])->references(['id'])->on('people')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['team_id'])->references(['id'])->on('teams')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });

        Schema::table('user_role', function (Blueprint $table) {
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['person_id'])->references(['id'])->on('people')->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_person_id_foreign');
        });

        Schema::table('user_role', function (Blueprint $table) {
            $table->dropForeign('user_role_role_id_foreign');
            $table->dropForeign('user_role_user_id_foreign');
        });

        Schema::table('team_person', function (Blueprint $table) {
            $table->dropForeign('team_person_person_id_foreign');
            $table->dropForeign('team_person_team_id_foreign');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign('roles_module_id_foreign');
            $table->dropForeign('roles_team_id_foreign');
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign('permission_role_permission_id_foreign');
            $table->dropForeign('permission_role_role_id_foreign');
        });

        Schema::table('livestream_wowza_vhosts', function (Blueprint $table) {
            $table->dropForeign('livestream_wowza_vhosts_wowza_media_server_id_foreign');
        });

        Schema::table('livestream_wowza_vhost_host_ports', function (Blueprint $table) {
            $table->dropForeign('livestream_wowza_vhost_host_ports_wowza_vhost_id_foreign');
        });

        Schema::table('livestream_videos_trans', function (Blueprint $table) {
            $table->dropForeign('livestream_videos_trans_source_video_id_foreign');
        });

        Schema::table('livestream_videos', function (Blueprint $table) {
            $table->dropForeign('livestream_videos_episode_id_foreign');
        });

        Schema::table('livestream_streams', function (Blueprint $table) {
            $table->dropForeign('livestream_streams_active_episode_id_foreign');
            $table->dropForeign('livestream_streams_livestream_account_id_foreign');
        });

        Schema::table('livestream_stream_targets', function (Blueprint $table) {
            $table->dropForeign('livestream_stream_targets_stream_id_foreign');
            $table->dropForeign('livestream_stream_targets_stream_integration_id_foreign');
        });

        Schema::table('livestream_stream_integrations', function (Blueprint $table) {
            $table->dropForeign('livestream_stream_integrations_episode_template_id_foreign');
            $table->dropForeign('livestream_stream_integrations_livestream_account_id_foreign');
        });

        Schema::table('livestream_schedules', function (Blueprint $table) {
            $table->dropForeign('livestream_schedules_episode_template_id_foreign');
            $table->dropForeign('livestream_schedules_livestream_account_id_foreign');
        });

        Schema::table('livestream_playlists', function (Blueprint $table) {
            $table->dropForeign('livestream_playlists_account_id_foreign');
        });

        Schema::table('livestream_playlist_player', function (Blueprint $table) {
            $table->dropForeign('livestream_playlist_player_player_id_foreign');
            $table->dropForeign('livestream_playlist_player_playlist_id_foreign');
        });

        Schema::table('livestream_players', function (Blueprint $table) {
            $table->dropForeign('livestream_players_livestream_account_id_foreign');
        });

        Schema::table('livestream_events', function (Blueprint $table) {
            $table->dropForeign('livestream_events_livestream_app_id_foreign');
        });

        Schema::table('livestream_episodes', function (Blueprint $table) {
            $table->dropForeign('livestream_episodes_default_playback_id_foreign');
            $table->dropForeign('livestream_episodes_livestream_account_id_foreign');
            $table->dropForeign('livestream_episodes_main_speaker_id_foreign');
            $table->dropForeign('livestream_episodes_main_video_id_foreign');
            $table->dropForeign('livestream_episodes_thumbnail_image_id_foreign');
        });

        Schema::table('livestream_episode_templates', function (Blueprint $table) {
            $table->dropForeign('livestream_episode_templates_livestream_account_id_foreign');
        });

        Schema::table('livestream_episode_person', function (Blueprint $table) {
            $table->dropForeign('livestream_episode_person_episode_id_foreign');
            $table->dropForeign('livestream_episode_person_person_id_foreign');
        });

        Schema::table('livestream_episode_current_recordings', function (Blueprint $table) {
            $table->dropForeign('livestream_episode_current_recordings_account_id_foreign');
            $table->dropForeign('livestream_episode_current_recordings_episode_id_foreign');
        });

        Schema::table('livestream_dashboard_account', function (Blueprint $table) {
            $table->dropForeign('livestream_dashboard_account_livestream_account_id_foreign');
            $table->dropForeign('livestream_dashboard_account_livestream_dashboard_id_foreign');
        });

        Schema::table('livestream_applications', function (Blueprint $table) {
            $table->dropForeign('livestream_applications_livestream_account_id_foreign');
        });

        Schema::table('livestream_accounts', function (Blueprint $table) {
            $table->dropForeign('livestream_accounts_default_episode_template_id_foreign');
            $table->dropForeign('livestream_accounts_team_id_foreign');
        });

        Schema::table('discover_users', function (Blueprint $table) {
            $table->dropForeign('discover_users_discover_group_id_foreign');
            $table->dropForeign('discover_users_user_id_foreign');
        });

        Schema::table('discover_teams', function (Blueprint $table) {
            $table->dropForeign('discover_teams_team_id_foreign');
        });

        Schema::table('discover_jobs_job_requirements', function (Blueprint $table) {
            $table->dropForeign('discover_jobs_job_requirements_job_id_foreign');
            $table->dropForeign('discover_jobs_job_requirements_job_requirement_id_foreign');
        });

        Schema::table('discover_jobs_departments', function (Blueprint $table) {
            $table->dropForeign('discover_jobs_departments_department_id_foreign');
            $table->dropForeign('discover_jobs_departments_job_id_foreign');
        });

        Schema::table('discover_jobs', function (Blueprint $table) {
            $table->dropForeign('discover_jobs_assigned_to_foreign');
            $table->dropForeign('discover_jobs_discover_team_id_foreign');
            $table->dropForeign('discover_jobs_event_id_foreign');
        });

        Schema::table('discover_groups', function (Blueprint $table) {
            $table->dropForeign('discover_groups_discover_team_id_foreign');
        });

        Schema::table('discover_events', function (Blueprint $table) {
            $table->dropForeign('discover_events_discover_team_id_foreign');
        });

        Schema::table('discover_event_tickets', function (Blueprint $table) {
            $table->dropForeign('discover_event_tickets_event_id_foreign');
        });

        Schema::table('cms_group_person', function (Blueprint $table) {
            $table->dropForeign('cms_group_person_group_id_foreign');
            $table->dropForeign('cms_group_person_person_id_foreign');
        });

        Schema::table('cms_accounts', function (Blueprint $table) {
            $table->dropForeign('cms_accounts_team_id_foreign');
        });

        Schema::dropIfExists('users');

        Schema::dropIfExists('user_role');

        Schema::dropIfExists('teams');

        Schema::dropIfExists('team_subscriptions');

        Schema::dropIfExists('team_person');

        Schema::dropIfExists('subscriptions');

        Schema::dropIfExists('subscription_plans');

        Schema::dropIfExists('social_accounts');

        Schema::dropIfExists('roles');

        Schema::dropIfExists('permissions');

        Schema::dropIfExists('permission_role');

        Schema::dropIfExists('performance_indicators');

        Schema::dropIfExists('people');

        Schema::dropIfExists('password_resets');

        Schema::dropIfExists('notifications');

        Schema::dropIfExists('modules');

        Schema::dropIfExists('livestream_wowza_vhosts');

        Schema::dropIfExists('livestream_wowza_vhost_host_ports');

        Schema::dropIfExists('livestream_wowza_media_servers');

        Schema::dropIfExists('livestream_videos_trans');

        Schema::dropIfExists('livestream_videos');

        Schema::dropIfExists('livestream_video_source_types');

        Schema::dropIfExists('livestream_streams');

        Schema::dropIfExists('livestream_stream_targets');

        Schema::dropIfExists('livestream_stream_integrations');

        Schema::dropIfExists('livestream_schedules');

        Schema::dropIfExists('livestream_playlists');

        Schema::dropIfExists('livestream_playlist_player');

        Schema::dropIfExists('livestream_players');

        Schema::dropIfExists('livestream_playback_ids');

        Schema::dropIfExists('livestream_packages');

        Schema::dropIfExists('livestream_events');

        Schema::dropIfExists('livestream_episodes');

        Schema::dropIfExists('livestream_episode_templates');

        Schema::dropIfExists('livestream_episode_person');

        Schema::dropIfExists('livestream_episode_current_recordings');

        Schema::dropIfExists('livestream_dashboards');

        Schema::dropIfExists('livestream_dashboard_account');

        Schema::dropIfExists('livestream_applications');

        Schema::dropIfExists('livestream_accounts');

        Schema::dropIfExists('jobs');

        Schema::dropIfExists('invoices');

        Schema::dropIfExists('invitations');

        Schema::dropIfExists('images');

        Schema::dropIfExists('failed_jobs');

        Schema::dropIfExists('episode_downloads');

        Schema::dropIfExists('discover_users');

        Schema::dropIfExists('discover_teams');

        Schema::dropIfExists('discover_jobs_job_requirements');

        Schema::dropIfExists('discover_jobs_departments');

        Schema::dropIfExists('discover_jobs');

        Schema::dropIfExists('discover_job_requirements');

        Schema::dropIfExists('discover_groups');

        Schema::dropIfExists('discover_events');

        Schema::dropIfExists('discover_event_tickets');

        Schema::dropIfExists('discover_departments');

        Schema::dropIfExists('cms_ministries');

        Schema::dropIfExists('cms_groups');

        Schema::dropIfExists('cms_group_person');

        Schema::dropIfExists('cms_accounts');

        Schema::dropIfExists('cache');

        Schema::dropIfExists('bans');

        Schema::dropIfExists('api_tokens');

        Schema::dropIfExists('announcements');
    }
}
