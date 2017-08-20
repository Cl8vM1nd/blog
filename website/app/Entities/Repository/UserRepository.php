<?php
# CrEaTeD bY FaI8T IlYa      
# 2017

namespace App\Entities\Repository;

class UserRepository extends EntityRepository
{
    /**
     * @param string $name
     *
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }
}