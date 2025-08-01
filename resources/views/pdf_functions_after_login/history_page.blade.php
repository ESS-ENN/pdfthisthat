@extends('layouts.app')

@section('content')

<main class="flex-grow bg-gray-50 dark:bg-gray-900 py-4 px-2 sm:px-4 lg:px-6">
    <div class="max-w-5xl mx-auto">
        
        <div class="text-center mb-4 mt-0">
            <div class="flex justify-center text-primary-500 text-4xl mb-2">
                <i class="bi bi-list-stars"></i>
            </div>
            <h4 class="text-xl font-bold text-primary-600 dark:text-primary-400 mb-2">History of work</h1>
            <p class="text-base text-gray-600 dark:text-gray-300">
                View All Your Previously Generated PDFs with Their Input Files.
            </p>
        </div>

        <div class="mt-8 mb-4 overflow-x-auto">
            <div class="w-full max-w-full rounded-xl">
                <table class="min-w-full border bg-white shadow-lg rounded-xl">
                    <thead class="bg-primary-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">ID</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Input Filename</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Operation</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Input File</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Output File</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Output Filename</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Created At</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($files as $file)
                            <tr class="hover:bg-primary-50 transition duration-150">
                                <td class="px-4 py-2 text-sm text-gray-800 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 truncate max-w-[150px] overflow-hidden whitespace-nowrap">{{ $file->original_file_name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 whitespace-nowrap">{{ $file->operation }}</td>
                                <!-- <td class="px-4 py-2 text-sm text-gray-800">
                                    <a href="{{ asset($file->input_file) }}"

                                    download
                                    class="inline-block px-3 py-1 text-xs font-medium rounded bg-gray-100 text-primary-600 hover:bg-gray-200">
                                        Download
                                    </a>
                                </td> -->
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    @if ($file->operation === 'HTML to Pdf')
                                        <a href="{{ $file->input_file }}" target="_blank"
                                        class="inline-block px-3 py-1 text-xs font-medium rounded bg-gray-100 text-primary-600 hover:bg-gray-200">
                                            View URL
                                        </a>
                                    @else
                                        <a href="{{ asset($file->input_file) }}" download
                                        class="inline-block px-3 py-1 text-xs font-medium rounded bg-gray-100 text-primary-600 hover:bg-gray-200">
                                            Download
                                        </a>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <a href="{{ route('download.file', $file->file_id) }}"
                                    class="inline-block px-3 py-1 text-xs font-medium rounded bg-gray-100 text-primary-600 hover:bg-gray-200">
                                        Download
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800 truncate max-w-[150px] overflow-hidden whitespace-nowrap">{{ $file->output_file_name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800 whitespace-nowrap">{{ \Carbon\Carbon::parse($file->date)->format('d-m-Y') }}</td>
                                <td class="px-4 py-2 text-sm whitespace-nowrap">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">
                                        {{ $file->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-sm text-gray-500">
                                    No work history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>


@endsection