<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat datang,') }} {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Titik dua (:value) = isi dengan variabel PHP, bukan teks biasa --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <x-stat-card label="Total Projects" :value="$totalProjects" />
                <x-stat-card label="Published"      :value="$publishedCount" color="text-green-600" />
                <x-stat-card label="Draft"          :value="$draftCount" color="text-yellow-600" />
                <x-stat-card label="Categories"     :value="$totalCategories" color="text-purple-600" />
                <x-stat-card label="Skills"         :value="$totalSkills" color="text-orange-600" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Project per kategori (withCount) --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Project per Kategori</h3>
                    <ul class="divide-y divide-gray-100">
                        @forelse ($categories as $category)
                            <li class="flex justify-between py-2">
                                <span class="text-gray-700">{{ $category->name }}</span>
                                <span class="font-semibold text-gray-900">{{ $category->projects_count }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-gray-500">Belum ada kategori.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Skill teratas --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">Skill Teratas</h3>
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('skills.index') }}" class="text-sm text-blue-600 hover:underline">Kelola skill</a>
                        @endif
                    </div>
                    <ul class="space-y-3">
                        @forelse ($topSkills as $skill)
                            <li>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">{{ $skill->name }}</span>
                                    <span class="text-gray-500">{{ $skill->level }}%</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded">
                                    <div class="h-2 bg-orange-500 rounded" style="width: {{ $skill->level }}%"></div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-500">Belum ada skill.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- 5 project terbaru --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Project Terbaru</h3>
                <ul class="divide-y divide-gray-100">
                    @forelse ($latestProjects as $project)
                        <li class="flex justify-between py-2">
                            <span class="text-gray-700">
                                {{ $project->nama }}
                                <span class="text-gray-400 text-sm">· {{ $project->category?->name ?? 'Tanpa kategori' }}</span>
                            </span>
                            <span class="text-sm {{ $project->status === 'published' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">Belum ada project.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
