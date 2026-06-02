<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('student.index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
            'foto.required' => 'Foto harus diupload.'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
        } else {
            $foto = null;
        }

        $students = new Student();

        $students->nim = $request->nim;
        $students->nama = $request->nama;
        $students->email = $request->email;
        $students->prodi = $request->prodi;
        $students->foto = $foto;

        if ($students->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data berhasil disimpan !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal disimpan !',
                'type' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::where('nim', $id);

        if ($student->count() < 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        return view('student.edit', [
            'student' => $student->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $request->validate([
            'nim' => 'required|unique:students,nim,' . $student->nim . ',nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
        ]);

        // default pakai foto lama
        $foto = $student->foto;

        // jika ganti foto
        if ($request->ganti_foto == 1) {

            $request->validate([
                'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
            ], [
                'foto.required' => 'Foto harus diupload.',
            ]);

            if ($request->hasFile('foto')) {

                // hapus foto lama
                if (!empty($student->foto) && Storage::disk('public')->exists($student->foto)) {
                    Storage::disk('public')->delete($student->foto);
                }

                // upload foto baru
                $foto = $request->file('foto')->store('foto', 'public');
            }
        }

        $student->nim = $request->nim;
        $student->nama = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;
        $student->foto = $foto;

        if ($student->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data berhasil diedit !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal diedit !',
                'type' => 'error'
            ]);
        }
    }

    public function download(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $file_path = public_path('storage/' . $student->foto);
        $file_name = 'foto-' . $student->nim . '.' . pathinfo($file_path, PATHINFO_EXTENSION);

        return response()->download($file_path, $file_name);
    }

    public function preview(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $file_path = public_path('storage/' . $student->foto);

        return response()->file($file_path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::where('nim', $id)->first();

        if (!$student) {
            return redirect('/student')->with([
                'notifikasi' => 'Data siswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        $foto_siswa = $student->foto;

        if ($student->delete()) {

            if (!empty($foto_siswa) && Storage::disk('public')->exists($foto_siswa)) {
                Storage::disk('public')->delete($foto_siswa);
            }

            return redirect('/student')->with([
                'notifikasi' => 'Data berhasil dihapus !',
                'type' => 'success'
            ]);

        } else {

            return redirect()->back()->with([
                'notifikasi' => 'Data gagal dihapus !',
                'type' => 'error'
            ]);

        }
    }
}