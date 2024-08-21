<?php

namespace App\Services;

use Web3\Web3;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use App\Models\NFT;

class NFTService
{
  protected $web3;
  protected $contract;
  protected $contractAddress;
  protected $abi;

  public function __construct()
  {
      $nft = NFT::first();
      
      if ($nft) {
          $this->contractAddress = $nft->contractAddress;
          $this->abi = $nft->abi;
      } else {
          throw new \Exception("No NFT found.");
      }
  
      $this->web3 = new Web3(new HttpProvider(new HttpRequestManager('http://127.0.0.1:8545', 10)));
      $this->contract = new Contract($this->web3->provider, $this->abi);
  }
  
  public function createToken($tokenURI, $fromAddress)
  {
    $result = null;

    $this->contract->at($this->contractAddress)->send('createToken', $tokenURI, [
      'from' => $fromAddress,
      'gas' => 200000
    ], function ($err, $transaction) use (&$result) {
      if ($err !== null) {
        throw new \Exception($err->getMessage());
      }

      // Simpan hash transaksi
      $result = $transaction;
    });

    return $result;
  }

  public function verifyNFT($transactionHash)
  {
    $receipt = null;

    $this->web3->eth->getTransactionReceipt($transactionHash, function ($err, $transactionReceipt) use (&$receipt) {
      if ($err !== null) {
        throw new \Exception($err->getMessage());
      }

      $receipt = $transactionReceipt;
    });

    return $receipt;
  }
}
