<?php

namespace App\Form;

use App\Form\DataTransformer\DateRangeTransformer;
use App\Model\DateRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new DateRangeTransformer());
        $builder->add('dateRange', TextType::class, [
            'label' => 'Date range (YYYY-MM-DD - YYYY-MM-DD)'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DateRange::class,
            'empty_data' => null,
        ]);
    }
}
