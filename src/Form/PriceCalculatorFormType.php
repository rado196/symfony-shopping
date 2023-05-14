<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceCalculatorFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $choices = ['' => ''];
    foreach ($options['data']['products'] as $product) {
      $choices[$product->getTitle()] = $product->getId();
    }

    if (isset($options['data']['selected'])) {
      $selected = $options['data']['selected'];
    }

    $builder
      ->add('productId', ChoiceType::class, [
        'label' => 'Product',
        'choices' => $choices,
        'data' => isset($selected['productId']) ? $selected['productId'] : null,
        'row_attr' => ['class' => 'form-group text-start mb-4'],
        'label_attr' => ['class' => 'form-label'],
        'attr' => ['class' => 'form-select'],
      ])
      ->add('taxId', TextType::class, [
        'label' => 'Your Tax ID',
        'data' => isset($selected['taxId']) ? $selected['taxId'] : null,
        'row_attr' => ['class' => 'form-group text-start mb-4'],
        'label_attr' => ['class' => 'form-label'],
        'attr' => ['class' => 'form-control'],
      ])
      ->add('save', SubmitType::class, [
        'label' => 'Calculate Price',
        'attr' => ['class' => 'btn btn-success'],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // Configure your form options here
    ]);
  }
}
