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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('email')->nullable()->default(null)->change();
            $table->string('mobile', 20)->after('email');
            $table->string('its', 8)->nullable()->unique()->after('mobile');
            $table->string('family_id', 10)->nullable()->unique()->after('its');
            $table->string('hof_its', 8)->after('family_id')->nullable();
            $table->string('its_family_id', 10)->after('hof_its')->nullable();
            $table->string('folio_no', 20)->after('its_family_id')->nullable();
            $table->enum('mumeneen_type', ['HOF', 'FM'])->after('folio_no')->nullable();
            $table->enum('title', ['Shaikh', 'Mulla'])->after('mumeneen_type')->nullable();
            $table->enum('gender', ['male', 'female'])->after('title')->nullable();
            $table->integer('age')->after('gender')->nullable();
            // as it don't support `length`, it can store upto `65,535 characters for TEXT type in MySQL`
            $table->text('address')->after('age')->nullable();
            $table->string('building', 100)->after('address')->nullable();
            $table->string('street', 100)->after('building')->nullable();
            $table->string('area', 100)->after('street')->nullable();
            $table->string('state', 50)->after('area')->nullable();
            $table->string('city', 100)->after('state')->nullable();
            $table->string('pincode', 10)->after('city')->nullable();
            $table->string('sector', 100)->after('pincode')->nullable();
            $table->string('sub_sector', 100)->after('sector')->nullable();
            $table->enum('status', ['active', 'in_active'])->after('sub_sector');
            $table->enum('role', ['superadmin', 'jamiat_admin', 'mumeneen'])->after('status');
            $table->integer('jamiat_id')->after('role')->nullable();
            $table->integer('otp')->after('jamiat_id')->nullable();
            $table->timestamp('expires_at')->after('otp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
