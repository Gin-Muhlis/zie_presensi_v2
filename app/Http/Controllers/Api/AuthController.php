<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        $user = User::whereEmail($request->email)->firstOrFail();

        $token = $user->createToken('auth-token');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * @param Request $request
     * 
     * @return json
     */
    public function studentRegister(Request $request) {

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

        return response()->json([
            'status' => 200,
            'message' => 'Siswa Berhasil Didaftarkan'
        ]);
    }

    public function studentLogin(Request $request) {
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
    }

    /**
     * @param mixed $data
     * 
     * @return object
     */
    private function studentValidator($data) {
        return Validator::make($data, [
            'name' => ['required', 'max:255', 'string'],
            'nis' => ['required', 'max:9', 'numeric'],
            'password' => ['required', 'max:255'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'class_student_id' => ['required', 'exists:class_students,id'],
        ], [
            'name.required' => 'Kolom nama harus diisi',
            'name.max' => 'Kolom nama maksimal 255 karakter',
            'name.string' => 'Kolom nama harus berupa string',
            'nis.required' => 'Kolom nis harus diisi',
            'nis.max' => 'Kolom nis maksimal 9 karakter',
            'nis.numeric' => 'Kolom nis harus berupa angka',
            'gender.required' => 'Kolom gender harus diisi',
            'gender.in' => 'Kolom gender harus berupa laki-laki,perempuan,lainnya',
            'password.required' => 'Kolom password harus diisi',
            'password.max' => 'Kolom password maksimal 255 karakter',
            'class_student_id.required' => 'Kolom Kelas harus diisi',
            'class_student_id.exists' => 'Kelas tidak valid',
        ]);
    }
}
