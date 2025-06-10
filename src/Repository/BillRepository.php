<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\TableNotFoundException;

class BillRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function createBill(array $data): void
    {
        $lines = $data['lines'];
        $total = array_sum(array_map(fn ($row) => $row['unit_price_in_cents'] * $row['quantity'], $lines));
        $currency = $lines[0]['currency'];
        $row = [
            'id' => $data['id'],
            'price' => sprintf('%.2f %s', $total/100, $currency),
            'lines' => json_encode($lines, JSON_THROW_ON_ERROR),
        ];


        try {
            $this->connection->insert('bills', $row);
        } catch (TableNotFoundException $e) {
            $this->connection->executeStatement('CREATE TABLE bills (
                        id VARCHAR(30) PRIMARY KEY,
                        price VARCHAR(64) NOT NULL,
                        lines TEXT NOT NULL
                    )');
            $this->connection->insert('bills', $row);
        }
    }

    public function getBills(): array
    {
        try {
            $stmt = $this->connection->executeQuery('SELECT * FROM bills');

            return $stmt->fetchAllAssociative();
        } catch (TableNotFoundException) {
            return [];
        }
    }

    public function getBill(string $id): array
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

        return $bill;
    }
}
