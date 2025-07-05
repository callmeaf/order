<?php

namespace Callmeaf\Order\App\Exports\Admin\V1;

use Callmeaf\Order\App\Models\Order;
use Callmeaf\Order\App\Repo\Contracts\OrderRepoInterface;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class OrdersExport implements FromCollection,WithHeadings,Responsable,WithMapping,WithCustomChunkSize
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = '';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    private OrderRepoInterface $orderRepo;
    public function __construct()
    {
        $this->orderRepo = app(OrderRepoInterface::class);
        $this->fileName = $this->fileName ?: \Base::exportFileName(model: $this->orderRepo->getModel()::class,extension: $this->writerType);
    }

    public function collection()
    {
        if(\Base::getTrashedData()) {
            $this->orderRepo->trashed();
        }

        $this->orderRepo->latest()->search();

        if(\Base::getAllPagesData()) {
            return $this->orderRepo->lazy();
        }

        return $this->orderRepo->paginate();
    }

    public function headings(): array
    {
        return [
           // 'status',
        ];
    }

    /**
     * @param Order $row
     * @return array
     */
    public function map($row): array
    {
        return [
            // $row->status?->value,
        ];
    }

    public function chunkSize(): int
    {
        return \Base::config('export_chunk_size');
    }
}
