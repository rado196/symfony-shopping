<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Product;
use App\Form\PriceCalculatorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as SymfonyValidation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
  #[Route(path: '/', name: 'app_purchase_calculator')]
  public function showPriceCalculator(
    ValidatorInterface $validator,
    Request $request,
    EntityManagerInterface $entityManager
  ): Response {
    $productRepository = $entityManager->getRepository(Product::class);
    $countryRepository = $entityManager->getRepository(Country::class);

    $errorMessage = '';
    $selected = [];
    $prices = [
      'product' => '--',
      'tax' => '--',
      'total' => '--',
    ];

    if ($request->isMethod('post')) {
      $params = $request->request->all('price_calculator_form');
      $selected = [
        'productId' => $params['productId'],
        'taxId' => $params['taxId'],
      ];

      $errors = $validator->validate(
        $selected,
        new SymfonyValidation\Collection([
          'productId' => [
            new SymfonyValidation\NotNull([
              'message' => 'Missing required field "productId".',
            ]),
            new SymfonyValidation\NotBlank([
              'message' => 'Invalid required field "productId".',
            ]),
          ],
          'taxId' => [
            new SymfonyValidation\NotNull([
              'message' => 'Missing required field "taxId".',
            ]),
            new SymfonyValidation\NotBlank([
              'message' => 'Invalid required field "taxId".',
            ]),
          ],
        ])
      );

      if (count($errors) > 0) {
        $errorMessage = (string) $errors;
      } else {
        $country = $countryRepository->findOneBy([
          'code' => strtoupper(substr($selected['taxId'], 0, 2)),
        ]);

        $errors = $validator->validate(
          $selected['taxId'],
          new SymfonyValidation\Length([
            'min' => $country->getTaxIdLength(),
            'max' => $country->getTaxIdLength(),
          ])
        );
        if (count($errors) > 0) {
          $errorMessage = (string) $errors;
        } else {
          $product = $productRepository->find($selected['productId']);
          $prices['product'] = $product->getPrice();
          $prices['tax'] = ($product->getPrice() * $country->getTaxPercent()) / 100;
          $prices['total'] = $prices['product'] + $prices['tax'];
        }
      }
    }

    $products = $productRepository->findAll();
    $form = $this->createForm(PriceCalculatorFormType::class, [
      'products' => $products,
      'selected' => $selected,
    ]);

    return $this->render('purchase/index.html.twig', [
      'form' => $form,
      'prices' => $prices,
      'errorMessage' => $errorMessage,
    ]);
  }
}
