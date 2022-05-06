<?php

namespace App\Repository;

use League\Csv\Reader;
use League\Csv\Statement;

class BibliothequeRepository
{
    private Reader $reader;

    public function __construct(string $filePath)
    {
        $stream = fopen($filePath, 'r');
        $this->reader = Reader::createFromStream($stream);
        $this->reader->setDelimiter(';');
        $this->reader->setHeaderOffset(0);
    }

    public function find(int $id)
    {
        return $this->reader->fetchOne($id);
    }

    public function findAll()
    {
        return $this->reader->getRecords();
    }

    public function findAllFrom(string $header, string $value)
    {
        $statement = (new Statement())->where(function (array $record) use ($header, $value) {
            return $record[$header] === $value;
        });

        return $statement->process($this->reader, $this->reader->getHeader())->getRecords($this->reader->getHeader());
    }

    private function getIndexFromHeader(string $header): ?int
    {
        return array_search($header, $this->reader->getHeader()) ?? null;
    }
}
