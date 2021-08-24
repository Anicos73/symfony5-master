<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $articleRepository;
    private $categorieRepository;

    public function __construct(ArticleRepository $articleRepository, CategorieRepository $categorieRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->categorieRepository = $categorieRepository;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $categories = $this->categorieRepository->findAll();
        $articles =$this->articleRepository->findAll();
        // dd($categories);
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories'=>$categories,
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function cate(): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $categories =$this->categorieRepository->findAll();
        $articles =$this->articleRepository->findAll();
        // dd($categories);
        return $this->render('home/categories/index.html.twig', [
            'articles' => $articles,
            'categories'=>$categories,
        ]);
    }
    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $this->articleRepository->find($id);
        $categories =$this->categorieRepository->findAll();
        if (!$article) {
            return $this->redirectToRoute('home');
        }
        return $this->render('home/show.html.twig', [
            'article' => $article,
            'categories'=>$categories,
        ]);
    }
    // recuperer les articles par categorie
  /**
     * @Route("/showArticle/{id}", name="show-article")
     */
    public function showArticleByCategory(?Categorie $categories): Response
    {
        if ($categories) {
            $articles= $categories->getArticles()->getValues();
        }else{
        //    echo $articles= "Aucun article disponible";
          return  $this->redirectToRoute('home');
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
