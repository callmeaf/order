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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('status')->index();
            $table->string('type')->index();
            /**
             * @var \Callmeaf\User\App\Repo\Contracts\UserRepoInterface $userRepo
             */
            $userRepo = app(\Callmeaf\User\App\Repo\Contracts\UserRepoInterface::class);
            $table->string('user_identifier')->nullable();
            $table->foreign('user_identifier')->references($userRepo->getModel()->identifierKey())->on($userRepo->getTable())->cascadeOnUpdate()->nullOnDelete();
            /**
             * @var \Callmeaf\Address\App\Repo\Contracts\AddressRepoInterface $addressRepo
             */
            $addressRepo = app(\Callmeaf\Address\App\Repo\Contracts\AddressRepoInterface::class);
            $table->foreignUlid('address_id')->constrained($addressRepo->getTable())->cascadeOnDelete();
            $table->string('total_price')->nullable();
            $table->string('total_cost')->nullable();
            $table->string('total_profit')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
