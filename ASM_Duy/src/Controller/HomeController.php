<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Order;
use App\Repository\OrderRepository;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
    }
    
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy([]); 
        $nikeProducts = $this->getProductsByCategory('Nike');
        $adidasProducts = $this->getProductsByCategory('Adidas');
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'nikeProducts' => $nikeProducts,
            'adidasProducts' => $adidasProducts,
        ]);
    }


    #[Route('/iphone', name: 'app_ipad')]

    public function iphoneindex(ProductRepository $productRepository): Response
    {
        // Lấy danh sách sản phẩm của category "macbook"
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'Nike']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/iphone/index.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/macbook', name: 'app_macbook')]

    public function macbookindex(ProductRepository $productRepository): Response
    {
        // Lấy danh sách sản phẩm của category "macbook"
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'Adidas']);
        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('home/macbook/index.html.twig', [
            'products' => $products,
        ]);
    }
    
    private function getProductsByCategory(string $categoryName): array
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
        if (!$category) {
            return []; // Return an empty array if category not found
        }

        return $this->entityManager->getRepository(Product::class)->findBy(['category' => $category]);
    }
}
