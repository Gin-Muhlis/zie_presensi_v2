<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
   
    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            $data = new StudentResource($user);
            return response()->json([
                'status' => 200,
                'student' => $data
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function studentABsenceData(
        Request $request
    ) {
       try {
        $student = $request->user();

        $this->authorize('student-view', StudentAbsence::class);

        $studentAbsences = $student
            ->studentAbsences()
            ->latest()
            ->get();

        $present = [];
        $sick = [];
        $permission = [];
        $withoutExplanasion = [];

        foreach($studentAbsences as $absence) {
            switch($absence->presence->name){
                case 'hadir':
                    array_push($present, $absence);
                    break;
                case 'sakit':
                    array_push($sick, $absence);
                    break;
                case 'izin':
                    array_push($permission, $absence);
                    break;
                case 'tanpa keterangan':
                    array_push($withoutExplanasion, $absence);
                    break;
                default:
                break;
            }
        }

        return response()->json([
            'status' => 200,
            'present' => count($present),
            'sick' => count($sick),
            'permission' => count($permission),
            'withoutExplanasion' => count($withoutExplanasion)
        ]);
       } catch(Exception $e) {
        return response()->json([
          'status' => 500,
          'message' => 'Terjadi Kesalahan!',
          'error' => $e->getMessage()
        ], 500);
       }
    }

    public function studentAbsence(
        Request $request
    ) {
        try {
            DB::beginTransaction();

            $student = $request->user();

            $this->authorize('student-create', StudentAbsence::class);

            $validator = $this->validateAbsence($request->all());

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Terjadi kesalahan dengan data yang dikirim',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validate();

            $student->studentAbsences()->create($validated);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Anda telah melakukan absensi',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => 'Terjadi Kesalahan!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateAbsence($data)
    {
        return Validator::make($data, [
            'teacher_id' => ['required', 'exists:teachers,id'],
            'presence_id' => ['required', 'exists:presences,id'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
        ], [
            'teacher_id.required' => 'Guru tidak ditemukan',
            'teacher_id.exists' => 'Guru tidak ditemukan',
            'presence_id.required' => 'Presensi tidak ditemukan',
            'presence_id.exists' => 'Presensi tidak ditemukan',
            'date.required' => 'Tanggal tidak boleh kosong',
            'date.date' => 'Tanggal tidak valid',
            'time.required' => 'Waktu tidak boleh kosong',
            'time.date_format' => 'Waktu tidak valid',
        ]);
    }
}
