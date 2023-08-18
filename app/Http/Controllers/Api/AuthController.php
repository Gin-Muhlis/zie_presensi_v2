<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Models\Student;
use App\Models\Teacher;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * 
     * @return json
     */
    public function studentRegister(Request $request)
    {

        try {
            DB::beginTransaction();

            $validator = $this->studentValidator($request->all());

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Terjadi kesalahan dengan data yang dikirim!',
                    'error' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validate();

            $validated['password'] = Hash::make($validated['password']);

            $student = Student::create($validated);

            $student->assignRole('siswa');

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Siswa Berhasil Didaftarkan'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan dengan data yang dikirim!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function studentLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nis' => 'required|numeric',
                'password' => 'required',
            ], [
                'nis.required' => 'NIS tidak boleh kosong',
                'nis.numeric' => 'NIS tidak valid',
                'password.required' => 'Password tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->errors()
                ]);
            }

            $credentials = $validator->validate();

            if (!Auth::guard('student_api')->attempt($credentials)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'NIS atau Password salah'
                ], 404);
            }

            $student = Student::whereNis($request->nis)->firstOrFail();

            $token = $student->createToken('student-auth-token');

            return response()->json([
                'status' => 200,
                'message' => 'Login Berhasil',
                'token' => $token->plainTextToken,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan dengan data yang dikirim!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param mixed $data
     * 
     * @return object
     */
    private function studentValidator($data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:255', 'string'],
            'nis' => ['required', 'digits:9', 'numeric'],
            'password' => ['required', 'max:255'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'class_student_id' => ['required', 'exists:class_students,id'],
        ], [
            'name.required' => 'Kolom nama harus diisi',
            'name.max' => 'Kolom nama maksimal 255 karakter',
            'name.string' => 'Kolom nama harus berupa string',
            'nis.required' => 'Kolom nis harus diisi',
            'nis.digits' => 'Kolom nis maksimal 9 digit',
            'nis.numeric' => 'Kolom nis harus berupa angka',
            'gender.required' => 'Kolom gender harus diisi',
            'gender.in' => 'Kolom gender harus berupa laki-laki,perempuan,lainnya',
            'password.required' => 'Kolom password harus diisi',
            'password.max' => 'Kolom password maksimal 255 karakter',
            'class_student_id.required' => 'Kolom Kelas harus diisi',
            'class_student_id.exists' => 'Kelas tidak valid',
        ]);
    }

    public function teacherRegister(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = $this->teacherValidator($request->all());

            if ($validator->fails()) {
                return response()->json([
                   'status' => 422,
                   'message' => 'Terjadi kesalahan dengan data yang dikirim!',
                    'error' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validate();

            $validated['password'] = Hash::make($validated['password']);

            $teacher = Teacher::create($validated);

            $teacher->assignRole('guru');

            DB::commit();

            return response()->json([
               'status' => 200,
               'message' => 'Guru Berhasil Didaftarkan'
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

    public function teacherLogin(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'password.required' => 'Password tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Terjadi kesalahan dengan data yang dikirim!',
                    'errors' => $validator->errors()
                ]);
            }

            $credentials = $validator->validate();

            if (!Auth::guard('teacher_api')->attempt($credentials)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email atau Password salah'
                ], 404);
            }

            $teacher = Teacher::whereEmail($request->email)->firstOrFail();

            $token = $teacher->createToken('teacher-auth-token');

            return response()->json([
                'status' => 200,
                'message' => 'Login Berhasil',
                'token' => $token->plainTextToken,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi Kesalahan!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function teacherValidator($data) {
        return Validator::make($data, [
            'email' => ['required', 'unique:teachers,email', 'email'],
            'name' => ['required', 'max:255', 'string'],
            'gender' => ['required', 'in:laki-laki,perempuan,lainnya'],
            'password' => ['required'],
        ], [
            'email.required' => 'Kolom email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Email tidak valid',
            'name.required' => 'Kolom nama harus diisi',
            'name.max' => 'Kolom nama maksimal 255 karakter',
            'name.string' => 'Kolom nama harus berupa string',
            'gender.required' => 'Kolom gender harus diisi',
            'gender.in' => 'Kolom gender harus berupa laki-laki,perempuan,lainnya',
            'password.required' => 'Kolom password harus diisi',
        ]);
    }
}
