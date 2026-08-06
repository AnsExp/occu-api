<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(true)->nullable(false);
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);
            $table->decimal('price_base', 10, 2)->nullable(false)->default(0.00);
            $table->string('form')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('institution')->nullable(false);
            $table->text('description')->nullable(true);
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable(false);
            $table->decimal('discount_amount', 10, 2)->nullable(false)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('agreement_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->nullable(false)->constrained('agreements')->cascadeOnDelete();
            $table->foreignId('specialty_id')->nullable(false)->constrained('specialties')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('phone')->nullable(true);
            $table->string('id_card')->nullable(false);
            $table->string('id_card_file')->nullable(true);
            $table->enum('gender', ['male', 'female', 'other'])->nullable(true);
            $table->date('birth_date')->nullable(true);
            $table->string('nationality')->nullable(true);
            $table->foreignId('user_id')->nullable(false)->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->nullable(false)->constrained('people')->cascadeOnDelete();
            $table->foreignId('specialty_id')->nullable(false)->constrained('specialties')->cascadeOnDelete();
            $table->boolean('is_occupational_doctor')->nullable(false)->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->nullable(false)->constrained('people')->cascadeOnDelete();
            $table->foreignId('agreement_id')->nullable(true)->constrained('agreements')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('medical_dates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(true)->nullable(false);
            $table->foreignId('doctor_id')->nullable(false)->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable(false)->constrained('patients')->cascadeOnDelete();
            $table->foreignId('specialty_id')->nullable(true)->constrained('specialties')->cascadeOnDelete();
            $table->date('date')->default(now())->nullable(false);
            $table->enum('type', ['normal', 'occupational'])->nullable(false)->default('normal');
            $table->string('timezone')->nullable(false)->default('America/Guayaquil');
            $table->integer('order')->nullable(false)->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('doctor_id');
            $table->index('patient_id');
            $table->index('specialty_id');
        });

        Schema::create('medical_date_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('principal_id')->nullable(false)->constrained('medical_dates')->cascadeOnDelete();
            $table->foreignId('related_id')->nullable(false)->constrained('medical_dates')->cascadeOnDelete();
            $table->timestamps();

            $table->index('principal_id');
            $table->unique(['principal_id', 'related_id']);
        });

        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable(true)->constrained('patients')->nullOnDelete();
            $table->foreignId('medical_date_id')->unique(true)->nullable(true)->constrained('medical_dates')->nullOnDelete();
            $table->decimal('height', 5, 2)->nullable(false);
            $table->decimal('weight', 5, 2)->nullable(false);
            $table->decimal('blood_pressure_systolic', 5, 2)->nullable(false);
            $table->decimal('blood_pressure_diastolic', 5, 2)->nullable(false);
            $table->decimal('temperature', 5, 2)->nullable(false);
            $table->decimal('oxygen_saturation', 5, 2)->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('patient_id');
            $table->unique(['patient_id', 'medical_date_id']);
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_date_id')->nullable(true)->constrained('medical_dates')->nullOnDelete();
            $table->string('timezone')->nullable(false)->default('America/Guayaquil');
            $table->string('sha256')->nullable(false);
            $table->string('file')->nullable(false);
            $table->json('snapshot')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('medical_date_id');
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(true)->nullable(false);
            $table->foreignId('doctor_id')->nullable(false)->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable(false)->constrained('patients')->cascadeOnDelete();
            $table->string('timezone')->nullable(false)->default('America/Guayaquil');
            $table->text('notes')->nullable(true);
            $table->string('sha256')->nullable(false);
            $table->string('file')->nullable(false);
            $table->json('snapshot')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('doctor_id');
            $table->index('patient_id');
        });

        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('prescription_medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->nullable(false)->constrained('prescriptions')->cascadeOnDelete();
            $table->foreignId('medication_id')->nullable(false)->constrained('medications')->cascadeOnDelete();
            $table->integer('quantity')->nullable(false)->default(1);
            $table->text('notes')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('prescription_id');
            $table->unique(['prescription_id', 'medication_id']);
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('price')->nullable(false)->default('$0.00');
            $table->string('periodicity')->nullable(false);
            $table->text('description')->nullable(false);
            $table->json('features')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('laboratory_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('timezone')->nullable(false)->default('America/Guayaquil');
            $table->string('sha256')->nullable(false);
            $table->string('file')->nullable(false);
            $table->json('snapshot')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('patient_id');
        });

        Schema::create('laboratory_options', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('laboratory_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_order_id')->nullable(false)->constrained('laboratory_orders')->cascadeOnDelete();
            $table->foreignId('laboratory_option_id')->nullable(false)->constrained('laboratory_options')->cascadeOnDelete();
            $table->integer('quantity')->nullable(false)->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->index('laboratory_order_id');
            $table->unique(['laboratory_order_id', 'laboratory_option_id']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('table', 100);
            $table->unsignedBigInteger('table_id');
            $table->enum('level', ['info', 'warning', 'error', 'critical'])->default('info');
            $table->enum('action', ['create', 'update', 'delete'])->nullable(false);
            $table->json('changes')->nullable(false);
            $table->foreignId('user_id')->nullable(false)->constrained('users')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index('table');
            $table->index(['table', 'table_id']);
            $table->index(['table', 'table_id', 'action']);
            $table->index(['table', 'table_id', 'level']);
            $table->index(['user_id', 'action']);
        });

        Schema::create('allowed_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 15)->unique(true)->nullable(false);
            $table->string('notes')->nullable(false);
            $table->timestamp('expires_at')->nullable(true);
            $table->timestamps();
        });

        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('key')->nullable(false);
            $table->text('value')->nullable(false);
        });

        Schema::create('options', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->constrained('users')->cascadeOnDelete();
            $table->string('key')->nullable(false);
            $table->longText('value')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('metadata');
        Schema::dropIfExists('allowed_ips');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('laboratory_exams');
        Schema::dropIfExists('laboratory_options');
        Schema::dropIfExists('laboratory_orders');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('prescription_medications');
        Schema::dropIfExists('medications');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('vital_signs');
        Schema::dropIfExists('medical_date_relationships');
        Schema::dropIfExists('medical_dates');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('people');
        Schema::dropIfExists('agreement_requirements');
        Schema::dropIfExists('agreements');
        Schema::dropIfExists('specialties');
    }
};
