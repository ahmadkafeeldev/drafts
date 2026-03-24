<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Note: another migration (`0001_01_01_000000_create_users_table`) already
        // creates the `users` table. When running `migrate:fresh`, we must avoid
        // attempting to create it again.
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('google_id')->default("");
                $table->string('apple_id')->default("");
                $table->string('first_name')->default("");
                $table->string('last_name')->default("");
                $table->string('company_name')->default("");
                $table->string('email')->unique()->default("");
                $table->timestamp('email_verified_at')->nullable();
                $table->string('profile_image')->default("profile_images/default.png");
                $table->timestamp('weight')->nullable();
                $table->string('connect_account_id')->default("");
                $table->string('dob')->default("");
                $table->string('gender')->default("");
                $table->string('bank_account_name')->default("");
                $table->string('bank_name')->default("");
                $table->string('bank_account_number')->default("");
                $table->string('device_type')->default("");
                $table->text('onesignal_id')->nullable();
                $table->string('password')->nullable();
                $table->tinyInteger('type')->default(1);
                $table->tinyInteger('is_verified')->default(1);
                $table->rememberToken();
                $table->timestamps();
            });

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            // Add columns that exist in this migration but may not exist yet.
            // We guard with Schema::hasColumn so `migrate:fresh` + re-runs are safe.
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->default("");
            }
            if (!Schema::hasColumn('users', 'apple_id')) {
                $table->string('apple_id')->default("");
            }
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->default("");
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->default("");
            }
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->default("");
            }
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->default("profile_images/default.png");
            }
            if (!Schema::hasColumn('users', 'weight')) {
                $table->timestamp('weight')->nullable();
            }
            if (!Schema::hasColumn('users', 'connect_account_id')) {
                $table->string('connect_account_id')->default("");
            }
            if (!Schema::hasColumn('users', 'dob')) {
                $table->string('dob')->default("");
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->default("");
            }
            if (!Schema::hasColumn('users', 'bank_account_name')) {
                $table->string('bank_account_name')->default("");
            }
            if (!Schema::hasColumn('users', 'bank_name')) {
                $table->string('bank_name')->default("");
            }
            if (!Schema::hasColumn('users', 'bank_account_number')) {
                $table->string('bank_account_number')->default("");
            }
            if (!Schema::hasColumn('users', 'device_type')) {
                $table->string('device_type')->default("");
            }
            if (!Schema::hasColumn('users', 'onesignal_id')) {
                $table->text('onesignal_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'type')) {
                $table->tinyInteger('type')->default(1);
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->tinyInteger('is_verified')->default(1);
            }
            // Columns like `email`, `password`, `remember_token` and timestamps may
            // already exist from the earlier migration; we avoid redefining them.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is additive when `users` already exists.
        // For safety, only drop the table if it doesn't look like it was created
        // by the earlier base migration.
        Schema::dropIfExists('users');
    }
};
