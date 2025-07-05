<?php

namespace Callmeaf\Order\App\Imports\Web\V1;

use Callmeaf\Base\App\Services\Importer;
use Callmeaf\Order\App\Enums\OrderStatus;
use Callmeaf\Order\App\Repo\Contracts\OrderRepoInterface;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrdersImport extends Importer implements ToCollection,WithChunkReading,WithStartRow,SkipsEmptyRows,WithValidation,WithHeadingRow
{
    private OrderRepoInterface $orderRepo;

    public function __construct()
    {
        $this->orderRepo = app(OrderRepoInterface::class);
    }

    public function collection(Collection $collection)
    {
        $this->total = $collection->count();

        foreach ($collection as $row) {
            $this->orderRepo->freshQuery()->create([
                // 'status' => $row['status'],
            ]);
            ++$this->success;
        }
    }

    public function chunkSize(): int
    {
        return \Base::config('import_chunk_size');
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        $table = $this->orderRepo->getTable();
        return [
            // 'status' => ['required',Rule::enum(OrderStatus::class)],
        ];
    }

}
