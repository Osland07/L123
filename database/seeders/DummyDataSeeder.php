<?php

namespace Database\Seeders;

use App\Models\RiskFactor;
use App\Models\RiskLevel;
use App\Models\Screening;
use App\Models\ScreeningDetail;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Use Indonesian locale if available/appropriate

        $distributions = [
            'Risiko hipertensi rendah' => 47,
            'Risiko hipertensi sedang' => 10,
            'Risiko hipertensi tinggi' => 43,
        ];

        $riskFactors = RiskFactor::pluck('id')->toArray();

        foreach ($distributions as $levelName => $count) {
            for ($i = 0; $i < $count; $i++) {
                // 1. Create User
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'role' => 'client',
                    'password' => Hash::make('password'), // Default password
                    'email_verified_at' => now(),
                ]);

                // 2. Generate Profile Data
                $gender = $faker->randomElement(['L', 'P']);
                $age = $faker->numberBetween(20, 70);
                $height = $faker->numberBetween(150, 190);
                $weight = $faker->numberBetween(50, 100);
                
                // Adjust BP based on risk level for realism
                if ($levelName === 'Risiko hipertensi tinggi') {
                    $systolic = $faker->numberBetween(140, 180);
                    $diastolic = $faker->numberBetween(90, 120);
                } elseif ($levelName === 'Risiko hipertensi sedang') {
                    $systolic = $faker->numberBetween(120, 139);
                    $diastolic = $faker->numberBetween(80, 89);
                } else {
                    $systolic = $faker->numberBetween(90, 119);
                    $diastolic = $faker->numberBetween(60, 79);
                }

                // 3. Create UserProfile
                UserProfile::create([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'age' => $age,
                    'gender' => $gender,
                    'height' => $height,
                    'weight' => $weight,
                    'systolic' => $systolic,
                    'diastolic' => $diastolic,
                ]);

                // 4. Create Screening
                $screening = Screening::create([
                    'user_id' => $user->id,
                    'client_name' => $user->name,
                    'snapshot_age' => $age,
                    'snapshot_height' => $height,
                    'snapshot_weight' => $weight,
                    'snapshot_systolic' => $systolic,
                    'snapshot_diastolic' => $diastolic,
                    'result_level' => $levelName,
                    'score' => $faker->randomFloat(2, 0, 100), // Random score
                ]);

                // 5. Create Screening Details (Risk Factors)
                // Determine how many factors to attach based on risk
                if ($levelName === 'Risiko hipertensi tinggi') {
                    $numFactors = $faker->numberBetween(5, count($riskFactors));
                } elseif ($levelName === 'Risiko hipertensi sedang') {
                    $numFactors = $faker->numberBetween(3, 5);
                } else {
                    $numFactors = $faker->numberBetween(0, 2);
                }

                if ($numFactors > 0 && !empty($riskFactors)) {
                    $selectedFactors = $faker->randomElements($riskFactors, $numFactors);
                    foreach ($selectedFactors as $factorId) {
                        ScreeningDetail::create([
                            'screening_id' => $screening->id,
                            'risk_factor_id' => $factorId,
                        ]);
                    }
                }
            }
        }
    }
}
