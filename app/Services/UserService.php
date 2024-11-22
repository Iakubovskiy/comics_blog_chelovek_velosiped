<?php
namespace App\Services;

use App\Repositories\RepositoryInterface;

class UserService
{
    protected $repository;
    
    public function __construct(RepositoryInterface $repository) {
        $this->repository = $repository;
    }
}