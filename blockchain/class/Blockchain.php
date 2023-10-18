<?php

require_once '../class/Block.php';

class Blockchain
{
    private static array $chain;

    public function __construct()
    {
    }

    private static function createGenesisBlock(Block $genesisBlock): Block
    {
        $genesisBlock->index = 0;
        $genesisBlock->previousHash = 0;
        $genesisBlock->hash = $genesisBlock->calculateHash();

        return $genesisBlock;
    }

    public static function getChain() {
        self::readChain();
        return self::$chain;
    }

    public static function getLatestBlock()
    {
        return self::$chain[count(self::$chain) - 1];
    }

    public static function addBlock(Block $newBlock)
    {
        self::readChain();

        if(isset(self::$chain) &&  count(self::$chain) > 0) {
            $prevBlock = self::getLatestBlock();
            $newBlock->previousHash = $prevBlock->hash;
            $newBlock->index = $prevBlock->index + 1;
            $newBlock->hash = $newBlock->calculateHash();
            array_push(self::$chain, $newBlock);
        }
        else {
            self::$chain = array();
            $newBlock = self::createGenesisBlock($newBlock);
            var_dump($newBlock);
            array_push(self::$chain, $newBlock);
        }
        return self::saveChain();
    }

    public static function isChainValid(): bool
    {
        self::$chain = self::getChain();

        for ($i = 1, $chainLength = count(self::$chain); $i < $chainLength; $i++) {
            
            $temp = self::$chain[$i];
            $currentBlock = new Block($temp->pollID, $temp->userID, $temp->data);
            $currentBlock->previousHash = $temp->previousHash;
            $currentBlock->hash = $temp->hash;
            $currentBlock->timestamp = $temp->timestamp;
            $currentBlock->index = $temp->index;
            
            $tempPrev = self::$chain[$i - 1];
            $previousBlock = new Block($tempPrev->pollID, $tempPrev->userID, $tempPrev->data);
            $previousBlock->previousHash = $tempPrev->previousHash;
            $previousBlock->hash = $tempPrev->hash;
            $previousBlock->timestamp = $tempPrev->timestamp;
            $previousBlock->index = $tempPrev->index;

            if ($currentBlock->hash !== $currentBlock->calculateHash()) {
                return false;
            }

            if ($currentBlock->previousHash !== $previousBlock->hash) {
                return false;
            }
        }

        return true;
    }

    public static function saveChain() {
        $json = json_encode(self::$chain);
        return file_put_contents('../blockchain/blockchain.json', $json);
    }

    public static function readChain() {
        $json = file_get_contents('../blockchain/blockchain.json');
        
        if($json == "") {
            $json = "[]";
        }
        self::$chain = json_decode($json);
    }
}

?>