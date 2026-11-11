<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::orderByDesc('level')->orderBy('name')->get();

        return view('skills.index', compact('skills'));
    }

    public function create(): View
    {
        return view('skills.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Skill::create($this->validated($request));

        return redirect()->route('skills.index')->with('success', 'Skill berhasil ditambahkan.');
    }

    public function edit(Skill $skill): View
    {
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($this->validated($request, $skill));

        return redirect()->route('skills.index')->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill dihapus.');
    }

    private function validated(Request $request, ?Skill $skill = null): array
    {
        return $request->validate([
            'name'  => ['required', 'string', 'max:100', Rule::unique('skills', 'name')->ignore($skill?->id)],
            'level' => ['required', 'integer', 'between:0,100'],
        ], [
            'name.required'  => 'Nama skill wajib diisi.',
            'name.max'       => 'Nama skill maksimal 100 karakter.',
            'name.unique'    => 'Nama skill sudah dipakai.',
            'level.required' => 'Level wajib diisi.',
            'level.integer'  => 'Level harus berupa angka bulat.',
            'level.between'  => 'Level harus antara 0 sampai 100.',
        ]);
    }
}
