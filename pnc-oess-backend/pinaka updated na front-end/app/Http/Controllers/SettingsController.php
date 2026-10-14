<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use App\Support\Oess;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show()
    {
        return SystemSetting::first()?->data ?? [];
    }

    public function update(Request $request)
    {
        $row = SystemSetting::first() ?? new SystemSetting(['data' => []]);
        $current = is_array($row->data) ? $row->data : [];

        $payload = $request->all();
        $updated = array_merge($current, $payload);

        $row->data = $updated;
        $row->save();

        $s = $row->data;
        Oess::audit(
            $request->user(),
            'Updated System Settings',
            'System Settings',
            "Updated configuration (Term: " . ($s['academicYear'] ?? 'N/A') . ' ' . ($s['semester'] ?? 'N/A') . ', Enrollment: ' . ($s['enrollmentStatus'] ?? 'N/A') . ')'
        );
        return $row->data;
    }
}
