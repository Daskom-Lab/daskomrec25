<?php
// app/Imports/CaasImport.php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Stage;
use App\Models\CaasStage;
use App\Models\Caas;

class CaasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validate required fields (return null if missing, skipping row)
        if (empty($row['nim'])) {
            return null; // Skip invalid row
        }

        try {
            // Ensure safe data retrieval with fallbacks
            $nim = $row['nim'];
            $name = $row['name'] ?? null;
            $major = $row['major'] ?? null;
            $class = $row['class'] ?? null;
            $email = $row['email'] ?? null;
            $gender = $row['gender'] ?? 'Male';
            $gems = $row['gems'] ?? null;
            $state = $row['state'] ?? 'Administration';
            $status = $row['status'] ?? 'Unknown';

            // Find or create user
            $user = User::firstOrCreate(
                ['nim' => $nim],
                ['password' => bcrypt($nim . '2025')]
            );

            // Create or update profile
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                compact('name', 'major', 'class', 'email', 'gender')
            );

            // Find or create role
            if (!empty($gems) && strtolower(trim($gems)) !== 'no gem') {
                $role = Role::firstOrCreate(['name' => $gems]);
                $role_id = $role->id;
            } else {
                $role_id = null;
            }
            

            // Find or create stage
            $stage = Stage::firstOrCreate(['name' => $state]);

            // Create or update CaasStage
            CaasStage::updateOrCreate(
                ['user_id' => $user->id],
                ['stage_id' => $stage->id, 'status' => $status]
            );

            // Create or update Caas
            return Caas::updateOrCreate(
                ['user_id' => $user->id],
                ['role_id' => $role_id]
            );
            
        } catch (\Exception $e) {
            return null;
        }
    }
}
