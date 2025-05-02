<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        $data = array(
            'title' => 'Role | ',
            'datarole' => $role,
        );
        $title = 'Delete role!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.role.index', $data);
    }

    public function create()
    {
        $data = array(
            'title' => 'Add Role | ',
        );
        return view('backend.role.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_role' => 'required|string|max:255',
            'nama_role' => 'required|string|max:255',
        ]);

        Role::create($request->all());
        Alert::success('Success', 'role created successfully.');

        return redirect()->route('roles.index');
    }

    public function show(Role $role)
    {
        $data = array(
            'title' => 'View Role | ',
        );
        return view('backend.role.show', $data);
    }

    public function edit(Role $role)
    {
        $data = array(
            'title' => 'Edit Role | ',
            'role' => $role,
        );
        return view('backend.role.edit', $data);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'kode_role' => 'required|string|max:255',
            'nama_role' => 'required|string|max:255',
        ]);

        $role->update($request->all());
        Alert::success('Success', 'role updated successfully.');

        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        Alert::success('Success', 'role deleted successfully.');

        return redirect()->route('roles.index');
    }
}
