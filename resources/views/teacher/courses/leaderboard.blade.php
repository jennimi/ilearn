@extends('layouts.app')

@section('content')
    <div class="container py-5 position-relative">
        <!-- Tombol Kembali ke Kursus -->
        <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-outline-primary position-absolute top-0 start-0 z-index-10 px-4 py-2 shadow-sm hover:bg-primary-200 transition-all duration-200">
            Kembali ke Kursus
        </a>

        <!-- Judul Papan Peringkat -->
        <h1 class="text-center mb-5 text-primary fw-bold">Papan Peringkat</h1>

        <!-- Tabel Papan Peringkat -->
        <div class="tw-table-responsive tw-shadow-sm tw-rounded-lg tw-bg-white">
            <table class="tw-w-full tw-table-auto tw-border tw-border-gray-200">
                <thead class="tw-bg-gray-100">
                    <tr>
                        <th class="tw-py-3 tw-px-4 tw-text-left tw-text-sm tw-font-medium tw-text-gray-600 tw-border-b tw-border-gray-200">NIK</th>
                        <th class="tw-py-3 tw-px-4 tw-text-left tw-text-sm tw-font-medium tw-text-gray-600 tw-border-b tw-border-gray-200">Nama Siswa</th>
                        <th class="tw-py-3 tw-px-4 tw-text-center tw-text-sm tw-font-medium tw-text-gray-600 tw-border-b tw-border-gray-200">Nilai</th>
                        <th class="tw-py-3 tw-px-4 tw-text-center tw-text-sm tw-font-medium tw-text-gray-600 tw-border-b tw-border-gray-200">Peringkat</th>
                    </tr>
                </thead>
                <tbody class="tw-divide-y tw-divide-gray-200">
                    <!-- Baris 1 -->
                    <tr class="tw-hover:bg-gray-50">
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">1</td>
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">John Doe</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center tw-text-gray-800">95</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center">
                            <span class="tw-inline-block tw-px-3 tw-py-1 tw-text-xs tw-font-semibold tw-text-white tw-bg-green-500 tw-rounded-full">1st</span>
                        </td>
                    </tr>
                    <!-- Baris 2 -->
                    <tr class="tw-hover:bg-gray-50">
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">2</td>
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">Jane Smith</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center tw-text-gray-800">90</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center">
                            <span class="tw-inline-block tw-px-3 tw-py-1 tw-text-xs tw-font-semibold tw-text-white tw-bg-green-500 tw-rounded-full">2nd</span>
                        </td>
                    </tr>
                    <!-- Baris 3 -->
                    <tr class="tw-hover:bg-gray-50">
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">3</td>
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">Emily Johnson</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center tw-text-gray-800">85</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center">
                            <span class="tw-inline-block tw-px-3 tw-py-1 tw-text-xs tw-font-semibold tw-text-gray-800 tw-bg-yellow-400 tw-rounded-full">3rd</span>
                        </td>
                    </tr>
                    <!-- Baris 4 -->
                    <tr class="tw-hover:bg-gray-50">
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">4</td>
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">Michael Brown</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center tw-text-gray-800">80</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center">
                            <span class="tw-inline-block tw-px-3 tw-py-1 tw-text-xs tw-font-semibold tw-text-gray-800 tw-bg-blue-400 tw-rounded-full">4th</span>
                        </td>
                    </tr>
                    <!-- Baris 5 -->
                    <tr class="tw-hover:bg-gray-50">
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">5</td>
                        <td class="tw-py-3 tw-px-4 tw-text-gray-800">Olivia Davis</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center tw-text-gray-800">75</td>
                        <td class="tw-py-3 tw-px-4 tw-text-center">
                            <span class="tw-inline-block tw-px-3 tw-py-1 tw-text-xs tw-font-semibold tw-text-gray-800 tw-bg-blue-400 tw-rounded-full">5th</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
@endsection
