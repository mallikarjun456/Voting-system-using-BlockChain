<?php
class Block
{
    public int $pollID;
    public int $userID;
    public int $index;
    public int $timestamp;
    public string $previousHash;
    public string $hash;
    public $data;

    public function __construct(int $pollID, int $userID, $data)
    {
        $this->pollID = $pollID;
        $this->userID = $userID;
        // $this->index = $index;
        $this->timestamp = time();
        // $this->previousHash = $previousHash;
        // $this->hash = $this->calculateHash();
        $this->data = $data;
    }

    public function calculateHash(): string
    {
        return hash(
            'sha256', 
            sprintf(
               '%d%s%s%s',
               $this->index,
               $this->timestamp,
               $this->previousHash,
               json_encode($this->data),
           )
        );
    }
}
?>