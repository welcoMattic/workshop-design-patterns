<?php

namespace App\Repository;

use App\Model\Bill;
use App\Model\BillLine;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Money\Currency;
use Money\Money;

class BillRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function createBill(Bill $bill): void
    {
        $lines = $bill->getLines()->map(function (BillLine $line) {
            return [
                'name' => $line->getName(),
                'quantity' => $line->getQuantity(),
                'unit_price_in_cents' => $line->getUnitPrice()->getAmount(),
                'currency' => $line->getUnitPrice()->getCurrency()->getCode(),
            ];
        })->toArray();

        $row = [
            'id' => $bill->getId(),
            'lines' => json_encode($lines, JSON_THROW_ON_ERROR),
        ];


        try {
            $this->connection->insert('bills', $row);
        } catch (TableNotFoundException $e) {
            $this->connection->executeStatement('CREATE TABLE bills (
                        id VARCHAR(30) PRIMARY KEY,
                        lines TEXT NOT NULL
                    )');
            $this->connection->insert('bills', $row);
        }
    }

    /**
     * @return Bill[]
     */
    public function getBills(): array
    {
        try {
            $stmt = $this->connection->executeQuery('SELECT * FROM bills');
            $list = $stmt->fetchAllAssociative();
            foreach ($list as $i => $line) {
                $list[$i]['lines'] = json_decode($line['lines'], true, flags: JSON_THROW_ON_ERROR);
            }
            return $this->convertBillList($list);
        } catch (TableNotFoundException) {
            return [];
        }
    }

    public function getBill(string $id): Bill
    {
        $bill = false;
        try {
            $stmt = $this->connection->executeQuery('SELECT * FROM bills WHERE id = :id', ['id' => $id]);
            $bill = $stmt->fetchAssociative();
        } catch (TableNotFoundException) {
            // Ignore
        }

        if ($bill === false) {
            throw new \InvalidArgumentException(sprintf(
                'No bill found with ID "%s".', $id
            ));
        }

        $bill['lines'] = json_decode($bill['lines'], true, 512, JSON_THROW_ON_ERROR);

        return $this->convertBill($bill);
    }

    /**
     * @param array[] $billArrays
     * @return Bill[]
     */
    private function convertBillList(array $billArrays)
    {
        return array_map([$this, 'convertBill'], $billArrays);
    }

    public function convertBill(array $billArray): Bill
    {
        $lines = [];
        foreach ($billArray['lines'] as $line) {
            $cents = $line['unit_price_in_cents'];
            $currency = $line['currency'];
            $currentObj = new Currency($currency);
            $price = new Money($cents, $currentObj);
            $lines[] = new BillLine(
                $line['name'],
                $line['quantity'],
                $price,
            );
        }

        return new Bill(
            $billArray['id'],
            new ArrayCollection($lines),
        );
    }

}
