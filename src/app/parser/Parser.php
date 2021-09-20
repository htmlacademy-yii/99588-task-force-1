<?php

namespace TaskForce\app\parser;

use TaskForce\app\exception\BaseException;
use TaskForce\app\parser\column\Column;
use \SplFileObject;

class Parser {
    private SplFileObject $srcFileObject;
    private SplFileObject $destFileObject;
    private string $srcFileName;
    private string $destFileName;
    private string $tableName;
    private array $columnHandler = [];

    public function __construct(string $srcFileName)
    {
        if (! is_readable($srcFileName)) {
            throw new BaseException("File opening error {\"$srcFileName\"}");
        }
        $this->srcFileObject = new SplFileObject($srcFileName);
        $this->srcFileName = $srcFileName;
    }

    public function setDestFileName(string $destFileName) :Parser
    {
        $this->destFileName = $destFileName;
        return $this;
    }

    public function setTableName(string $tableName) :Parser
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function pushColumnHandler(Column $handler) :Parser
    {
        $this->columnHandler[] = $handler;
        return $this;
    }

    private function defaultDestFileName(string $fileName) :string
    {
        return substr($fileName, 0, -4) . ".sql";
    }

    private function createDestFileObject() :void
    {
        $fileName = $this->destFileName ?? $this->defaultDestFileName($this->srcFileName);
        $this->destFileObject = new SplFileObject($fileName, "w");
        $this->destFileObject->ftruncate(0);
    }

    public function parseFile(?string $fileName = NULL) :Parser
    {
        $this->createDestFileObject();
        $header = $this->srcFileObject->fgetcsv();

        while (! $this->srcFileObject->eof()) {
            $line = $this->srcFileObject->fgetcsv();
            if (isset($line[0]) && $line[0] != "\n") {
                $this->writeLine($line);
            }
        }
        return $this;
    }

    private function writeLine($line) :void
    {
        $insert = "";
        $values = "";
        foreach ($this->columnHandler as $key => $handler) {
            if (isset($line[$key]) && method_exists($handler, "setValue")) {
                $handler->setValue($line[$key]);
            }
            $insert .= "`{$handler->getKey()}`,";
            $values .= "'{$handler->getValue()}',";
        }
        $insert = substr($insert, 0,-1);
        $values = substr($values, 0,-1);
        $this->destFileObject->fwrite("INSERT INTO {$this->tableName}({$insert}) VALUES ({$values});\n");
    }
}
