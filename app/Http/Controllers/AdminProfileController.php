<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    // ===== HALAMAN PROFIL ADMIN LOGIN =====
    public function index()
    {
        $admin = Auth::user();

        return view('admin.profiladmin.profiladmin', compact('admin'));
    }

    // ===== UPDATE PROFIL ADMIN LOGIN =====
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // Upload foto
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/admin/'), $filename);

            // Simpan nama file ke kolom photo
            $user->photo = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ===== TAMBAH ADMIN DARI HALAMAN PROFIL (POP UP) =====
    public function addAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:5',
        ]);

        $admin = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'photo' => null, // foto tidak diisi
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Admin baru berhasil ditambahkan!',
            'id' => $admin->id_user,
        ]);
    }

    // ===== HALAMAN LIST ADMIN =====
    public function list()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();

        return view('admin.profiladmin.listadmin', compact('admins'));
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role === 'superadmin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Superadmin tidak bisa dihapus!',
            ]);
        }

        $admin->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Admin berhasil dihapus.',
        ]);
    }
}
