<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionComunaAddressToLocationsTable extends Migration
{
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('region')->nullable()->after('description');
            $table->string('comuna')->nullable()->after('region');
            $table->string('address')->nullable()->after('comuna');
        });
    }

    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['region', 'comuna', 'address']);
        });
    }
}
