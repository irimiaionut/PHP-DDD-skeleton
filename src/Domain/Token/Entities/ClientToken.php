<?php
namespace App\Domain\Token\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="ClientToken")
 **/

class ClientToken
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="string") **/
    protected $clientName;

    /** @ORM\Column(type="string") **/
    protected $tokenValue;


    public function __construct(string $clientName, string $tokenValue)
    {
        $this->clientName = $clientName;
        $this->tokenValue = $tokenValue;
    }


    # Accessors
    public function getId() : int { return $this->id; }
    public function getClientName() : string { return $this->clientName; }
    public function getTokenValue() : string { return $this->tokenValue; }
}