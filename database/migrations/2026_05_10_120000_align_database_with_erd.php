<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | DOCTORS — ERD fields
        |--------------------------------------------------------------------------
        */
        Schema::table('doctors', function (Blueprint $table) {
            if (! Schema::hasColumn('doctors', 'clinic_no')) {
                $table->string('clinic_no', 32)->nullable()->unique()->after('id');
            }
            if (! Schema::hasColumn('doctors', 'full_name')) {
                $table->string('full_name', 200)->nullable()->after('clinic_no');
            }
            if (! Schema::hasColumn('doctors', 'address')) {
                $table->string('address', 255)->nullable()->after('full_name');
            }
        });

        foreach (DB::table('doctors')->get() as $row) {
            $full = trim(($row->first_name ?? '').' '.($row->last_name ?? ''));
            if ($full === '') {
                $full = 'Doctor #'.$row->id;
            }
            $clinic = $row->clinic_no ?? 'CLN-'.str_pad((string) $row->id, 5, '0', STR_PAD_LEFT);
            DB::table('doctors')->where('id', $row->id)->update([
                'full_name' => $full,
                'clinic_no' => $clinic,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PATIENTS — doctor_id + rename date column + drop legacy denormalized fields
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (! Schema::hasColumn('patients', 'doctor_id')) {
                    $table->unsignedBigInteger('doctor_id')->nullable()->after('phone');
                }
            });

            if (Schema::hasColumn('patients', 'doctor_id')) {
                try {
                    Schema::table('patients', function (Blueprint $table) {
                        $table->foreign('doctor_id')->references('id')->on('doctors')->nullOnDelete();
                    });
                } catch (\Throwable $e) {
                }
            }

            if (Schema::hasColumn('patients', 'date_of_registration')
                && ! Schema::hasColumn('patients', 'date_registered')) {
                DB::statement('ALTER TABLE patients RENAME COLUMN date_of_registration TO date_registered');
            }

            $legacyPatientCols = [
                'ward', 'bed_number', 'doctor', 'kin_name', 'kin_relationship', 'kin_phone',
                'blood_type', 'admission_date', 'medical_record',
            ];
            foreach ($legacyPatientCols as $col) {
                if (Schema::hasColumn('patients', $col)) {
                    Schema::table('patients', function (Blueprint $table) use ($col) {
                        $table->dropColumn($col);
                    });
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | NEXT_OF_KIN
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('next_of_kin') && Schema::hasColumn('next_of_kin', 'address')) {
            try {
                if (Schema::getConnection()->getDriverName() === 'pgsql') {
                    DB::statement('ALTER TABLE next_of_kin ALTER COLUMN address DROP NOT NULL');
                }
            } catch (\Throwable $e) {
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BED_ALLOCATIONS → patients.id
        |--------------------------------------------------------------------------
        */
        try {
            Schema::table('bed_allocations', function (Blueprint $table) {
                $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
        }

        /*
        |--------------------------------------------------------------------------
        | OUT_PATIENTS — ERD
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('out_patients')) {
            DB::statement('ALTER TABLE out_patients DROP CONSTRAINT IF EXISTS out_patients_doctor_id_foreign');

            Schema::table('out_patients', function (Blueprint $table) {
                foreach (['doctor_id', 'reason'] as $col) {
                    if (Schema::hasColumn('out_patients', $col)) {
                        $table->dropColumn($col);
                    }
                }
                if (! Schema::hasColumn('out_patients', 'appointment_time')) {
                    $table->time('appointment_time')->nullable();
                }
            });

            if (Schema::hasColumn('out_patients', 'visit_date')
                && ! Schema::hasColumn('out_patients', 'appointment_date')) {
                DB::statement('ALTER TABLE out_patients RENAME COLUMN visit_date TO appointment_date');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | APPOINTMENTS
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('appointments')) {
            try {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
                    $table->foreign('consultant_id')->references('id')->on('doctors')->cascadeOnDelete();
                });
            } catch (\Throwable $e) {
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('appointments')) {
            try {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->dropForeign(['patient_id']);
                });
            } catch (\Throwable $e) {
            }
            try {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->dropForeign(['consultant_id']);
                });
            } catch (\Throwable $e) {
            }
        }

        try {
            Schema::table('bed_allocations', function (Blueprint $table) {
                $table->dropForeign(['patient_id']);
            });
        } catch (\Throwable $e) {
        }

        if (Schema::hasTable('out_patients')) {
            if (Schema::hasColumn('out_patients', 'appointment_date')
                && ! Schema::hasColumn('out_patients', 'visit_date')) {
                DB::statement('ALTER TABLE out_patients RENAME COLUMN appointment_date TO visit_date');
            }
            Schema::table('out_patients', function (Blueprint $table) {
                if (Schema::hasColumn('out_patients', 'appointment_time')) {
                    $table->dropColumn('appointment_time');
                }
            });
            Schema::table('out_patients', function (Blueprint $table) {
                if (! Schema::hasColumn('out_patients', 'doctor_id')) {
                    $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
                }
                if (! Schema::hasColumn('out_patients', 'reason')) {
                    $table->text('reason')->nullable();
                }
            });
        }

        if (Schema::hasTable('patients')) {
            try {
                Schema::table('patients', function (Blueprint $table) {
                    $table->dropForeign(['doctor_id']);
                });
            } catch (\Throwable $e) {
            }
            if (Schema::hasColumn('patients', 'doctor_id')) {
                Schema::table('patients', function (Blueprint $table) {
                    $table->dropColumn('doctor_id');
                });
            }
        }

        if (Schema::hasColumn('patients', 'date_registered')
            && ! Schema::hasColumn('patients', 'date_of_registration')) {
            DB::statement('ALTER TABLE patients RENAME COLUMN date_registered TO date_of_registration');
        }

        Schema::table('doctors', function (Blueprint $table) {
            foreach (['clinic_no', 'full_name', 'address'] as $col) {
                if (Schema::hasColumn('doctors', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
