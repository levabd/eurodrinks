<?php namespace Allatrack\Eurodrinks\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAllatrackEurodrinksStatTables extends Migration {

    public function up()
    {
        Schema::create('allatrack_eurodrinks_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ru', 255)->nillable();
            $table->string('name_uk', 255)->nillable();
            $table->string('name_en', 255)->nillable();
            $table->text('description_ru')->nillable();
            $table->text('description_uk')->nillable();
            $table->text('description_en')->nillable();

            $table->string('slug', 255)->unique();
            $table->string('import_name', 255)->unique();
        });

        Schema::table('backend_users', function (Blueprint $table) {
            $table->integer('brand_id')->nullable()->unsigned();
            $table->foreign('brand_id')->references('id')->on('allatrack_eurodrinks_brands')->onDelete('cascade')->nullable();
            $table->timestamp('available_until')->nullable();
        });

        // we use shorter name 'brand_contractors' instead of 'allatrack_eurodrinks_brand_contractors'
        // - because of error ocured while creating primary keys
        Schema::create('brand_contractor', function (Blueprint $table) {
            $table->integer('brand_id')->unsigned();
            $table->integer('contractor_id')->unsigned();
            $table->primary(['brand_id', 'contractor_id']);
        });

        Schema::create('allatrack_eurodrinks_contractors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ru', 255)->nillable();
            $table->string('name_uk', 255)->nillable();
            $table->string('name_en', 255);
            $table->string('slug')->unique();
            $table->string('import_name', 255)->unique();
            $table->integer('edrpoy')->unsigned()->nullable();
            $table->boolean('is_group')->default(false);
            $table->integer('contractor_id')->nullable()->unsigned();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('allatrack_eurodrinks_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ru', 255)->nillable();
            $table->string('name_uk', 255)->nillable();
            $table->string('name_en', 255);
            $table->double('latitude');
            $table->double('longitude');
        });

        Schema::create('contractor_address', function (Blueprint $table) {
            $table->integer('contractor_id')->unsigned();
            $table->integer('address_id')->unsigned();
            $table->primary(['address_id', 'contractor_id']);
        });

        Schema::create('allatrack_eurodrinks_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ru', 255)->nillable();
            $table->string('name_uk', 255)->nillable();
            $table->string('name_en', 255);
            $table->text('description_ru')->nillable();
            $table->text('description_uk')->nillable();
            $table->text('description_en')->nillable();
            $table->double('capacity')->default(0);
            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')
                ->on('allatrack_eurodrinks_brands')
                ->onDelete('cascade');
        });

        Schema::create('product_contractor', function (Blueprint $table) {
            $table->integer('contractor_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->primary(['product_id', 'contractor_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('allatrack_eurodrinks_products');

        if (Schema::hasColumn('backend_users', 'brand_id'))
        {
            Schema::table('backend_users', function (Blueprint $table) {
                $table->dropForeign(['brand_id']);
                $table->dropColumn('brand_id');
            });
        }

        Schema::dropIfExists('allatrack_eurodrinks_brands');
        Schema::dropIfExists("allatrack_eurodrinks_brand_contractors");
        Schema::dropIfExists("allatrack_eurodrinks_contractors_addresses");
        Schema::dropIfExists("allatrack_eurodrinks_contractors");
        Schema::dropIfExists('allatrack_eurodrinks_products');
        Schema::dropIfExists('product_contractor');
    }
}
