<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use Symfony\Component\Serializer\Annotation\Groups;


class PaginatorResponse
{

   
    private $limit;
   
    private $page;
    
    private $count;

    private $data;

    private $lastPage;

    public function getData()
    {
        return $this->data;
    }


    public function setData($data)
    {
        $this->data = $data;
    }


    public function getLimit(): ?int
    {
        return $this->limit;
    }


    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
    }


    public function getPage(): ?int
    {
        return $this->page;
    }


    public function setPage(?int $page)
    {
        $this->page = $page;
    }


    public function getCount(): ?int
    {
        return $this->count;
    }


    public function setCount(?int $count)
    {
        $this->count = $count;
    }

    /**
     * Get the value of lastPage
     *
     * @return  mixed
     */
    public function getLastPage() : ?int
    {
        return $this->lastPage;
    }

    /**
     * Set the value of lastPage
     *
     * @param   mixed  $lastPage  
     *
     * @return  self
     */
    public function setLastPage(?int $lastPage) 
    {
        $this->lastPage = $lastPage;
    }
}
