<?php

namespace App\Exports;

use App\Models\LicensedVideo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VideoOrdersExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return $licenses = LicensedVideo::with('user')->with('video')->orderBy('created_at', 'desc');

    }

    /**
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->created_at,
            $row->user->email,
            $row->user->company,
            $row->video->title
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date Licensed',
            'User email',
            'Company',
            'Video Name'
        ];
    }

}
