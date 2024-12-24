<?php

namespace App\Services;

use App\Repositories\Contracts\ShoeRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class FrontService
{
    protected $shoeRepository;
    protected $categoryRepository;

    public function __construct(ShoeRepositoryInterface $shoeRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->shoeRepository = $shoeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function searchShoes(string $keyword)
    {
        return $this->shoeRepository->searchByName($keyword);
    }

    public function getFrontPageData()
    {
        $categories = $this->categoryRepository->getAllCategories();
        $popularShoes = $this->shoeRepository->getPopularShoes(4);
        $newShoes = $this->shoeRepository->getAllNewShoes();

        return compact('categories','popularShoes','newShoes');
    }
}
