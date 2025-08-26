<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleAbility;

use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (Gate::denies('roles.view')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Fetch roles from the database
        $roles = Role::paginate(10);

        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (Gate::denies('roles.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('dashboard.roles.create', [
            'role' => new Role(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if (Gate::denies('roles.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);

        // $role = Role::createWithAbilities(
        //     $request->input('name'),
        //     $request->input('abilities')
        // );
        $role = Role::createWithAbilities($request);


        return redirect()->route('dashboard.roles.index')->with('success', 'Role created successfully.');
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
    public function edit(Role $role)
    {


        $role_abilities = $role->abilities->pluck('type', 'ability')->toArray();

        return view('dashboard.roles.edit', compact('role', 'role_abilities'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // if (Gate::denies('roles.update')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);

        $role->updateWithAbilities($request);



        return redirect()->route('dashboard.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // if (Gate::denies('roles.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }
        Role::destroy($id);

        return redirect()->route('dashboard.roles.index')->with('success', 'Role deleted successfully.');
    }
}




//this is the modification on main


//this is modification on fixMain
