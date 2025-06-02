<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(): View
    {
        $profiles = Profile::all();
        return view('profiles.index', compact('profiles'));
    }
    public function create(): View
    {
        return view('profiles.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user_tabel',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'nullable|date',
            'last_login' => 'nullable|date',
        ]);

        Profile::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'birth_date' => $request->birth_date,
        ]);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }
    public function show($id): View
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.show', compact('profile'));
    }
    public function edit(string $id): View
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }
    public function update(Request $request, string $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user_tabel,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'birth_date' => 'nullable|date',
        ]);

        $profile = Profile::findOrFail($id);
        $profile->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $profile->password,
            'birth_date' => $request->birth_date,
        ]);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }
    public function destroy(string $id): RedirectResponse
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }    
}
