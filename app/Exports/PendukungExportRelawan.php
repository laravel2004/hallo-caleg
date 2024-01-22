<?php

namespace App\Exports;

use App\Models\Pendukung;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PendukungExportRelawan implements FromCollection, WithHeadings, WithEvents {
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        $userId = Auth::id();
        $pendukungs = Pendukung::with(['tps', 'user'])->where('user_id', $userId)->get();
        $nomor = 1;

        return $pendukungs->map(function ($pendukung) use (&$nomor) {
            return [
                'nomor' => $nomor++,
                'name' => $pendukung->name,
                'jenis_kelamin' => $pendukung->jenis_kelamin,
                'usia' => $pendukung->usia,
                'kec' => $pendukung->kec,
                'desa' => $pendukung->desa,
                'rt' => $pendukung->rt,
                'rw' => $pendukung->rw,
                'tps_name' => $pendukung->tps->name,
            ];
        });
    }

    public function headings(): array {
        return [
            'NO.',
            'NAMA',
            'JENIS KELAMIN',
            'USIA',
            'KECAMATAN',
            'DESA',
            'RT',
            'RW',
            'TPS',
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:I1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                $columns = ['A', 'C', 'D', 'G', 'H', 'I'];
                foreach ($columns as $column) {
                    $event->sheet->getDelegate()->getStyle($column . ':' . $column)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(8);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(8);

                $lastColumn = $event->sheet->getHighestColumn();
                $lastRow = $event->sheet->getHighestRow();
                $range = 'A1:' . $lastColumn . $lastRow;

                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '#000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
