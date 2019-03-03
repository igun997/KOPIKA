<?php
namespace Helpers;
use Helpers\IPFSKonektor;
/**
 * Resep
 */
class ArtikeHelper
{
  public $ipfs;
  function __construct($obj)
  {
    $this->ipfs = $obj;
  }
  public function submit($data)
  {
    return $this->ipfs->add(json_encode($data));
  }
}

?>
